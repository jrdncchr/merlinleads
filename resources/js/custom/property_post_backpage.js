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
    $('#postCompleteBtn').click(function() {
        $("#postCompleteBtn").prop('disabled', true).html("<img src='" + base_url + "resources/images/ajax-loader.gif' />");
        $.ajax({
            url: base_url + "property_module/backpagePostComplete",
            data: {type: $('#type').val(), title: $('#title').val()},
            type: 'post',
            success: function(data) {
                if (data === "OK") {
                    window.location = base_url + "property";
                }
            }
        });
    });
    $('#generateBtn').click(function() {
        $("#generateBtn").prop('disabled', true).html("<img src='" + base_url + "resources/images/ajax-loader.gif' />");
        $.ajax({
            url: base_url + 'property_module/generateBackpageModule',
            data: {type: $('#type').val()},
            type: 'post',
            cache: false,
            dataType: 'json',
            success: function(data) {
                if (data.result === "OK") {
                    $('#generateDiv').fadeOut("fast");
                    $('#price').val(data.price);
                    $('#bedrooms').val(data.bedrooms);
                    $('#title').val(data.title);
                    $('#specificLocation').val(data.specific_location);
                    $('#description').val(data.description);
                    $('#address').val(data.address);
                    $('#zipcode').val(data.zip_code);
                    $('#crossStreet').val(data.cross_street);
                    $('#location').val(data.location);
                    $('#zipcode2').val(data.zip_code);
                    $('#email').val(data.email);
                    $('#type').attr('disabled', true);
                    $('#postCompleteDiv').fadeIn("slow");
                    $('#postMessage').removeClass().addClass('alert alert-info')
                            .html("<i class='fa fa-info'></i> Generating successful! Don't forget to click post complete button after you finish posting the generated information.");
                } else {
                    $('#generateDiv').fadeOut("fast");
                    $('#postMessage').removeClass().addClass('alert alert-danger')
                            .html("<i class='fa fa-info'></i> " + data.result);
                }
            }
        });
    });

    $('#type').change(function() {
        if ($('#type').val() === "Video") {
            $('#postMessage').removeClass().addClass("alert alert-warning")
                    .html("<i class='fa fa-exclamation'></i> Make sure that you have filled up the Video information on this module to avoid having empty fields.");
            $("#generateBtn").prop('disabled', false).html("Generate");
            $('#generateDiv').fadeIn("fast");
        } else {
            $('#postMessage').removeClass().html("");
            $("#generateBtn").prop('disabled', false).html("Generate");
            $('#generateDiv').fadeIn("fast");
        }
    });
}