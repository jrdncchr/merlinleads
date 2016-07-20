<h4 style="text-align: center; font-weight: bold; margin-bottom: 15px;">Queue</h4>

<div class="row">
    <div class="col-sm-12">
        <a href="<?php echo base_url() . 'scheduler/post'; ?>" class="btn btn-default btn-sm pull-right">Posts</a>
        <a href="<?php echo base_url() . 'scheduler/category'; ?>" class="btn btn-default btn-sm pull-right" style="margin-right: 10px;">Categories</a>
        <button disabled class="btn btn-default btn-sm pull-right" style="margin-right: 10px;">Queue</button>
        <a href="<?php echo base_url() . 'scheduler'; ?>" class="btn btn-default btn-sm pull-right" style="margin-right: 10px;">Scheduler</a>
    </div>
</div>

<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <div class="table-responsive">
            <table id="queue-dt" cellpadding="0" cellspacing="0" border="0" class="display table table-striped no-multiple">
                <thead>
                <tr>
                    <th>Schedule</th>
                    <th>Type</th>
                    <th>Library</th>
                    <th>Category</th>
                    <th>Post Name</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
</div>

<script>
    var actionUrl = "<?php echo base_url() . "scheduler/queue" ?>";
    var dt, selected, selectedRows;

    $(document).ready(function() {
        initDt();
    });

    function initDt() {
        dt = $("#queue-dt").dataTable({
            "bJQueryUI": true,
            "order": [[ 0, "asc" ]],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": {action: "get_queue"}
            },
            columns: [
                {data: "schedule", width: "20%"},
                {data: "type",  width: "15%", render: function(data, type, row) {
                        return data == "Weekly" ?
                            "<span class='text-primary'>" + data + "</span>" :
                            "<span class='text-danger'>" + data + "</span>"
                    }
                },
                {data: "library", width: "15%", render: function(data, type, row) {
                    return row.post_library == "user" ?
                        "<span class='badge badge-user-lib'>User Library</span>" :
                        "<span class='badge badge-merlin-lib'>Merlin Library</span>";
                    }
                },
                {data: "category", width: "15%"},
                {data: "post_name", width: "30%"}
            ]
        });
    }

</script>