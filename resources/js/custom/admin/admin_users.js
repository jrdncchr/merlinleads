$(document).ready(function () {
    setupUsersDatatable();
    activateEvents();
});
function setupUsersDatatable() {
    $('#users').dataTable({
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $(nRow).children().each(function (index, td) {
                if (index === 1) {
                    if ($(td).html() === "active") {
                        $(td).css({"background-color": "#5cb85c", 'color': 'white'});
                    } else if ($(td).html() === "pending") {
                        $(td).css({"background-color": "#5B6665", 'color': 'white'});
                    } else if ($(td).html() === "disabled") {
                        $(td).css({"background-color": "#d9534f", 'color': 'white'});
                    }
                }
            });
            return nRow;
        },
        "bJQueryUI": true,
        "bProcessing": true,
        "bFilter": true,
        "bInfo": false,
        "bServerSide": true,
        "sAjaxSource": base_url + "admin/getUsersOverview",
        "aoColumnDefs": [{
            "aTargets": [0], // Column to target
            "mRender": function (data, type, full) {
                return '<button type="button" onclick="editUser(' + full[0] + ')"  class="btn btn-primary btn-xs" style="padding: 0px 10px !important; width: 80px;">\n\
                                    <i class="fa fa-edit"></i> Edit\n\
                                </button>\n\
<button type="button" onclick="loginUser(' + full[0] + ')" class="btn btn-primary btn-xs" style="padding: 0px 10px !important; width: 80px;">\n\
                                    <i class="fa fa-user"></i> Login\n\
                                </button>';
            }
        }]
    });
}
var user_id;
function editUser(id) {
    user_id = id;
    $('#userDetailLodaer').show();
    $('#userDetailForm').hide();
    $("#userDetailModal").modal('show');
    $('#classified').prop('checked', false);
    $('#social').prop('checked', false);
    $('#media').prop('checked', false);
    $.ajax({
        url: base_url + "user/getUserDetails",
        data: {'user_id': id},
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            if (data.error) {
                $("#userDetailModal").modal('hide');
                alert(data.error);
            } else {
                $('#username').val(data.user['username']);
                $('#first-name').val(data.user['firstname']);
                $('#last-name').val(data.user['lastname']);
                $('#phone').val(data.user['phone']);
                $('#email').val(data.user['email']);
                $('#country').val(data.user['country']);
                $('#state').html(data.state);
                $('#type').val(data.user['type']);
                $('#status').val(data.user['status']);
                $('#userDetailForm').show();
                $('#userDetailLodaer').hide();
            }
        },
        error: function (xhr, status, error) {
            alert(error);
        }
    });
}

function loginUser(id) {
    $.ajax({
        url: base_url + "user/loginUser",
        data: {id: id},
        type: "POST",
        success: function (data) {
            if (data === "OK") {
                window.location = base_url + "property";
            }
        }
    });
}

function activateEvents() {
    $('#saveBtn').click(function () {
        loading('info', "Saving User details, please wait...");
        var classified = $('#classified').is(":checked") ? "yes" : "no";
        var media = $('#media').is(":checked") ? "yes" : "no";
        var social = $('#social').is(":checked") ? "yes" : "no";
        $.ajax({
            url: base_url + "user/updateUserDetails",
            data: {
                'user_id': user_id,
                'firstname': $('#first-name').val(),
                'lastname': $('#last-name').val(),
                'phone': $('#phone').val(),
                'email': $('#email').val(),
                'country': $('#country').val(),
                'state': $('#state').val(),
                'type': $('#type').val(),
                'status': $('#status').val(),
                'classified': classified,
                'social': social,
                'media': media
            },
            type: 'POST',
            success: function (data) {
                if (data === "OK") {
                    loading("success", "Saving User Details successful!");
                    var dt = $("#users").dataTable();
                    dt.fnReloadAjax();
                } else {
                    alert(data);
                }
            },
            error: function (xhr, status, error) {
                alert(error);
            }
        });
    });

    $("#country").change(function () {
        $.ajax({
            url: base_url + "registration/getCountryStates",
            data: {'country': $("#country").val()},
            cache: false,
            type: 'post',
            success: function (data) {
                $("#state").html(data);
            },
            error: function (xhr, status, error) {
                alert(error);
            }
        });
    });

    $('#changePasswordBtn').click(function () {
        if ($('#newPassword').val().length > 4) {
            var verify = confirm('Are you sure to change the password of this user?');
            if (verify) {
                loading("info", "Changing password, please wait...");
                $.ajax({
                    url: base_url + "user/changePassword",
                    data: {id: user_id, newPassword: $('#newPassword').val()},
                    type: 'POST',
                    success: function (data) {
                        if (data === "OK") {
                            $('#newPassword').val("")
                            loading("success", "Changing password successful!");
                        } else {
                            loading("danger", "Changing password failed!");
                        }
                    }
                });
            }
        } else {
            alert("New Password should be at least 5 characters.");
        }
    });

    $('#deleteUserBtn').click(function () {
        var verify = confirm("Are you sure to delete this user?");
        if (verify) {
            loading("info", "Deleting user, please wait...");
            $.ajax({
                url: base_url + "user/deleteUser",
                data: {id: user_id},
                type: 'POST',
                success: function (data) {
                    if (data === "OK") {
                        var oTable = $('#users').dataTable();
                        oTable.fnReloadAjax();
                        $("#userDetailModal").modal('hide');
                        loading('success', "Deleting user successful!");
                    } else {
                        loading('danger', "Deleting user failed!");
                    }
                }
            });
        }
    });
}