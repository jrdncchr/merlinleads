$(document).ready(function() {
    activateEvents();
});

function activateEvents() {
    $('#tscModule').change(function() {
        $.ajax({
            url: base_url + "admin/changeModuleSc",
            data: {category: $('#tscCategory').val(), module: $('#tscModule').val()},
            type: 'post',
            cache: false,
            success: function(data) {
                $('#tscType').html(data);
                $('#tscShortcode').prop('disabled', true).html("");
                $('#tscShortcodeVal').prop('readonly', true).val("");
            }
        });

    });

    $('#tscType').change(function() {
        if ($('#tscType').val() !== "") {
            getShortcodes();
        } else {
            $('#tscShortcode').prop('disabled', true).html("");
            $('#tscShortcodeVal').prop('readonly', true).val("");
        }
    });

    $('#tscShortcode').change(function() {
        getShortcodeVal();
    });

    // add shortcode validation
    var validShortcode = true;
    $('#addScShortcode').focusout(function() {
        $.ajax({
            url: base_url + 'admin/validateTemplateScShortcode',
            data: {category: $('#tscCategory').val(), module: $('#tscModule').val(), shortcode: $('#addScShortcode').val()},
            cache: false,
            type: 'post',
            success: function(data) {
                if (data === "Unavailable") {
                    $('#addScShortcode').addClass('input-error');
                    $('#addScMessage').removeClass().addClass('alert alert-danger')
                            .html("<i class='fa fa-exclamation'></i> The shortcode you entered is similar to an existing shortcode or invalid!");
                    validShortcode = false;
                } else {
                    $('#addScShortcode').removeClass('input-error');
                    $('#addScMessage').removeClass().html("");
                    validShortcode = true;
                }
            }
        });
    });

    $('#addScBtn').click(function() {
        if ($('#tscType').val() !== "") {
            if (validate("addSc")) {
                if (validShortcode) {
                    $.ajax({
                        url: base_url + 'admin/addTemplateSc',
                        data: {category: $('#tscCategory').val(), module: $('#tscModule').val(), type: $('#tscType').val(), shortcode: $('#addScShortcode').val(), content: $('#addScContent').val()},
                        type: 'post',
                        cache: false,
                        success: function(data) {
                            if (data === "OK") {
                                getShortcodes();
                                toastr.success("Adding Shortcode Successful!");
                                $('#addScShortcode').val("");
                                $('#addScContent').val("");
                                $('#addTemplateScModal').modal('hide');
                            } else {
                                alert(data);
                            }
                        }
                    });
                }
            }
        } else {
            $('#addScMessage').removeClass().addClass('alert alert-danger')
                    .html("<i class='fa fa-exclamation'></i> Please select a type first.");
        }
    });

    $('#deleteScBtn').click(function() {
        if ($('#tscType').val() !== "") {
            var ok = confirm("Are you sure you want to delete this shortcode?");
            if (ok) {
                $.ajax({
                    url: base_url + 'admin/deleteTemplateSc',
                    data: {category: $('#tscCategory').val(), scid: $('#tscShortcode').val()},
                    type: 'post',
                    cache: false,
                    success: function(data) {
                        if (data === "OK") {
                            getShortcodes();
                            toastr.error("Deleting Shortcode Successful!");
                        }
                    }
                });
            }
        }
    });

    $('#updateScBtn').click(function() {
        if ($('#tscType').val() !== "") {
            $.ajax({
                url: base_url + 'admin/updateTemplateSc',
                data: {category: $('#tscCategory').val(), scid: $('#tscShortcode').val(), content: $('#tscShortcodeVal').val()},
                type: 'post',
                cache: false,
                success: function(data) {
                    if (data === "OK") {
                        toastr.success("Updating Shortcode Successful!");
                    }
                }
            });
        }
    });

    function getShortcodes() {
        $.ajax({
            url: base_url + 'admin/getShortcodes',
            data: {category: $('#tscCategory').val(), module: $('#tscModule').val(), type: $('#tscType').val()},
            type: 'post',
            cache: false,
            success: function(data) {
                $('#tscShortcode').html(data);
                $('#tscShortcode').prop('disabled', false);
                $('#tscShortcodeVal').prop('readonly', false);
                getShortcodeVal();
            }
        });
    }

    function getShortcodeVal() {
        $.ajax({
            url: base_url + 'admin/getShortcodeVal',
            data: {category: $('#tscCategory').val(), module: $('#tscModule').val(), type: $('#tscType').val(), scid: $('#tscShortcode').val()},
            type: 'post',
            cache: false,
            success: function(data) {
                $('#tscShortcodeVal').val(data);
            }
        });
    }

}