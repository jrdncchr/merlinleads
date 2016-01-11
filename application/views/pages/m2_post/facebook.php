<div class="col-xs-10 col-xs-offset-1">
    <div class='row'>
        <div class='col-xs-12'>
            <a href="<?php echo base_url() . 'property' ?>">&Leftarrow; Return to Properties Overview</a>
            <a href="<?php echo base_url() . 'property/edit/' . $property_overview->id ?>" class="pull-right">&Rightarrow; Edit
                Property</a>
            <h4><i class="fa fa-share"></i> Post Property <small>[ <?php echo $selectedModule; ?> ]</small></h4>
            <hr/>
            <h4>Property Name: <strong><?php echo $property_overview->name; ?></strong></h4>

            <table id="dt" class="display dataTable" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Sub Category Name</th>
                    <th>Date Saved</th>
                </tr>
                </thead>
            </table>
            <br />
            <button id="showBtn" type="button" class="btn btn-sm btn-success">Show Generate Form</button>
            <button id="deleteBtn" type="button" class="btn btn-sm btn-danger">Delete</button>
        </div>
    </div>
</div>

<div id="modalContent" style="display: none;">
    <form>
        <div class="form-group">
            <label class="control-label">* Category</label>
            <select id="category" class="form-control required">
                <option value="">Select Category</option>
                <?php foreach($categories as $c): ?>
                    <?php echo "<option value='$c->category_id'>$c->category_name</option>"; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">* Sub Category</label>
            <select id="subCategory" class="form-control required" disabled></select>
            <input type="text" class="form-control" id="subCategoryDisplay" disabled style="display: none;"/>
        </div>
        <div id="generateFields" style="display: none;">
            <div class="form-group">
                <label class="control-label">* Headline</label>
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control required" id="headline">
                    <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">* Body</label>
                <div class="input-group input-group-sm">
                    <textarea rows="4" class="form-control required" style="height: 100px;" id="body"></textarea>
                    <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">* Keywords</label>
                <div class="input-group input-group-sm">
                    <textarea rows="3" class="form-control required" style="height: 100px;" id="keywords"></textarea>
                    <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="modalContentUnavailable" style="display: none;">
    <p class="text-primary"><i class="fa fa-question-circle"></i> You did not integrate or authorized facebook into your account yet, proceed to My Account page and Integration section to setup it.</p>
</div>

<script>

var dt;
var actionUrl = "<?php echo base_url(); ?>post/facebook";
var selectedPostId, selectedSubCategoryId, selectedRows;
var postLink = "<?php echo isset($postLink) ? $postLink : ''; ?>";
var allowFeedPosting = "<?php echo isset($main_f->facebook_feed_posting) && $user->fb_access_token != '' ? 'yes' : 'no'; ?>";

$(function() {
    setupDataTables();
    activateEvents();

    $("#globalFormModalPost").on("hidden.bs.modal", function() {
        $("#category").val("");
        $("#subCategory").show().prop("disabled", true).val("");
        $("#subCategoryDisplay").hide().val("");
        clearGlobalModalPost();
    });
});

function setupDataTables() {

    dt = $('#dt').dataTable({
        "bJQueryUI": true,
        "bDestroy": true,
        "ajax": {
            "url":  actionUrl,
            "type": "POST",
            "data": { action: "get" }
        },
        columns: [
            { data: "category_name" },
            { data: "sub_category_name" },
            { data: "date_created" },
            { data: "post_id", visible: false},
            { data: "category_id", visible: false },
            { data: "sub_category_id", visible: false },
            { data: "headline", visible: false },
            { data: "body", visible: false },
            { data: "keywords", visible: false },
        ],
        "fnDrawCallback": function( oSettings ) {
            var table = $("#dt").dataTable();
            $('#dt tbody tr').on('dblclick', function () {
                var pos = table.fnGetPosition(this);
                var data = table.fnGetData(pos);
                showAddEditModal(data);
            });
        }
    });
}

function activateEvents() {
    $("#globalFormModalPost").find("#globalFormModalContentPost").html($("#modalContent").html());
    $("#globalConfirmModal").find("#globalConfirmModalContent").html($("#modalContentUnavailable").html());

    $('#showBtn').off("click").click(function() {
        update = false;
        $("#globalFormModalPost").find(".modal-title").html("Post Facebook Generate Form");
        $("#globalFormModalPost").modal({
            show: true,
            keyboard: false,
            backdrop: "static"
        });
        $("#category").prop("disabled", false);
    });

    $("#category").change(function() {
        if($(this).val()) {
            $.post(actionUrl, { action : "list", categoryId : $(this).val() }, function(data) {
                var options = "<option value=''>Select Sub Category</option>";
                for(var i in data) {
                    options += "<option value='" + data[i].sub_category_id + "'>" + data[i].sub_category_name + "</option>";
                }
                $("#subCategory").prop("disabled", false).html(options);
            }, "json");
        } else {
            $("#subCategory").prop("disabled", true).val("");
            clearGlobalModalPost();
        }
    });

    $("#subCategory").change(function() {
        clearGlobalModalPost();
        if($(this).val()) {
            $("#postGenerateBtn").show();
        } else {
            $("#postGenerateBtn").hide();
        }
    });

    $("#postGenerateBtn").click(function() {
        buttonLoadStart($(this), "Generating...");
        $.post(actionUrl, { action: "generate", subCategory: $("#subCategory").val() }, function(data) {
            $("#headline").val(data.headline);
            $("#body").val(data.body);
            $("#keywords").val(data.keywords);
            $("#generateFields, #postPostBtn, #postSaveBtn").show();
            buttonLoadEnd($("#postGenerateBtn"), "Generate");
            $("#postGenerateBtn").hide();
        }, "json");
    });


    $("#postSaveBtn").off("click").click(function() {
        if(validateGlobalFormModalPost()) {
            var data = {
                info: {
                    category_id         : $('#category').val(),
                    sub_category_id     : $('#subCategory').val(),
                    headline            : $("#headline").val(),
                    body                : $("#body").val(),
                    keywords            : $("#keywords").val()
                },
                action: "add"
            };
            if(update) {
                data.post_id = selectedPostId;
                data.info.sub_category_id = selectedSubCategoryId;
                data.action = "update";
            }
            proccess({
                dt: dt,
                url: actionUrl,
                data: data,
                btn: $("#postSaveBtn"),
                btnLoadText: "Saving...",
                btnText: "Save",
                success: "Successfully Saved.",
                modal: $('#globalFormModalPost'),
                hideModal: true
            });
        }
    });


    $('#deleteBtn').off("click").click(function() {
        selectedRows = $.map($("#dt").DataTable().rows('.selected').data(), function (item) {
            return item.post_id;
        });
        console.log(selectedRows);
        if(selectedRows.length > 0) {
            showDeleteModal();
        } else {
            toastr.warning("Select an item to delete.");
        }
    });

    $("#postPostBtn").off("click").click(function() {
        if(allowFeedPosting == "yes") {
            if(validateGlobalFormModalPost()) {
                var data = {
                    link                : postLink,
                    headline            : $("#headline").val(),
                    body                : $("#body").val(),
                    keywords            : $("#keywords").val()
                };
                proccess({
                    dt: dt,
                    url: "<?php echo base_url(). "facebook/post"; ?>",
                    data: data,
                    btn: $("#postPostBtn"),
                    btnLoadText: "Posting...",
                    btnText: "Post",
                    success: "Successfully Posted.",
                    modal: $('#globalFormModalPost'),
                    hideModal: false
                });
            }
        } else {

            $("#globalFormModalPost").modal('hide');
            $("#globalConfirmModal").find(".modal-title").html("Facebook Feed Posting");
            $("#globalConfirmModal").modal({
                show: true,
                keyboard: false,
                backdrop: "static"
            });
        }
    });

    $("#globalConfirmBtn").attr('href', '<?php echo base_url() . "main/myaccount/facebook"?>');
}

function showAddEditModal(data) {
    update = true;
    $("#globalFormModalPost").find(".modal-title").html("Edit Generated Facebook Post");
    $("#globalFormModalPost").modal({
        show: true,
        keyboard: false,
        backdrop: "static"
    });
    selectedPostId = data.post_id;
    selectedSubCategoryId = data.sub_category_id;
    $("#category").prop("disabled", true).val(data.category_id);
    $("#subCategory").hide();
    $("#subCategoryDisplay").show().val(data.sub_category_name);
    $("#headline").val(data.headline);
    $("#body").val(data.body);
    $("#keywords").val(data.keywords);
    $("#generateFields").show();

    $("#postSaveBtn").show();
}


function deleteAction() {
    var data = {
        action: "delete",
        idList: selectedRows
    };
    proccess({
        dt: dt,
        url: actionUrl,
        data: data,
        btn: $("#globalDeleteBtn"),
        btnLoadText: "Deleting...",
        btnText: "Delete",
        success: "Successfully Deleted.",
        modal: $('#globalDeleteModal'),
        hideModal: true
    });
}

function clearGlobalModalPost() {
    $("#generateFields").hide();
    $("#postPostBtn").hide();
    $("#postSaveBtn").hide();
    $("#postGenerateBtn").hide();
}

</script>