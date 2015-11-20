<div class='row'>
    <div class='col-xs-12'>
        <div class="form-group">
            <div class="col-xs-12">
                <div id="hsCtaMessage"></div>
            </div>
        </div>
        <div class="col-xs-4">
            <label><strong>Module</strong></label>
            <select class="form-control" id="module">
                <option value="Classified Ads">Classified Ads</option>
            </select>
            <label><strong>Type</strong></label>
            <select class="form-control" id="type">
                <option value="Headline Statement" class="cta-option">Headline Statements</option>
                <option value="Call to Action" class="hs-option">Call to Actions</option>
                <option value="Video Term" class="hs-option">Video Term</option>
                <option value="Video Call to Action" class="hs-option">Video Call to Actions</option>
            </select>
        </div>
        <div class="col-xs-8">
            <label><strong>List</strong></label>
            <select class="form-control" size="15" id="list">
                <?php echo $default; ?>
            </select>
            <br />
            <button id="showAddBtn" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add</button>
            <button id="deleteBtn" class="btn btn-danger btn-sm  pull-right"><i class="fa fa-trash-o"></i> Delete</button>
            <button id="showEditBtn" class="btn btn-primary btn-sm pull-right"><i class="fa fa-edit"></i> Edit</button>
        </div>

    </div>
</div>

<div class="modal fade" id="hsCtaModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modalTitle">Add</h4>
            </div>
            <div class="modal-body">
                <label>Text: </label> <input type="text" class="form-control" id="modalData" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" id="editBtn" style="display: none;">Edit</button>
                <button type="button" class="btn btn-sm btn-success" id="addBtn">Add</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#templatesSideLink').addClass('custom-nav-active');
        $('#hsCtaTopLink').addClass('custom-nav-active');
    });
</script>