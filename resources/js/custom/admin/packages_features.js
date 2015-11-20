/**
 * Created by Jordan Cachero on 3/19/2015.
 */
$(document).ready(function() {
    activateEvents();
});

var update = false;
var selectedPfId = 0;

function activateEvents() {
    $('#showAddEditModalBtn').off('click').click(function() {
        update = false;
        $('#addEditModal').modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });
    });

    $(".editBtn").off('click').click(function() {
        update = true;
        var pf = $(this).parents('.pf');
        selectedPfId = pf.find(".id").val();
        $("#name").val(pf.find('.name').val());
        $("#status").val(pf.find('.status').val());

        pf.find('tr').each(function() {
            var feature = $(this).find('span').attr('class');
            var value = $(this).find('span').html();
            if($("#" + feature).is(':checkbox')) {
                if(value == "on") {
                    $("#" + feature).prop("checked", true);
                }
            } else {
                $("#" + feature).val(value);
            }

        });

        $('#addEditModal').modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });
    });

    $('.deleteBtn').off('click').click(function() {
        var id = $(this).parents('.pf').find(".id").val();
        var ok = confirm("Are you sure to delete this package?");
        if(ok) {
            process({action: "delete", id: id}, function () {
                window.location = base_url + "admin/packages_features";
            });
        }
    });

    $("#saveBtn").off("click").off('click').click(function() {
        if(validateForm()) {
            var data = $("#addEditForm").serializeObject();
            data.action = update ? "update" : "add";
            if(update) {
                data.id = selectedPfId;
            }
            process(
                data,
                function () {
                    window.location = base_url + "admin/packages_features";
                }
            );
        }
    });

    $('#addEditModal').on("hidden.bs.modal", function() {
        clearAddEditForm();
    });

}

function clearAddEditForm() {
    $('#addEditForm').find('input').each(function() {
        $(this).val("");
        $(this).prop('checked', false);
    });
    $('#status').val("0");
    selectedPfId = 0;
}

// AJAX PROCESS
function process(data, callback) {
    $.ajax({
        url: base_url + "admin/packages_features_process",
        data: data,
        type: "POST",
        dataType: 'json',
        success: function(data) {
            callback(data);
        },
        error: function(error) {
            loading('error', "Sorry, something went wrong! :(");
            console.log(error);
        }
    });
}

// VALIDATE
function validateForm() {
    var valid = true;
    $('#addEditForm').find('.required').each(function() {
        if ($(this).val() == "") {
            $(this).addClass('input-error');
            valid = false;
        } else {
            $(this).removeClass('input-error');
        }
    });
    if (!valid) {
        loading("danger", "A required field is empty.");
    }
    return valid;
}