$(document).ready(function() {
    activateModuleSaving();
    activateModuleEvents();
    activatePickerEvents();

    $('#ohDate').datepicker({
        dateFormat: "yy-mm-dd",
        onSelect: function(dateText, inst) {
            $('#ohDateValue').val(dateText);
        }
    }).keypress(function(event) {
        event.preventDefault();
    });
    $('#ohStartTime').timepicker();
    $('#ohEndTime').timepicker();
});

function activateModuleEvents() {
    $('#moduleActivateBtn').click(function() {
        if (moduleValidateAll()) {
            $.ajax({
                url: base_url + 'property_module/changeStatus',
                data: {status: 'active'},
                type: 'post',
                cache: false,
                success: function(data) {
                    if (data === "OK") {
                        $('#moduleActivateDiv').fadeOut('fast');
                        $('#moduleDeactivateDiv').fadeIn('slow');
                    }
                }
            });
        }
    });
    $('#moduleDeactivateBtn').click(function() {
        var ok = confirm("Are you sure you want to deactivate this module?");
        if (ok) {
            $.ajax({
                url: base_url + 'property_module/changeStatus',
                data: {status: 'inactive'},
                type: 'post',
                cache: false,
                success: function(data) {
                    if (data === "OK") {
                        $('#moduleDeactivateDiv').fadeOut('fast');
                        $('#moduleActivateDiv').fadeIn('slow');
                    }
                }
            });
        }
    });
}

var moduleCurrentTab = "moduleBasics";
function activateModuleSaving() {
    $('#module-tabs a[href="#moduleBasics"]').click(function(e) {
        e.preventDefault();
        moduleCurrentTab = "moduleBasics";
        saveModule($(this));
    });
    $('#module-tabs a[href="#headlineStatements"]').click(function(e) {
        e.preventDefault();
        moduleCurrentTab = "headlineStatements";
        saveModule($(this));
    });
    $('#module-tabs a[href="#callToAction"]').click(function(e) {
        e.preventDefault();
        moduleCurrentTab = "callToAction";
        saveModule($(this));
    });
    $('#module-tabs a[href="#openHouse"]').click(function(e) {
        e.preventDefault();
        moduleCurrentTab = "openHouse";
        saveModule($(this));
    });
    $('#module-tabs a[href="#optionalFields"]').click(function(e) {
        e.preventDefault();
        moduleCurrentTab = "optionalFields";
        saveModule($(this));
    });
    $('#module-tabs a[href="#video"]').click(function(e) {
        e.preventDefault();
        moduleCurrentTab = "video";
        saveModule($(this));
    });
    $('#module-tabs a[href="#moduleActivate"]').click(function(e) {
        e.preventDefault();
        moduleCurrentTab = "moduleActivate";
        saveModule($(this));
    });
    $('.btn-save-module').click(function() {
        saveModule('button');
    });
}

function saveModule(tab) {
    if ($('#moduleStatus').val() === "Active") {
        if (moduleValidateAll()) {
            saveNow();
        }
    } else {
        validate(moduleCurrentTab);
        saveNow();
    }
    function saveNow() {
        startLoader('Saving Craiglist Module, please wait...');
        var hs = "";
        $('#headlineStatements').find('.x-hs').each(function() {
            hs += $(this).val() + "|";
        });
        var cta = "";
        $('#callToAction').find('.x-cta').each(function() {
            cta += $(this).val() + "|";
        });
        var videoCta = "";
        $('#video').find('.video-cta').each(function() {
            videoCta += $(this).val() + "|";
        });
        var videoTerm = "";
        $('#video').find('.video-term').each(function() {
            videoTerm += $(this).val() + "|";
        });
        var wheelchairAccessible = "no", noSmoking = "no", furnished = "no";
        if ($('#wheelchairAccessible').is(":checked")) {
            wheelchairAccessible = "yes";
        }
        if ($('#noSmoking').is(":checked")) {
            noSmoking = "yes";
        }
        if ($('#furnished').is(":checked")) {
            furnished = "yes";
        }
        $.ajax({
            url: base_url + 'property_module/saveClassifiedsModule',
            data: {
                price: $('#price').val(), housingType: $('#housingType').val(), bath: $('#bath').val(), laundry: $('#laundry').val(), parking: $('#parking').val(),
                crossStreet: $('#crossStreet').val(), wheelchairAccessible: wheelchairAccessible, noSmoking: noSmoking, furnished: furnished,
                headlineStatements: hs, cta: cta, ohDate: $('#ohDateValue').val(), ohStartTime: $('#ohStartTime').val(), ohEndTime: $('#ohEndTime').val(),
                ohNotes: $('#ohNotes').val(), adTags: $('#ofAdTags').val(), videoYoutubeUrl: $('#videoYoutubeUrl').val(),
                videoCta: videoCta, videoTerm: videoTerm
            },
            type: 'post',
            cache: false,
            success: function(data) {
                stopLoader();
                if (tab !== 'button') {
                    tab.tab('show');
                }
                toast = toastr.success('Module Saved!');
                $("#" + currentTab).find(".form-control").each(function() {
                    $(this).removeClass('input-error');
                });
                $("#" + currentTab + "Message").removeClass().html("");
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
}
}

function moduleValidateAll() {
    if (validate('moduleBasics')) {
        if (validate('headlineStatements')) {
            if (validate('callToAction')) {
                if (validate('openHouse')) {
                    if (validate('optionalFields')) {
                        if (validate('video')) {
                            return true;
                        } else {
                            $('#module-tabs a[href="#video"]').tab('show');
                            moduleCurrentTab = 'video';
                        }
                    } else {
                        $('#module-tabs a[href="#optionalFields"]').tab('show');
                        moduleCurrentTab = 'optionalFields';
                    }
                } else {
                    $('#module-tabs a[href="#openHouse"]').tab('show');
                    moduleCurrentTab = 'openHouse';
                }
            } else {
                $('#module-tabs a[href="#callToAction"]').tab('show');
                moduleCurrentTab = 'callToAction';
            }
        } else {
            $('#module-tabs a[href="#headlineStatements"]').tab('show');
            moduleCurrentTab = 'headlineStatements';
        }
    } else {
        $('#module-tabs a[href="#moduleBasics"]').tab('show');
        moduleCurrentTab = 'moduleBasics';
    }

    return false;
}

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

function activatePickerEvents() {
    //Regular Headline Statements Picker
    var hsModalList = new Array();
    $('#hsPre').change(function() {
        if ($(this).val().length <= 10) {
            hsModalList = $(this).val();
            if (hsModalList.length === 10) {
                $('#hsModalSelectedCount').removeClass().addClass('text-success').html("You need to select <b>" + (10 - hsModalList.length) + "</b> more items.");
                $('#hsModalDoneBtn').attr("disabled", false);
            } else {
                $('#hsModalSelectedCount').removeClass().addClass('text-success').html("You need to select <b>" + (10 - hsModalList.length) + "</b> more items.");
                $('#hsModalDoneBtn').attr("disabled", true);
            }
        } else {
            alert("Sorry, you can only select a maximum of 10 items.");
            $(this).val(hsModalList);
        }
    });

    $('#hsModalDoneBtn').click(function() {
        var i = 0;
        $('#headlineStatements').find(".x-hs").each(function() {
            $(this).val(hsModalList[i]);
            i++;
        });
        $('#hsModal').modal('hide');
    });

    $('#hsModal').on('hidden.bs.modal', function() {
        $('#hsPre').val("");
        hsModalList = new Array();
        $('#hsModalDoneBtn').attr("disabled", true);
        $('#hsModalSelectedCount').removeClass().addClass('text-danger').html("You need to select <b>10</b> more items.");
    });

    //Video Term Library
    var vtModalList = new Array();
    $('#vtSelect').change(function() {
        if ($(this).val().length <= 10) {
            vtModalList = $(this).val();
            if (vtModalList.length === 10) {
                $('#vtModalSelectedCount').removeClass().addClass('text-success').html("You need to select <b>" + (10 - vtModalList.length) + "</b> more items.");
                $('#vtModalDoneBtn').attr("disabled", false);
            } else {
                $('#vtModalSelectedCount').removeClass().addClass('text-success').html("You need to select <b>" + (10 - vtModalList.length) + "</b> more items.");
                $('#vtModalDoneBtn').attr("disabled", true);
            }
        } else {
            alert("Sorry, you can only select a maximum of 10 items.");
            $(this).val(vtModalList);
        }
    });

    $('#vtModalDoneBtn').click(function() {
        var i = 0;
        $('#video').find(".x-vt").each(function() {
            $(this).val(vtModalList[i]);
            i++;
        });
        $('#vtModal').modal('hide');
    });

    $('#vtModal').on('hidden.bs.modal', function() {
        $('#vtSelect').val("");
        vtModalList = new Array();
        $('#vtModalDoneBtn').attr("disabled", true);
        $('#vtModalSelectedCount').removeClass().addClass('text-danger').html("You need to select <b>10</b> more items.");
    });

    //Regular Call To Action Picker Event
    var ctaModalList = new Array();
    $('#ctaModalList').change(function() {
        if ($(this).val().length <= 10) {
            ctaModalList = $('#ctaModalList').val();
            if (ctaModalList.length === 10) {
                $('#ctaModalSelectedCount').removeClass().addClass('text-success').html("You need to select <b>" + (10 - ctaModalList.length) + "</b> more items.");
                $('#ctaModalDoneBtn').attr("disabled", false);
            } else {
                $('#ctaModalSelectedCount').removeClass().addClass('text-danger').html("You need to select <b>" + (10 - ctaModalList.length) + "</b> more items.");
                $('#ctaModalDoneBtn').attr("disabled", true);
            }

        } else {
            alert("Sorry, you can only select 10 items.");
            $(this).val(ctaModalList);
        }
    });
    
    $('#ctaModalDoneBtn').click(function() {
        var i = 0;
        $("#callToAction").find(".x-cta").each(function() {
            $(this).val(ctaModalList[i]);
            i++;
        });
        $('#ctaModal').modal('hide');
    });

    $('#ctaModal').on('hidden.bs.modal', function() {
        $('#ctaModalList').val("");
        ctaModalList = new Array();
        $('#ctaModalDoneBtn').attr("disabled", true);
        $('#ctaModalSelectedCount').removeClass().addClass('text-danger').html("You need to select <b>10</b> more items.");
    });

    //Video Call To Action Picker Event
    $('#ctaVideoModalList').change(function() {
        if ($(this).val().length <= 10) {
            ctaModalList = $('#ctaVideoModalList').val();
            if (ctaModalList.length === 10) {
                $('#ctaVideoModalSelectedCount').removeClass().addClass('text-success').html("You need to select <b>" + (10 - ctaModalList.length) + "</b> more items.");
                $('#ctaVideoModalDoneBtn').attr("disabled", false);
            } else {
                $('#ctaVideoModalSelectedCount').removeClass().addClass('text-danger').html("You need to select <b>" + (10 - ctaModalList.length) + "</b> more items.");
                $('#ctaVideoModalDoneBtn').attr("disabled", true);
            }

        } else {
            alert("Sorry, you can only select 10 items.");
            $(this).val(ctaModalList);
        }
    });

    $('#ctaVideoModalDoneBtn').click(function() {
        var i = 0;
        $("#video").find(".video-cta").each(function() {
            $(this).val(ctaModalList[i]);
            i++;
        });
        $('#ctaVideoModal').modal('hide');
    });

    $('#ctaVideoModal').on('hidden.bs.modal', function() {
        $('#ctaVideoModalList').val("");
        ctaModalList = new Array();
        $('#ctaVideoModalDoneBtn').attr("disabled", true);
        $('#ctaVideoModalSelectedCount').removeClass().addClass('text-danger').html("You need to select <b>10</b> more items.");
    });
}