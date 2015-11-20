<div class="col-xs-12">
    <div class='row'>
        <div class="form-group">
            <div class="col-xs-12">
                <div id="message"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6">
                <h2 style="margin-top: 0!important;">SEO Builder - Advance Search Categories</h2>
            </div>
            <div class="col-xs-6">
                <button id="deleteBtn" class="btn btn-danger btn-sm pull-right"><i class="fa fa-minus-circle"></i> Delete </button>
                <button id="showModalBtn" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus-circle"></i> Add </button>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table id="dt" class="dataTable" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Status</th>
                        <th>Date Created</th>
                    </tr>
                    </thead></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="modalContent" style="display: none;">
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="categoryName">Category Name</label>
                <input type="text" class="form-control required" id="categoryName" placeholder="Category Name">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="checkbox">
                <label style="display: inline !important;">
                    <input type="checkbox" id="status" style="margin-top: 1px !important;"/>
                    Check to activate this category.
                </label>
            </div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-xs-12">
            <p><b>Sub Categories</b></p>
            <ul class="list-group" id="subCategories">
<!--                <li class="list-group-item">-->
<!--                    <span class="badge"><i class="fa fa-minus-circle"></i></span>-->
<!--                    Sample Sub Category-->
<!--                </li>-->
            </ul>
            <div class="form-horizontal" style="margin-bottom: 10px;" id="addSubCategoriesForm">
                <div class="form-group">
                    <label class="col-xs-5 control-label">Add Sub Category</label>
                    <div class="col-xs-7">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Sub Category Name">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button"><i class="fa fa-plus-circle"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var dt;
    var update = false, exists = false;
    var actionUrl = "<?php echo base_url() . "admin2/seo_builder_as_category" ?>";
    var selected, selectedRows;

    $(document).ready(function() {
        $('#seoBuilderSideLink').addClass('custom-nav-active');
        $('#seoBuilderAsCategoriesTopLink').addClass('custom-nav-active');
        setupDataTables();
        activateEvents();
    });

    function activateEvents() {
        $("#globalFormModal").find("#globalFormModalContent").html($("#modalContent").html());
        $("#globalFormModal").on("hidden.bs.modal", function() {
            $("#globalFormModal").find("input").val("");
            $("#status").attr("checked", false);
            $("#subCategories").html("");
        });

        $("#showModalBtn").off("click").click(function() {
            update = false;
            $("#globalFormModal").find(".modal-title").html("Add Category");
            showGlobalModal();
        });

        $("#globalSaveBtn").off("click").click(function() {
            if(validateGlobalFormModal()) {
                if(!exists) {
                    var status = $("#status").is(":checked") ? "Active" : "Inactive";
                    var data = {
                        info: {
                            category_name: $("#categoryName").val(),
                            status: status,
                            sub_categories: getSubCategories()
                        },
                        action: "add"
                    };
                    if(update) {
                        data.id = selected.id;
                        data.action = "update";
                    }
                    proccess({
                        dt: dt,
                        url: actionUrl,
                        data: data,
                        btn: $("#globalSaveBtn"),
                        btnLoadText: "Saving...",
                        btnText: "Save",
                        success: "Successfully Saved.",
                        modal: $('#globalFormModal'),
                        hideModal: true
                    });
                }

            }
        });

        $('#deleteBtn').off("click").click(function() {
            selectedRows = $.map($("#dt").DataTable().rows('.selected').data(), function (item) {
                return item.id;
            });
            if(selectedRows.length > 0) {
                showDeleteModal();
            } else {
                toastr.warning("Select an item to delete.");
            }
        });

        $("#categoryName").off("blur").blur(function(data) {
            var validate = true;
            if(update) {
                if($(this).val() == selected.category_name) {
                    validate = false;
                }
            }
            if(validate) {
                $.ajax({
                    url: actionUrl,
                    data: { action: "validate_exists", to_validate: $("#categoryName").val() },
                    type: "post",
                    dataType: "json",
                    success: function(data) {
                        if(data.already_exist == true) {
                            exists = true;
                            $("#categoryName").parent().addClass('has-error');
                            globalFormModalError(true, "Category name already exists!");
                        } else {
                            exists = false;
                            $("#categoryName").parent().removeClass('has-error');
                            globalFormModalError(false);
                        }
                    }
                });
            } else {
                exists = false;
                $("#categoryName").parent().removeClass('has-error');
                globalFormModalError(false);
            }
        });

        $("#addSubCategoriesForm").find("button").off("click").click(function() {
            var subCategory = $("#addSubCategoriesForm").find("input").val();
            if(subCategory !== "") {
                $("#subCategories").append(""
                + "<li class='list-group-item'>"
                + "<span class='badge'><i class='fa fa-minus-circle'></i></span>"
                + "<span class='subCategory'>" + subCategory + "</span>"
                + "</li>" +
                "");
                $("#addSubCategoriesForm").find("input").val("");
                activateRemoveSubCategoryEvent();
            }
        });
    }

    function activateRemoveSubCategoryEvent() {
        $("#subCategories").find(".badge").off("click").click(function() {
            $(this).closest("li").remove();
        });
    }

    function getSubCategories() {
        var subCategories = "";
        $("#subCategories").find(".subCategory").each(function() {
            subCategories += $(this).html() + "|";
        });
        return subCategories == "" ? subCategories : subCategories.slice(0, -1);
    }

    function setupDataTables() {
        dt = $("#dt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [],
            "bDestroy": true,
            "filter": false,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": { action: "list" }
            },
            columns: [
                { data: "category_name", width: "50%" },
                { data: "status", width: "25%", render:
                    function(data, type, row) {
                        var textClass = data == "Active" ? "text-success" : "text-danger";
                        return  "<b><span class='" + textClass + "'>" + data + "</span></b>";
                    }
                },
                { data: "date_created", width: "25%" },
                { data: "id", visible: false }
            ],
            "fnDrawCallback": function( oSettings ) {
                var table = $("#dt").dataTable();
                $('#dt tbody tr').on('dblclick', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    showUpdateModal(data);
                });
            }
        });
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

    function showUpdateModal(data) {
        update = true;
        selected = data;
        $("#globalFormModal").find(".modal-title").html("Update Category");
        $("#categoryName").val(data.category_name);
        if(data.status == "Active") {
            $("#status").attr("checked", true);
        } else {
            $("#status").attr("checked", false);
        }
        if(data.sub_categories != "") {
            var subCategories = data.sub_categories.split("|");
            for(var i = 0; i < subCategories.length; i++) {
                $("#subCategories").append(""
                + "<li class='list-group-item'>"
                + "<span class='badge'><i class='fa fa-minus-circle'></i></span>"
                + "<span class='subCategory'>" + subCategories[i] + "</span>"
                + "</li>" +
                "");
            }
        }
        activateRemoveSubCategoryEvent();
        showGlobalModal();
    }

</script>