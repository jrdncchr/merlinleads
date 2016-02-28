$(document).ready(function() {
    activateEvents();
});

function activateEvents() {
    $('#changePasswordBtn').click(function() {
        $.ajax({
            url: base_url + "test/change_password",
            data: {username: $('#username').val(), password: $('#password').val()},
            type: "POST",
            success: function(data) {
                alert(data);
            }
        });
    });

    $('#validatePasswordBtn').click(function() {
        $.ajax({
            url: base_url + "test/validate_password",
            data: {password: $('#v_password').val()},
            type: "POST",
            success: function(data) {
                alert(data);
            }
        });
    });
}