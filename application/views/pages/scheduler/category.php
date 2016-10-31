<h4 style="text-align: center; font-weight: bold; margin-bottom: 15px;">Scheduler - User Post Categories</h4>

<div class="centered-pills" style="margin-bottom: 10px;">
    <ul class="nav nav-pills">
        <li role="presentation">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                Scheduler <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li role="presentation"><a href="<?php echo base_url() . 'scheduler/'; ?>">Weekly</a></li>
                <li role="presentation"><a href="<?php echo base_url() . 'scheduler/monthly'; ?>">Monthly</a></li>
            </ul>
        </li>
        <li role="presentation"><a href="<?php echo base_url() . 'scheduler/queue'; ?>">Queues</a></li>
        <li role="presentation" class="active"><a href="<?php echo base_url() . 'scheduler/category'; ?>">Categories</a></li>
        <li role="presentation"><a href="<?php echo base_url() . 'scheduler/post'; ?>">Posts</a></li>
    </ul>
    <hr style="border-style: dotted" />
</div>

<button id="add-btn" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Add Category</button>

<div class="row" style="margin-top: 10px;">
    <div class="col-xs-12">
        <div class="table-responsive">
            <table id="schedulerLibraryDt" cellpadding="0" cellspacing="0" border="0" class="table table-striped no-multiple">
                <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Post Count</th>
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
                <h4 class="modal-title" id="form-modal-label">Add Category</h4>
            </div>
            <div class="modal-body">
                <div class="notice"></div>
                <div class="form-group">
                    <label for="category-name">* Category Name</label>
                    <input type="text" class="form-control required" id="category-name" />
                </div>
                <div class="form-group">
                    <label for="category-description">* Category Description</label>
                    <textarea class="form-control required" id="category-description" rows="4"></textarea>
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
    var actionUrl = "<?php echo base_url() . "scheduler/category_action" ?>";
    var dt, selectedId, selectedRows;

    $(document).ready(function() {
        initDt();

        $('#add-btn').on('click', function() {
            $('#delete-btn').hide();
            selectedId = 0;
            var modal = $('#form-modal');
            modal.find('.modal-title').html('Add Category');
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
                    category: {
                        category_name: $('#category-name').val(),
                        category_description: $('#category-description').val()
                    }
                };
                if(selectedId > 0) {
                    data.category.category_id = selectedId;
                }
                loading('info', 'Saving category...');
                $.post(actionUrl, data, function(res) {
                    if(res.success) {
                        $('#form-modal').modal('hide');
                        loading('success', 'Saving category successful!');
                        dt.fnReloadAjax();
                    }
                }, 'json');
            }

        });

        $('#delete-btn').on('click', function() {
            var ok = confirm("Are you sure to delete this category?");
            if(ok) {
                loading('info', 'Deleting category...');
                $.post(actionUrl, {action: 'delete', category_id: selectedId}, function(res) {
                    if(res.success) {
                        $('#form-modal').modal('hide');
                        loading('success', 'Deleting category successful!');
                        dt.fnReloadAjax();
                    }
                }, 'json');
            }
        });

    });

    function initDt() {
        dt = $("#schedulerLibraryDt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [4],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": {action: "list"}
            },
            columns: [
                {data: "category_name", width: "20%"},
                {data: "category_description", width: "45%"},
                {data: "post_count", width: "15%"},
                {data: "category_date_created", width: "20%"},
                {data: "category_id", visible: false}
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("#schedulerLibraryDt").dataTable();
                $('#schedulerLibraryDt tbody tr').on('click', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    showEdit(data);
                });
            }
        });
    }
    function showEdit(data) {
        selectedId = data.category_id;
        var modal = $('#form-modal');
        modal.modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });
        modal.find('.modal-title').html('Edit Category');
        $('#delete-btn').show();
        $('#category-name').val(data.category_name);
        $('#category-description').val(data.category_description);
    }
</script>