$(document).ready(function() {
    activatePopovers();
});

function activatePopovers() {
    $(document).find(".helper").each(function() {
        $(this).popover({
            'trigger': 'hover'
        });
    });
}

function validate(div) {
    var valid = true;
    $('#' + div).find('.required').each(function() {
        if ($(this).val().length < 3) {
            $(this).addClass('input-error');
            $('#' + div + 'Message').removeClass().addClass('alert alert-danger')
                    .html("<i class='fa fa-exclamation'></i> A required field is empty or invalid.");
            valid = false;
        } else {
            $(this).removeClass('input-error');
        }
    });
    if (valid) {
        $('#' + div + 'Message').removeClass().html("");
        return true;
    } else {
        return false;
    }
}