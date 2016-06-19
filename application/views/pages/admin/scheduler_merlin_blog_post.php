<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <button class="btn btn-success btn-sm" id="add-btn"><i class="fa fa-plus-circle"></i> Add Blog Post Template</button>
        <div class="table-responsive" style="margin-top: 10px;">
            <table id="scheduler-post-dt" cellpadding="0" cellspacing="0" border="0" class="display table table-striped">
                <thead>
                <tr>
                    <th>Category</th>
                    <th>Topic</th>
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
                <h4 class="modal-title" id="form-modal-label">Add Blog Post</h4>
            </div>
            <div class="modal-body">
                <div class="notice"></div>
                <div class="form-group">
                    <label for="bp-category">* Category</label>
                    <select id="bp-category" class="form-control required">
                        <?php foreach($category as $c): ?>
                            <option value="<?php echo $c->category_id; ?>"><?php echo $c->category_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bp-topic">* Topic</label>
                    <input type="text" class="form-control required" id="bp-topic" />
                </div>
                <div class="form-group">
                    <label for="bp-headline">* Headline</label>
                    <textarea class="form-control required" id="bp-headline" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="bp-body">* Body</label>
                    <textarea class="form-control required" id="bp-body" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label for="bp-keywords">* Keywords</label>
                    <textarea class="form-control required" id="bp-keywords" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="bp-facebook-snippet">* Facebook Snippet</label>
                    <textarea class="form-control required" id="bp-facebook-snippet" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="bp-twitter-snippet">* Twitter Snippet</label>
                    <textarea class="form-control required" id="bp-twitter-snippet" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="bp-linkedin-snippet">* LinkedIn Snippet</label>
                    <textarea class="form-control required" id="bp-linkedin-snippet" rows="2"></textarea>
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
    var actionUrl = "<?php echo base_url() . "admin/scheduler_blog_post_action" ?>";
    var dt, selectedId, selectedRows;

    $(document).ready(function() {
        $("#schedulerBlogPostTemplateTopLink").addClass("custom-nav-active");
        $("#schedulerSideLink").addClass("custom-nav-active");

        initDt();

        $('#add-btn').on('click', function() {
            $('#delete-btn').hide();
            selectedId = 0;
            var modal = $('#form-modal');
            modal.find('.modal-title').html('Add Blog Post Template');
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
                        bp_category: $('#bp-category').val(),
                        bp_topic: $('#bp-topic').val(),
                        bp_headline: $('#bp-headline').val(),
                        bp_body: $('#bp-body').val(),
                        bp_keywords: $('#bp-keywords').val(),
                        bp_facebook_snippet: $('#bp-facebook-snippet').val(),
                        bp_twitter_snippet: $('#bp-twitter-snippet').val(),
                        bp_linkedin_snippet: $('#bp-linkedin-snippet').val()
                    }
                };
                if(selectedId > 0) {
                    data.post.bp_id = selectedId;
                }
                loading('info', 'Saving blog post template...');
                $.post(actionUrl, data, function(res) {
                    if(res.success) {
                        $('#form-modal').modal('hide');
                        loading('success', 'Saving blog post template successful!');
                        dt.fnReloadAjax();
                    }
                }, 'json');
            }

        });

        $('#delete-btn').on('click', function() {
            var ok = confirm("Are you sure to delete this blog post template?");
            if(ok) {
                loading('info', 'Deleting blog post template...');
                $.post(actionUrl, {action: 'delete', bp_id: selectedId}, function(res) {
                    if(res.success) {
                        $('#form-modal').modal('hide');
                        loading('success', 'Deleting blog post template successful!');
                        dt.fnReloadAjax();
                    }
                }, 'json');
            }
        });

    });

    function initDt() {
        dt = $("#scheduler-post-dt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [1],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": {action: "list"}
            },
            columns: [
                {data: "category_name", width: "30%"},
                {data: "bp_topic", width: "50%"},
                {data: "bp_date_created", width: "20%"},
                {data: "bp_category", visible: false},
                {data: "bp_headline", visible: false},
                {data: "bp_id", visible: false},
                {data: "bp_body", visible: false},
                {data: "bp_keywords", visible: false},
                {data: "bp_facebook_snippet", visible: false},
                {data: "bp_twitter_snippet", visible: false},
                {data: "bp_linkedin_snippet", visible: false}
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("#scheduler-post-dt").dataTable();
                $('#scheduler-post-dt tbody tr').on('dblclick', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    showEdit(data);
                });
            }
        });
    }

    function showEdit(data) {
        selectedId = data.bp_id;
        var modal = $('#form-modal');
        modal.modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });
        modal.find('.modal-title').html('Edit Blog Post Template');
        $('#delete-btn').show();
        $('#bp-category').val(data.bp_category);
        $('#bp-topic').val(data.bp_topic);
        $('#bp-headline').val(data.bp_headline);
        $('#bp-body').val(data.bp_body);
        $('#bp-keywords').val(data.bp_keywords);
        $('#bp-facebook-snippet').val(data.bp_facebook_snippet);
        $('#bp-twitter-snippet').val(data.bp_twitter_snippet);
        $('#bp-linkedin-snippet').val(data.bp_linkedin_snippet);
    }
</script>