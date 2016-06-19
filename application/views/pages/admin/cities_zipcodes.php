<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <button class="btn btn-success btn-sm" id="add-btn"><i class="fa fa-plus-circle"></i> Add City / Zip Code</button>
        <div class="table-responsive" style="margin-top: 10px;">
            <table id="dt" cellpadding="0" cellspacing="0" border="0" class="table table-striped">
                <thead>
                <tr>
                    <th>City</th>
                    <th>Zip Code</th>
                    <th>Used By</th>
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
                <h4 class="modal-title" id="form-modal-label">Add City / Zip Code</h4>
            </div>
            <div class="modal-body">
                <div class="notice"></div>
                <div class="form-group">
                    <label for="cz-city">* City</label>
                    <input type="text" class="form-control required" id="cz-city" />
                </div>
                <div class="form-group">
                    <label for="cz-zipcode">* Zip Code</label>
                    <input type="text" class="form-control required" id="cz-zipcode" />
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
    var actionUrl = "<?php echo base_url() . "admin/cities_zipcodes_action" ?>";
    var dt, selectedId, selectedRows;

    $(document).ready(function() {
        $("#czListTopLink").addClass("custom-nav-active");
        $("#czSideLink").addClass("custom-nav-active");
        initDt();

        $('#add-btn').on('click', function() {
            $('#delete-btn').hide();
            selectedId = 0;
            var modal = $('#form-modal');
            modal.find('.modal-title').html('Add City / Zip Code');
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
                    cz: {
                        cz_city: $('#cz-city').val(),
                        cz_zipcode: $('#cz-zipcode').val()
                    }
                };
                if(selectedId > 0) {
                    data.category.category_id = selectedId;
                }
                loading('info', 'Saving...');
                $.post(actionUrl, data, function(res) {
                    if(res.success) {
                        $('#form-modal').modal('hide');
                        loading('success', 'Saving successful!');
                        dt.fnReloadAjax();
                    }
                }, 'json');
            }

        });

        $('#delete-btn').on('click', function() {
            var ok = confirm("Are you sure to delete this?");
            if(ok) {
                loading('info', 'Deleting...');
                $.post(actionUrl, {action: 'delete', cz_id: selectedId}, function(res) {
                    if(res.success) {
                        $('#form-modal').modal('hide');
                        loading('success', 'Deleting successful!');
                        dt.fnReloadAjax();
                    }
                }, 'json');
            }
        });

    });

    function initDt() {
        dt = $("#dt").dataTable({
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
                {data: "cz_city", width: "30%"},
                {data: "cz_zipcode", width: "20%"},
                {data: "email", width: "30%"},
                {data: "cz_date_created", width: "20%"},
                {data: "cz_id", visible: false}
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("#dt").dataTable();
                $('#dt tbody tr').on('dblclick', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    showEdit(data);
                });
            }
        });
    }

    function showEdit(data) {
        selectedId = data.cz_id;
        var modal = $('#form-modal');
        modal.modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });
        modal.find('.modal-title').html('Edit City / Zip Code');
        $('#delete-btn').show();
        $('#cz-city').val(data.cz_city);
        $('#cz-zipcode').val(data.cz_zipcode);
    }
</script>