$(document).ready(function () {
    $('.payment-select').show();
});

function showForm(e) {
    $('.payment-form').hide();
    if ($(e).val() === "Monthly") {
        $(e).parents('tr').find('.monthly-form').show();
    } else if ($(e).val() === "Annual") {
        $(e).parents('tr').find('.annual-form').show();
    } else if ($(e).val() === "Six Months") {
        $(e).parents('tr').find('.six-month-form').show();
    }
}