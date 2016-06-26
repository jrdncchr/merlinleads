<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <h2 style="margin-top: 0;">Users Requests</h2>
        <button class="btn btn-success btn-sm pull-right" id="add-btn" style="margin-bottom: 10px;"><i class="fa fa-plus-circle"></i> Add User Request</button>
        <div class="table-responsive" style="margin-top: 10px;">
            <table id="dt" cellpadding="0" cellspacing="0" border="0" class="table table-striped no-multiple">
                <thead>
                <tr>
                    <th>Email</th>
                    <th>Type</th>
                    <th>City / Zip Code</th>
                    <th>Status</th>
                    <th>Date Requested</th>
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
                <h4 class="modal-title" id="form-modal-label">User Request</h4>
            </div>
            <div class="modal-body">
                <div class="notice"></div>
                <div class="form-group">
                    <label for="czu-email">* Email</label>
                    <input type="text" class="form-control required email" id="czu-email" />
                </div>
                <div class="form-group">
                    <label for="czu-city-zipcode">* City / Zip Code</label>
                    <select class="form-control required" id=czu-city-zipcode>
                        <option value="">Select City / Zipcode</option>
                        <?php foreach($cz as $c): ?>
                            <option value="<?php echo $c->cz_id; ?>"><?php echo $c->cz_city . " / " . $c->cz_zipcode; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="czu-type">* Type</label>
                    <select class="form-control" id="czu-type">
                        <option value="first">Primary</option>
                        <option value="second">Secondary</option>
                        <option value="third">Third</option>
                        <option value="fourth">Fourth</option>
                        <option value="fifth">Fifth</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="czu-status">* Status</label>
                    <select id="czu-status" class="form-control required">
                        <option value="pending">Pending</option>
                        <option value="active">Active</option>
                    </select>
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
        $("#czUsersTopLink").addClass("custom-nav-active");
        $("#czSideLink").addClass("custom-nav-active");
        initDt();

        $('#add-btn').on('click', function() {
            $('#czu-email').attr('disabled', false);
            $('#delete-btn').hide();
            selectedId = 0;
            var modal = $('#form-modal');
            modal.find('.modal-title').html('Add User Request');
            modal.modal({
                show: true,
                keyboard: false,
                backdrop: 'static'
            });
        });

        $('#save-btn').on('click', function() {
            if(validator.validateForm($('#form-modal'))) {
                var data = {
                    action: 'czu_save',
                    czu: {
                        czu_cz_id: $('#czu-city-zipcode').val(),
                        czu_type: $('#czu-type').val(),
                        czu_status: $('#czu-status').val()
                    }
                };
                if(selectedId == 0) {
                    data.email = $('#czu-email').val();
                } else {
                    data.czu.czu_id = selectedId;
                }
                loading('info', 'Saving...');
                $.post(actionUrl, data, function(res) {
                    if(res.success) {
                        $('#form-modal').modal('hide');
                        loading('success', 'Saving successful!');
                        dt.fnReloadAjax();
                    } else {
                        validator.displayAlertError($('#form-modal'), true, res.message);
                    }
                }, 'json');
            }

        });

        $('#delete-btn').on('click', function() {
            var ok = confirm("Are you sure to delete this?");
            if(ok) {
                loading('info', 'Deleting...');
                $.post(actionUrl, {action: 'czu_delete', czu_id: selectedId}, function(res) {
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
                "data": {action: "czu_list"}
            },
            columns: [
                {data: "email", width: "30%"},
                {data: "czu_type", width: "10%"},
                {data: "cz_city", width: "20%", render: function(data, type, row) {
                        return row.cz_city + " / " + row.cz_zipcode;
                    }
                },
                {data: "czu_status", width: "10%", render: function(data, type, row) {
                        return data == "pending" ?
                            "<span class='text-warning'>" + data + "</span>" :
                            "<span class='text-success'>" + data + "</span>";
                    }
                },
                {data: "czu_date_created", width: "10%"},
                {data: "czu_id", visible: false},
                {data: "czu_user_id", visible: false},
                {data: "czu_cz_id", visible: false},
                {data: "cz_zipcode", visible:false}
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("#dt").dataTable();
                $('#dt tbody tr').on('click', function (e) {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    showEdit(data);
                });
            }
        });
    }

    function showEdit(data) {
        selectedId = data.czu_id;
        var modal = $('#form-modal');
        modal.modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });
        modal.find('.modal-title').html('Update User Request');
        $('#delete-btn').show();
        $('#czu-city-zipcode').val(data.czu_cz_id);
        $('#czu-status').val(data.czu_status);
        $('#czu-type').val(data.czu_type);
        $('#czu-email').val(data.email).attr('disabled', true);
    }
</script>