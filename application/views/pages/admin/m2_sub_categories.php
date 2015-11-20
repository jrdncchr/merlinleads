<div class='row'>
    <div class='col-xs-12'>
        <h4 style="margin-top: 0 !important;">Modules 2 Templates : Sub Categories</h4>
        <table id="subCategoriesDT" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th></th>
                <th>Sub Category Name</th>
                <th>Category Name</th>
                <th>Category Type</th>
                <th>Status</th>
            </tr>
            </thead>
        </table>
        <br />
        <button id="addBtn" type="button" class="btn btn-sm btn-success">Add</button>
        <button id="deleteBtn" type="button" class="btn btn-sm btn-danger">Delete</button>
    </div>
</div>

<div id="modalContent" style="display: none;">
    <form>
        <div class="form-group">
            <label class="control-label">* Category</label>
            <select id="category" class="form-control required">
                <option value="">Select Category</option>
                <?php foreach($categories as $c): ?>
                    <?php echo "<option value='$c->category_id'>$c->category_name [ $c->category_type ]</option>"; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">* Sub Category Name</label>
            <input type="text" class="form-control required" id="subCategoryName">
        </div>
        <div class="form-group">
            <label class="control-label">* Headline</label>
            <input type="text" class="form-control required" id="headline">
        </div>
        <div class="form-group">
            <label class="control-label">* Body</label>
            <textarea rows="4" class="form-control required" id="body"></textarea>
        </div>
        <div class="form-group">
            <label class="control-label">* Keywords</label>
            <textarea rows="3" class="form-control required" id="keywords"></textarea>
        </div>
        <div class="form-group">
            <label class="control-label">* Active? </label>
            <input type="checkbox" id="status">
        </div>
    </form>
</div>

<script>
    var subCategoriesDT;
    var update = false;
    var selectedId;
    var checkedRows = [];

    $(document).ready(function() {
        $("#subCategoryTopLink").addClass("custom-nav-active");
        $("#categorySideLink").addClass("custom-nav-active");

        $("#globalFormModal").find("#globalFormModalContent").html($("#modalContent").html());

        subCategoriesDT = $('#subCategoriesDT').dataTable({
            "bJQueryUI": true,
            "bDestroy": true,
            "ajax": {
                "url":  "<?php echo base_url() . "admin2/sub_category"; ?>",
                "type": "POST",
                "data": {action: "get"}
            },
            columns: [
                {
                    "data": "sub_category_id",
                    render: function ( data, type, row ) {
                        return '<input type="checkbox" />';
                    },
                    className: "dt-body-center",
                    "searchable": false,
                    "orderable": false,
                    "width": "2%"
                },
                { data: "sub_category_name" },
                { data: "category_name" },
                { data: "category_type" },
                {
                    "data": "status",
                    render: function ( data, type, row ) {
                        return data == 1 ? "<span class='text-success'>Active</span>"
                            : "<span class='text-danger'>Inactive</span>";
                    }
                },
                { data: "category_id", visible: false }
            ],
            "fnDrawCallback": function( oSettings ) {
                var table = $("#subCategoriesDT").dataTable();
                $('#subCategoriesDT tbody tr').on('dblclick', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    showAddEditModal(data);
                });
            },
            "fnRowCallback": function( nRow, data, iDisplayIndex,iDisplayIndexFull) {
                $('input', nRow).off('change').change(function(row) {
                    if($(this).is(":checked")) {
                        checkedRows.push(data.sub_category_id);
                    } else {
                        var index = checkedRows.indexOf(data.sub_category_id);
                        if (index > -1) {
                            checkedRows.splice(index, 1);
                        }
                    }
                });
            }
        });

        activateEvents();
    });

    function showAddEditModal(data) {
        update = true;
        selectedId = data.sub_category_id;

        $("#globalFormModal").find(".modal-title").html("Edit Sub Category");
        $("#globalFormModal").modal({
            show: true,
            keyboard: false,
            backdrop: "static"
        });
        $("#category").val(data.category_id);
        $("#subCategoryName").val(data.sub_category_name);
        $("#headline").val(data.headline);
        $("#body").val(data.body);
        $("#keywords").val(data.keywords);

        if(data.status == 1) {
            $("#status").prop("checked", true);
        } else {
            $("#status").prop("checked", false);
        }
    }

    function activateEvents() {
        $('#addBtn').off("click").click(function() {
            update = false;
            $("#globalFormModal").find(".modal-title").html("Add Sub Category");
            $("#globalFormModal").modal({
                show: true,
                keyboard: false,
                backdrop: "static"
            });
        });

        $("#globalSaveBtn").off("click").click(function() {
            if(validateGlobalFormModal()) {
                var data = {
                    info: {
                        category_id         : $('#category').val(),
                        sub_category_name   : $('#subCategoryName').val(),
                        headline            : $("#headline").val(),
                        body                : $("#body").val(),
                        keywords            : $("#keywords").val(),
                        status              : $("#status").is(":checked") ? 1 : 0
                    },
                    action: "add"
                };
                if(update) {
                    data.sub_category_id = selectedId;
                    data.action = "update";
                }
                proccess({
                    dt: subCategoriesDT,
                    url: base_url + "admin2/sub_category",
                    data: data,
                    btn: $("#globalSaveBtn"),
                    btnLoadText: "Saving...",
                    btnText: "Save",
                    success: "Successfully Saved.",
                    modal: $('#globalFormModal'),
                    hideModal: true
                });
            }
        });

        $('#deleteBtn').off("click").click(function() {
            if(checkedRows.length > 0) {
                showDeleteModal();
            } else {
                toastr.warning("Select an item to delete.");
            }
        });
    }

    function deleteAction() {
        console.log(checkedRows);
        var data = {
            action: "delete",
            idList: checkedRows
        };
        proccess({
            dt: subCategoriesDT,
            url: base_url + "admin2/sub_category",
            data: data,
            btn: $("#globalDeleteBtn"),
            btnLoadText: "Deleting...",
            btnText: "Delete",
            success: "Successfully Deleted.",
            modal: $('#globalDeleteModal'),
            hideModal: true
        });
    }


</script>