$(document).ready(function() {
    $("#registrationForm").find(".helper").each(function() {
        $(this).popover({
            'trigger': 'hover'
        });
    });
/*    $("#username").focusout(function() {
        validateUsername();
    });*/
    $("#email").focusout(function() {
        validateEmail();
    });

    $("#country").change(function() {
        $('#state').attr('disabled', true);
        $.ajax({
            url: base_url + "registration/getCountryStates",
            data: {'country': $("#country").val()},
            cache: false,
            type: 'post',
            success: function(data) {
                $("#state").html(data);
                $('#state').attr('disabled', false);
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
    });

    $('#registerBtn').click(function() {
        if (validate()) {
            loading("info", "Registering, please wait...");
            $.ajax({
                url: base_url + "registration/create",
                data: {
                    firstname: encodeURIComponent($('#firstname').val()),
                    lastname: encodeURIComponent($('#lastname').val()),
                    password: encodeURIComponent($('#password').val()),
                    phone: encodeURIComponent($('#phone').val()),
                    email: $('#email').val(),
                    country: encodeURIComponent($('#country').val()),
                    state: encodeURIComponent($('#state').val())
                },
                type: "POST",
                success: function(data) {
                    if (data === "OK") {
                        window.location = base_url + "registration/thankyou";
                    }
                }
            });
        }
    });
});

function validate() {
    var error = "";
    if (validEmail) {
        var validRequired = true;
        $("#registrationForm").find(".required").each(function() {
            if ($(this).val() === "") {
                $(this).addClass('input-error');
                validRequired = false;
            } else {
                $(this).removeClass('input-error');
            }
        });
        if (validRequired) {
            if ($('#password').val() === $('#confirmPassword').val()) {
                if ($('#email').val() === $('#confirmEmail').val()) {
                    return true;
                } else {
                    error = "Email and confirm email did not match.";
                }
            } else {
                error = "Password and confirm password did not match.";
            }
        } else {
            error = "A field is empty, please fill up all fields.";
        }
    } else {
        error = "Invalid Email";
    }
    $('#regMessage').removeClass().addClass('alert alert-danger')
            .html("<i class='fa fa-exclamation'></i> " + error);
    $("html, body").animate({scrollTop: 0}, "slow");
    return false;
}

var validUsername = false;
var validEmail = false;

function validateUsername() {
    if ($("#username").val().length > 3) {
        $.ajax({
            url: base_url + "registration/checkUsername",
            data: {'username': $("#username").val()},
            cache: false,
            type: 'post',
            success: function(data) {
                if (data === "OK") {
                    $("#username").css({'background': '#dff0d8'});
                    $("#usernameMessage").removeClass().addClass("text-success")
                            .html("<i class='fa fa-check'></i> Username available!");
                    validUsername = true;
                } else {
                    $("#username").css({'background': '#f2dede'});
                    $("#usernameMessage").removeClass().addClass("text-danger")
                            .html("<i class='fa fa-exclamation'></i> Username is already taken!");
                    validUsername = false;
                }
            }
        });
    } else {
        $("#username").css({'background': 'white'});
        $("#usernameMessage").removeClass().html("");
        validUsername = false;
    }
}

function validateEmail() {
    if (isValidEmail($("#email").val())) {
        $.ajax({
            url: base_url + "registration/checkEmail",
            data: {'email': $("#email").val()},
            cache: false,
            type: 'post',
            success: function(data) {
                if (data === "OK") {
                    $("#email").css({'background': '#dff0d8'});
                    $("#emailMessage").removeClass().addClass("text-success")
                            .html("<i class='fa fa-check'></i> Email available!");
                    validEmail = true;
                } else {
                    $("#email").css({'background': '#f2dede'});
                    $("#emailMessage").removeClass().addClass("text-danger")
                            .html("<i class='fa fa-exclamation'></i> This email is already registered.");
                    validEmail = false;
                }
            }
        });
    } else {
        $("#email").css({'background': 'white'});
        $("#emailMessage").removeClass().addClass("text-danger")
                .html("<i class='fa fa-exclamation'></i> Invalid email format.");
        validEmail = false;
    }
}