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
    $('#generateBtn').click(function() {
        $("#generateBtn").prop('disabled', true).html("<img src='" + base_url + "resources/images/ajax-loader.gif' />");
        $.ajax({
            url: base_url + 'property_module/generateCraiglistModule',
            data: {type: $('#type').val()},
            type: 'post',
            cache: false,
            dataType: 'json',
            success: function(data) {
                if (data.result === "OK") {
                    $('#generateDiv').fadeOut("fast");
                    $('#phone').val(data.phone);
                    $('#contactName').val(data.contact_name);
                    $('#postingTitle').val(data.posting_title);
                    $('#postingBody').val(data.posting_body);
                    $('#postalCode').val(data.postal_code);
                    $('#specificLocation').val(data.specific_location);
                    $('#sqft').val(data.sqft);
                    $('#price').val(data.price);
                    $('#bathrooms').val(data.bathrooms);
                    $('#bedrooms').val(data.bedrooms);
                    $('#startTime').val(data.start_time);
                    $('#endTime').val(data.end_time);
                    $('#housingType').val(data.housing_type);
                    $('#laundry').val(data.laundry);
                    $('#parking').val(data.parking);
                    $('#street').val(data.street);
                    $('#crossStreet').val(data.cross_street);
                    $('#city').val(data.city);
                    $('#stateAbbr').val(data.state_abbr);
                    if ($.trim(data.wheelchair_accessible) === "yes") {
                        $('#wheelchairAccessible').prop('checked', true);
                    }
                    if ($.trim(data.no_smoking) === "yes") {
                        $('#noSmoking').prop('checked', true);
                    }
                    if ($.trim(data.furnished) === "yes") {
                        $('#furnished').prop('checked', true);
                    }
                    $('#type').attr('disabled', true);
                    activateCopyToClipboard();
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

    $('#postCompleteBtn').click(function() {
        $("#postCompleteBtn").prop('disabled', true).html("<img src='" + base_url + "resources/images/ajax-loader.gif' />");
        $.ajax({
            url: base_url + "property_module/craiglistPostComplete",
            data: {type: $("#type").val(), title: $('#postingTitle').val()},
            type: 'post',
            success: function(data) {
                if (data === "OK") {
                    window.location = base_url + "property";
                } else {
                    alert(data);
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
    $("a#copyPhone").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#phone').val();
        }
    });
    $("a#copyContactName").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#contactName').val();
        }
    });
    $("a#copyPostingTitle").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#postingTitle').val();
        }
    });
    $("a#copySpecificLocation").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#specificLocation').val();
        }
    });
    $("a#copyPostalCode").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#postalCode').val();
        }
    });
    $("a#copyPostingBody").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#postingBody').val();
        }
    });
    $("a#copySqft").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#sqft').val();
        }
    });
    $("a#copyPrice").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#price').val();
        }
    });
    $("a#copyStreet").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#street').val();
        }
    });
    $("a#copyCrossStreet").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#crossStreet').val();
        }
    });
    $("a#copyCity").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#city').val();
        }
    });
    $("a#copyStateAbbr").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#stateAbbr').val();
        }
    });
}