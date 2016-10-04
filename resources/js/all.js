//var base_url = window.location.protocol + "//" + window.location.host;
//var base_url = window.location.protocol + "//" + window.location.host + "/leadgeneratortool/";

$(document).ready(function() {
    setColumnSize();
    $(window).resize(function () { setColumnSize(); });

    //fix iframe z-index
    $('iframe').each(function() {
        var url = $(this).attr("src");
        if ($(this).attr("src").indexOf("?") > 0) {
            $(this).attr({
                "src": url + "&wmode=transparent",
                "wmode": "Opaque"
            });
        }
        else {
            $(this).attr({
                "src": url + "?wmode=transparent",
                "wmode": "Opaque"
            });
        }
    });

    toastr.options = {
        "positionClass": "toast-bottom-right"
    };
    toastr.options.preventDuplicates = true;
});

function setColumnSize() {
    $('.wrap').css('min-height', $( window ).height() - 100);
    $('.footer').show();
}

var toast;
function startLoader(msg) {
    $('#loader').fadeIn('fast');
    toastr.clear(toast);
    toast = toastr.info(msg);
}

function stopLoader() {
    $('#loader').fadeOut('fast');
    toastr.clear(toast);
}

function loading(type, message) {
    toastr.clear(toast);
    if (toast) {
        toast.remove();
    }
    if (type === "success") {
        toast = toastr.success(message);
    } else if (type === "info") {
        toast = toastr.info(message);
    } else if (type === "danger") {
        toast = toastr.error(message);
    }
}

function isUrl(s) {
    var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    return regexp.test(s);
}

function isValidEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function getDateDiff(date) { // interval means unit,
    // in which you want the result
    var second = 1000,
            minute = second * 60,
            hour = minute * 60,
            day = hour * 24,
            week = day * 7;
    date1 = new Date(date).getTime();
    date2 = new Date().getTime();
    var timediff = date2 - date1;
    if (isNaN(timediff)) {
        return NaN;
    }
    return Math.floor(timediff / hour);
    //return Math.floor(timediff / hour) - 13;
}

$('#test').click(function() {
    $.ajax({
        url: base_url + "property_module/test",
        success: function(data) {
            alert(data);
        }
    });
});

$.fn.serializeObject = function(){
    var obj = {};

    $.each( this.serializeArray(), function(i,o){
        var n = o.name,
            v = o.value;

        obj[n] = obj[n] === undefined ? v
            : $.isArray( obj[n] ) ? obj[n].concat( v )
            : [ obj[n], v ];
    });

    return obj;
};


function showCropper(data, image, w, h) {
    'use strict';
    var $image = $("#cropperImage");
    $image.attr('src', image.src);
    $("#cropperModal").on("shown.bs.modal", function() {
        $image.cropper({
            strict: true,
            rotatable: false,
            viewMode: 1,
            dragMode: 'move',
            cropBoxResizable: false,
            checkOrientation: false,
            built: function() {
                var m;
                for(var i = 1; i <= 5; i++) {
                    var nWidth = i * parseInt(w);
                    var nHeight = i * parseInt(h);
                    m = i;
                    if(nWidth > image.width || nHeight > image.height) {
                        break;
                    }
                }
                m = m == 1 ? 1 : m-1;
                $image.cropper('setData', {
                    width: w * m,
                    height: h * m
                });
            }
        });

        $("#cropperDone").off("click").click(function() {
            var croppedCanvas = $image.cropper('getCroppedCanvas', {width: w, height: h});
            croppedCanvas.toBlob(function(blob) {
                data.files[0] = blob;
                $("#cropperModal").modal('hide');
                data.submit();
            });
        });
    });

    $("#cropperModal").on("hidden.bs.modal", function() {
        $image.cropper('destroy');
    });

    $("#cropperModal").modal({
        show: true,
        backdrop: "static",
        keyboard: false
    });

}