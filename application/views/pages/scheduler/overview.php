<div class="row">
    <div class="col-xs-12">
        <h2>Scheduler</h2>
        <a href="<?php echo base_url() . "scheduler/form"; ?>" class="btn btn-success btn-sm pull-right">
            <i class="fa fa-plus-circle"></i> Create
        </a>

    </div>
</div>

<div class="row" style="margin-top: 10px;">
    <div class="col-xs-12">
        <table id="schedulerDt" class="table-bordered" style="width: 100%;">
            <thead>
            <tr>
                <th>Module</th>
                <th>Status</th>
                <th>Interval</th>
                <th>Day</th>
                <th>Time</th>
                <th>Content Type</th>
                <th>Date Created</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<script>
    var actionUrl = "<?php echo base_url() . "scheduler/action" ?>";
    var dt, selected, selectedRows;

    $(document).ready(function() {
        initSchedulerDataTable();
    });

    function initSchedulerDataTable() {
        dt = $("#schedulerDt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [],
            "bDestroy": true,
            "filter": false,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": {action: "list"}
            },
            columns: [
                {data: "module", width: "15%"},
                {data: "status", width: "10%",
                    render: function(data, type, row) {
                        var style = data == 'Active' ? 'text-success' : 'text-danger';
                        return "<span class='" + style + "'><b>" + data + "</b></span>";
                    }
                },
                {data: "interval", width: "20%"},
                {data: "day", width: "10%"},
                {data: "time", width: "10%"},
                {data: "type", width: "15%"},
                {data: "date_created", width: "20%"},
                {data: "id", visible: false}
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("#schedulerDt").dataTable();
                $('#schedulerDt tbody tr').on('dblclick', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    window.location = "<?php echo base_url() . "scheduler/form/" ?>" + data.id;
                });
            }
        });
    }
</script>