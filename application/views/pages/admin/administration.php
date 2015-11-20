<div class='row'>
    <div id="addProperty" class='col-xs-9'>
        <a href="<?php echo base_url() . 'main' ?>">&Leftarrow; Return to Main</a>
        <p class="lead"><strong>Administration</strong>
            <img src="<?php echo base_url() . IMG . 'ajax-loader-3.GIF'; ?>" class="img-responsive pull-right" style="display: none;" id="loader">
        </p>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="propertyTabs">
            <li class="active"><a href="#templatesFull" data-toggle="tab">Templates [Full]</a></li>
            <li><a href="#templateSc" data-toggle="tab">Templates [SC]</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Templates -->
            <div class="tab-pane fade in active" id="templatesFull">
                <form class="form-horizontal col-xs-12">
                    <h4>Templates [Full]
                        <button type="button" class="btn btn-success btn-xs pull-right" id="addTemplateBtn"><i class="fa fa-plus"></i> Add Template</button>
                    </h4>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <?php
                            if (isset($_SESSION['admin_message'])) {
                                ?>
                                <div id="templatesFullMessage" class="alert alert-success"><i class='fa fa-check'></i> <?php echo $_SESSION['admin_message'] ?></div>
                                <?php unset($_SESSION['admin_message']); ?>
                            <?php } else { ?>
                                <div id="templatesFullMessage"></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-xs-1 control-label">Category</label>
                        <div class="col-xs-3">
                            <select class="form-control" id="tfCategory">
                                <option value="Properties">Properties</option>
                            </select>
                        </div>
                        <label for="type" class="col-xs-1 control-label">Module</label>
                        <div class="col-xs-3">
                            <select class="form-control" id="tfModule">
                                <?php echo $modules; ?>
                            </select>
                        </div>
                        <label for="type" class="col-xs-1 control-label">Template No.</label>
                        <div class="col-xs-3">
                            <select class="form-control" id="tfTemplateNo">
                                <?php echo $template_count; ?>
                            </select>
                        </div>
                    </div>
                    <div id="typeDiv" class="form-group" style="display: none;">
                        <div class="col-xs-4"></div>
                        <label for="type" class="col-xs-1 control-label">Type</label>
                        <div class="col-xs-3">
                            <select class="form-control" id="tfType">
                                <option value="Regular">Regular</option>
                                <option value="Video">Video</option>
                            </select>
                        </div>
                        <div class="col-xs-4"></div>
                    </div>
                    <hr />

                    <!-- Div for Youtube -->
                    <div id="youtubeFullDiv" class="fullDiv">
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Title
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Template Title"></i>
                            </label>
                            <div class="col-xs-8">
                                <input type="text" id="tfTitle" class="form-control required" value="<?php echo $template->title; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Description
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Template Description"></i>
                            </label>
                            <div class="col-xs-8">
                                <textarea id="tfDescription" class="form-control required" style="height: 150px;"><?php echo $template->description; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Keyword
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Template Keyword"></i>
                            </label>
                            <div class="col-xs-8">
                                <textarea id="tfKeyword" class="form-control required"><?php echo $template->keyword; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Div for Craiglist -->
                    <div id="craiglistFullDiv" class="fullDiv" style="display: none;">
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Title
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Template Title"></i>
                            </label>
                            <div class="col-xs-8">
                                <input type="text" id="clPostingTitle" class="form-control required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Specific Location
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Specific Location"></i>
                            </label>
                            <div class="col-xs-8">
                                <input type="text" id="clSpecificLocation" class="form-control required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Description
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Template Description"></i>
                            </label>
                            <div class="col-xs-8">
                                <textarea id="clPostingBody" class="form-control required" style="height: 150px;"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Div for Ebay -->
                    <div id="ebayFullDiv" class="fullDiv" style="display: none;">
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Title
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Template Title"></i>
                            </label>
                            <div class="col-xs-8">
                                <input type="text" id="ebayTitle" class="form-control required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Description
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Template Description"></i>
                            </label>
                            <div class="col-xs-8">
                                <textarea id="ebayDescription" class="form-control required" style="height: 150px;"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Div for Backpage -->
                    <div id="bpFullDiv" class="fullDiv" style="display: none;">
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Specific Location
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Specific Location"></i>
                            </label>
                            <div class="col-xs-8">
                                <input type="text" id="bpSpecificLocation" class="form-control required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Title
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Template Title"></i>
                            </label>
                            <div class="col-xs-8">
                                <input type="text" id="bpTitle" class="form-control required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Description
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Template Description"></i>
                            </label>
                            <div class="col-xs-8">
                                <textarea id="bpDescription" class="form-control required" style="height: 150px;"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom div for save and delete -->
                    <div class="form-group">
                        <label class="col-xs-3"></label>
                        <div class="col-xs-8">
                            <button id="tfDeleteBtn" type="button" class="btn btn-danger btn-xs" ><i class="fa fa-trash-o"></i> Delete Template</button>
                            <button id="tfSaveBtn" type="button" class="btn btn-primary btn-xs pull-right"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Template  Short codes -->
            <div class="tab-pane fade" id="templateSc">
                <form class="form-horizontal col-xs-12">
                    <h4>Templates [SC]</h4>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div id="templatesScMessage"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-xs-1 control-label">Category</label>
                        <div class="col-xs-3">
                            <select class="form-control" id="tscCategory">
                                <option value="Properties">Properties</option>
                            </select>
                        </div>
                        <label for="type" class="col-xs-1 control-label">Module</label>
                        <div class="col-xs-3">
                            <select class="form-control" id="tscModule">
                                <?php echo $modules; ?>
                            </select>
                        </div>
                        <label for="type" class="col-xs-1 control-label">Type</label>
                        <div class="col-xs-3">
                            <select class="form-control" id="tscType">
                                <?php echo $template_sc_types; ?>
                            </select>
                        </div>
                    </div>
                    <hr />
                    <div class="form-group col-xs-12">
                        <p class="text-primary"><i class="fa fa-info"></i> Select a module and type first.</p>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-4">
                            <select id="tscShortcode" class="form-control" disabled="disabled"></select>
                        </div>
                        <div class="col-xs-8">
                            <textarea id="tscShortcodeVal" class="form-control" readonly="true" style="height: 100px;"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-2">
                            <button type="button" class="btn btn-success btn-xs pull-left" data-toggle="modal" data-target="#addTemplateScModal"><i class="fa fa-plus"></i> Add Short Code</button>
                        </div>
                        <div class="col-xs-3 pull-right">
                            <button type="button" class="btn btn-danger btn-xs pull-right" id="deleteScBtn"><i class="fa fa-trash-o"></i> Delete</button>
                            <button type="button" class="btn btn-primary btn-xs pull-right" id="updateScBtn"><i class="fa fa-save"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<br />

<!-- Add Template Full Modal -->
<div class="modal fade" id="addTemplateFullModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add Template [Full]</h4>
            </div>
            <div id="addTemplateFull" class="modal-body">
                <div class="row">
                    <form class="form-horizontal col-xs-11">
                        <!-- Youtube ADD Div -->
                        <div id="youtubeAddDiv" class="addDiv">
                            <div id="youtubeAddDivMessage"></div>
                            <div class="form-group">
                                <label for="type" class="col-xs-3 control-label">Template No.</label>
                                <div class="col-xs-9">
                                    <input type="text" id="addTfTemplateNo" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-xs-3 control-label">Title</label>
                                <div class="col-xs-9">
                                    <input type="text" id="addTfTitle" class="form-control required" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-xs-3 control-label">Description</label>
                                <div class="col-xs-9">
                                    <textarea id="addTfDescription" class="form-control required" style="height: 150px;"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-xs-3 control-label">Keyword</label>
                                <div class="col-xs-9">
                                    <textarea id="addTfKeyword" class="form-control required"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Craiglist ADD Div -->
                        <div id="craiglistAddDiv" class="addDiv" style="display:none;">
                            <div id="craiglistAddDivMessage"></div>
                            <div class="form-group">
                                <label for="type" class="col-xs-3 control-label">Template No.</label>
                                <div class="col-xs-9">
                                    <input type="text" id="addClTemplateNo" class="form-control" readonly="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-xs-3 control-label">Posting Title</label>
                                <div class="col-xs-9">
                                    <input type="text" id="addClPostingTitle" class="form-control required" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-xs-3 control-label">Specific Location</label>
                                <div class="col-xs-9">
                                    <input type="text" id="addClSpecificLocation" class="form-control required" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-xs-3 control-label">Posting Body</label>
                                <div class="col-xs-9">
                                    <textarea id="addClPostingBody" class="form-control required" style="height: 150px;"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Ebay ADD Div -->
                        <div id="ebayAddDiv" class="addDiv" style="display:none;">
                            <div id="ebayAddDivMessage"></div>
                            <div class="form-group">
                                <label for="type" class="col-xs-3 control-label">Template No.</label>
                                <div class="col-xs-9">
                                    <input type="text" id="addEbayTemplateNo" class="form-control" readonly="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-xs-3 control-label">Title</label>
                                <div class="col-xs-9">
                                    <input type="text" id="addEbayTitle" class="form-control required" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-xs-3 control-label">Description</label>
                                <div class="col-xs-9">
                                    <textarea id="addEbayDescription" class="form-control required" style="height: 150px;"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Backpage ADD Div -->
                        <div id="bpAddDiv" class="addDiv" style="display:none;">
                            <div id="bpAddDivMessage"></div>
                            <div class="form-group">
                                <label for="type" class="col-xs-3 control-label">Template No.</label>
                                <div class="col-xs-9">
                                    <input type="text" id="addBpTemplateNo" class="form-control" readonly="true" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-xs-3 control-label">Specific Location</label>
                                <div class="col-xs-9">
                                    <input type="text" id="addBpSpecificLocation" class="form-control required" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-xs-3 control-label">Title</label>
                                <div class="col-xs-9">
                                    <input type="text" id="addBpTitle" class="form-control required" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-xs-3 control-label">Description</label>
                                <div class="col-xs-9">
                                    <textarea id="addBpDescription" class="form-control required" style="height: 150px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="tfAddBtn">Add Template</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Template Shortcode Modal -->
<div class="modal fade" id="addTemplateScModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add Template [SC]</h4>
            </div>
            <div id="addSc" class="modal-body">
                <div class="row">
                    <div id="addScMessage"></div>
                    <form class="form-horizontal col-xs-11">
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Short code</label>
                            <div class="col-xs-9">
                                <input type="text" id="addScShortcode" class="form-control required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Content</label>
                            <div class="col-xs-9">
                                <textarea id="addScContent" class="form-control required"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="addScBtn">Add Shortcode</button>
            </div>
        </div>
    </div>
</div>