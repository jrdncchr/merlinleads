<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <button class="btn btn-success btn-sm" id="add-btn"><i class="fa fa-plus-circle"></i> Add Content</button>
        <div class="table-responsive" style="margin-top: 10px;">
            <table id="schedulerContentDt" cellpadding="0" cellspacing="0" border="0" class="display table table-striped">
                <thead>
                <tr>
                    <th>Library</th>
                    <th>Content</th>
                    <th>Url</th>
                    <th>Date Created</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
</div>

<div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="form-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="form-modal-label">Add Content</h4>
            </div>
            <div class="modal-body">
                <div class="notice"></div>
                <div class="form-group">
                    <label for="content-library">* Library</label>
                    <select id="content-library" class="form-control required">
                        <?php foreach($library as $l): ?>
                            <option value="<?php echo $l->library_id; ?>"><?php echo $l->library_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="content-body">* Content</label>
                    <textarea class="form-control required" id="content-body" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label for="content-url">Url</label>
                    <input type="text" class="form-control url" id="content-url" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm pull-left" id="delete-btn">Delete</button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="save-btn">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    var actionUrl = "<?php echo base_url() . "admin/scheduler_content_action" ?>";
    var dt, selected, selectedRows;

    $(document).ready(function() {
        $("#schedulerContentsTopLink").addClass("custom-nav-active");
        $("#schedulerSideLink").addClass("custom-nav-active");

        initDt();

        $('#add-btn').on('click', function() {
            $('#delete-btn').hide();
            selectedId = 0;
            var modal = $('#form-modal');
            modal.find('.modal-title').html('Add Content');
            modal.modal({
                show: true,
                keyboard: false,
                backdrop: 'static'
            });
        });

        $('#save-btn').on('click', function() {
            if(validator.validateForm($('#form-modal'))) {
                var data = {
                    action: 'save',
                    content: {
                        library_id: $('#content-library').val(),
                        content_body: $('#content-body').val(),
                        content_url: $('#content-url').val()
                    }
                };
                if(selectedId > 0) {
                    data.content.content_id = selectedId;
                }
                loading('info', 'Saving content...');
                $.post(actionUrl, data, function(res) {
                    if(res.success) {
                        $('#form-modal').modal('hide');
                        loading('success', 'Saving content successful!');
                        dt.fnReloadAjax();
                    }
                }, 'json');
            }

        });

        $('#delete-btn').on('click', function() {
            var ok = confirm("Are you sure to delete this content?");
            if(ok) {
                loading('info', 'Deleting content...');
                $.post(actionUrl, {action: 'delete', content_id: selectedId}, function(res) {
                    if(res.success) {
                        $('#form-modal').modal('hide');
                        loading('success', 'Deleting content successful!');
                        dt.fnReloadAjax();
                    }
                }, 'json');
            }
        });

    });

    function initDt() {
        dt = $("#schedulerContentDt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [3],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": {action: "list"}
            },
            columns: [
                {data: "library_name", width: "20%"},
                {data: "content_body", width: "40%"},
                {data: "content_url", width: "20%"},
                {data: "date_created", width: "20%"},
                {data: "content_id", visible: false},
                {data: "library_id", visible: false}
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("#schedulerContentDt").dataTable();
                $('#schedulerContentDt tbody tr').on('dblclick', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    showEdit(data);
                });
            }
        });
    }

    function showEdit(data) {
        selectedId = data.content_id;
        var modal = $('#form-modal');
        modal.modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });
        modal.find('.modal-title').html('Edit Content');
        $('#delete-btn').show();
        $('#content-library').val(data.library_id);
        $('#content-body').val(data.content_body);
        $('#content-url').val(data.content_url);
    }
</script>