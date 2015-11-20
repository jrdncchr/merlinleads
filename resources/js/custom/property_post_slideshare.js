$(document).ready(function () {
    activatePopovers();
    activateEvents();
    activateAdvanceEvents();
    activateCopyToClipboard();
});

function activatePopovers() {
    $(document).find(".helper").each(function () {
        $(this).popover({
            'trigger': 'hover'
        });
    });
}

function activateEvents() {
    $('#selectTemplate').change(function () {
        loading("info", "Generating Template, please wait...");
        $.ajax({
            url: base_url + 'property_module/getMediaTemplate',
            data: {poID: $('#poID').val(), templateNo: $('#selectTemplate').val()},
            type: 'post',
            cache: false,
            dataType: 'json',
            success: function (data) {
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
                loading("success", "Generating Template Successful!");
                $('#title').val(data.title);
                $('#description').html(data.description);
                $('#keyword').html(data.keyword);

                $('#generateSlideBtn').show();
                $('#generateOptions').show();
                $('#downloadDiv').hide();
                $('#postDiv').hide();
            }
        });
    });

    $('#generateBtn').click(function () {
        loading("info", "Generating Template, please wait...");
        $("#generateBtn").prop('disabled', true).html("<img src='" + base_url + "resources/images/ajax-loader.gif' />");
        $.ajax({
            url: base_url + 'property_module/generateMediaTemplate',
            data: {poID: $('#poID').val(), templateNo: $('#selectTemplate').val()},
            type: 'post',
            cache: false,
            dataType: 'json',
            success: function (data) {
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
                loading("success", "Generating Template Successful!");
                $('#title').val(data.title);
                $('#description').html(data.description);
                $('#keyword').html(data.keyword);
                $('#ssTitle').val(data.title);
                $('#ssDescription').html(data.description);
                $('#ssTags').html(data.keyword);
                $("#generateBtn").prop('disabled', false).html("Generate");
                $("#generateBtn").fadeOut();
            }
        });
    });
}

function activateAdvanceEvents() {
    $('.list-group-item').popover({
        trigger: "hover",
        html: true,
        placement: "top"
    });
    $('#bg').change(function () {
        $('#bg-preview').attr('src', base_url + "resources/images/ppt/bg/" + $('#bg').val());
    });
    $('#generateSlideBtn').click(function () {
        if($('#title').val() !== "" && $('#description').val() !== "" && $('#keyword').val() !== "") {
            var slides = "";
            $('#slidesOrder').find(".list-group-item").each(function () {
                slides += $(this).html() + ",";
            });
            if (slides !== "") {
                loading('info', 'Generating slide, please wait...');
                slides = slides.slice(0, -1);
                $.ajax({
                    url: base_url + "property_module/generateSlideshareSlide",
                    data: {type: "Homes", slides: slides, bg: $('#bg').val(), templateNo: $('#selectTemplate').val()},
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        if (data.result === "OK") {
                            $('#ssUpload').val(data.download_url);
                            $('#downloadLink').attr('href', data.download_url);
                            $('#generateSlideBtn').hide();
                            $('#generateOptions').hide();
                            $('#downloadDiv').show();
                            $('#postDiv').show();
                            $('#postSuccessMessage').html("").hide();
                            $('#postInputs').show();
                            loading('success', 'Generating slide successful...');
                        } else {
                            loading('danger', 'Generating slide failed.. ');
                        }

                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            } else {
                loading('danger', 'Please make sure the Slide to be generated have atleast one data.');
            }
        } else {
            loading('danger', 'Please click the generate button in the regular tab first.');
        }

    });

    $('#postToSlideshare').click(function() {
       if(validatePostForm()) {
           loading('info', 'Posting to Slideshare please wait...');
           $.ajax({
               url: base_url + "property_module/postSlideShare",
               data: {username: $('#ssUsername').val(), password: $('#ssPassword').val(), upload_url: $('#ssUpload').val(),
                        'title': $('#title').val(), 'description': $('#description').val(), 'tags': $('#keyword').val()},
               dataType: 'json',
               type: 'POST',
               success: function(data) {
                   if(data.SlideShowID) {
                       loading('success', "Posting to Slideshare successful!");
                       $('#postSuccessMessage').html("<i class='fa fa-check'></i> You have successfully posted this side in your slideshare account!").show();
                       $('#postInputs').hide();
                   } else {
                       loading('danger', data.Message);
                   }
               }
           });
       }
    });

}
function validatePostForm() {
    if($('#ssUsername').val() !== "" && $('#ssPassword').val() !== "") {
        return true;
    }
    loading('danger', 'Please enter you username and password');
    return false;
}

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text/html", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text/html");
    ev.target.appendChild(document.getElementById(data));
}
function activateCopyToClipboard() {
    $("a#copyDescription").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function () {
            return $('#description').html();
        }
    });
    $("a#copyTitle").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function () {
            return $('#title').val();
        }
    });
    $("a#copyKeyword").zclip({
        path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
        copy: function () {
            return $('#keyword').html();
        }
    });
}