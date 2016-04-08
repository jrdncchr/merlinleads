<div class='row'>
    <div class='col-xs-12'>
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-xs-3">
                <h4 style="margin-top: 0 !important;">Merlin Libraries</h4>
            </div>
            <div class="col-xs-3 col-xs-offset-6">
                <a class="btn btn-success btn-sm btn-block" href="<?php echo base_url() . 'admin/scheduler/form'?>"><i class="fa fa-plus-circle"></i> Add Library</a>
            </div>
        </div>
        <table id="libraryDt" cellpadding="0" cellspacing="0" border="0" class="display table table-striped">
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

<script>
    var actionUrl = "<?php echo base_url() . "admin/scheduler" ?>";
    var dt, selected, selectedRows;

    $(document).ready(function() {
        $("#schedulerLibrariesTopLink").addClass("custom-nav-active");
        $("#schedulerSideLink").addClass("custom-nav-active");

        dt = $("#libraryDt").dataTable({
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
                var table = $("#libraryDt").dataTable();
                $('#libraryDt tbody tr').on('dblclick', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    window.location = "<?php echo base_url() . "admin/scheduler/form/" ?>" + data.id;
                });
            }
        });
    });

</script>