<ol class="breadcrumb">
    <li><a href="<?php echo base_url() . 'scheduler/' ?>">Scheduler</a></li>
    <li><a href="<?php echo base_url() . 'scheduler/library' ?>">Library</a></li>
    <li class="active">Form</li>
</ol>
<h4><i class="fa fa-book"></i> <?php echo isset($library) ? "Edit" : "Add" ?> Library</h4>

<hr />

<ul id="schedulerLibraryTabs" class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a id="detailsTab" href="#tab-details" role="tab" data-toggle="tab">Details</a>
    </li>
    <li id="templateTab" role="presentation" <?php echo !isset($library) ? "style='display: none;'" : "" ?>>
        <a href="#tab-templates" role="tab" data-toggle="tab">Templates</a>
    </li>
</ul>

<div id="addEditForm" class="tab-content" style="padding-top: 10px;">
    <div id="tab-details" class="tab-pane active" role="tabpanel">
        <div class="row">
            <div class="col-xs-6">
                <div class="notice"></div>
                <div class="form-group">
                    <label for="libraryName" class="control-label">* Library Name</label>
                    <input type="text" class="form-control required" id="libraryName"
                           value="<?php echo isset($library) ? $library->name : "" ?>">
                </div>
                <div class="form-group">
                    <label for="libraryDescription" class="control-label">* Description</label>
                    <textarea rows="3" class="form-control required" style="height: 90px;" id="libraryDescription"><?php echo isset($library) ? $library->description : "" ?></textarea>
                </div>
                <button class="btn btn-sm" <?php if(!isset($library)) { echo "style='display:none';"; } ?> id="deleteLibraryBtn">Delete Library</button>
                <button class="btn btn-sm pull-right btn-success" id="saveLibraryBtn">Save Library</button>
            </div>
        </div>
    </div>

    <div id="tab-templates" class="tab-pane" role="tabpanel">
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-xs-3">
                <button id="addTemplateBtn" class="btn btn-success btn-sm btn-block"><i class="fa fa-plus-circle"></i> Add Template</button>
            </div>
            <div class="col-xs-3 col-xs-offset-6">
                <button id="deleteTemplateBtn" class="btn btn-sm btn-default btn-block">Delete Template(s)</button>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="userTemplatesDt" cellpadding="0" cellspacing="0" border="0" class="display table table-striped">
                        <thead>
                        <tr>
                            <th>Headline</th>
                            <th>Body</th>
                            <th>Keywords</th>
                            <th>Date Created</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


<div id="libraryConfirmModalContent" style="display: none;">
    <p class="text-danger"><i class="fa fa-exclamation"></i> Are you sure to delete this library?</p>
</div>

<div id="templateConfirmModalContent" style="display: none;">
    <p class="text-danger"><i class="fa fa-exclamation"></i> <span></span></p>
</div>

<div id="templateModalFormContent" style="display: none;">
    <div class="form-group">
        <label for="templateHeadline" class="control-label">* Headline</label>
        <input type="text" class="form-control required" id="templateHeadline" />
    </div>
    <div class="form-group">
        <label for="templateBody" class="control-label">* Body</label>
        <textarea rows="3" class="form-control required" style="height: 90px;" id="templateBody"></textarea>
    </div>
    <div class="form-group">
        <label for="templateKeywords" class="control-label">* Keywords</label>
        <input type="text" class="form-control required" id="templateKeywords" />
    </div>
    <div class="form-group">
        <label for="templateUrl" class="control-label"> Url</label>
        <input type="text" class="form-control" id="templateUrl" placeholder="ex. http://www.merlinleads.com" />
    </div>
</div>

<script>
    var actionUrl = "<?php echo base_url(); ?>scheduler/library";
    var libraryId = <?php echo isset($library) ? $library->id : 0; ?>;
    var templateId = 0;

    $(function() {
        /*
         * Library Events
         */
        $("#saveLibraryBtn").on("click", function() {
            if(validator.validateForm($("#tab-details"))) {
                var data = {
                    action: "save",
                    name: $("#libraryName").val(),
                    description: $("#libraryDescription").val(),
                    url: $("#templateUrl").val()
                };
                if(libraryId > 0) {
                    data['id'] = libraryId;
                }
                loading("info", "Saving, please wait...");
                $.post(actionUrl, data, function(data) {
                    if(data.success == true) {
                        loading("success", "Saving library successful!");
                        if(data.id) {
                            libraryId = data.id;
                            $("#templateTab").show();
                            $("#deleteLibraryBtn").show();
                            initDt();
                        }
                    }
                }, 'json');
            }
        });

        $("#deleteLibraryBtn").on("click", function() {
            $("#globalConfirmBtn").show();
            $("#globalConfirmBtn").off("click").on("click", function() {
                loading("info", "Deleting library, please wait...");
                $.post(actionUrl, {action: "delete", library_id: libraryId}, function(data) {
                    if(data.success == true) {
                        $("#globalConfirmModalContent").html("Deleting library successful, you will be redirected.");
                        loading("success", "Deleting library successful!");
                        window.location = actionUrl;
                    } else {
                        loading("error", "Something went wrong!");
                    }
                }, 'json')
            });

            $("#globalConfirmModalContent").html($("#libraryConfirmModalContent").html());
            $("#globalConfirmModal").find(".modal-title").html("Delete Library");
            $("#globalConfirmModal").modal("show");
        });

        /*
         * Templates Events
         */
        if(libraryId > 0) {
            initDt();
        }
        $("#globalFormModalContent").html($("#templateModalFormContent").html());

        $('#addTemplateBtn').on("click", function() {
            templateId = 0;
            $("#globalFormModal").find(".modal-title").html("Add Template");
            $("#globalFormModal").modal("show");
        });

        $("#globalSaveBtn").on("click", function() {
            if(validateGlobalFormModal()) {
                var validUrl = true;
                if($('#templateUrl').val()) {
                    var regex = /\b(?:(?:https?|ftp):\/\/www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i;
                    if(!regex.test($('#templateUrl').val())) {
                        validUrl = false;
                        validator.displayInputError($("#templateUrl"), true);
                        loading('danger', "Invalid URL, make sure to add www.");
                    } else {
                        validator.displayInputError($("#templateUrl"), false);
                    }
                }
                if(validUrl) {
                    var data = {
                        action: "save",
                        headline: $("#templateHeadline").val(),
                        content: $("#templateBody").val(),
                        keywords: $("#templateKeywords").val(),
                        url: $("#templateUrl").val(),
                        library_id: libraryId
                    };

                    if(templateId > 0) {
                        data['id'] = templateId;
                    }

                    loading("info", "Saving, please wait...");
                    $.post(actionUrl + "/template", data, function(data) {
                        if(data.success == true) {
                            loading("success", "Saving template successful!");
                            $("#globalFormModal").modal("hide");
                            dt.fnReloadAjax();
                        } else {
                            loading("error", "Something went wrong!");
                        }
                    }, 'json');
                }
            }
        });

        $("#deleteTemplateBtn").on("click", function() {
            var table = $('#userTemplatesDt').DataTable();
            var selectedRows = table.rows('.selected').data();
            var modalContent = $("#templateConfirmModalContent");
            if(selectedRows.length > 0) {
                modalContent.find("span").html("Are you sure to delete selected templates(s)?");
                $("#globalConfirmBtn").show();

                // Change the event for the global confirm button
                $("#globalConfirmBtn").off("click").on("click", function() {
                    loading("info", "Deleting templates(s), please wait...");
                    var table = $('#userTemplatesDt').DataTable();
                    var selectedRows = table.rows('.selected').data();
                    var ids = [];
                    for(var i = 0; i < selectedRows.length; i++) {
                        ids.push(selectedRows[i].id);
                    }
                    $.post(actionUrl + "/template", {action: "delete", ids: ids}, function(data) {
                        if(data.success == true) {
                            $("#globalConfirmModal").modal("hide");
                            loading("success", "Deleting template(s) successful!");
                            dt.fnReloadAjax();
                        } else {
                            loading("error", "Something went wrong!");
                        }
                    }, 'json')
                });

            } else {
                modalContent.find("span").html("No selected row.");
                $("#globalConfirmBtn").hide();
            }
            $("#globalConfirmModalContent").html(modalContent.html());
            $("#globalConfirmModal").find(".modal-title").html("Delete Template(s)");
            $("#globalConfirmModal").modal("show");
        });

    });

    function initDt() {
        dt = $("#userTemplatesDt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [3],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl + "/template",
                "data": {action: "list", library_id: libraryId}
            },
            columns: [
                {data: "headline", width: "20%"},
                {data: "content", width: "40%"},
                {data: "keywords", width: "20%"},
                {data: "date_created", width: "20%"},
                {data: "url", visible: false},
                {data: "id", visible: false}
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("#userTemplatesDt").dataTable();
                $('#userTemplatesDt tbody tr').on('dblclick', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    showTemplateEditModal(data);
                });
            }
        });
    }

    function showTemplateEditModal(data) {
        templateId = data.id;
        $("#globalFormModal").find(".modal-title").html("Edit Template");
        $("#globalFormModal").modal("show");

        $("#templateHeadline").val(data.headline);
        $("#templateBody").val(data.content);
        $("#templateKeywords").val(data.keywords);
        $("#templateUrl").val(data.url);
    }
</script>