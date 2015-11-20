$(document).ready(function () {
    activatePackageEvents();
});
function activatePackageEvents() {
    $('#packages').change(function () {
        loading("info", "Loading module information...");
        $.ajax({
            url: base_url + "admin/getPackageInfo",
            data: {'id': $('#packages').val()},
            type: "post",
            dataType: "json",
            success: function (data) {
                $('#stripePlanId').val(data.stripe_plan_id);
                $('#type').val(data.type);
                $('#packageName').val(data.name).attr('disabled', true);
                $('#packageFeature').val(data.packages_features_id);
                $('#packageStatus').val(data.status);
                if (parseInt(data.show) === 1) {
                    $('#show').prop('checked', true);
                } else {
                    $('#show').prop('checked', false);
                }
                $('#packageInformationDiv').fadeIn('fast');
                $('#packageUpdateBtn').show();
            }
        });
    });

    $('#packageUpdateBtn').click(function () {
        loading("info", "Updating package details...");
        var show = 0;
        if ($('#show').is(':checked')) {
            show = 1;
        }
        $.ajax({
            url: base_url + "admin/updatePackage",
            data: {
                'stripe_plan_id': $('#stripePlanId').val(),
                'packages_features_id': $('#packageFeature').val(),
                'status': $('#packageStatus').val(),
                'show': show
            },
            type: 'post',
            success: function (data) {
                if (data === "Success") {
                    refreshPackageList();
                    loading("success", "Updating package successful!");
                } else {
                    loading("danger", "Updating package failed!");
                }
            }
        });
    });

    function clearPackageFields() {
        $('#packageName').val("");
        $('#packageNumberOfProperty').val("");
        $('#packageNumberOfProfile').val("");
    }

    function refreshPackageList() {
        $.ajax({
            url: base_url + "admin/getPackageList",
            success: function (data) {
                $('#packages').html(data);
            }
        });
    }

    function validatePackageFields() {
        var valid = true;
        $('#packageInformationDiv').find('.required').each(function () {
            if (!$(this).val()) {
                valid = false;
                $(this).addClass('input-error');
            } else {
                $(this).removeClass('input-error');
            }
        });
        return valid;
    }

}