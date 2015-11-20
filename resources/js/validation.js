/**
 * Created by danero on 5/6/15.
 */

function globalFormModalError(show, message) {
    var errorDiv = $("#globalFormModal").find('.modal-error');
    if(show) {
        errorDiv.html( error_message(message) );
        errorDiv.show();
    } else {
        errorDiv.html("");
        errorDiv.hide();
    }
}

function validateGlobalFormModal() {
    var valid = true;
    var errorDiv = $("#globalFormModal").find('.modal-error');
    $("#globalFormModal").find('.required').each(function()  {
        if(!$(this).val()) {
            valid = false;
            $(this).parent().addClass('has-error');
        } else {
            $(this).parent().removeClass('has-error');
        }
    });
    if(!valid) {
        errorDiv.html( error_message("A required(*) field is empty.") );
        errorDiv.show();
    } else {
        errorDiv.html('');
        errorDiv.hide();
    }
    return valid;
}

function validateGlobalFormModalPost() {
    var valid = true;
    var errorDiv = $("#globalFormModalPost").find('.modal-error');
    $("#globalFormModal").find('.required').each(function()  {
        if(!$(this).val()) {
            valid = false;
            $(this).parent().addClass('has-error');
        } else {
            $(this).parent().removeClass('has-error');
        }
    });
    if(!valid) {
        errorDiv.html( error_message("A required(*) field is empty.") );
        errorDiv.show();
    } else {
        errorDiv.html('');
        errorDiv.hide();
    }
    return valid;
}

function validatePageForm() {
    var valid = true;
    var form = $("#page-form");
    var errorDiv = form.find(".alert-danger");
    form.find(".required").each(function() {
        if(!$(this).val()) {
            valid = false;
            $(this).parent().addClass('has-error');
        } else {
            $(this).parent().removeClass('has-error');
        }
    });
    if(!valid) {
        errorDiv.html( error_message("A required(*) field is empty.") );
        errorDiv.show();
        $("html, body").animate({
            scrollTop: 0
        }, 1000);
    } else {
        errorDiv.html('');
        errorDiv.hide();
    }
    return valid;
}

function error_message(message) {
    return "<i class='fa fa-exclamation-circle'></i> " + message;
}