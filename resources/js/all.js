//var base_url = window.location.protocol + "//" + window.location.host;
//var base_url = window.location.protocol + "//" + window.location.host + "/leadgeneratortool/";

$(document).ready(function() {
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
});

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
