$(document).ready(function() {
    activateImagesSaving();
    activateImageUpload();
});


function activateImagesSaving() {
    $('.save-image-btn').click(function(e) {
         e.preventDefault();
        saveImages($("#images-tab"), "button");
    });
    $('.show-image').mouseenter(function() {
        $(this).find(".upload-image-btn").fadeIn('fast');
    });
    $('.show-image').mouseleave(function() {
        $(this).find(".upload-image-btn").fadeOut('fast');
    });
}

function saveImages(tabToLook, tabToShow) {
    var fields = {};

    tabToLook.find('.form-group').each(function() {
        var field = {};
        field['field'] = $(this).find('.image-list').attr('id');
        field['text'] = $(this).find('.image-text').val();
        field['image1'] = $(this).find('.image1').css('background-image').replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');
        field['image2'] = $(this).find('.image2').css('background-image').replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');
        field['image3'] = $(this).find('.image3').css('background-image').replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');
        fields[$(this).find('.image-list').attr('id')] = field;
    });

    loading("info", "Saving Images, please wait...");
    $.ajax({
        url: base_url + "property_module/updatePropertyImageAll",
        data: {fields: fields},
        type: 'POST',
        success: function(data) {
            if (data === "OK") {
                loading("success", "Saving Images successful!");
                if (tabToShow !== "button") {
                    tabToShow.tab('show');
                }
            }
        }
    });
}

function activateImageUpload() {
    $('.upload').fileupload({
        dataType: 'json',
        add: function(e, data) {
            var goUpload = true;
            var uploadFile = data.files[0];
            if (!(/\.(gif|jpg|jpeg|tiff|png)$/i).test(uploadFile.name)) {
                alert('You must select an image file only');
                goUpload = false;
            }
            if (uploadFile.size > 1000000) { // 1mb
                alert('Please upload a smaller image, max size is 1 MB');
                goUpload = false;
            }
            if (goUpload) {
                data.submit();
            }
        },
        progressall: function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $(this).parent().find('span').html("Uploading.. " + progress + '%');
        },
        done: function(e, data) {
            var obj = $(this);
            $.each(data.result.files, function(index, file) {
                var info = new Array();
                // get the old values
                info['image1'] = obj.parents('.image-list').find('.image1').css('background-image').replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');
                info['image2'] = obj.parents('.image-list').find('.image2').css('background-image').replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');
                info['image3'] = obj.parents('.image-list').find('.image3').css('background-image').replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');
                info['text'] = obj.parents('.form-group').find('.image-text').val();
                // get the new value of the selected image
                var className = obj.parents('.fileUpload').find('.lgt-image').attr('class');
                var toUpdate = className.split(' ')[1];
                var path = base_url + "resources/others/uploads/php/files/";
                info['selected'] = toUpdate;
                info[toUpdate] = path + file.name;
                // ajax update
                updateImageSaved(info, obj.parents('.image-list').attr('id'), obj);
            });
        }
    }
    );
}

function updateImageSaved(info, field, obj) {
    $.ajax({
        url: base_url + "property_module/updatePropertyImage",
        data: {field: field, image1: info['image1'], image2: info['image2'], image3: info['image3'], text: info['text']},
        type: 'post',
        success: function(data) {
            if (data === "OK") {
                var selected = info['selected'];
                obj.parent().find('span').html("");
                obj.parents('.image-list').find("." + selected).css('background-image', "url(" + info[selected] + ")");
            }
        },
        error: function(xhr, status, error) {
            alert(error);
        }
    });
}