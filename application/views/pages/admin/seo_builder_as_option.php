<div class="col-xs-12">
    <div class='row'>
        <div class="form-group">
            <div class="col-xs-12">
                <div id="message"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6">
                <h2 style="margin-top: 0!important;">SEO Builder - Advance Search Options</h2>
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
                            <label for="category">Select a category & input: </label>
                            <select class="form-control" id="category">
                                <option value="0" selected>Select a category</option>
                                <?php foreach($categories as $c): ?>
                                    <option value="<?php echo $c->id ?>"><?php echo $c->category_name; ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <select class="form-control" id="input" style="display: none;">
                            <option value="0">Select Field</option>
                        </select>
                    </div>
                </div>
                <table id="dt" class="dataTable" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Option</th>
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
                <label for="label">Option</label>
                <input type="text" class="form-control required" id="option" placeholder="Option">
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
    var actionUrl = "<?php echo base_url() . "admin2/seo_builder_as_option" ?>";
    var selected, selectedRows;

    $(document).ready(function() {
        $('#seoBuilderSideLink').addClass('custom-nav-active');
        $('#seoBuilderAsOptionsTopLink').addClass('custom-nav-active');
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
            if($("#category").val() != "0" && $("#input").val() != "0") {
                update = false;
                $("#globalFormModal").find(".modal-title").html("Add Option");
                showGlobalModal();
            } else {
                toastr.error("Please select a category and input. ");
            }
        });

        $("#globalSaveBtn").off("click").click(function() {
            if(validateGlobalFormModal()) {
                if(!exists) {
                    var show = $("#show").is(":checked") ? 1 : 0;
                    var data = {
                        info: {
                            input_id    : $("#input").val(),
                            value       : $("#option").val(),
                            show        : show
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

        $("#option").off("blur").blur(function() {
            var validate = true;
            if(update) {
                if($(this).val() == selected.value) {
                    validate = false;
                }
            }
            if(validate) {
                $.ajax({
                    url: actionUrl,
                    data: { action: "validate_exists", to_validate: $("#option").val(), input_id: $("#input").val() },
                    type: "post",
                    dataType: "json",
                    success: function(data) {
                        if(data.already_exist == true) {
                            exists = true;
                            $("#option").parent().addClass('has-error');
                            globalFormModalError(true, "Option already exists!");
                        } else {
                            exists = false;
                            $("#option").parent().removeClass('has-error');
                            globalFormModalError(false);
                        }
                    }
                });
            } else {
                exists = false;
                $("#option").parent().removeClass('has-error');
                globalFormModalError(false);
            }
        });

        $("#category").off("change").change(function() {
            setupInputs();
        });

        $("#input").off("change").change(function() {
            setupDataTables();
        });
    }

    function setupInputs() {
        if($("#category").val() != "0") {
            $.ajax({
                url: actionUrl,
                data: { action: "inputs", category_id: $("#category").val() },
                type: "POST",
                dataType: "json",
                success: function(data) {
                    var options = "<option value='0'>Select Input</option>";
                    for(var i = 0; i < data.length; i++) {
                        options += "<option value='" + data[i].id + "'>" + data[i].label + "</option>";
                    }
                    $("#input").html(options).show();
                }
            });
        } else {
            $("#input").hide();
        }
        setupDataTables();
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
                "data": { action: "list", input_id: $("#input").val() }
            },
            columns: [
                { data: "value", width: "60%" },
                { data: "show", width: "20%", render:
                    function(data, type, row) {
                        var textClass = data == "1" ? "text-success" : "text-danger";
                        return  "<b><span class='" + textClass + "'>" + (data == 1 ? "Yes" : "No") + "</span></b>";
                    }
                },
                { data: "date_created", width: "20%" },
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
        $("#globalFormModal").find(".modal-title").html("Update Option");
        $("#option").val(data.value);
        if(data.show == "1") {
            $("#show").attr("checked", true);
        } else {
            $("#show").attr("checked", false);
        }
        showGlobalModal();
    }

</script>