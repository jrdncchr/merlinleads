
<div class="modal fade" id="globalConfirmModal" backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body" style="padding: 10px 20px 0 20px;">
                <div class="alert alert-danger modal-error"></div>
                <div id="globalConfirmModalContent">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                <a id="globalConfirmBtn" href="#" class="btn btn-sm btn-primary">OK</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="globalFormModal" backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body" style="padding: 10px 20px 0 20px;">
                <div class="alert alert-danger modal-error"></div>
                <div id="globalFormModalContent">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                <button id="globalSaveBtn" type="button" class="btn btn-sm btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="globalFormModalPost" backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body" style="padding: 10px 20px 0 20px;">
                <div class="alert alert-danger modal-error"></div>
                <div id="globalFormModalContentPost">

                </div>
            </div>
            <div class="modal-footer">
                <button id="postPostBtn" type="button" class="btn btn-sm btn-success pull-left" style="display: none;">Post</button>
                <button id="postGenerateBtn" type="button" class="btn btn-sm btn-primary" style="display: none;">Generate</button>
                <button id="postSaveBtn" type="button" class="btn btn-sm btn-primary" style="display: none;">Save</button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="globalDeleteModal" backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body" style="padding: 10px 0 0 0;">
                <p class="text-center text-warning"><b><i class="fa fa-exclamation-triangle"></i> <span id="deleteModalText">Are you sure to delete selected items?</span></b></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                <button id="globalDeleteBtn" type="button" class="btn btn-sm btn-primary">Delete</button>
                <input value="0" id="deleteConfirmed" type="hidden" />
            </div>
        </div>
    </div>
</div>
