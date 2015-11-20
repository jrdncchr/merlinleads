$(document).ready(function() {
    activateEvents();
});

function activateEvents() {
    $('#addTemplateBtn').click(function() {
        $('#addTemplateFullModal').modal('show');
        $(".addDiv").fadeOut('fast');
        switch ($("#tfModule").val()) {
            case "Youtube":
                $('#youtubeAddDiv').fadeIn('fast');
                break;
            case "Slideshare":
                $('#slideshareAddDiv').fadeIn('fast');
                break;
            case "Craiglist":
                $.ajax({
                    url: base_url + "admin/getNextTemplateNo",
                    data: {category: $('#tfCategory').val(), module: $('#tfModule').val()},
                    type: 'post',
                    cache: false,
                    success: function(data) {
                        $('#addClTemplateNo').val(data);
                        $('#craiglistAddDiv').fadeIn('fast');
                    }
                });
                break;
            case "Backpage":
                $.ajax({
                    url: base_url + "admin/getNextTemplateNo",
                    data: {category: $('#tfCategory').val(), module: $('#tfModule').val()},
                    type: 'post',
                    cache: false,
                    success: function(data) {
                        $('#addBpTemplateNo').val(data);
                        $('#bpAddDiv').fadeIn('fast');
                    }
                });
                break;
            case "Ebay":
                $.ajax({
                    url: base_url + "admin/getNextTemplateNo",
                    data: {category: $('#tfCategory').val(), module: $('#tfModule').val()},
                    type: 'post',
                    cache: false,
                    success: function(data) {
                        $('#addEbayTemplateNo').val(data);
                        $('#ebayAddDiv').fadeIn('fast');
                    }
                });
                break;
            case "Twitter":
                $.ajax({
                    url: base_url + "admin/getNextTemplateNo",
                    data: {category: $('#tfCategory').val(), module: $('#tfModule').val()},
                    type: 'post',
                    cache: false,
                    success: function(data) {
                        $('#addTwitterTemplateNo').val(data);
                        $('#twitterAddDiv').fadeIn('fast');
                    }
                });
                break;
            default:
        }
    });

    $('#tfModule').change(function() {
        $.ajax({
            url: base_url + "admin/changeModuleFull",
            data: {type: $('#tfCategory').val(), module: $('#tfModule').val()},
            type: 'post',
            cache: false,
            dataType: 'json',
            success: function(data) {
                $('.fullDiv').fadeOut('fast');
                $('#tfTemplateNo').html(data.count);
                $('#typeDiv').fadeOut('fast');
                $('#tfType').val("Regular");
                switch ($('#tfModule').val()) {
                    case "Youtube":
                        $('#youtubeFullDiv').fadeIn('fast');
                        $('#tfTitle').val(data.title);
                        $('#tfDescription').val(data.description);
                        $('#tfKeyword').val(data.keyword);
                        break;
                    case "Slideshare":
                        $('#slideshareFullDiv').fadeIn('fast');
                        $('#ssTitle').val(data.title);
                        $('#ssDescription').val(data.description);
                        $('#ssKeyword').val(data.keyword);
                        break;
                    case "Craiglist":
                        $('#craiglistFullDiv').fadeIn('fast');
                        $('#clPostingTitle').val(data.posting_title);
                        $('#clSpecificLocation').val(data.specific_location);
                        $('#clPostingBody').val(data.posting_body);
                        $('#typeDiv').slideDown('slow');
                        break;
                    case "Backpage":
                        $('#bpFullDiv').fadeIn('fast');
                        $('#bpSpecificLocation').val(data.specific_location);
                        $('#bpTitle').val(data.title);
                        $('#bpDescription').val(data.description);
                        $('#typeDiv').slideDown('slow');
                        break;
                    case "Ebay":
                        $('#ebayFullDiv').fadeIn('fast');
                        $('#ebayTitle').val(data.title);
                        $('#ebayDescription').val(data.description);
                        $('#typeDiv').slideDown('slow');
                        break;
                    case "Twitter":
                        $('#twitterFullDiv').fadeIn('fast');
                        $('#twitterDescription').val(data.description);
                        break;
                    default:
                }
                toastr.success("Getting Template Successful!");
                stopLoader();
            }
        });
    });

    // For Classifieds
    $('#tfType').change(function() {
        startLoader('Changing Module Type, please wait...');
        $.ajax({
            url: base_url + 'admin/changeModuleType',
            data: {category: $('#tfCategory').val(), module: $('#tfModule').val(), type: $('#tfType').val()},
            type: 'post',
            cache: false,
            dataType: 'json',
            success: function(data) {
                $('#tfTemplateNo').html(data.count);
                switch ($('#tfModule').val()) {
                    case "Craiglist":
                        $('#clPostingTitle').val(data.posting_title);
                        $('#clSpecificLocation').val(data.specific_location);
                        $('#clPostingBody').val(data.posting_body);
                        break;
                    case "Backpage":
                        $('#bpTitle').val(data.title);
                        $('#bpSpecificLocation').val(data.specific_location);
                        $('#bpDescription').val(data.description);
                        break;
                    case "Ebay":
                        $('#ebayTitle').val(data.title);
                        $('#ebayDescription').val(data.description);
                        break;
                    default:
                }
                toastr.success("Changing Module Type Successful!");
                stopLoader();
            }
        });
    });

    $('#tfTemplateNo').change(function() {
        startLoader('Getting Template, please wait...');
        $.ajax({
            url: base_url + 'admin/changeTemplateFull',
            data: {category: $('#tfCategory').val(), module: $('#tfModule').val(), template_no: $('#tfTemplateNo').val(), type: $('#tfType').val()},
            type: 'post',
            cache: false,
            dataType: 'json',
            success: function(data) {
                switch ($('#tfModule').val()) {
                    case "Youtube":
                        $('#tfTitle').val(data.title);
                        $('#tfDescription').val(data.description);
                        $('#tfKeyword').val(data.keyword);
                        break;
                    case "Slideshare":
                        $('#ssTitle').val(data.title);
                        $('#ssDescription').val(data.description);
                        $('#ssKeyword').val(data.keyword);
                        break;
                    case "Craiglist":
                        $('#clPostingTitle').val(data.posting_title);
                        $('#clSpecificLocation').val(data.specific_location);
                        $('#clPostingBody').val(data.posting_body);
                        break;
                    case "Backpage":
                        $('#bpTitle').val(data.title);
                        $('#bpSpecificLocation').val(data.specific_location);
                        $('#bpDescription').val(data.description);
                        break;
                    case "Ebay":
                        $('#ebayTitle').val(data.title);
                        $('#ebayDescription').val(data.description);
                        break;
                    case "Twitter":
                        $("#twitterDescription").val(data.description);
                        break;
                    default:
                }
                toastr.success("Getting Template Successful!");
                stopLoader();
            }
        });
    });

    $('#tfSaveBtn').click(function() {
        if ($('#tfModule').val() === "Youtube") {
            if (validate('youtubeFullDiv')) {
                var data = {category: $('#tfCategory').val(), module: $('#tfModule').val(), template_no: $('#tfTemplateNo').val(),
                    title: $('#tfTitle').val(), description: $('#tfDescription').val(), keyword: $('#tfKeyword').val()};
                save(data);

            }
        } else if ($('#tfModule').val() === "Slideshare") {
            if (validate('ssFullDiv')) {
                var data = {category: $('#tfCategory').val(), module: $('#tfModule').val(), template_no: $('#tfTemplateNo').val(),
                    title: $('#ssTitle').val(), description: $('#ssDescription').val(), keyword: $('#ssKeyword').val()};
                save(data);

            }
        } else if ($('#tfModule').val() === "Craiglist") {
            if (validate('craiglistFullDiv')) {
                var data = {category: $('#tfCategory').val(), module: $('#tfModule').val(), template_no: $('#tfTemplateNo').val(), type: $('#tfType').val(),
                    posting_title: $('#clPostingTitle').val(), specific_location: $('#clSpecificLocation').val(), posting_body: $('#clPostingBody').val()};
                save(data);
            }
        } else if ($('#tfModule').val() === "Backpage") {
            if (validate('bpFullDiv')) {
                var data = {category: $('#tfCategory').val(), module: $('#tfModule').val(), template_no: $('#tfTemplateNo').val(), type: $('#tfType').val(),
                    specific_location: $('#bpSpecificLocation').val(), title: $('#bpTitle').val(), description: $('#bpDescription').val()};
                save(data);
            }
        } else if ($('#tfModule').val() === "Ebay") {
            if (validate('ebayFullDiv')) {
                var data = {category: $('#tfCategory').val(), module: $('#tfModule').val(), template_no: $('#tfTemplateNo').val(), type: $('#tfType').val(),
                    title: $('#ebayTitle').val(), description: $('#ebayDescription').val()};
                save(data);
            }
        } else if ($('#tfModule').val() === "Twitter") {
            if (validate('twitterFullDiv')) {
                var data = {category: $('#tfCategory').val(), module: $('#tfModule').val(), template_no: $('#tfTemplateNo').val(), description: $('#twitterDescription').val()};
                save(data);
            }
        }
        function save(data) {
            $("#tfSaveBtn").prop('disabled', true).html("<img src='" + base_url + "resources/images/ajax-loader.gif' />");
            $.ajax({
                url: base_url + 'admin/saveTemplateFull',
                data: data,
                type: 'post',
                cache: false,
                success: function(data) {
                    if (data === "OK") {
                        $("#tfSaveBtn").prop('disabled', false).html("Update");
                        toastr.success("Saving Template Successful!");
                    } else {
                        alert(data);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    });

    $('#tfAddBtn').click(function() {
        if ($('#tfModule').val() === "Youtube") {
            if (validate('youtubeAddDiv')) {
                if (validTemplateNo) {
                    $("#tfAddBtn").prop('disabled', true).html("<img src='" + base_url + "resources/images/ajax-loader.gif' />");
                    var data = {category: $('#tfCategory').val(), module: $('#tfModule').val(), template_no: $('#addTfTemplateNo').val(),
                        title: $('#addTfTitle').val(), description: $('#addTfDescription').val(), keyword: $('#addTfKeyword').val()};
                    add(data);
                }
            }
        } else if ($('#tfModule').val() === "Slideshare") {
            if (validate('slideshareAddDiv')) {
                if (validTemplateNo) {
                    $("#tfAddBtn").prop('disabled', true).html("<img src='" + base_url + "resources/images/ajax-loader.gif' />");
                    var data = {category: $('#tfCategory').val(), module: $('#tfModule').val(), template_no: $('#addSsTemplateNo').val(),
                        title: $('#addSsTitle').val(), description: $('#addSsDescription').val(), keyword: $('#addSsKeyword').val()};
                    add(data);
                }
            }
        } else if ($('#tfModule').val() === "Craiglist") {
            if (validate('craiglistAddDiv')) {
                $("#tfAddBtn").prop('disabled', true).html("<img src='" + base_url + "resources/images/ajax-loader.gif' />");
                var data = {category: $('#tfCategory').val(), module: $('#tfModule').val(), number: $('#addClTemplateNo').val(), type: $('#tfType').val(),
                    posting_title: $('#addClPostingTitle').val(), specific_location: $('#addClSpecificLocation').val(), posting_body: $('#addClPostingBody').val()};
                add(data);
            }
        } else if ($('#tfModule').val() === "Backpage") {
            if (validate('bpFullDiv')) {
                var data = {category: $('#tfCategory').val(), module: $('#tfModule').val(), number: $('#addBpTemplateNo').val(), type: $('#tfType').val(),
                    specific_location: $('#addBpSpecificLocation').val(), title: $('#addBpTitle').val(), description: $('#addBpDescription').val()};
                add(data);
            }
        } else if ($('#tfModule').val() === "Ebay") {
            if (validate('ebayFullDiv')) {
                var data = {category: $('#tfCategory').val(), module: $('#tfModule').val(), number: $('#addEbayTemplateNo').val(), type: $('#tfType').val(),
                    title: $('#addEbayTitle').val(), description: $('#addEbayDescription').val()};
                add(data);
            }
        } else if ($('#tfModule').val() === "Twitter") {
            if (validate('twitterFullDiv')) {
                var data = {category: $('#tfCategory').val(), module: $('#tfModule').val(), templateNo: $('#addTwitterTemplateNo').val(),
                    description: $('#addTwitterDescription').val()};
                add(data);
            }
        }


        function add(data) {
            $.ajax({
                url: base_url + 'admin/addTemplateFull',
                data: data,
                type: 'post',
                cache: false,
                success: function(data) {
                    if (data === "OK") {
                        window.location = base_url + "admin";
                    } else {
                        alert(data);
                    }
                }
            });
        }
    });

    $('#tfDeleteBtn').click(function() {
        var ok = confirm("Are you sure to delete this template[" + $('#tfTemplateNo').val() + "]?");
        if (ok) {
            $("#tfActionsBtn").prop('disabled', true).html("<img src='" + base_url + "resources/images/ajax-loader.gif' />");
            $.ajax({
                url: base_url + 'admin/deleteTemplateFull',
                data: {category: $('#tfCategory').val(), module: $('#tfModule').val(), template_no: $('#tfTemplateNo').val(), type: $('#tfType').val()},
                type: 'post',
                cache: false,
                success: function(data) {
                    if (data === "OK") {
                        window.location = base_url + "admin";
                    } else {
                        alert(data);
                    }
                }
            });
        }
    });

    var validTemplateNo = true;
    $('.addTemplateNo').keyup(function() {
        $.ajax({
            url: base_url + 'admin/validateTemplateFullNo',
            data: {category: $('#tfCategory').val(), module: $('#tfModule').val(), template_no: $(this).val()},
            cache: false,
            type: 'post',
            success: function(data) {
                if (data === "Unavailable") {
                    validTemplateNo = false;
                    alert("The template number is already used.");
                } else {
                    validTemplateNo = true;
                }
            }
        });
    });

}