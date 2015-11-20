$(document).ready(function() {
    activatePopovers();
    activateTermFeatureEvents();
    activateBasicEvents();
    activateSaving();
    $('#main-tabs a[href="#property-tab"]').click(function(e) {
        e.preventDefault();
        saveTab($(this), function() {
            lastTab = "property";
        });
    });
    $('#main-tabs a[href="#classified-tab"]').click(function(e) {
        e.preventDefault();
        saveTab($(this), function() {
            lastTab = "classified";
        });
    });
    $('#main-tabs a[href="#images-tab"]').click(function(e) {
        e.preventDefault();
        saveTab($(this), function() {
            lastTab = "images";
        });

    });
});

var lastTab = "property";

function saveTab(tab, callback) {
    var ok = true;
    if (lastTab === "property") {
        if (!$("#name").val()) {
            ok = false;
            $("#basicMessage").addClass("alert alert-danger").html("<i class='fa fa-exclamation'></i> Property Name must have a value.");
        } else {
            $("#basicMessage").removeClass().html("");
            save('button');
        }
    } else if (lastTab === "classified") {
        saveModule('button');
    } else if (lastTab === "images") {
        saveImages($("#images-tab"), $(this));
    }
    if (ok) {
        $(tab).tab('show');
        callback();
    }
}

function activatePopovers() {
    $(document).find(".helper").each(function() {
        $(this).popover({
            'trigger': 'hover'
        });
    });
}

function activateBasicEvents() {
    $("#country").change(function() {
        $("#state").prop('disabled', true);
        $.ajax({
            url: base_url + "registration/getCountryStates",
            data: {'country': $("#country").val()},
            cache: false,
            type: 'post',
            success: function(data) {
                $("#state").html(data);
                $("#state").prop('disabled', false);
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
    });

    $('#propertyType').keydown(function(e) {
        if (e.which !== 9) {
            return false;
        }
    });

    $('#propertyType').focus(function() {
        getCategoryTypes();
        $('#propertyTypeModal').modal('show');
    });
    $('#propertyTypeModal').on('hidden.bs.modal', function() {
        $('#saleType').focus();
    });

    $('#propertyCategory').change(function() {
        getCategoryTypes();
    });

    $('#generatePropertyTypeBtn').click(function() {
        $('#propertyType').val($('#propertyCategory').val() + " " + $('#propertyCategoryType').val());
        $('#propertyTypeModal').modal('hide');
    });

    function getCategoryTypes() {
        $('#propertyCategoryType').prop('disabled', true);
        $.ajax({
            url: base_url + 'property/getPropertyCategoryTypes',
            data: {category: $('#propertyCategory').val()},
            type: 'post',
            cache: false,
            success: function(data) {
                $('#propertyCategoryType').html(data);
                $('#propertyCategoryType').prop('disabled', false);
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
    }
}

function activateTermFeatureEvents() {
    //Feature and Terms
    var inputFeature = 1;
    $('#feature1Btn').click(function() {
        inputFeature = 1;
        showTermFeatureModal();
    });
    $('#feature2Btn').click(function() {
        inputFeature = 2;
        showTermFeatureModal();
    });
    $('#feature3Btn').click(function() {
        inputFeature = 3;
        showTermFeatureModal();
    });

    $('#featureCategory').change(function() {
        setFeatureSelects();
    });

    $('#generateFeatureBtn').click(function() {
        $('#termFeatureModal').modal('hide');
        $('#feature' + inputFeature).val($('#featureSelect').val());
    });

    function showTermFeatureModal() {
        if ($('#main').val() === "" || $('#secondary').val() === "") {
            $('#termFeatureMessage').removeClass().addClass('alert alert-danger')
                    .html("<i class='fa fa-exclamation'></i> Please select a main and second term first.");
        } else {
            setFeatureCategories();
            $('#termFeatureMessage').removeClass().html("");
            $('#termFeatureModal').modal('show');
        }
    }

    function setFeatureCategories() {
        $('#featureCategory').prop('disabled', true);
        $.ajax({
            url: base_url + 'property/getFeatureCategories',
            data: {main: $('#main').val(), secondary: $('#secondary').val()},
            type: 'post',
            cache: false,
            success: function(data) {
                $('#featureCategory').html(data);
                $('#featureCategory').prop('disabled', false);
                setFeatureSelects();
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
    }

    function setFeatureSelects() {
        $('#featureSelect').prop('disabled', true);
        $.ajax({
            url: base_url + 'property/getFeatureSelects',
            data: {main: $('#main').val(), secondary: $('#secondary').val(), category: $('#featureCategory').val()},
            type: 'post',
            cache: false,
            success: function(data) {
                $('#featureSelect').html(data);
                $('#featureSelect').prop('disabled', false);
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
    }
}

var currentTab = "basic";
function activateSaving() {
    $('#propertyTabs a[href="#basic"]').click(function(e) {
        e.preventDefault();
        currentTab = "basic";
        save($(this));
    });
    $('#propertyTabs a[href="#activate"]').click(function(e) {
        e.preventDefault();
        if (ready()) {
            currentTab = "activate";
            save($(this));
        }
    });
    $('#propertyTabs a[href="#detail"]').click(function(e) {
        e.preventDefault();
        if (ready()) {
            currentTab = "detail";
            save($(this));
        }
    });
    $('#propertyTabs a[href="#typeAndFeatures"]').click(function(e) {
        e.preventDefault();
        if (ready()) {
            currentTab = "typeAndFeatures";
            save($(this));
        }
    });
    $('#propertyTabs a[href="#links"]').click(function(e) {
        e.preventDefault();
        if (ready()) {
            currentTab = "links";
            save($(this));
        }
    });
    $('#propertyTabs a[href="#keywords"]').click(function(e) {
        keywordsRequirementCheck(true);
    });
    $('.btn-save').click(function() {
        if (ready()) {
            save('button');
        } else {
            $("html, body").animate({scrollTop: 0}, "slow");
        }
    });
    $('#activateBtn').click(function() {
        if (validateAll(true)) {
            $.ajax({
                url: base_url + "property/activate",
                success: function(data) {
                    if (data === "OK") {
                        $('#deactivateDiv').show();
                        $('#activateDiv').hide();
                        var ok = confirm("Property activated! Do you want to go to the \"Classified Module Details Tab\"?");
                        if (ok) {
                            $('#main-tabs a[href="#classified-tab"]').tab('show')
                        }
                    }
                }
            });
        }
    });
    $('#deactivateBtn').click(function() {
        var ok = confirm("Are you sure you want to deactivate this property?");
        if (ok) {
            $.ajax({
                url: base_url + "property/deactivate",
                success: function(data) {
                    if (data === "OK") {
                        window.location = base_url + 'property';
                    }
                }
            });
        }
    });
    function ready() {
        if (currentTab === "basic") {
            if ($('#name').val() === "") {
                $('#basicMessage').removeClass().addClass('alert alert-danger')
                        .html("<i class='fa fa-exclamation'></i> Please fill up the property name first.");
                $('#name').addClass('input-error');
                $('#propertyTabs a[href="#basic"]').tab('show');
                return false;
            }
        }
        $('#basicMessage').removeClass().html("");
        $('#name').removeClass('input-error');
        return true;
    }
}

function keywordsRequirementCheck(showTab) {
    if (validate("basic")) {
        if (validate('typeAndFeatures')) {
            if (showTab) {
                setupKeywords();
                $('#propertyTabs a[href="#keywords"]').tab('show');
                currentTab = 'keywords';
                save($(this));
            }
        } else {
            $("#typeAndFeaturesMessage").removeClass().addClass('alert alert-danger')
                    .html("<i class='fa fa-exclamation'></i> Please fill up all required fields in the <strong>Type and Features</strong> tab first before going to the <strong>Keyword</strong> tab.");
            $('#propertyTabs a[href="#typeAndFeatures"]').tab('show');
            currentTab = 'typeAndFeatures';
        }
    } else {
        $("#basicMessage").removeClass().addClass('alert alert-danger')
                .html("<i class='fa fa-exclamation'></i> Please fill up all required fields in the <strong>Basic Info</strong> tab first before going to the <strong>Keyword</strong> tab.");
        $('#propertyTabs a[href="#basic"]').tab('show');
        currentTab = 'basic';
    }
}

function save(tab) {
    if ($('#status').val() === "Active") {
        if (validateAll(true)) {
            saveNow('true');
        }
    } else {
        if (validateAll(false)) {
            saveNow('true');
        } else {
            saveNow('false');
        }
    }

    function saveNow(valid) {
        startLoader('Saving Property, please wait...');
        var bullets = "";
        $('#bullets').find('.x-bullet').each(function() {
            bullets += $(this).val() + "|";
        });
        var features = "";
        $('#features').find('.x-feature').each(function() {
            features += $(this).val() + "|";
        });
        var keywords = "";
        $('#keywords').find('.x-keyword').each(function() {
            keywords += $(this).val() + "|";
        });
        $.ajax({
            url: base_url + 'property/save',
            data: {
                profile: $('#profile').val(), name: $('#name').val(), propertyType: $('#propertyType').val(), saleType: $('#saleType').val(),
                address: $('#address').val(), city: $('#city').val(), city2: $('#city2').val(), city3: $('#city3').val(), zipcode: $('#zipcode').val(),
                country: $('#country').val(), state: $('#state').val(), area: $('#area').val(), mlsDescription: $('#mlsDescription').val(), mlsID: $('#mlsID').val(),
                bullets: bullets, schooldDistrict: $('#schooldDistrict').val(), highschool: $('#highschool').val(), middleschool: $('#middleschool').val(),
                elementaryschool: $('#elementaryschool').val(), noBedrooms: $('#noBedrooms').val(), noBathrooms: $('#noBathrooms').val(),
                buildingSqFt: $('#buildingSqFt').val(), yearBuilt: $('#yearBuilt').val(), lotSize: $('#lotSize').val(), main: $('#main').val(),
                secondary: $('#secondary').val(), features: features, keywords: keywords, propertyWebpageLUrl: $('#propertyWebpageLUrl').val(),
                drivingInstructions: $('#drivingInstructions').val(), mapUrl: $('#mapUrl').val(), otherListingURL: $('#otherListingURL').val(), valid: valid
            },
            type: 'post',
            cache: false,
            success: function(data) {
                stopLoader();
                if (tab !== 'button') {
                    tab.tab('show');
                }
                toast = toastr.success('Property Saved!');
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

function validateAll(show) {
    if (validate('basic')) {
        if (validate('detail')) {
            if (validate('typeAndFeatures')) {
                if (validate('keywords')) {
                    if (validate('links')) {
                        return true;
                    } else {
                        if (show) {
                            $('#propertyTabs a[href="#links"]').tab('show');
                            currentTab = 'links';
                        }
                    }
                } else {
                    if (show) {
                        keywordsRequirementCheck(false);
                    }
                }
            } else {
                if (show) {
                    $('#propertyTabs a[href="#typeAndFeatures"]').tab('show');
                    currentTab = 'typeAndFeatures';
                }
            }
        } else {
            if (show) {
                $('#propertyTabs a[href="#detail"]').tab('show');
                currentTab = 'detail';
            }
        }
    } else {
        if (show) {
            $('#propertyTabs a[href="#basic"]').tab('show');
            currentTab = 'basic';
        }
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

function setupKeywords() {
    var city = $('#city').val(), address = $('#address').val(), stateAbbr = $('#state').val().split(' - ')[0];
    var main = $('#main').val(), secondary = $('#secondary').val(), saleType = $('#saleType').val();
    var feature1 = $('#feature1').val(), feature2 = $('#feature2').val(), feature3 = $('#feature3').val();
    $('#keyword1').val(main + " " + saleType + " in " + city);
    $('#keyword2').val(feature1 + " " + main + " " + saleType + " in " + city);
    $('#keyword3').val(feature2 + " " + main + " " + saleType + " in " + city);
    $('#keyword4').val(feature3 + " " + main + " " + saleType + " in " + city);
    $('#keyword5').val(feature1 + " " + feature2 + " " + main + " " + saleType + " in " + city);
    $('#keyword6').val(feature1 + " " + feature3 + " " + main + " " + saleType + " in " + city);
    $('#keyword7').val(feature2 + " " + feature3 + " " + main + " " + saleType + " in " + city);
    $('#keyword8').val(secondary + " " + saleType + " in " + city);
    $('#keyword9').val(feature1 + " " + secondary + " " + saleType + " in " + city);
    $('#keyword10').val(feature2 + " " + secondary + " " + saleType + " in " + city);
    $('#keyword11').val(feature3 + " " + secondary + " " + saleType + " in " + city);
    $('#keyword12').val(feature1 + " " + feature2 + " " + secondary + " " + saleType + " in " + city);
    $('#keyword13').val(feature1 + " " + feature3 + " " + secondary + " " + saleType + " in " + city);
    $('#keyword14').val(feature2 + " " + feature3 + " " + secondary + " " + saleType + " in " + city);
    $('#keyword15').val(address);
    $('#keyword16').val(address + " " + city);
    $('#keyword17').val(address + " " + city + " " + stateAbbr);
    $('#keyword18').val(address + " " + city + " " + stateAbbr + " " + $('#zipcode').val());
    for (var i = 1; i <= 18; i++) {
        setupKeywordByActiveBtn(i);
    }
    activateKeywordBtnGroupEvent();
}

function activateKeywordBtnGroupEvent() {
    for (var i = 1; i <= 18; i++) {
        activateChangeKeywordEvent(i);
    }
}

function activateChangeKeywordEvent(i) {
    $('.keybtn-group' + i).find('.btn').each(function() {
        $(this).click(function() {
            var id = $(this).attr('id');
            var option = id.charAt(id.length - 1);
            changeKeyword(i, option);
        });
    });
}

function setupKeywordByActiveBtn(i) {
    $('.keybtn-group' + i).find('.btn').each(function() {
        if ($(this).hasClass('active')) {
            var id = $(this).attr('id');
            var option = id.charAt(id.length - 1);
            changeKeyword(i, option);
        }
    });
}

function changeKeyword(i, option) {
    var city = $('#city').val(), address = $('#address').val(), stateAbbr = $('#state').val().split(' - ')[0];
    var main = $('#main').val(), secondary = $('#secondary').val(), saleType = $('#saleType').val();
    var feature1 = $('#feature1').val(), feature2 = $('#feature2').val(), feature3 = $('#feature3').val();
    var city2 = $('#city2').val(), city3 = $('#city3').val(), zipcode = $('#zipcode').val(), area = $('#area').val();
    switch (parseInt(option)) {
        case 1:
            switch (i) {
                case 1:
                    $('#keyword1').val(main + " " + saleType + " in " + city);
                    break;
                case 2:
                    $('#keyword2').val(feature1 + " " + main + " " + saleType + " in " + city);
                    break;
                case 3:
                    $('#keyword3').val(feature2 + " " + main + " " + saleType + " in " + city);
                    break;
                case 4:
                    $('#keyword4').val(feature3 + " " + main + " " + saleType + " in " + city);
                    break;
                case 5:
                    $('#keyword5').val(feature1 + " " + feature2 + " " + main + " " + saleType + " in " + city);
                    break;
                case 6:
                    $('#keyword6').val(feature1 + " " + feature3 + " " + main + " " + saleType + " in " + city);
                    break;
                case 7:
                    $('#keyword7').val(feature2 + " " + feature3 + " " + main + " " + saleType + " in " + city);
                    break;
                case 8:
                    $('#keyword8').val(secondary + " " + saleType + " in " + city);
                    break;
                case 9:
                    $('#keyword9').val(feature1 + " " + secondary + " " + saleType + " in " + city);
                    break;
                case 10:
                    $('#keyword10').val(feature2 + " " + secondary + " " + saleType + " in " + city);
                    break;
                case 11:
                    $('#keyword11').val(feature3 + " " + secondary + " " + saleType + " in " + city);
                    break;
                case 12:
                    $('#keyword12').val(feature1 + " " + feature2 + " " + secondary + " " + saleType + " in " + city);
                    break;
                case 13:
                    $('#keyword13').val(feature1 + " " + feature3 + " " + secondary + " " + saleType + " in " + city);
                    break;
                case 14:
                    $('#keyword14').val(feature2 + " " + feature3 + " " + secondary + " " + saleType + " in " + city);
                    break;
                case 16:
                    $('#keyword16').val(address + " " + city);
                    break;
                case 17:
                    $('#keyword17').val(address + " " + city + " " + stateAbbr);
                    break;
                case 18:
                    $('#keyword18').val(address + " " + city + " " + stateAbbr + " " + zipcode);
                    break;
            }
            break;
        case 2:
            switch (i) {
                case 1:
                    $('#keyword1').val(main + " " + saleType + " in " + city2);
                    break;
                case 2:
                    $('#keyword2').val(feature1 + " " + main + " " + saleType + " in " + city2);
                    break;
                case 3:
                    $('#keyword3').val(feature2 + " " + main + " " + saleType + " in " + city2);
                    break;
                case 4:
                    $('#keyword4').val(feature3 + " " + main + " " + saleType + " in " + city2);
                    break;
                case 5:
                    $('#keyword5').val(feature1 + " " + feature2 + " " + main + " " + saleType + " in " + city2);
                    break;
                case 6:
                    $('#keyword6').val(feature1 + " " + feature3 + " " + main + " " + saleType + " in " + city2);
                    break;
                case 7:
                    $('#keyword7').val(feature2 + " " + feature3 + " " + main + " " + saleType + " in " + city2);
                    break;
                case 8:
                    $('#keyword8').val(secondary + " " + saleType + " in " + city2);
                    break;
                case 9:
                    $('#keyword9').val(feature1 + " " + secondary + " " + saleType + " in " + city2);
                    break;
                case 10:
                    $('#keyword10').val(feature2 + " " + secondary + " " + saleType + " in " + city2);
                    break;
                case 11:
                    $('#keyword11').val(feature3 + " " + secondary + " " + saleType + " in " + city2);
                    break;
                case 12:
                    $('#keyword12').val(feature1 + " " + feature2 + " " + secondary + " " + saleType + " in " + city2);
                    break;
                case 13:
                    $('#keyword13').val(feature1 + " " + feature3 + " " + secondary + " " + saleType + " in " + city2);
                    break;
                case 14:
                    $('#keyword14').val(feature2 + " " + feature3 + " " + secondary + " " + saleType + " in " + city2);
                    break;
                case 16:
                    $('#keyword16').val(address + " " + city2);
                    break;
                case 17:
                    $('#keyword17').val(address + " " + city2 + " " + stateAbbr);
                    break;
                case 18:
                    $('#keyword18').val(address + " " + city2 + " " + stateAbbr + " " + zipcode);
                    break;
            }
            break;
        case 3:
            switch (i) {
                case 1:
                    $('#keyword1').val(main + " " + saleType + " in " + city3);
                    break;
                case 2:
                    $('#keyword2').val(feature1 + " " + main + " " + saleType + " in " + city3);
                    break;
                case 3:
                    $('#keyword3').val(feature2 + " " + main + " " + saleType + " in " + city3);
                    break;
                case 4:
                    $('#keyword4').val(feature3 + " " + main + " " + saleType + " in " + city3);
                    break;
                case 5:
                    $('#keyword5').val(feature1 + " " + feature2 + " " + main + " " + saleType + " in " + city3);
                    break;
                case 6:
                    $('#keyword6').val(feature1 + " " + feature3 + " " + main + " " + saleType + " in " + city3);
                    break;
                case 7:
                    $('#keyword7').val(feature2 + " " + feature3 + " " + main + " " + saleType + " in " + city3);
                    break;
                case 8:
                    $('#keyword8').val(secondary + " " + saleType + " in " + city3);
                    break;
                case 9:
                    $('#keyword9').val(feature1 + " " + secondary + " " + saleType + " in " + city3);
                    break;
                case 10:
                    $('#keyword10').val(feature2 + " " + secondary + " " + saleType + " in " + city3);
                    break;
                case 11:
                    $('#keyword11').val(feature3 + " " + secondary + " " + saleType + " in " + city3);
                    break;
                case 12:
                    $('#keyword12').val(feature1 + " " + feature2 + " " + secondary + " " + saleType + " in " + city3);
                    break;
                case 13:
                    $('#keyword13').val(feature1 + " " + feature3 + " " + secondary + " " + saleType + " in " + city3);
                    break;
                case 14:
                    $('#keyword14').val(feature2 + " " + feature3 + " " + secondary + " " + saleType + " in " + city3);
                    break;
                case 16:
                    $('#keyword16').val(address + " " + city3);
                    break;
                case 17:
                    $('#keyword17').val(address + " " + city3 + " " + stateAbbr);
                    break;
                case 18:
                    $('#keyword18').val(address + " " + city3 + " " + stateAbbr + " " + zipcode);
                    break;
            }
            break;
        case 4:
            switch (i) {
                case 1:
                    $('#keyword1').val(main + " " + saleType + " in " + area);
                    break;
                case 2:
                    $('#keyword2').val(feature1 + " " + main + " " + saleType + " in " + area);
                    break;
                case 3:
                    $('#keyword3').val(feature2 + " " + main + " " + saleType + " in " + area);
                    break;
                case 4:
                    $('#keyword4').val(feature3 + " " + main + " " + saleType + " in " + area);
                    break;
                case 5:
                    $('#keyword5').val(feature1 + " " + feature2 + " " + main + " " + saleType + " in " + area);
                    break;
                case 6:
                    $('#keyword6').val(feature1 + " " + feature3 + " " + main + " " + saleType + " in " + area);
                    break;
                case 7:
                    $('#keyword7').val(feature2 + " " + feature3 + " " + main + " " + saleType + " in " + area);
                    break;
                case 8:
                    $('#keyword8').val(secondary + " " + saleType + " in " + area);
                    break;
                case 9:
                    $('#keyword9').val(feature1 + " " + secondary + " " + saleType + " in " + area);
                    break;
                case 10:
                    $('#keyword10').val(feature2 + " " + secondary + " " + saleType + " in " + area);
                    break;
                case 11:
                    $('#keyword11').val(feature3 + " " + secondary + " " + saleType + " in " + area);
                    break;
                case 12:
                    $('#keyword12').val(feature1 + " " + feature2 + " " + secondary + " " + saleType + " in " + area);
                    break;
                case 13:
                    $('#keyword13').val(feature1 + " " + feature3 + " " + secondary + " " + saleType + " in " + area);
                    break;
                case 14:
                    $('#keyword14').val(feature2 + " " + feature3 + " " + secondary + " " + saleType + " in " + area);
                    break;
            }
            break;
        case 5:
            switch (i) {
                case 1:
                    $('#keyword1').val(main + " " + saleType + " in " + zipcode);
                    break;
                case 2:
                    $('#keyword2').val(feature1 + " " + main + " " + saleType + " in " + zipcode);
                    break;
                case 3:
                    $('#keyword3').val(feature2 + " " + main + " " + saleType + " in " + zipcode);
                    break;
                case 4:
                    $('#keyword4').val(feature3 + " " + main + " " + saleType + " in " + zipcode);
                    break;
                case 5:
                    $('#keyword5').val(feature1 + " " + feature2 + " " + main + " " + saleType + " in " + zipcode);
                    break;
                case 6:
                    $('#keyword6').val(feature1 + " " + feature3 + " " + main + " " + saleType + " in " + zipcode);
                    break;
                case 7:
                    $('#keyword7').val(feature2 + " " + feature3 + " " + main + " " + saleType + " in " + zipcode);
                    break;
                case 8:
                    $('#keyword8').val(secondary + " " + saleType + " in " + zipcode);
                    break;
                case 9:
                    $('#keyword9').val(feature1 + " " + secondary + " " + saleType + " in " + zipcode);
                    break;
                case 10:
                    $('#keyword10').val(feature2 + " " + secondary + " " + saleType + " in " + zipcode);
                    break;
                case 11:
                    $('#keyword11').val(feature3 + " " + secondary + " " + saleType + " in " + zipcode);
                    break;
                case 12:
                    $('#keyword12').val(feature1 + " " + feature2 + " " + secondary + " " + saleType + " in " + zipcode);
                    break;
                case 13:
                    $('#keyword13').val(feature1 + " " + feature3 + " " + secondary + " " + saleType + " in " + zipcode);
                    break;
                case 14:
                    $('#keyword14').val(feature2 + " " + feature3 + " " + secondary + " " + saleType + " in " + zipcode);
                    break;
            }
            break;
        default:
    }
}