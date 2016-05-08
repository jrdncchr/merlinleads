<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <button class="btn btn-success btn-sm" id="add-btn"><i class="fa fa-plus-circle"></i> Add Library</button>
        <div class="table-responsive" style="margin-top: 10px;">
            <table id="schedulerLibraryDt" cellpadding="0" cellspacing="0" border="0" class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Content Count</th>
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
                <h4 class="modal-title" id="form-modal-label">Add Library</h4>
            </div>
            <div class="modal-body">
                <div class="notice"></div>
                <div class="form-group">
                    <label for="library-type">* Library Type</label>
                    <select id="library-type" class="form-control required">
                        <option value="CWoP">Content without post</option>
                        <option value="CWoP">Content with post</option>
                        <option value="CWoP">Cross Promotional</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="library-name">* Library Name</label>
                    <input type="text" class="form-control required" id="library-name" />
                </div>
                <div class="form-group">
                    <label for="library-description">* Library Description</label>
                    <textarea class="form-control required" id="library-description" rows="4"></textarea>
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
    var actionUrl = "<?php echo base_url() . "admin/scheduler_library_action" ?>";
    var dt, selectedId, selectedRows;

    $(document).ready(function() {
        $("#schedulerLibrariesTopLink").addClass("custom-nav-active");
        $("#schedulerSideLink").addClass("custom-nav-active");
        initDt();

        $('#add-btn').on('click', function() {
            $('#delete-btn').hide();
            selectedId = 0;
            var modal = $('#form-modal');
            modal.find('.modal-title').html('Add Library');
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
                    library: {
                        library_type: $('#library-type').val(),
                        library_name: $('#library-name').val(),
                        library_description: $('#library-description').val()
                    }
                };
                if(selectedId > 0) {
                    data.library.library_id = selectedId;
                }
                loading('info', 'Saving library...');
                $.post(actionUrl, data, function(res) {
                    if(res.success) {
                        $('#form-modal').modal('hide');
                        loading('success', 'Saving library successful!');
                        dt.fnReloadAjax();
                    }
                }, 'json');
            }

        });

        $('#delete-btn').on('click', function() {
            var ok = confirm("Are you sure to delete this library?");
            if(ok) {
                loading('info', 'Deleting library...');
                $.post(actionUrl, {action: 'delete', library_id: selectedId}, function(res) {
                    if(res.success) {
                        $('#form-modal').modal('hide');
                        loading('success', 'Deleting library successful!');
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
                {data: "library_name", width: "15%"},
                {data: "library_description", width: "30%"},
                {data: "library_type", width: "20%", render: function(data) {
                    if(data == "CWoP") {
                        return "Content without post";
                    } else if(data == "CWP") {
                        return "Content with post";
                    } else {
                        return "Cross Promotional";
                    }
                }
                },
                {data: "content_count", width: "15%"},
                {data: "date_created", width: "20%"},
                {data: "library_id", visible: false}
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("#schedulerLibraryDt").dataTable();
                $('#schedulerLibraryDt tbody tr').on('dblclick', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    showEdit(data);
                });
            }
        });
    }

    function showEdit(data) {
        selectedId = data.library_id;
        var modal = $('#form-modal');
        modal.modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });
        modal.find('.modal-title').html('Edit Library');
        $('#delete-btn').show();
        $('#library-name').val(data.library_name);
        $('#library-description').val(data.library_description);
        $('#library-type').val(data.library_type);
    }
</script>