<div class='row'>
    <div class='col-xs-12'>
        <h4 style="margin-top: 0 !important;">Modules 2 Templates : Categories</h4>
        <table id="categories" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th></th>
                <th>Category Name</th>
                <th>Category Type</th>
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
            <label class="control-label">* Category Type</label>
            <select class="form-control required" id="categoryType">
                <option value="">Select Category Type</option>
                <option value="Property">Property</option>
                <option value="Generic">Generic</option>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">* Category Name</label>
            <input type="text" class="form-control required" id="categoryName">
        </div>
    </form>
</div>

<script>
    var categoriesDT;
    var update = false;
    var selectedId;
    var checkedRows = [];

    $(document).ready(function() {
        $("#m2TemplatesTopLink").addClass("custom-nav-active");
        $("#templatesSideLink").addClass("custom-nav-active");

        $("#globalFormModal").find("#globalFormModalContent").html($("#modalContent").html());

        categoriesDT = $('#categories').dataTable({
            "bJQueryUI": true,
            "bDestroy": true,
            "ajax": {
                "url":  "<?php echo base_url() . "admin2/category"; ?>",
                "type": "POST",
                "data": {action: "get"}
            },
            columns: [
                {
                    "data": "category_id",
                    render: function ( data, type, row ) {
                        return '<input type="checkbox" />';
                    },
                    className: "dt-body-center",
                    "searchable": false,
                    "orderable": false,
                    "width": "2%"
                },
                { data: "category_name" },
                { data: "category_type" }
            ],
            "fnDrawCallback": function( oSettings ) {
                var table = $("#categories").dataTable();
                $('#categories tbody tr').on('dblclick', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    showAddEditModal(data);
                });
            },
            "fnRowCallback": function( nRow, data, iDisplayIndex,iDisplayIndexFull) {
                $('input', nRow).off('change').change(function(row) {
                    if($(this).is(":checked")) {
                        checkedRows.push(data.category_id);
                    } else {
                        var index = checkedRows.indexOf(data.category_id);
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
        selectedId = data.category_id;

        $("#globalFormModal").find(".modal-title").html("Edit Category");
        $("#globalFormModal").modal({
            show: true,
            keyboard: false,
            backdrop: "static"
        });
        $("#categoryName").val(data.category_name);
        $("#categoryType").val(data.category_type);
    }

    function activateEvents() {
        $('#addBtn').off("click").click(function() {
            update = false;
            $("#globalFormModal").find(".modal-title").html("Add Category");
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
                        category_name: $('#categoryName').val(),
                        category_type: $('#categoryType').val()
                    },
                    action: "add"
                };
                if(update) {
                    data.category_id = selectedId;
                    data.action = "update";
                }
                proccess({
                    dt: categoriesDT,
                    url: base_url + "admin2/category",
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
        var data = {
            action: "delete",
            idList: checkedRows
        };
        proccess({
            dt: categoriesDT,
            url: base_url + "admin2/category",
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