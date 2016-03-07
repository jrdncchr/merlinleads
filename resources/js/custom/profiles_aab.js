$(document).ready(function() {
    activatePopovers();
    activateSaving();
    activateImageUpload();

    $('.save-image-btn').click(function() {
        updateAllImage($('#images'), 'button');
    });
});
function activatePopovers() {
    $(document).find(".helper").each(function() {
        $(this).popover({
            'trigger': 'hover'
        });
    });
}

var currentTab = "basic";
function activateSaving() {
    $('#profileTabs a[href="#basic"]').click(function(e) {
        e.preventDefault();
        $("#errorMessage").removeClass().html("");
        currentTab = "basic";
        save($(this));
    });
    $('#profileTabs a[href="#activate"]').click(function(e) {
        e.preventDefault();
        if (ready()) {
            $("#errorMessage").removeClass().html("");
            currentTab = "activate";
            save($(this));
        }
    });
    $('#profileTabs a[href="#testimonials"]').click(function(e) {
        e.preventDefault();
        if (ready()) {
            $("#errorMessage").removeClass().html("");
            currentTab = "testimonials";
            save($(this));
        }
    });
    $('#profileTabs a[href="#advance"]').click(function(e) {
        e.preventDefault();
        if (ready()) {
            $("#errorMessage").removeClass().html("");
            currentTab = "advance";
            save($(this));
        }
    });
    $('#profileTabs a[href="#social"]').click(function(e) {
        e.preventDefault();
        if (ready()) {
            $("#errorMessage").removeClass().html("");
            currentTab = "social";
            save($(this));
        }
    });
    $('#profileTabs a[href="#images"]').click(function(e) {
        e.preventDefault();
        if (ready()) {
            $("#errorMessage").removeClass().html("");
            currentTab = "images";
            save($(this));
        }
    });
    $('.x-save').click(function() {
        if (buttonReady()) {
            $("#errorMessage").removeClass().html("");
            save($(this));
        }
    });

    $("#activateBtn").click(function() {
        if (validateAll()) {
            $.ajax({
                url: base_url + 'profiles/activate',
                success: function(data) {
                    if (data === "OK") {
                        window.location = base_url + 'profiles';
                    }
                }
            });
        }
    });
    $("#deactivateBtn").click(function() {
        var ok = confirm("Are you sure you want to deactivate this profile?");
        if (ok) {
            $.ajax({
                url: base_url + 'profiles/deactivate',
                type: 'post',
                cache: false,
                success: function(data) {
                    if (data === "OK") {
                        window.location = base_url + 'profiles';
                    } else {
                        alert(data);
                    }
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        }
    });
    function ready() {
        if (currentTab === "basic") {
            if ($('#profileName').val() === "") {
                $('#basicMessage').removeClass().addClass('alert alert-danger')
                        .html("<i class='fa fa-exclamation'></i> Changing tab will auto save, please fill up the profile name first.");
                $('#profileName').addClass('input-error');
                $('#propertyTabs a[href="#basic"]').tab('show');
                return false;
            }
        }
        $('#basicMessage').removeClass().html("");
        $('#profileName').removeClass('input-error');
        return true;
    }
    function buttonReady() {
        if (currentTab === "basic") {
            if ($('#profileName').val() === "") {
                $('#basicMessage').removeClass().addClass('alert alert-danger')
                        .html("<i class='fa fa-exclamation'></i> Please fill up the profile name first.");
                $('#profileName').addClass('input-error');
                $('#propertyTabs a[href="#basic"]').tab('show');
                return false;
            }
        }
        $('#basicMessage').removeClass().html("");
        $('#profileName').removeClass('input-error');
        return true;
    }
}

function save(object) {
    if ($('#status').val() === "Active") {
        if (validateAll()) {
            saveNow();
        }
    } else {
        saveNow();
    }

    function saveNow() {
        $("#" + currentTab).find(".required").each(function() {
            $(this).removeClass('input-error');
        });
        var testimonials = "";
        $('#testimonials').find('.x-testimonial').each(function() {
            testimonials += $(this).val() + "|";
        });
        startLoader('Saving Profile, please wait...');
        $.ajax({
            url: base_url + "profiles/save",
            data: {profileType: $('#profileType').val(), profileName: $('#profileName').val(), firstname: $('#firstname').val(), lastname: $('#lastname').val(),
                company: $('#company').val(), slogan: $('#slogan').val(), phone: $('#phone').val(), email: $('#email').val(),
                contactWebpage: $('#contactWebpage').val(), yearStarted: $('#yearStarted').val(), about: $('#about').val(), linkFreeSearch: $('#linkFreeSearch').val(),
                linkCurrentListing: $('#linkCurrentListing').val(), testimonials: testimonials, companyWebsite: $('#companyWebsite').val(),
                brokerName: $('#brokerName').val(), brokerAddress: $('#brokerAddress').val(), brokerPhone: $('#brokerPhone').val(),
                brokerLicenseNo: $('#brokerLicenseNo').val(), listingBookUrl: $('#listingBookUrl').val(), facebookUrl: $('#facebookUrl').val(),
                twitterUrl: $('#twitterUrl').val(), linkedInUrl: $('#linkedInUrl').val(), youtubeChannelUrl: $('#youtubeChannelUrl').val()},
            type: 'post',
            cache: false,
            success: function(data) {
                stopLoader();
                if (data === 'OK') {
                    if (object !== 'button') {
                        object.tab('show');
                    }
                    $(".x-save").prop('disabled', false).html("Save");
                    toast = toastr.success('Profile Saved!');
                } else {
                    alert(data);
                }
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
    }
}

function validateAll() {
    if (validate('basic')) {
        if (validate('testimonials')) {
            if (validate('social')) {
                if (validate('advance')) {
                    return true;
                } else {
                    $('#profileTabs a[href="#advance"]').tab('show');
                    currentTab = 'advance';
                }
            } else {
                $('#profileTabs a[href="#social"]').tab('show');
                currentTab = 'social';
            }
        } else {
            $('#profileTabs a[href="#testimonials"]').tab('show');
            currentTab = 'testimonials';
        }
    } else {
        $('#profileTabs a[href="#basic"]').tab('show');
        currentTab = 'basic';
    }
    return false;
}
// Save Validation
function validate(tab) {
    var validRequired = true;
    $("#" + tab).find(".required").each(function() {
        if ($(this).val() === "") {
            $(this).addClass('input-error');
            validRequired = false;
        } else {
            $(this).removeClass('input-error');
        }
    });
    if (validRequired) {
        var validUrls = true;
        $("#" + tab).find(".url").each(function() {
            if ($(this).val() !== "") {
                if (isUrl($(this).val())) {
                    $(this).removeClass('input-error');
                } else {
                    $(this).addClass('input-error');
                    validUrls = false;
                }
            }
        });
        if (validUrls) {
            var validEmails = true;
            $("#" + tab).find(".required.email").each(function() {
                if (isValidEmail($(this).val())) {
                    $(this).removeClass('input-error');
                } else {
                    $(this).addClass('input-error');
                    validEmails = false;
                }
            });
            if (validEmails) {
                $("#" + tab + "Message").removeClass().html("");
                return true;
            } else {
                $("#" + tab + "Message").removeClass().addClass('alert alert-danger')
                        .html("<i class='fa fa-exclamation'></i> <strong>A field must be an Email.</strong> Please input a valid email address.");
                return false;
            }
        } else {
            $("#" + tab + "Message").removeClass().addClass('alert alert-danger')
                    .html("<i class='fa fa-exclamation'></i> <strong>A field must be a URL.</strong> Please add http://, https://, etc. in the beginning. ");
            return false;
        }
    } else {
        $("#" + tab + "Message").removeClass().addClass('alert alert-danger')
                .html("<i class='fa fa-exclamation'></i> A required field is empty.");
        return false;
    }
}


function activateImageUpload() {
    $('#owner_image').find('.upload').each(function() {
        addFileUploadFunction($(this), 185, 250);
    });
    $('#logo_image').find('.upload').each(function() {
        addFileUploadFunction($(this), 140, 110);
    });
}

var alertModal = $("#globalAlertModal");
function addFileUploadFunction(e, w, h) {
        e.fileupload({
            dataType: 'json',
            add: function(e, data) {
                alertModal.find('.modal-title').html("Upload Image");

                var goUpload = true;
                var uploadFile = data.files[0];
                if (!(/\.(gif|jpg|jpeg|tiff|png)$/i).test(uploadFile.name)) {
                    alertModal.find('.modal-body').html("<i class='fa fa-info-circle'></i> Invalid image file.");
                    goUpload = false;
                }
                if (uploadFile.size > 1000000) { // 1mb
                    alertModal.find('.modal-body').html("<i class='fa fa-info-circle'></i>  Upload size cannot be greater than 1MB.");
                    goUpload = false;
                }

                var file, img;
                if ((file = data.files[0])) {
                    if (goUpload) {
                        img = new Image();
                        img.onload = function() {
                            goUpload = false;
                            showCropper(data, this, w, h);
                        };
                        img.onerror = function() {
                            alertModal.find('.modal-body').html("<i class='fa fa-info-circle'></i>  Invalid image file.");
                            goUpload = false;
                            displayAlertModal();
                        };
                        img.src = URL.createObjectURL(file);
                    } else {
                        displayAlertModal();
                    }
                } else {
                    displayAlertModal();
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
                    updateImage(info, obj.parents('.image-list').attr('id'), obj);
                });
            }
        }
    );
}

function updateImage(info, field, obj) {
    $.ajax({
        url: base_url + "profiles/updateProfileImage",
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

function updateAllImage(tabToLook, tabToShow) {
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
        url: base_url + "profiles/updateProfileImageAll",
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