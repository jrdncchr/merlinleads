<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <button class="btn btn-success btn-sm" id="add-btn"><i class="fa fa-plus-circle"></i> Add Post</button>
        <div class="table-responsive" style="margin-top: 10px;">
            <table id="scheduler-post-dt" cellpadding="0" cellspacing="0" border="0" class="display table table-striped no-multiple">
                <thead>
                <tr>
                    <th>Category</th>
                    <th>Post Name</th>
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
                    <label for="post-name">* Post Name</label>
                    <input type="text" class="form-control required" id="post-name" />
                </div>
                <div class="form-group">
                    <label for="post-facebook-snippet">* Facebook Snippet</label>
                    <textarea class="form-control required" id="post-facebook-snippet" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="post-body">* Twitter Snippet</label>
                    <textarea class="form-control required" id="post-twitter-snippet" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="post-linkedin-snippet">* LinkedIn Snippet</label>
                    <textarea class="form-control required" id="post-linkedin-snippet" rows="2"></textarea>
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
    var actionUrl = "<?php echo base_url() . "admin/scheduler_post_action" ?>";
    var dt, selected, selectedRows;

    $(document).ready(function() {
        $("#schedulerPostsTopLink").addClass("custom-nav-active");
        $("#schedulerSideLink").addClass("custom-nav-active");

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
                        post_facebook_snippet: $('#post-facebook-snippet').val(),
                        post_twitter_snippet: $('#post-twitter-snippet').val(),
                        post_linkedin_snippet: $('#post-linkedin-snippet').val(),
                        post_name: $('#post-name').val()
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
        dt = $("#scheduler-post-dt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [5],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": {action: "list"}
            },
            columns: [
                {data: "category_name", width: "30%"},
                {data: "post_name", width: "50%"},
                {data: "post_date_created", width: "20%"},
                {data: "post_twitter_snippet", visible: false},
                {data: "post_twitter_snippet", visible: false},
                {data: "post_linkedin_snippet", visible: false},
                {data: "post_id", visible: false},
                {data: "post_category_id", visible: false}
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("#scheduler-post-dt").dataTable();
                $('#scheduler-post-dt tbody tr').on('click', function () {
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
        $('#post-facebook-snippet').val(data.post_facebook_snippet);
        $('#post-twitter-snippet').val(data.post_twitter_snippet);
        $('#post-linkedin-snippet').val(data.post_linkedin_snippet);
        $('#post-name').val(data.post_name);
    }
</script>