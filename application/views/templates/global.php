<div class="modal fade" id="globalAlertModal" backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body text-primary" style="padding: 10px 20px 0 20px;"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

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


<!-- Cropper Modal -->
<div class="modal fade" id="cropperModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Crop Image</h4>
            </div>
            <div class="modal-body">
                <div class="imgcropper-container">
                    <img id="cropperImage" style="max-width: 100%; max-height: 400px;" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="cropperDone">Done</button>
            </div>
        </div>
    </div>
</div>

<!-- Event Notification Modal -->
<div class="modal fade" id="event_notification_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-bell"></i> Event Notification</h4>
            </div>
            <div class="modal-body">
                <p>
                    <span style="font-weight: bold;"></span><br />
                    We have detected that your event notification for this event is turned on.
                </p>
                <p>Would you like post the content notification?</p>
                <a href="#" style="font-size: 14px;">&RightArrow; View Event Notification Settings</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-sm" id="event_notification_yes">Yes</button>
                <button type="button" class="btn btn-default btn-sm" id="event_notification_no">No</button>
            </div>
        </div>
    </div>
</div>
