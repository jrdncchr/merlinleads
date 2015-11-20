$(document).ready(function() {
    activateEvents();
    activatePopovers();
    activateCopyToClipboard();
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
            url: base_url + "property_module/ebayPostComplete",
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
            url: base_url + 'property_module/generateEbayModule',
            data: {type: $('#type').val()},
            type: 'post',
            cache: false,
            dataType: 'json',
            success: function(data) {
                if (data.result === "OK") {
                    $('#generateDiv').fadeOut("fast");
                    $('#title').val(data.title);
                    $('#description').val(data.description);
                    $('#zipcode').val(data.zipcode);
                    $('#sqft').val(data.sqft);
                    $('#price').val(data.price);
                    $('#bedrooms').val(data.bedrooms);
                    $('#bathrooms').val(data.bathrooms);
                    $('#phone').val(data.phone);
                    $('#yearBuilt').val(data.year_built);
                    $('#size').val(data.size);
                    $('#street').val(data.street);
                    $('#email').val(data.email);
                    $('#city').val(data.city);
                    $('#state').val(data.state);
                    activateCopyToClipboard();
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

function activateCopyToClipboard() {
    $("a#copyTitle").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#title').val();
        }
    });
    $("a#copyBedrooms").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#bedrooms').val();
        }
    });
    $("a#copyPrice").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#price').val();
        }
    });
    $("a#copyBedrooms").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#bedrooms').val();
        }
    });
    $("a#copyBathrooms").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#bathrooms').val();
        }
    });
    $("a#copyDescription").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#description').val();
        }
    });
    $("a#copySize").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#size').val();
        }
    });
    $("a#copyYearBuilt").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#yearBuilt').val();
        }
    });
    $("a#copyEmail").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#email').val();
        }
    });
    $("a#copyPhone").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#phone').val();
        }
    });
    $("a#copyStreet").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#street').val();
        }
    });
    $("a#copyZipcode").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#zipcode').val();
        }
    });
    $("a#copyCity").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#city').val();
        }
    });
    $("a#copyState").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#state').val();
        }
    });
}