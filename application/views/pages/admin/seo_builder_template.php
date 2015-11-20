<div class="col-xs-12">
    <div class='row'>
        <div class="form-group">
            <div class="col-xs-12">
                <div id="message"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-6">
                <h2 style="margin-top: 0!important;">SEO Builder - Templates</h2>
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
                        <th>Name</th>
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
        <div class="col-xs-6">
            <div class="form-group">
                <label for="templateName">Template Name</label>
                <input type="text" class="form-control required" id="templateName" placeholder="Template Name">
            </div>
        </div>
        <div class="col-xs-6">
            <label for="status">&nbsp;</label>
            <div class="checkbox">
                <label style="display: inline !important;">
                    <input type="checkbox" id="status" style="margin-top: 1px !important;"/>
                    Check to activate this template.
                </label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="state">Page Name</label>
                <textarea class="form-control required" id="pageName" placeholder="Page Name" rows="3" style="resize: none;"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="state">Meta Description</label>
                <textarea class="form-control required" id="metaDescription" placeholder="Meta Description" rows="3" style="resize: none;"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="state">Meta Tags Keywords</label>
                <textarea class="form-control required" id="metaTagsKeywords" placeholder="Meta Tags Keywords" rows="3" style="resize: none;"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="state">Link Display</label>
                <textarea class="form-control required" id="linkDisplay" placeholder="Link Display" rows="3" style="resize: none;"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="state">Link Description</label>
                <textarea class="form-control required" id="linkDescription" placeholder="Link Description" rows="3" style="resize: none;"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label for="state">Sub Header Paragraph</label>
                <textarea class="form-control required" id="subHeaderParagraph" placeholder="Sub Header Paragraph" rows="3" style="resize: none;"></textarea>
            </div>
        </div>
    </div>
</div>

<script>
    var dt;
    var update = false, templateExists = false;
    var actionUrl = "<?php echo base_url() . "admin2/seo_builder_template" ?>";
    var selectedId, selectedRows, selectedTemplateName;

    $(document).ready(function() {
        $('#seoBuilderSideLink').addClass('custom-nav-active');
        $('#seoBuilderTemplateTopLink').addClass('custom-nav-active');
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
            update = false;
            $("#globalFormModal").find(".modal-title").html("Add Template");
            showGlobalModal();
        });

        $("#globalSaveBtn").off("click").click(function() {
            if(validateGlobalFormModal()) {
                if(!templateExists) {
                    var status = $("#status").is(":checked") ? "Active" : "Inactive";
                    var data = {
                        info: {
                            template_name               : $("#templateName").val(),
                            page_name                   : $("#pageName").val(),
                            meta_description            : $("#metaDescription").val(),
                            meta_tags_keywords          : $("#metaTagsKeywords").val(),
                            link_display                : $("#linkDisplay").val(),
                            link_description            : $("#linkDescription").val(),
                            sub_header_paragraph        : $("#subHeaderParagraph").val(),
                            status: status
                        },
                        action: "add"
                    };
                    if(update) {
                        data.id = selectedId;
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

        $("#pageName").off("blur").blur(function(data) {
            if($(this).val() !== selectedTemplateName) {
                $.ajax({
                    url: actionUrl,
                    data: { action: "template_validate", template_name: $("#templateName").val() },
                    type: "post",
                    dataType: "json",
                    success: function(data) {
                        if(data.already_exist == true) {
                            templateExists = true;
                            $("#templateName").parent().addClass('has-error');
                            globalFormModalError(true, "Template name already exists!");
                        } else {
                            templateExists = false;
                            $("#templateName").parent().removeClass('has-error');
                            globalFormModalError(false);
                        }
                    }
                });
            }
        });
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
                { data: "template_name", width: "50%" },
                { data: "status", width: "25%", render:
                    function(data, type, row) {
                        var textClass = data == "Active" ? "text-success" : "text-danger";
                        return  "<b><span class='" + textClass + "'>" + data + "</span></b>";
                    }
                },
                { data: "date_created", width: "25%" },
                { data: "id", visible: false },
                { data: "page_name", visible: false},
                { data: "meta_description", visible: false },
                { data: "meta_tags_keywords", visible: false },
                { data: "link_display", visible: false },
                { data: "link_description", visible: false },
                { data: "sub_header_paragraph", visible: false }
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
        selectedId = data.id;
        selectedTemplateName = data.template_name;
        $("#globalFormModal").find(".modal-title").html("Update Template");
        $("#templateName").val(data.template_name);
        if(data.status == "Active") {
            $("#status").attr("checked", true);
        } else {
            $("#status").attr("checked", false);
        }
        $("#pageName").val(data.page_name);
        $("#metaDescription").val(data.meta_description);
        $("#metaTagsKeywords").val(data.meta_tags_keywords);
        $("#linkDisplay").val(data.link_display);
        $("#linkDescription").val(data.link_description);
        $("#subHeaderParagraph").val(data.sub_header_paragraph);
        showGlobalModal();
    }

</script>