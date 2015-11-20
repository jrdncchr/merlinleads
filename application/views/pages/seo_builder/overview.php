<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h2>IDX - SEO Builder</h2>
            <a href="<?php echo base_url() . "seo_builder/manage"; ?>" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus-circle"></i> Create</a>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-xs-12">
            <table id="seoBuilderDt" class="table-bordered" style="width: 100%;">
                <thead>
                <tr>
                    <th>SEO Builder Name</th>
                    <th>Status</th>
                    <th>City</th>
                </tr>
                </thead></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    var actionUrl = "<?php echo base_url() . "seo_builder/action" ?>";
    var dt, selected, selectedRows;

    $(document).ready(function() {
        initSeoBuilderDataTable();
    });

    function initSeoBuilderDataTable() {
        dt = $("#seoBuilderDt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [],
            "bDestroy": true,
            "filter": false,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": { action: "list" }
            },
            columns: [
                { data: "name", width: "50%" },
                { data: "status", width: "25%"},
                { data: "city_name", width: "25%" },
                { data: "id", visible: false }
            ],
            "fnDrawCallback": function( oSettings ) {
                var table = $("#seoBuilderDt").dataTable();
                $('#seoBuilderDt tbody tr').on('dblclick', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    window.location.replace("<?php echo base_url() . "seo_builder/manage/" ?>" + data.id);
                });
            }
        });
    }

    function validateProfile() {
        return $("#profile").val() != "" ? false : true;
    }
</script>