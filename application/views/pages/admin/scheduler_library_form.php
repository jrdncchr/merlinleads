<h4><i class="fa fa-book"></i> <?php echo isset($library) ? "Edit" : "Add" ?> Library</h4>

<hr />

<ul id="schedulerLibraryTabs" class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
        <a id="detailsTab" href="#tab-details" role="tab" data-toggle="tab">Details</a>
    </li>
    <li id="categoryTab" role="presentation" <?php echo !isset($library) ? "style='display: none;'" : "" ?>>
        <a href="#tab-categories" role="tab" data-toggle="tab">Categories</a>
    </li>
    <li id="templateTab" role="presentation" <?php echo !isset($library) ? "style='display: none;'" : "" ?>>
        <a href="#tab-templates" role="tab" data-toggle="tab">Templates</a>
    </li>
    <li id="snippetTab" role="presentation" <?php echo !isset($library) ? "style='display: none;'" : "" ?>>
        <a href="#tab-snippets" role="tab" data-toggle="tab">Snippets</a>
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

    <div id="tab-categories" class="tab-pane" role="tabpanel">
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-xs-3">
                <button id="addCategoryBtn" class="btn btn-success btn-sm btn-block"><i class="fa fa-plus-circle"></i> Add Category</button>
            </div>
            <div class="col-xs-3 col-xs-offset-6">
                <button id="deleteCategoryBtn" class="btn btn-sm btn-default btn-block">Delete Category</button>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="categoriesDt" cellpadding="0" cellspacing="0" border="0" class="display table table-striped">
                        <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Active</th>
                            <th>Date Created</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

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
                    <table id="templatesDt" cellpadding="0" cellspacing="0" border="0" class="display table table-striped">
                        <thead>
                        <tr>
                            <th>Category</th>
                            <th>Headline</th>
                            <th>Date Created</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div id="tab-snippets" class="tab-pane" role="tabpanel">
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-xs-3">
                <button id="addSnippetBtn" class="btn btn-success btn-sm btn-block"><i class="fa fa-plus-circle"></i> Add Snippet</button>
            </div>
            <div class="col-xs-3 col-xs-offset-6">
                <button id="deleteSnippetBtn" class="btn btn-sm btn-default btn-block">Delete Snippet(s)</button>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="snippetsDt" cellpadding="0" cellspacing="0" border="0" class="display table table-striped">
                        <thead>
                        <tr>
                            <th>Category</th>
                            <th>Snippet</th>
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

<div id="snippetConfirmModalContent" style="display: none;">
    <p class="text-danger"><i class="fa fa-exclamation"></i> Are you sure to delete this snippet?</p>
</div>

<div id="templateModalFormContent" style="display: none;">
    <div class="form-group">
        <label for="templateCategory" class="control-label">* Category</label>
        <select class="form-control required" id="templateCategory">
            <option value="">Select Category</option>
        </select>
    </div>
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
</div>


<div id="categoryModalFormContent" style="display: none;">
    <div class="form-group">
        <label for="categoryName" class="control-label">* Category Name</label>
        <input type="text" class="form-control required" id="categoryName" />
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label>
                <input type="checkbox" id="categoryActive"> Active
            </label>
        </div>
    </div>
</div>


<div id="snippetModalFormContent" style="display: none;">
    <div class="form-group">
        <label for="snippetCategoryId" class="control-label">* Category</label>
        <select class="form-control required" id="snippetCategoryId">
            <option value="">Select Category</option>
        </select>
    </div>
    <div class="form-group">
        <label for="snippetText" class="control-label">* Snippet Text</label>
        <textarea class="form-control required" id="snippetText"></textarea>
    </div>
</div>

<script>
    var actionUrl = "<?php echo base_url(); ?>admin/scheduler";
    var libraryId = <?php echo isset($library) ? $library->id : 0; ?>;
    var templateId = 0;
    var categoryId = 0;
    var snippetId = 0;
    var templatesDt, categoriesDt, snippetsDt;

    $(function() {
        $("#schedulerLibrariesTopLink").addClass("custom-nav-active");
        $("#schedulerSideLink").addClass("custom-nav-active");

        /*
         * Library Events
         */
        $("#saveLibraryBtn").on("click", function() {
            if(validator.validateForm($("#tab-details"))) {
                var data = {
                    action: "save",
                    name: $("#libraryName").val(),
                    description: $("#libraryDescription").val()
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

        $('#addTemplateBtn').on("click", function() {
            templateId = 0;
            $("#globalFormModalContent").html($("#templateModalFormContent").html());
            $("#globalFormModal").find(".modal-title").html("Add Template");
            $("#globalFormModal").modal("show");

            $.post(actionUrl + '/template', {action: 'category_option', library_id: libraryId}, function(html) {
                $('#templateCategory').append(html);
            });

            activateSaveTemplateEvent();
        });

        $("#deleteTemplateBtn").on("click", function() {
            var table = $('#templatesDt').DataTable();
            var selectedRows = table.rows('.selected').data();
            var modalContent = $("#templateConfirmModalContent");
            if(selectedRows.length > 0) {
                modalContent.find("span").html("Are you sure to delete selected templates(s)?");
                $("#globalConfirmBtn").show();

                // Change the event for the global confirm button
                $("#globalConfirmBtn").off("click").on("click", function() {
                    loading("info", "Deleting templates(s), please wait...");
                    var ids = [];
                    for(var i = 0; i < selectedRows.length; i++) {
                        ids.push(selectedRows[i].id);
                    }
                    $.post(actionUrl + "/template", {action: "delete", ids: ids}, function(data) {
                        if(data.success == true) {
                            $("#globalConfirmModal").modal("hide");
                            loading("success", "Deleting template(s) successful!");
                            templatesDt.fnReloadAjax();
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

        /*
         * Category Events
         */

        $('#addCategoryBtn').on("click", function() {
            categoryId = 0;
            $("#globalFormModalContent").html($("#categoryModalFormContent").html());
            $("#globalFormModal").find(".modal-title").html("Add Category");
            $("#globalFormModal").modal("show");

            activateSaveCategoryEvent();
        });

        $("#deleteCategoryBtn").on("click", function() {
            var table = $('#categoriesDt').DataTable();
            var selectedRows = table.rows('.selected').data();
            var modalContent = $("#templateConfirmModalContent");
            if(selectedRows.length > 0) {
                modalContent.find("span").html("Are you sure to delete selected libraries?");
                $("#globalConfirmBtn").show();

                // Change the event for the global confirm button
                $("#globalConfirmBtn").off("click").on("click", function() {
                    loading("info", "Deleting categories, please wait...");
                    var ids = [];
                    for(var i = 0; i < selectedRows.length; i++) {
                        ids.push(selectedRows[i].category_id);
                    }
                    $.post(actionUrl + "/category", {action: "delete", ids: ids}, function(data) {
                        if(data.success == true) {
                            $("#globalConfirmModal").modal("hide");
                            loading("success", "Deleting category successful!");
                            categoriesDt.fnReloadAjax();
                            templatesDt.fnReloadAjax();
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
            $("#globalConfirmModal").find(".modal-title").html("Delete Category");
            $("#globalConfirmModal").modal("show");
        });

        /*
        Snippet
         */

        $('#addSnippetBtn').on("click", function() {
            snippetId = 0;
            $("#globalFormModalContent").html($("#snippetModalFormContent").html());
            $("#globalFormModal").find(".modal-title").html("Add Snippet");
            $("#globalFormModal").modal("show");

            $.post(actionUrl + '/snippet', {action: 'category_option', library_id: libraryId}, function(html) {
                $('#snippetCategoryId').append(html);
            });

            activateSaveSnippetEvent();
        });

        $("#deleteSnippetBtn").on("click", function() {
            var table = $('#snippetsDt').DataTable();
            var selectedRows = table.rows('.selected').data();
            var modalContent = $("#snippetConfirmModalContent");
            if(selectedRows.length > 0) {
                modalContent.find("span").html("Are you sure to delete selected snippets?");
                $("#globalConfirmBtn").show();

                // Change the event for the global confirm button
                $("#globalConfirmBtn").off("click").on("click", function() {
                    loading("info", "Deleting snippets, please wait...");
                    var ids = [];
                    for(var i = 0; i < selectedRows.length; i++) {
                        ids.push(selectedRows[i].snippet_id);
                    }
                    $.post(actionUrl + "/snippet", {action: "delete", ids: ids}, function(data) {
                        if(data.success == true) {
                            $("#globalConfirmModal").modal("hide");
                            loading("success", "Deleting snippets successful!");
                            snippetsDt.fnReloadAjax();
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
            $("#globalConfirmModal").find(".modal-title").html("Delete Snippet");
            $("#globalConfirmModal").modal("show");
        });

    });

    function initDt() {
        templatesDt = $("#templatesDt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [4],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl + "/template",
                "data": {action: "list", library_id: libraryId}
            },
            columns: [
                {data: "category_name", width: "15%"},
                {data: "headline", width: "75%"},
                {data: "date_created", width: "10%"},
                {data: "content", visible: false},
                {data: "keywords", visible: false},
                {data: "category_id", visible: false},
                {data: "id", visible: false}
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("#templatesDt").dataTable();
                $('#templatesDt tbody tr').on('dblclick', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    showTemplateEditModal(data);
                });
            }
        });

        categoriesDt = $("#categoriesDt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [2],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl + "/category",
                "data": {action: "list", library_id: libraryId}
            },
            columns: [
                {data: "category_name", width: "50%"},
                {data: "active", width: "20%", render: function(data, row, options) {
                        return data == 1
                            ? "<span class='text-success'><i class='fa fa-check'></i></span>"
                            : "<span class='text-danger'><i class='fa fa-times'></i></span>";
                }
                },
                {data: "date_created", width: "30%"},
                {data: "category_id", visible: false}
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("#categoriesDt").dataTable();
                $('#categoriesDt tbody tr').on('dblclick', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    showCategoryEditModal(data);
                });
            }
        });

        snippetsDt = $("#snippetsDt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [2],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl + "/snippet",
                "data": {action: "list", library_id: libraryId}
            },
            columns: [
                {data: "category_name", width: "20%"},
                {data: "snippet_text", width: "60%"},
                {data: "date_created", width: "20%"},
                {data: "category_id", visible: false}
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("#snippetsDt").dataTable();
                $('#snippetsDt tbody tr').on('dblclick', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    showSnippetEditModal(data);
                });
            }
        });
    }

    function activateSaveCategoryEvent() {
        $("#globalSaveBtn").off('click').on("click", function() {
            if(validateGlobalFormModal()) {
                var data = {
                    action: "save",
                    category_name: $('#categoryName').val(),
                    active: $("#categoryActive").is(':checked') ? 1 : 0,
                    library_id: libraryId
                };

                if(categoryId > 0) {
                    data['category_id'] = categoryId;
                }

                loading("info", "Saving, please wait...");
                $.post(actionUrl + "/category", data, function(data) {
                    if(data.success == true) {
                        loading("success", "Saving category successful!");
                        $("#globalFormModal").modal("hide");
                        categoriesDt.fnReloadAjax();
                        templatesDt.fnReloadAjax();
                    } else {
                        loading("error", "Something went wrong!");
                    }
                }, 'json');
            }
        });
    }

    function activateSaveTemplateEvent() {
        $("#globalSaveBtn").off('click').on("click", function() {
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
                        category_id: $('#templateCategory').val(),
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
                            templatesDt.fnReloadAjax();
                        } else {
                            loading("error", "Something went wrong!");
                        }
                    }, 'json');
                }
            }
        });
    }

    function activateSaveSnippetEvent() {
        $("#globalSaveBtn").off('click').on("click", function() {
            if(validateGlobalFormModal()) {
                var data = {
                    action: "save",
                    category_id: $('#snippetCategoryId').val(),
                    snippet_text: $("#snippetText").val(),
                    library_id: libraryId
                };

                if(snippetId > 0) {
                    data['snippet_id'] = snippetId;
                }

                loading("info", "Saving snippet, please wait...");
                $.post(actionUrl + "/snippet", data, function(data) {
                    if(data.success == true) {
                        loading("success", "Saving snippet successful!");
                        $("#globalFormModal").modal("hide");
                        snippetsDt.fnReloadAjax();
                    } else {
                        loading("error", "Something went wrong!");
                    }
                }, 'json');
            }
        });
    }

    function showTemplateEditModal(data) {
        templateId = data.id;
        $("#globalFormModalContent").html($("#templateModalFormContent").html());
        $("#globalFormModal").find(".modal-title").html("Edit Template");
        $("#globalFormModal").modal("show");

        $.post(actionUrl + '/template', {action: 'category_option', library_id: libraryId}, function(html) {
            $('#templateCategory').append(html);
            $("#templateCategory").val(data.category_id);
        });

        $("#templateHeadline").val(data.headline);
        $("#templateBody").val(data.content);
        $("#templateKeywords").val(data.keywords);

        activateSaveTemplateEvent();
    }

    function showCategoryEditModal(data) {
        categoryId = data.category_id;
        $("#globalFormModalContent").html($("#categoryModalFormContent").html());
        $("#globalFormModal").find(".modal-title").html("Edit Template");

        $("#globalFormModal").modal("show");

        $("#categoryName").val(data.category_name);
        if(data.active == 1) {
            $('#categoryActive').attr('checked', 'checked');
        }
        activateSaveCategoryEvent();
    }

    function showSnippetEditModal(data) {
        snippetId = data.snippet_id;
        $("#globalFormModalContent").html($("#snippetModalFormContent").html());
        $("#globalFormModal").find(".modal-title").html("Edit Snippet");
        $("#globalFormModal").modal("show");

        $.post(actionUrl + '/snippet', {action: 'category_option', library_id: libraryId}, function(html) {
            $('#snippetCategoryId').append(html);
            $("#snippetCategoryId").val(data.category_id);
        });

        $('#snippetText').val(data.snippet_text);
        activateSaveSnippetEvent();
    }


</script>