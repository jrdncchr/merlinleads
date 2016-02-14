
function buttonLoadStart(btn, text) {
    if(text) {
        btn.html("<i class='fa fa-cog custom-loading'></i> " + text);
    } else {
        btn.html("<i class='fa fa-cog custom-loading'></i>");
    }
    btn.prop("disabled", true);
}

function buttonLoadEnd(btn, text) {
    btn.html(text);
    btn.prop("disabled", false);
}

function proccess(opt) {
    buttonLoadStart(opt.btn, opt.btnLoadText);
    $.post(opt.url, opt.data, function(data) {
        if(data.success == true) {
            toastr.success(opt.success);
            checkedRows = [];
            selectedRows = [];
            if(typeof opt['dt'] !== "undefined") {
                opt.dt.fnReloadAjax();
            }
            if(opt.hideModal) {
                opt.modal.modal("hide");
            }
            if(typeof opt['callback'] !== "undefined") {
                opt.callback();
            }
        } else {
            toastr.error("Something went wrong.");
        }
        buttonLoadEnd(opt.btn, opt.btnText);
        opt.btn.hide();
    }, "json");
}

function showDeleteModal(message) {
    $("#globalDeleteModal").modal({
        show: true,
        keyboard: false,
        backdrop: 'static'
    });

    if(message) {
        $("#globalDeleteModal").find("#deleteModalText").html(message);
    }

    $("#globalDeleteBtn").off("click").click(function() {
        $('#deleteConfirmed').val(1);
        deleteAction();
    });
}

function showGlobalModal() {
    $("#globalFormModal").modal({
        show: true,
        keyboard: false,
        backdrop: "static"
    });
}

$(function() {
    /* Modal Global Events  */
    $(".modal")
        .on("shown.bs.modal", function() {
            $(this).find('input, textarea, select')
                .not('input[type=hidden],input[type=button],input[type=submit],input[type=reset],input[type=image],button')
                .filter(':enabled:visible:first')
                .focus();
            })

        .on("hidden.bs.modal", function() {
            var globalFormModal = $("#globalFormModal");
            globalFormModal.find('.modal-error').hide().html("");
            globalFormModal.find('input, textarea, select')
                .not('input[type=hidden],input[type=button],input[type=submit],input[type=reset],input[type=image],button')
                .filter(':enabled')
                .each(function() {
                    $(this).parent().removeClass('has-error').val('');
                    $(this).val('');
                });

            var globalFormModalPost = $("#globalFormModalPost");
            globalFormModalPost.find('.modal-error').hide().html("");
            globalFormModalPost.find('input, textarea, select')
                .not('input[type=hidden],input[type=button],input[type=submit],input[type=reset],input[type=image],button')
                .filter(':enabled')
                .each(function() {
                    $(this).parent().removeClass('has-error').val('');
                    $(this).val('');
                });
    });


    /* DataTables Global Events */
    $(".dataTable").on('click', 'tr', function () {
        $(this).toggleClass('selected');
    });


    /* Copy to Clipboard */
    $(".clip").off("click").click(function() {
        var e = $(this).closest(".input-group").find(".form-control");
        e.select();
        document.execCommand('copy');
        loading('info', "Copied to clipboard.");
    });

});