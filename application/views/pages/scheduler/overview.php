<p><a href="<?php echo base_url() . 'property' ?>">&Leftarrow; Return to Properties</a></p>
<h4 style="text-align: center; font-weight: bold; margin-bottom: 15px;">Scheduler</h4>
<hr style="margin: 15px;" />

<div class="row" style="margin-bottom: 20px;">
    <div class="col-xs-3">
        <a href="<?php echo base_url() . "scheduler/form"; ?>" class="btn btn-success btn-sm btn-block">
            <i class="fa fa-plus-circle"></i> Add Scheduler
        </a>
    </div>
</div>


<div class="row" style="margin-top: 10px;">
    <div class="col-xs-12">
        <div class="table-responsive">
            <table id="schedulerDt" cellpadding="0" cellspacing="0" border="0" class="display table table-striped">
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
            "aaSorting": [6],
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