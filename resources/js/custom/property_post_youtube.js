$(document).ready(function() {
    activatePopovers();
    activateEvents();
});

function activatePopovers() {
    $(document).find(".helper").each(function() {
        $(this).popover({
            'trigger': 'hover'
        });
    });
}

function activateEvents() {
    $('#selectTemplate').change(function() {
        loading("info", "Generating Template, please wait...");
        $.ajax({
            url: base_url + 'property_module/getMediaTemplate',
            data: {poID: $('#poID').val(), templateNo: $('#selectTemplate').val()},
            type: 'post',
            cache: false,
            dataType: 'json',
            success: function(data) {
                if (data.module === "") {
                    $('#status').removeClass().addClass('text-success control-label')
                            .html("This template is available for posting.");
                    $("#generateBtn").fadeIn();
                } else {
                    $('#status').removeClass().addClass('text-danger control-label')
                            .html("This template is already posted.");
                    $("#generateBtn").fadeOut();
                }
                $('#postMessage').removeClass().html("");
                $('#link').removeClass('input-error');
                loading("success", "Generating Template Successful!");
                $('#link').val(data.link);
                $('#title').val(data.title);
                $('#description').html(data.description);
                $('#keyword').html(data.keyword);
            }
        });
    });

    $('#generateBtn').click(function() {
        loading("info", "Generating Template, please wait...");
        var module = $('#selectedModule').val();
        if (module === "Youtube") {
            if (isUrl($('#link').val())) {
                $("#generateBtn").prop('disabled', true).html("<img src='" + base_url + "resources/images/ajax-loader.gif' />");
                $.ajax({
                    url: base_url + 'property_module/generateMediaTemplate',
                    data: {poID: $('#poID').val(), templateNo: $('#selectTemplate').val(), link: $('#link').val()},
                    type: 'post',
                    cache: false,
                    dataType: 'json',
                    success: function(data) {
                        if (data.module === "") {
                            $('#generateBtn').prop('disabled', false);
                            $('#status').removeClass().addClass('text-success control-label')
                                    .html("This template is available for posting.");
                        } else {
                            $('#generateBtn').prop('disabled', true);
                            $('#status').removeClass().addClass('text-danger control-label')
                                    .html("This template is already posted.");
                        }
                        $('#postMessage').removeClass().addClass('alert alert-success')
                                .html("<i class='fa fa-check'></i> Generating template[" + $('#selectTemplate').val() + "] successful!");
                        $('#link').removeClass('input-error');
                        loading("success", "Generating Template Successful!");
                        $('#link').val(data.link);
                        $('#title').val(data.title);
                        $('#description').html(data.description);
                        $('#keyword').html(data.keyword);
                        $("#generateBtn").prop('disabled', false).html("Generate");
                        $("#generateBtn").fadeOut();
                    }
                });
            } else {
                $('#postMessage').removeClass().addClass('alert alert-danger')
                        .html("<i class='fa fa-exclamation'></i> Youtube Link must be a url.");
                $('#link').addClass('input-error');
            }
        }
    });
}

function activateCopyToClipboard() {
    $("a#copyDescription").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#description').html();
        }
    });
    $("a#copyTitle").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#title').val();
        }
    });
    $("a#copyKeyword").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#keyword').html();
        }
    });
}