<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <button class="btn btn-success btn-sm" id="add-btn"><i class="fa fa-plus-circle"></i> Add Category</button>
        <div class="table-responsive" style="margin-top: 10px;">
            <table id="scheduler-category-dt" cellpadding="0" cellspacing="0" border="0" class="table table-striped">
                <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Type</th>
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
                    <label for="category-type">* Category Type</label>
                    <select id="category-type" class="form-control required">
                        <option value="WITHOUT_BLOG_POST">Without blog post</option>
                        <option value="WITH_BLOG_POST">With blog post</option>
                    </select>
                </div>
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
    var actionUrl = "<?php echo base_url() . "admin/scheduler_category_action" ?>";
    var dt, selectedId, selectedRows;

    $(document).ready(function() {
        $("#schedulerCategoriesTopLink").addClass("custom-nav-active");
        $("#schedulerSideLink").addClass("custom-nav-active");
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
                        category_type: $('#category-type').val(),
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
        dt = $("#scheduler-category-dt").dataTable({
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
                {data: "category_name", width: "15%"},
                {data: "category_description", width: "30%"},
                {data: "category_type", width: "20%", render: function(data) {
                    if(data == "WITHOUT_BLOG_POST") {
                        return "Without blog post";
                    } else if(data == "WITH_BLOG_POST") {
                        return "With blog post";
                    }
                }
                },
                {data: "post_count", width: "15%"},
                {data: "category_date_created", width: "20%"},
                {data: "category_id", visible: false}
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("#scheduler-category-dt").dataTable();
                $('#scheduler-category-dt tbody tr').on('dblclick', function () {
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
        $('#category-type').val(data.category_type);
    }
</script>