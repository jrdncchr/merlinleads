<div class="col-xs-12">
    <div class='row'>
        <div class="form-group">
            <div class="col-xs-12">
                <div id="message"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6">
                <h2 style="margin-top: 0!important;">SEO Builder - Advance Search Inputs</h2>
            </div>
            <div class="col-xs-6">
                <button id="deleteBtn" class="btn btn-danger btn-sm pull-right"><i class="fa fa-minus-circle"></i> Delete </button>
                <button id="showModalBtn" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus-circle"></i> Add </button>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-6">
                    <div class="form-inline" style="margin-bottom: 10px;">
                        <div class="form-group">
                            <label for="category">Select a category: </label>
                            <select class="form-control" id="category">
                                <option value="0">Select a category</option>
                                <?php foreach($categories as $c): ?>
                                    <option value="<?php echo $c->id ?>"><?php echo $c->category_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <table id="dt" class="dataTable" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Label</th>
                        <th>Short Code</th>
                        <th>Type</th>
                        <th>Show</th>
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
                <label for="label">Label</label>
                <input type="text" class="form-control required" id="label" placeholder="Label">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control required" id="type">
                    <option value="SELECT">Drop Down</option>
                    <option value="INPUT">Text Field</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="shortCode">Short Code</label>
                <input type="text" class="form-control required" id="shortCode" placeholder="Short Code">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="checkbox">
                <label style="display: inline !important;">
                    <input type="checkbox" id="show" style="margin-top: 1px !important;"/>
                    Check to show this input.
                </label>
            </div>
        </div>
    </div>
</div>

<script>
    var dt;
    var update = false, exists = false;
    var actionUrl = "<?php echo base_url() . "admin2/seo_builder_as_input" ?>";
    var selected, selectedRows;

    $(document).ready(function() {
        $('#seoBuilderSideLink').addClass('custom-nav-active');
        $('#seoBuilderAsInputsTopLink').addClass('custom-nav-active');
        setupDataTables();
        activateEvents();
    });

    function activateEvents() {
        $("#globalFormModal").find("#globalFormModalContent").html($("#modalContent").html())
            .on("hidden.bs.modal", function() {
                $("#globalFormModal").find("input").val("");
                $("#status").attr("checked", false);
            });

        $("#showModalBtn").off("click").click(function() {
            if($("#category").val() != "0") {
                update = false;
                $("#globalFormModal").find(".modal-title").html("Add Input");
                showGlobalModal();
            } else {
                toastr.error("Please select a category. ");
            }
        });

        $("#globalSaveBtn").off("click").click(function() {
            if(validateGlobalFormModal()) {
                if(!exists) {
                    var show = $("#show").is(":checked") ? 1 : 0;
                    var data = {
                        info: {
                            label              : $("#label").val(),
                            type               : $("#type").val(),
                            short_code         : $("#shortCode").val(),
                            category_id        : $("#category").val(),
                            show: show
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

        $("#label").off("blur").blur(function(data) {
            var validate = true;
            if(update) {
                if($(this).val() == selected.label) {
                    validate = false;
                }
            }
            if(validate) {
                $.ajax({
                    url: actionUrl,
                    data: { action: "validate_exists", to_validate: $("#label").val(), category_id: $("#category").val() },
                    type: "post",
                    dataType: "json",
                    success: function(data) {
                        if(data.already_exist == true) {
                            exists = true;
                            $("#label").parent().addClass('has-error');
                            globalFormModalError(true, "Label already exists!");
                        } else {
                            exists = false;
                            $("#label").parent().removeClass('has-error');
                            globalFormModalError(false);
                        }
                    }
                });
            } else {
                exists = false;
                $("#label").parent().removeClass('has-error');
                globalFormModalError(false);
            }
        });

        $("#category").off("change").change(function() {
            setupDataTables();
        });
    }

    function setupDataTables() {
        dt = $("#dt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [],
            "bDestroy": true,
            "bAutoWidth": false,
            "filter": false,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": { action: "list", category_id: $("#category").val() }
            },
            columns: [
                { data: "label", width: "40%" },
                { data: "short_code", width: "20%" },
                { data: "type", width: "15%" },
                { data: "show", width: "10%", render:
                    function(data, type, row) {
                        var textClass = data == "1" ? "text-success" : "text-danger";
                        return  "<b><span class='" + textClass + "'>" + (data == 1 ? "Yes" : "No") + "</span></b>";
                    }
                },
                { data: "date_created", width: "15%" },
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
        $("#globalFormModal").find(".modal-title").html("Update Input");
        $("#label").val(data.label);
        $("#shortCode").val(data.short_code);
        $("#type").val(data.type);
        if(data.show == "1") {
            $("#show").attr("checked", true);
        } else {
            $("#show").attr("checked", false);
        }
        showGlobalModal();
    }

</script>