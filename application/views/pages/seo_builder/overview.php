<p><a href="<?php echo base_url() . 'property' ?>">&Leftarrow; Return to Properties</a></p>
<h4 style="text-align: center; font-weight: bold; margin-bottom: 15px;">IDX - SEO Builder</h4>
<hr style="margin: 15px;" />

<div class="row" style="margin-bottom: 20px;">
    <div class="col-xs-3">
        <a href="<?php echo base_url() . "seo_builder/manage"; ?>" class="btn btn-block btn-success btn-sm">
            <i class="fa fa-plus-circle"></i> Create SEO Builder
        </a>
    </div>
</div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-xs-12">
            <table id="seoBuilderDt" cellpadding="0" cellspacing="0" border="0" class="display table table-striped">
                <thead>
                <tr>
                    <th>SEO Builder Name</th>
                    <th>Status</th>
                    <th>City</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
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