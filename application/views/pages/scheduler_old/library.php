
<ol class="breadcrumb">
    <li><a href="<?php echo base_url() . 'scheduler/' ?>">Scheduler</a></li>
    <li class="active">Library</li>
</ol>
<h4><i class="fa fa-book"></i> Libraries</h4>
<hr />

<div class="row" style="margin-bottom: 20px;">
    <div class="col-xs-3">
        <a href="<?php echo base_url() . "scheduler/library/form"; ?>" class="btn btn-success btn-sm btn-block">
            <i class="fa fa-plus-circle"></i> Add Library
        </a>
    </div>
</div>


<div class="row" style="margin-top: 10px;">
    <div class="col-xs-12">
        <div class="table-responsive">
            <table id="schedulerLibraryDt" cellpadding="0" cellspacing="0" border="0" class="display table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Template Count</th>
                    <th>Date Created</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
</div>

<script>
    var actionUrl = "<?php echo base_url() . "scheduler/library" ?>";
    var dt, selected, selectedRows;

    $(document).ready(function() {
        initDt();
    });

    function initDt() {
        dt = $("#schedulerLibraryDt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [3],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": {action: "list"}
            },
            columns: [
                {data: "name", width: "20%"},
                {data: "description", width: "40%"},
                {data: "template_count", width: "20%"},
                {data: "date_created", width: "20%"},
                {data: "id", visible: false}
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("#schedulerLibraryDt").dataTable();
                $('#schedulerLibraryDt tbody tr').on('dblclick', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    window.location = "<?php echo base_url() . "scheduler/library/form/" ?>" + data.id;
                });
            }
        });
    }
</script>