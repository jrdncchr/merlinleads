$(document).ready(function () {
    activateProfileTable();
});

function activateProfileTable() {
    $('#profiles').dataTable({
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $(nRow).children().each(function (index, td) {
                if (index === 3) {
                    if ($(td).html() === "Active") {
                        $(td).css({"background-color": "#5cb85c", 'color': 'white'});
                    } else if ($(td).html() === "Inactive") {
                        $(td).css({"background-color": "#d9534f", 'color': 'white'});
                    } else if ($(td).html() === "Edit") {
                        $(td).css({"background-color": "lightgrey", 'color': 'black'});
                    }
                }
            });
            return nRow;
        },
        "bJQueryUI": true,
        "bFilter": false,
        "bInfo": false,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": base_url + "profiles/getProfiles",
        "aoColumnDefs": [{
            "aTargets": [0],
            "mRender": function (data, type, full) {
                return '<div class="btn-group">\n\
                                <button type="button" class="btn btn-primary btn-xs dropdown-toggle" style="padding: 0px 10px !important;" data-toggle="dropdown">\n\
                                    Actions <span class="caret"></span>\n\
                                </button>\n\
                                <ul class="dropdown-menu" role="menu">\n\
                                    <li><a href="' + base_url + 'profiles/edit/' + full[0] + '"><i class="fa fa-edit"></i> Edit</a></li>\n\
                                    <li><a href="#" onclick="deleteProfile(' + full[0] + ');"><i class="fa fa-trash-o"></i> Delete</a></li>\n\
                                </ul>\n\
                            </div>';
            }
        }]
    });
    var oTable = $('#profiles').dataTable();
    oTable.fnSort([[3, 'desc']]);
}

function deleteProfile(id) {
    var verify = confirm('Are you sure to delete this profile?');
    if (verify) {
        $.ajax({
            url: base_url + 'profiles/delete',
            data: {id: id},
            type: 'post',
            cache: false,
            success: function (data) {
                if (data === "OK") {
                    var oTable = $('#profiles').dataTable();
                    oTable.fnReloadAjax();
                    toastr.error('Deleting Profile Successful!');
                } else {
                    alert(data);
                }
            },
            error: function (xhr, status, error) {
                alert(error);
            }
        });
    }
}