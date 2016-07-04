<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <h2 style="margin-top: 0;">City / Zip Codes Requests</h2>
        <div class="table-responsive" style="margin-top: 10px;">
            <table id="dt" cellpadding="0" cellspacing="0" border="0" class="table table-striped no-multiple">
                <thead>
                <tr>
                    <th>Actions</th>
                    <th>City</th>
                    <th>Zip Code</th>
                    <th>Status</th>
                    <th>Requested By</th>
                    <th>Date Requested</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
</div>

<script>
    var actionUrl = "<?php echo base_url() . "admin/cities_zipcodes_action" ?>";
    var dt, selectedId, selectedRows;

    $(document).ready(function() {
        $("#czRequestsTopLink").addClass("custom-nav-active");
        $("#czSideLink").addClass("custom-nav-active");
        initDt();
    });

    function initDt() {
        dt = $("#dt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [5],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": {action: "czr_list"}
            },
            columns: [
                {data: "czr_id", width: "15%", render: function(data, type, row){
                            return row.czr_status == 'pending' ?
                            "<button class='btn btn-success btn-xs' onclick='approveRequest(" + data + ");'>Approve</button>" +
                            "<button class='btn btn-danger btn-xs' onclick='rejectRequest(" + data + ")'>Reject</button>" :
                            "<button class='btn btn-success btn-xs' onclick='approveRequest(" + data + ");'>Approve</button>";
                    }
                },
                {data: "czr_city", width: "25%"},
                {data: "czr_zipcode", width: "10%"},
                {data: "czr_status", width: "10%", render: function(data, type, row) {
                        if(data == "pending") {
                            return "<span class='text-primary'>Pending</span>";
                        } else if(data == "rejected") {
                            return "<span class='text-danger'>Rejected</span>";
                        }  else if(data == "approved") {
                            return "<span class='text-success'>Approved</span>";
                        }
                    }
                },
                {data: "email", width: "30%"},
                {data: "czr_date_requested", width: "15%"}

            ]
        });
    }

    function approveRequest(id) {
        loading('info', 'Approving Request...');
        $.post(actionUrl, {action: 'czr_save', status: 'approved', czr_id: id}, function(res) {
            if(res.success) {
                loading('success', 'Request is now approved.');
                dt.fnReloadAjax();
            }
        }, 'json');
    }

    function rejectRequest(id) {
        loading('info', 'Rejecting Request...');
        $.post(actionUrl, {action: 'czr_save', status: 'rejected', czr_id: id}, function(res) {
            if(res.success) {
                loading('success', 'Request is now rejected.');
                dt.fnReloadAjax();
            }
        }, 'json');
    }
</script>