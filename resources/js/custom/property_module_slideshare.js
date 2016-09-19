$(document).ready(function() {
    activatePopovers();
    activateSaving();
    activateUpload();
    $('.btn-save').click(function() {
        saveAll();
    });

    $('#generateBtn').click(function(data) {
        loading('info', "Generating Slide, please wait...");
        $.ajax({
            url: base_url + "property_module/generateSlideshareSlide",
            success: function(data) {
                loading('success', "Generating Slide successful!");
            }
        });
    });
});

function activatePopovers() {
    $(document).find(".helper").each(function() {
        $(this).popover({
            'trigger': 'hover'
        });
    });
}

var currentTab = "siat";
function activateSaving() {
    $('#slideshare-tabs a[href="#siat"]').click(function(e) {
        e.preventDefault();
        currentTab = "siat";
        save($(this));
    });
    $('#slideshare-tabs a[href="#activate"]').click(function(e) {
        e.preventDefault();
        currentTab = "activate";
        save($(this));
    });
}

function save(tab) {
    tab.tab('show');
}

function activateUpload() {
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
                info['image'] = file.name;
                info['text'] = obj.parent().parent().parent().find('.form-control').val();
                updateImageSaved(info, obj.attr('id'), obj);
                $('.popover').popover('hide');
            });
        }
    });

    $('.upload2').fileupload({
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
                info['image'] = file.name;
                info['text'] = "No text by default";
                updateImageSaved(info, obj.attr('id'), obj);
                $('.popover').popover('hide');
            });
        }
    });
}

function updateImageSaved(info, field, obj) {
    $.ajax({
        url: base_url + "property_module/updateSlideShareImage",
        data: {field: field, image: info['image'], text: info['text']},
        type: 'post',
        success: function(data) {
            obj.parent().removeClass('btn-primary').addClass('btn-success');
            obj.parent().find('span').html("<i class='fa fa-upload'></i>");
            obj.parent().parent().find('.fileUpload').attr('data-content', "<img src='" + base_url + "resources/others/uploads/php/files/" + info['image'] + "' class='img-thumbnail'/>");
            obj.parent().parent().find('.fileUpload').attr('id', info['image']);
        },
        error: function(xhr, status, error) {
            alert(error);
        }
    });
}

function saveAll() {
    loading('info', 'Saving, please wait..');
    $.ajax({
        url: base_url + "property_module/updateSlideShare",
        data: {
            'category': $('#category').val(),
            'front-image': $('#front').parent().attr('id'),
            'front-text': $('#front-text').val(),
            'back-image': $('#back').parent().attr('id'),
            'back-text': $('#back-text').val(),
            'kitchen-image': $('#kitchen').parent().attr('id'),
            'kitchen-text': $('#kitchen-text').val(),
            'dining_room-image': $('#dining_room').parent().attr('id'),
            'dining_room-text': $('#dining_room-text').val(),
            'living_room-image': $('#living_room').parent().attr('id'),
            'living_room-text': $('#living_room-text').val(),
            'family_room-image': $('#family_room').parent().attr('id'),
            'family_room-text': $('#family_room-text').val(),
            'master_bedroom-image': $('#master_bedroom').parent().attr('id'),
            'master_bedroom-text': $('#master_bedroom-text').val(),
            'master_bathroom-image': $('#master_bathroom').parent().attr('id'),
            'master_bathroom-text': $('#master_bathroom-text').val(),
            'lower_level-image': $('#lower_level').parent().attr('id'),
            'lower_level-text': $('#lower_level-text').val()
        },
        type: 'post',
        success: function(data) {
            if (data === "OK") {
                loading('success', 'Saving Module Successful!');
            } else {
                loading('danger', 'An error occured!');
            }
        }
    });
}