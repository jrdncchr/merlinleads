$(document).ready(function() {
    activateEvents();
});

function activateEvents() {
    $('#module').change(function() {
        getList();
    });
    $('#type').change(function() {
        getList();
    });
    $('#showAddBtn').click(function() {
        $('#modalTitle').html("Add");
        $('#addBtn').show();
        $('#editBtn').hide();
        $('#hsCtaModal').modal('show');
    });
    $('#addBtn').click(function() {
        loading("info", "Adding data, please wait...");
        $.ajax({
            url: base_url + "admin/addHsCta",
            data: {'module': $('#module').val(), 'type': $('#type').val(), 'content': $('#modalData').val()},
            type: 'post',
            success: function(data) {
                if (data === "Success") {
                    getList();
                    $('#hsCtaModal').modal('hide');
                    loading("success", "Adding data successful!");
                }
            }
        });
    });
    $('#showEditBtn').click(function() {
        $('#modalTitle').html("Edit");
        $('#editBtn').show();
        $('#addBtn').hide();
        $('#modalData').val($('#list option:selected').html());
        $('#hsCtaModal').modal('show');
    });
    $('#editBtn').click(function() {
        loading("info", "Updating data, please wait...");
        $.ajax({
            url: base_url + "admin/updateHsCta",
            data: {'id': $('#list option:selected').val(), 'content': $('#modalData').val()},
            type: 'post',
            success: function(data) {
                if (data === "Success") {
                    getList();
                    $('#hsCtaModal').modal('hide');
                    loading("success", "Updating data successful!");
                }
            }
        });
    });
    $('#deleteBtn').click(function() {
        var ok = confirm("Are you sure you want to delete this data?");
        if (ok) {
            loading("info", "Deleting data, please wait...");
            $.ajax({
                url: base_url + "admin/deleteHsCta",
                data: {'id': $('#list option:selected').val()},
                type: 'post',
                success: function(data) {
                    if (data === "Success") {
                        getList();
                        $('#hsCtaModal').modal('hide');
                        loading("danger", "Deleting data successful!");
                    }
                }
            });
        }
    });

    $('#hsCtaModal').on('hidden.bs.modal', function() {
        $('#modalData').val("");
    });
}

function getList() {
    $('#list').attr('disabled', true);
    $.ajax({
        url: base_url + "admin/getHsCta",
        data: {'module': $('#module').val(), 'type': $('#type').val()},
        type: 'post',
        success: function(data) {
            $('#list').html(data);
            $('#list').attr('disabled', false);
        }
    });
}