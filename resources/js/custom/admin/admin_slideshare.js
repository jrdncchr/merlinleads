$(document).ready(function() {
    activateEvents();
});

function activateEvents() {
    $('#addForm').submit(function(e) {
        e.preventDefault();
        $.ajaxFileUpload({
            url: base_url + "admin/upload_slideshare_bg/" + $('#title').val(),
            secureuri: false,
            fileElementId: 'userfile',
            dataType: 'json',
            success: function(data) {
                if (data.status !== 'error') {
                    window.location = base_url + "admin/slideshare";
                } else {
                    alert(data.msg);
                }
            }
        });
    });

    $('#bg').change(function() {
        $('#bg-preview').attr('src', base_url + "resources/images/ppt/bg/" + $('#bg').val());
    });

    $('#deleteBtn').click(function() {
        if ($('#bg').val() !== "" || null === $('#bg').val()) {
            var ok = confirm("Are you sure to delete this bg?");
            if (ok) {
                $.ajax({
                    url: base_url + "admin/delete_slideshare_bg",
                    data: {file: $('#bg').val()},
                    type: "post",
                    success: function(data) {
                        if (data === "OK") {
                            window.location = base_url + "admin/slideshare";
                        }
                    }
                });
            }
        }
    });
}