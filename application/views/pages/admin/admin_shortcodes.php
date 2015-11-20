<div class='row'>
    <div class='col-xs-12'>
        <form class="form-horizontal">
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
                    <button type="button" class="btn btn-success btn-sm pull-left" data-toggle="modal" data-target="#addTemplateScModal"><i class="fa fa-plus"></i> Add Short Code</button>
                </div>
                <div class="col-xs-3 pull-right">
                    <button type="button" class="btn btn-danger btn-sm pull-right" id="deleteScBtn">Delete</button>
                    <button type="button" class="btn btn-primary btn-sm pull-right" id="updateScBtn">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
<br />
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

<script>
    $(document).ready(function() {
        $('#shortCodesSideLink').addClass('custom-nav-active');
        $('#shortCodesTopLink').addClass('custom-nav-active');
    });
</script>