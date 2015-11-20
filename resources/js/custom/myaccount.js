$(document).ready(function() {
    activatePopovers();
    activateUpdateEvents();
    activateInputEvent();
    activateCardEvents();
});

function activatePopovers() {
    $(document).find(".helper").each(function() {
        $(this).popover({
            'trigger': 'hover'
        });
    });
}

function activateCardEvents() {
    $('#showCreateCard').click(function() {
        $('#createCardDiv').show();
        $('#showRetrieveCard').show();
        $('#showCreateCard').hide();
        $('#retrieveCardDiv').hide();
    });
    $('#showRetrieveCard').click(function() {
        $('#retrieveCardDiv').show();
        $('#showCreateCard').show();
        $('#showRetrieveCard').hide();
        $('#createCardDiv').hide();
    });

    $('#updateCardBtn').click(function() {
        loading('info', 'Updating Card Info...');
        if(validateUpdate()) {
            $.ajax({
                url: base_url + "stripe_api/update_card",
                data: {'exp_month': $('#u_exp_month').val(), 'exp_year': $('#u_exp_year').val(), 'cardholder_name': $('#u_cardholder_name').val(),
                        'address_city': $('#u_address_city').val(), 'address_country': $('#u_address_country').val(),'address_line1': $('#u_address_line1').val(), 'address_line2': $('#u_address_line2').val(),
                        'address_state': $('#u_address_state').val(), 'address_zip': $('#u_address_zip').val()},
                type: 'POST',
                success: function(data) {
                    loading('success', 'Updating Card Info Successful!');
                },
                error: function(error) {
                    loading('danger', 'Card Validation Failed.');
                }

            });
        }
    });

    $('#saveCardBtn').click(function() {
        loading('info', 'Saving Card Info...');
        if(validateCreate()) {
            $.ajax({
                url: base_url + "stripe_api/create_card",
                data: {'card_number': $('#card_number').val(), 'exp_month': $('#exp_month').val(), 'exp_year': $('#exp_year').val(), 'cvc': $('#cvc').val(), 'cardholder_name': $('#cardholder_name').val(),
                    'address_city': $('#address_city').val(), 'address_country': $('#address_country').val(),'address_line1': $('#address_line1').val(), 'address_line2': $('#address_line2').val(),
                    'address_state': $('#address_state').val(), 'address_zip': $('#address_zip').val()},
                type: 'POST',
                success: function(data) {
                    loading('success', 'Saving Card Info Successful!');
                },
                error: function(error) {
                    loading('danger', 'Card Validation Failed.');
                }

            });
        } else {
            loading('danger', 'Invalid Inputs.');
        }
    });

    function validateCreate() {
        var valid = true;
        $('#createCardDiv').find('input').each(function() {
           if($(this).attr('id') !== "cardholder_name") {
                if($(this).val() === "" || null === $(this).val()) {
                    $(this).addClass('input-error');
                    valid = false;
                } else {
                    $(this).removeClass('input-error');
                }
           }
        });
        return valid;
    }

    function validateUpdate() {
        if($('u_exp_month').val() === "") {
            loading('error', 'Invalid value for expiration month');
            return false;
        }
        if($('u_exp_year').val() === "") {
            loading('error', 'Invalid value for expiration year');
            return false;
        }
        return true;
    }
}

function activateInputEvent() {
    $("#country").change(function() {
        $.ajax({
            url: base_url + "registration/getCountryStates",
            data: {'country': $("#country").val()},
            cache: false,
            type: 'post',
            success: function(data) {
                $("#state").html(data);
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
    });
}

function activateUpdateEvents() {
    $("#updateBasicInfoBtn").click(function() {
        if (validateBasic() === true) {
            loading('info', 'Saving account, please wait...');
            $.ajax({
                url: base_url + 'main/updateMyAccount',
                data: {
                    first_name: $('#firstname').val(),
                    last_name: $('#lastname').val(),
                    phone: $('#phone').val(),
                    email: $('#email').val(),
                    country: $('#country').val(),
                    state: $('#state').val()
                },
                type: 'post',
                cache: false,
                success: function(data) {
                    if (data === "OK") {
                        loading('success', 'Saving account successful!');
                    } else {
                        loading('danger', 'Saving account failed: ' + data);
                    }
                    $("#updateBasicInfoBtn").prop('disabled', false).html("Update");
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        }
    });

    $("#updateAdvanceBtn").click(function() {
        if (validateBasic() === true) {
            loading('info', 'Verifying credentials, please wait...');
            $.ajax({
                url: base_url + 'main/verifyTwitterCredentials',
                data: {
                    consumer_key: $('#consumerKey').val(),
                    consumer_secret: $('#consumerSecret').val(),
                    access_token: $('#accessToken').val(),
                    access_token_secret: $('#accessTokenSecret').val()
                },
                type: 'post',
                cache: false,
                success: function(data) {
                    if (data === "OK") {
                        loading('success', 'Saving twitter credentials successful!');
                    } else {
                        loading('danger', data);
                    }
                    $("#updateBasicInfoBtn").prop('disabled', false).html("Update");
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        }
    });

    $('#updatePasswordBtn').click(function() {
        if (validatePassword() === true) {
            $("#updatePasswordBtn").prop('disabled', true).html("<img src='" + base_url + "resources/images/ajax-loader.gif' />");
            $.ajax({
                url: base_url + 'main/changePassword',
                data: {currentPassword: $('#currentPassword').val(), newPassword: $('#newPassword').val()},
                type: 'post',
                cache: false,
                success: function(data) {
                    if (data === "OK") {
                        $('#passwordMessage').removeClass().addClass('alert alert-success')
                                .html("<i class='fa fa-check'></i> Changing Password Successful!");
                        toastr.success('Changing Password Successful!');
                        $('#currentPassword').val("");
                        $('#newPassword').val("");
                        $('#confirmPassword').val("");
                    } else {
                        $('#passwordMessage').removeClass().addClass('alert alert-danger')
                                .html("<i class='fa fa-exclamation'></i> " + data);
                    }
                    $("#updatePasswordBtn").prop('disabled', false).html("Update");
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        }
    });
}

function validateBasic() {
    var valid = true;
    $('#basic').find('.required').each(function() {
        if ($(this).val() === "") {
            $(this).addClass('panel-danger');
            valid = false;
        } else {
            $(this).removeClass('panel-danger');
        }
    });
    if (valid) {
        if (isValidEmail($("#email").val())) {
            return true;
        } else {
            $('#basicMessage').removeClass().addClass('alert alert-danger')
                    .html("<i class='fa fa-exclamation'></i> Email field must be a valid email address.");
            return false;
        }
    } else {
        $('#basicMessage').removeClass().addClass('alert alert-danger')
                .html("<i class='fa fa-exclamation'></i> A required field is empty.");
        return false;
    }
}

function validatePassword() {
    if ($('#newPassword').val().length < 5) {
        $('#passwordMessage').removeClass().addClass('alert alert-danger')
                .html("<i class='fa fa-exclamation'></i> New Password must have atleast 5 characters.");
        return false;
    }
    if ($('#newPassword').val() !== $('#confirmPassword').val()) {
        $('#passwordMessage').removeClass().addClass('alert alert-danger')
                .html("<i class='fa fa-exclamation'></i> New Password and Confirm Password did not match.");
        return false;
    }
    return true;
}

function isValidEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}