/**
 * Created by Jordan Cachero on 3/19/2015.
 */

var update = false;
var selectedFeature;

$(document).ready(function() {

    // GET FEATURES
    $('#features').off('change').change(function() {
        selectedFeature = $(this).val()[0];
        process(
            {
                action: 'get_feature_details',
                id: selectedFeature
            },
            function(data) {
                update = true;
                $('#featureDetailsDiv').show().find('h5').html("Feature Details - Update");
                $('#featureName').val(data.name);
                $('#featureDescription').val(data.description);
                $('#featureKey').val(data.key).attr('readonly', true);
                $('#featureInputType').val(data.input_type);
                $('#featureDefaultValue').val(data.default_value);
            },
            "Fetching features details...",
            "Fetching details successful."
            );
    });

    // SAVE FEATURE
    $('#saveFeatureBtn').off('click').click(function() {
        if(validateFeature()) {
            var action = update ? "update_feature" : "add_feature";
            var data = {
                action: action,
                name: $('#featureName').val(),
                description: $('#featureDescription').val(),
                key: $('#featureKey').val(),
                default_value: $('#featureDefaultValue').val(),
                input_type: $('#featureInputType').val()
            };
            if(update) {
                data.id = selectedFeature;
            }
            process(
                data,
                function() {
                    refreshFeatures();
                    if(!update) {
                        clearFeatureDetailsForm();
                        $('#featureDetailsDiv').hide();
                    }
                },
                "Saving feature...",
                "Saving feature successful!"
            );
        }
    });

    // SHOW ADD FORM
    $('#showAddFormBtn').off('click').click(function() {
        update = false;
        clearFeatureDetailsForm();
        $('#featureDetailsDiv').show().find("h5").html("Feature Details - Add");
        $('#saveFeatureBtn').removeClass('btn-primary').addClass('btn-success');
    });

    // DELETE FEATURE
    $('#deleteFeatureBtn').off('click').click(function() {
        var ok = confirm("Delete Feature Confirmation");
        if(ok) {
            process({action: "delete_feature", id: selectedFeature}, function () {
                refreshFeatures();
                clearFeatureDetailsForm();
                $("#featureDetailsDiv").hide();
            },
            "Deleting feature...",
            "Deleting feature successful!"
            );
        }
    });

});

// REFRESH LIST
function refreshFeatures() {
    process({action: "refresh_features_list"}, function(data) {
            $('#features').html(data.result);
        });
}

// AJAX PROCESS
function process(data, callback, loadingMessage, successMessage) {
    if (loadingMessage) { loading('info', loadingMessage); }
    $.ajax({
        url: base_url + "admin/features_process",
        data: data,
        type: "POST",
        dataType: 'json',
        success: function(data) {
            if (successMessage) { loading('success', successMessage); }
            callback(data);
        },
        error: function(error) {
            loading('error', "Sorry, something went wrong! :(");
            console.log(error);
        }
    });
}

// CLEAR FORM
function clearFeatureDetailsForm() {
    $('#featureName').val("");
    $('#featureDescription').val("");
    $('#featureKey').val("").attr('readonly', false);
    $('#featureInputType').val("checkbox");
    $('#featureDefaultValue').val("");
}

// VALIDATE
function validateFeature() {
    var valid = true;
    $('#featureDetailsDiv').find('input').each(function() {
        if ($(this).val() == "") {
            $(this).addClass('input-error');
            valid = false;
        } else {
            $(this).removeClass('input-error');
        }
    });
    if (!valid) {
        loading("danger", "A field should not be empty.");
    }
    return valid;
}
