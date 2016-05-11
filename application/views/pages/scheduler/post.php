<h4 style="text-align: center; font-weight: bold; margin-bottom: 15px;"><i class="fa fa-file-text-o"></i> Contents</h4>

<div class="row">
    <div class="col-sm-12">
        <button id="add-btn" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Add Post</button>
        <button disabled class="btn btn-default btn-sm pull-right">Post</button>
        <a href="<?php echo base_url() . 'scheduler/category'; ?>" class="btn btn-default btn-sm pull-right" style="margin-right: 10px;">Categories</a>
        <a href="<?php echo base_url() . 'scheduler/queue'; ?>" class="btn btn-default btn-sm pull-right" style="margin-right: 10px;">Queues</a>
        <a href="<?php echo base_url() . 'scheduler'; ?>" class="btn btn-default btn-sm pull-right" style="margin-right: 10px;">Scheduler</a>
    </div>
</div>

<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <div class="table-responsive">
            <table id="schedulerContentDt" cellpadding="0" cellspacing="0" border="0" class="display table table-striped">
                <thead>
                <tr>
                    <th>Category</th>
                    <th>Post</th>
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
                <h4 class="modal-title" id="form-modal-label">Add Post</h4>
            </div>
            <div class="modal-body">
                <div class="notice"></div>
                <div class="form-group">
                    <label for="post-category">* Category</label>
                    <select id="post-category" class="form-control required">
                        <?php foreach($category as $c): ?>
                            <option value="<?php echo $c->category_id; ?>"><?php echo $c->category_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="post-body">* Post</label>
                    <textarea class="form-control required" id="post-body" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label for="post-url">Url</label>
                    <input type="text" class="form-control url" id="post-url" />
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
    var actionUrl = "<?php echo base_url() . "scheduler/post_action" ?>";
    var dt, selected, selectedRows;

    $(document).ready(function() {
        initDt();

        $('#add-btn').on('click', function() {
            $('#delete-btn').hide();
            selectedId = 0;
            var modal = $('#form-modal');
            modal.find('.modal-title').html('Add Post');
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
                    post: {
                        post_category_id: $('#post-category').val(),
                        post_body: $('#post-body').val(),
                        post_url: $('#post-url').val()
                    }
                };
                if(selectedId > 0) {
                    data.post.post_id = selectedId;
                }
                loading('info', 'Saving post...');
                $.post(actionUrl, data, function(res) {
                    if(res.success) {
                        $('#form-modal').modal('hide');
                        loading('success', 'Saving post successful!');
                        dt.fnReloadAjax();
                    }
                }, 'json');
            }

        });

        $('#delete-btn').on('click', function() {
            var ok = confirm("Are you sure to delete this post?");
            if(ok) {
                loading('info', 'Deleting post...');
                $.post(actionUrl, {action: 'delete', post_id: selectedId}, function(res) {
                    if(res.success) {
                        $('#form-modal').modal('hide');
                        loading('success', 'Deleting post successful!');
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
                {data: "category_name", width: "20%"},
                {data: "post_body", width: "40%"},
                {data: "post_url", width: "20%"},
                {data: "post_date_created", width: "20%"},
                {data: "post_id", visible: false},
                {data: "post_category_id", visible: false}
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
        selectedId = data.post_id;
        var modal = $('#form-modal');
        modal.modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });
        modal.find('.modal-title').html('Edit Post');
        $('#delete-btn').show();
        $('#post-category').val(data.post_category_id);
        $('#post-body').val(data.post_body);
        $('#post-url').val(data.post_url);
    }
</script>