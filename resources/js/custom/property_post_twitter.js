$(document).ready(function () {
    activateBasicEvents();

    $('#rbCustom').click(function () {
        $('#customUrl').attr('disabled', false);
    });
    $('#rbProperty').click(function () {
        $('#customUrl').attr('disabled', true);
    });

    $('#enableBtn').click(function () {
        var option = $("input[name='option']:checked").val();
        if (option === "Custom") {
            if (isUrl($('#customUrl').val())) {
                $('#customUrl').removeClass('input-error');
                enableTwitterModule();
            } else {
                $('#customUrl').addClass('input-error');
                loading('danger', "Input must be a valid URL.");
            }
        } else {
            enableTwitterModule();
        }
    });

    $('#disableBtn').click(function() {
        var ok = confirm("Are you sure you want to disable twitter autoposting?");
        if(ok) {
            disableTwitterModule();
        }
    });
});

function enableTwitterModule() {
    loading('info', "Enabling twitter auto post, please wait...");
    $.ajax({
        url: base_url + "property_module/enableTwitterAutoPost",
        type: "POST",
        data: {option: $("input[name='option']:checked").val(), url: $('#customUrl').val()},
        dataType: 'json',
        success: function (data) {
            if (data.error) {
                loading('error', data.error);
            } else {
                if (data.result === "OK") {
                    loading('success', "Twitter auto post is now enabled!");
                    $('#enableBtn').hide();
                    $('#disableBtn').fadeIn('slow');
                }
            }
        }
    });
}

function disableTwitterModule() {
    loading('info', "Disabling Twitter auto post.");
    $.ajax({
        url: base_url + "property_module/disableTwitterAutoPost",
        dataType: 'json',
        success: function(data) {
            if(data.error) {
                loading('error', data.error);
            } else {
                if(data.result === "OK") {
                    loading('success', "Twitter auto post is now disabled!");
                    $('#disableBtn').hide();
                    $('#enableBtn').fadeIn('slow');
                }
            }
        }
    });
}

/*
Basic Events
 */

function activateBasicEvents() {
    $("#generateBtn").off('click').click(function() {
        loading("info", "Generating Twitter Tweet");
        $.post(base_url + "property_module/generateTwitterBasic", {templateNo: $("#templateNo").val()}, function(data) {
            $("#tweet").val(data.description);
        }, "json");
    });
    $("a#copyTweet").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function() {
            return $('#tweet').val();
        }
    });
}
