<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <a href="<?php echo base_url() . "seo_builder" ?>">&leftarrow; Back to SEO Builder Overview</a>
            <h3><?php echo isset($sb) ? "Update" : "Create"; ?>  SEO Builder
                <?php if(isset($seo)) { ?>
                    <button type="button" id="delete_btn" class="btn btn-sm btn-danger pull-right">
                        <i class="fa fa-trash-o"></i> Delete SEO Builder</button>
                <?php } ?>
            </h3>
            <hr />
            <div style="padding: 0 10%;">
                <div id="page-form" class="form-horizontal">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="alert alert-danger" style="display: none"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-2">
                            <p class="text-primary"><b>Template</b></p>
                        </div>
                        <div class="col-xs-10">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">* Template</label>

                                        <div class="col-sm-8">
                                            <select class="form-control required" id="template">
                                                <option value="">Select Template</option>
                                                <?php foreach($templates as $t): ?>
                                                    <option value="<?php echo $t->id ?>"
                                                        <?php if(isset($seo)) { if($t->id == $seo->template_id) { ?> selected <?php } } ?>>
                                                        <?php echo $t->template_name; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">* Profile</label>

                                        <div class="col-sm-8">
                                            <select class="form-control required" id="profile">
                                                <option value="">Select Profile</option>
                                                <?php foreach($profiles as $p): ?>
                                                    <option value="<?php echo $p->id ?>"
                                                        <?php if(isset($seo)) { if($p->id == $seo->profile_id) { ?> selected <?php } } ?>>
                                                        <?php echo $p->name; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="city" class="col-sm-4 control-label">* City</label>

                                        <div class="col-sm-8">
                                            <select class="form-control required" id="city">
                                                <option value="">Select City</option>
                                                <?php foreach($cities as $c): ?>
                                                    <option value="<?php echo $c->id ?>"
                                                        <?php if(isset($seo)) { if($c->id == $seo->city_id) { ?> selected <?php } } ?>>
                                                        <?php echo $c->city_name; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="city" class="col-sm-4 control-label">* Status</label>
                                        <div class="col-sm-8">
                                            <select class="form-control required" id="status">
                                                <option value="">Select Status</option>
                                                <option value="Active-Exclusive Right" <?php if(isset($seo)) { if($seo->status == "Active-Exclusive Right") { ?> selected <?php } } ?>>Active-Exclusive Right</option>
                                                <option value="Auction" <?php if(isset($seo)) { if($seo->status == "Auction") { ?> selected <?php } } ?>>Auction</option>
                                                <option value="Contingent Offer" <?php if(isset($seo)) { if($seo->status == "Contingent Offer") { ?> selected <?php } } ?>>Contingent Offer</option>
                                                <option value="Exclusive Agency" <?php if(isset($seo)) { if($seo->status == "Exclusive Agency") { ?> selected <?php } } ?>>Exclusive Agency</option>
                                                <option value="Pending Offer" <?php if(isset($seo)) { if($seo->status == "Pending Offer") { ?> selected <?php } } ?>>Pending Offer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-xs-2">
                            <p class="text-primary"><b>Details</b></p>
                        </div>
                        <div class="col-xs-10">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="city" class="col-sm-4 control-label">Bathrooms</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="bathrooms">
                                                <option value="Any" <?php if(isset($seo)) { if($seo->bathrooms == "Any") { ?> selected <?php } } ?>>Any</option>
                                                <option value="1+" <?php if(isset($seo)) { if($seo->bathrooms == "1+") { ?> selected <?php } } ?>>1+</option>
                                                <option value="2+" <?php if(isset($seo)) { if($seo->bathrooms == "2+") { ?> selected <?php } } ?>>2+</option>
                                                <option value="3+" <?php if(isset($seo)) { if($seo->bathrooms == "3+") { ?> selected <?php } } ?>>3+</option>
                                                <option value="4+" <?php if(isset($seo)) { if($seo->bathrooms == "4+") { ?> selected <?php } } ?>>4+</option>
                                                <option value="5+" <?php if(isset($seo)) { if($seo->bathrooms == "5+") { ?> selected <?php } } ?>>5+</option>
                                                <option value="6+" <?php if(isset($seo)) { if($seo->bathrooms == "6+") { ?> selected <?php } } ?>>6+</option>
                                                <option value="7+" <?php if(isset($seo)) { if($seo->bathrooms == "7+") { ?> selected <?php } } ?>>7+</option>
                                                <option value="8+" <?php if(isset($seo)) { if($seo->bathrooms == "8+") { ?> selected <?php } } ?>>8+</option>
                                                <option value="9+" <?php if(isset($seo)) { if($seo->bathrooms == "9+") { ?> selected <?php } } ?>>9+</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="city" class="col-sm-4 control-label">Bedrooms</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="bedrooms">
                                                <option value="Any" <?php if(isset($seo)) { if($seo->bedrooms == "Any") { ?> selected <?php } } ?>>Any</option>
                                                <option value="1+" <?php if(isset($seo)) { if($seo->bedrooms == "1+") { ?> selected <?php } } ?>>1+</option>
                                                <option value="2+" <?php if(isset($seo)) { if($seo->bedrooms == "2+") { ?> selected <?php } } ?>>2+</option>
                                                <option value="3+" <?php if(isset($seo)) { if($seo->bedrooms == "3+") { ?> selected <?php } } ?>>3+</option>
                                                <option value="4+" <?php if(isset($seo)) { if($seo->bedrooms == "4+") { ?> selected <?php } } ?>>4+</option>
                                                <option value="5+" <?php if(isset($seo)) { if($seo->bedrooms == "5+") { ?> selected <?php } } ?>>5+</option>
                                                <option value="6+" <?php if(isset($seo)) { if($seo->bedrooms == "6+") { ?> selected <?php } } ?>>6+</option>
                                                <option value="7+" <?php if(isset($seo)) { if($seo->bedrooms == "7+") { ?> selected <?php } } ?>>7+</option>
                                                <option value="8+" <?php if(isset($seo)) { if($seo->bedrooms == "8+") { ?> selected <?php } } ?>>8+</option>
                                                <option value="9+" <?php if(isset($seo)) { if($seo->bedrooms == "9+") { ?> selected <?php } } ?>>9+</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="city" class="col-sm-4 control-label">Square Ft.</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" placeholder="Square Ft." id="square_ft" value="<?php if(isset($seo)) echo $seo->square_ft; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="city" class="col-sm-4 control-label">Acres</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" placeholder="Acres" id="acres"  value="<?php if(isset($seo)) echo $seo->acres; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="city" class="col-sm-4 control-label">Min Price</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" placeholder="Min Price" id="min_price"  value="<?php if(isset($seo)) echo $seo->min_price; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="city" class="col-sm-4 control-label">Max Price</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" placeholder="Max Price" id="max_price"  value="<?php if(isset($seo)) echo $seo->max_price; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-xs-2">
                            <p class="text-primary"><b>Category</b></p>
                        </div>
                        <div class="col-xs-10">

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">* Category</label>

                                        <div class="col-sm-8">
                                            <select class="form-control required" id="category">
                                                <option value="">Select Category</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Sub Category</label>

                                        <div class="col-sm-8">
                                            <select class="form-control" id="sub_category">
                                                <option value="">Select Sub Category</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div id="search_criteria_div" style="display: none;">
                        <div class="row">
                            <div class="col-xs-2">
                                <p class="text-primary"><b>Search Criteria</b></p>
                            </div>
                            <div class="col-xs-10">
                                <div id="search_criteria_inputs" class="row"></div>
                            </div>
                        </div>
                        <hr />
                    </div>

                    <div class="row">
                        <div class="col-xs-2">
                            <p class="text-primary"><b>Save & Generate</b></p>
                        </div>
                        <div class="col-xs-10">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">* Seo Builder Name</label>
                                    <div class="col-xs-9">
                                        <input type="text" id="seo_builder_name" class="form-control required" placeholder="Enter SEO Builder name"  value="<?php if(isset($seo)) echo $seo->name; ?>" />
                                        <input type="hidden" id="id" value="<?php if(isset($seo)) echo $seo->id; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="col-xs-3 control-label">&nbsp;</label>
                                    <div class="col-xs-9">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <button type="button" id="save_btn" class="btn btn-sm btn-success btn-block">Save</button>
                                            </div>
                                            <div class="col-xs-6">
                                                <button type="button" id="generate_btn" class="btn btn-sm btn-primary btn-block">Generate</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="modal fade" id="generate_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Generated IDX SEO Contents</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="page_name">Page Name</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="page_name" />
                                <a class="input-group-addon copy"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <div class="input-group input-group-sm">
                                <textarea style="height: 70px;"  class="form-control" id="meta_description"></textarea>
                                <a class="input-group-addon copy"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_tags_keywords">Meta Tags Keywords</label>
                            <div class="input-group input-group-sm">
                                <textarea style="height: 70px;"  class="form-control" id="meta_tags_keywords"></textarea>
                                <a class="input-group-addon copy"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="link_display">Link Display</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="link_display" />
                                <a class="input-group-addon copy"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="link_description">Link Description</label>
                            <div class="input-group input-group-sm">
                                <textarea style="height: 70px;"  class="form-control" id="link_description"></textarea>
                                <a class="input-group-addon copy"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sub_header_paragraph">Sub Header Paragraph</label>
                            <div class="input-group input-group-sm">
                                <textarea style="height: 100px;"  class="form-control" id="sub_header_paragraph"></textarea>
                                <a class="input-group-addon copy"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    var categories = <?php echo json_encode($categories); ?>;
    var actionUrl = "<?php echo base_url() . "seo_builder/action"; ?>";
    var searchCriteria = "";
    var categoryId = '<?php if(isset($seo)) echo $seo->category; ?>';
    var subCategory = '<?php if(isset($seo)) echo $seo->sub_category; ?>';
    var edit = false;

    $(document).ready(function() {
        var sc = '<?php if(isset($seo)) echo $seo->search_criteria; ?>';
        if(sc !== '') {
            searchCriteria = JSON.parse(sc);
        }
        setupCategories();
        activateEvents();
    });

    function activateEvents() {
        $("#save_btn").off("click").click(function() {
            save();
        });

        $("#generate_btn").off("click").click(function() {
            save(function() {
                buttonLoadStart($("#generate_btn"), "Generating...");
                $.ajax({
                    url : actionUrl,
                    data : { action: "generate", id: $("#id").val() },
                    type: "post",
                    dataType: "json",
                    success: function(data) {
                        if(data.success) {
                            $("#generate_modal").modal({
                                show: true,
                                backdrop: "static",
                                keyboard: false
                            });

                            $("#page_name").val(data.result.page_name);
                            $("#meta_description").val(data.result.meta_description);
                            $("#meta_tags_keywords").val(data.result.meta_tags_keywords);
                            $("#link_display").val(data.result.link_display);
                            $("#link_description").val(data.result.link_description);
                            $("#sub_header_paragraph").val(data.result.sub_header_paragraph);

                            loading("success", "Generating SEO builder successful!");
                            setTimeout(function() {
                                activateCopyToClipboard();
                            }, 1000);
                        } else {
                            loading("danger", data.error);
                        }
                        buttonLoadEnd($("#generate_btn"), "Generate");
                    }
                });
            });
        });

        $('#delete_btn').off("click").click(function() {
            showDeleteModal("Delete IDX SEO Builder");
        });
    }

    function deleteAction() {
        var data = {
            action: "delete",
            id: $("#id").val()
        };
        proccess({
            url: actionUrl,
            data: data,
            btn: $("#globalDeleteBtn"),
            btnLoadText: "Deleting...",
            btnText: "Delete",
            success: "Successfully Deleted.",
            modal: $('#globalDeleteModal'),
            hideModal: false,
            callback: function() {
                window.location.replace("<?php echo base_url() . "seo_builder/" ?>");
            }
        });
    }

    function gather_data(action) {
        var info = {
            action : action,

            template_id     : $("#template").val(),
            profile_id      : $("#profile").val(),
            city_id         : $("#city").val(),
            status          : $("#status").val(),

            bathrooms       : encodeURIComponent($("#bathrooms").val()),
            bedrooms        : encodeURIComponent($("#bedrooms").val()),
            square_ft       : $("#square_ft").val(),
            acres           : $("#acres").val(),
            min_price       : $("#min_price").val(),
            max_price       : $("#max_price").val(),

            category        : $("#category").val(),
            sub_category    : $("#sub_category").val(),

            name            : $("#seo_builder_name").val()
        };

        if($("#id").val() != "") {
            info.id = $("#id").val();
        }

        var search_criteria = {};
        $("#search_criteria_inputs").find("input, select").each(function() {
            search_criteria[$(this).attr("id")] = $(this).val();
        });
        info.search_criteria = search_criteria;

        return info;
    }

    function save(callback) {
        if(validatePageForm()) {
            if(callback) {
                buttonLoadStart($("#generate_btn"), "Generating...");
            } else {
                buttonLoadStart($("#save_btn"), "Saving...");
            }
            $.ajax({
                url : actionUrl,
                data : gather_data("save"),
                type: "post",
                dataType: "json",
                success: function(data) {
                    if(data.success == true) {
                        if(data.last_inserted_id) {
                            $("#id").val(data.last_inserted_id);
                        }
                        if(callback) {
                            callback();
                        } else {
                            buttonLoadEnd($("#save_btn"), "Save");
                            loading("success", "Saving successful!");
                        }
                    } else {
                        loading("danger", data.error);
                        buttonLoadEnd($("#save_btn"), "Save");
                        buttonLoadEnd($("#generate_btn"), "Generate");
                    }
                }
            });
        }
    }

    function setupCategories() {
        var categoriesHTML = "<option value=''>Select Category</option>";
        for(var i = 0; i < categories.length; i++) {
            categoriesHTML += "<option value='" + categories[i].id + "'>" + categories[i].category_name + "</option>";
        }
        $("#category").html(categoriesHTML).off("change").change(function() {
            if($("#category").val() == "") {
                $("#search_criteria_div").hide();
            } else {
                for(var i = 0; i < categories.length; i++) {
                    if($("#category").val() == categories[i].id) {
                        var subCategoriesHTML = "<option value=''>Select Sub Category</option>";
                        var subCategories = categories[i].sub_categories.split("|");
                        if(categories[i].sub_categories != "") {
                            for(var y = 0; y < subCategories.length; y++) {
                                subCategoriesHTML += "<option value='" + subCategories[y] + "'>" + subCategories[y] + "</option>";
                            }
                        }
                        $("#sub_category").html(subCategoriesHTML);
                        break;
                    }
                }
                showCategoryInputs();
            }
        });
        if(categoryId != '') {
            edit = true;
            $("#category").val(categoryId).change();
            $("#sub_category").val(subCategory);
            showCategoryInputs();
        }
    }

    function setupSearchCriteriaValues() {
        $("#search_criteria_div").find("input, select").each(function() {
            $(this).val(searchCriteria[$(this).attr("id")]);
        });
    }

    function showCategoryInputs() {
        $("#search_criteria_div").show().find("#search_criteria_inputs").html(
            '<div class="text-center" style="width: 100%;"><strong><i class="fa fa-spinner custom-loading"></i> <small>Loading search criteria fields, please wait...</small></strong></div>'
        );
        $.post(actionUrl, { action: "category_inputs", category_id: $("#category").val() }, function(data) {
            var html = "";
            for(var i = 0; i < data.length; i++) {
                html += generateInputHtml(data[i]);
            }
            $("#search_criteria_div").find("#search_criteria_inputs").html(html);
            if(edit) {
                setupSearchCriteriaValues();
            }
        }, "json");
    }


    function generateInputHtml(data) {
        var input = "";
        if(data.type == "SELECT") {
            var options = "<option value=''> Select " + data.label + "</option>";
            for(var i = 0; i < data.options.length; i++) {
                var option = data.options[i].value;
                options += "<option value='" + option + "'>" + option + "</option>";
            }
            input += "<select class='form-control' id='" + data.field_id + "'>" + options + "</select>";
        } else {
            input += "<input type='text' class='form-control' id='" + data.field_id + "' placeholder='" + data.label + "' />";
        }

        var htmlTemplate = "";
        htmlTemplate += "<div class='col-xs-6'>" +
        "<div class='form-group'>" +
        "<label class='col-sm-4 control-label'>" + data.label + "</label>" +
        "<div class='col-sm-8'>" + input +
        "</div>" +
        "</div>" +
        "</div>";

        return htmlTemplate;
    }


    function activateCopyToClipboard() {
        $("a.copy").zclip({
            path: 'http://www.steamdev.com/zclip/js/ZeroClipboard.swf',
            copy: function () {
                return $(this).closest(".form-group").find("input, textarea").val();
            }
        });
    }
</script>