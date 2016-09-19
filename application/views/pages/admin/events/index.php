<div class="col-xs-12">
    <div class="row">
        <div class="form-group">
            <div class="col-xs-12">
                <div id="message"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h4>Properties Events</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table id="dt" class="dataTable no-multiple" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Date Created</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var dt;
    var actionUrl = "<?php echo base_url() . "admin2/events" ?>";

    $(document).ready(function() {
        $("#eventsSideLink").addClass("custom-nav-active");
        $('#eventsPropertiesTopLink').addClass("custom-nav-active");
        setupDataTables();
    });

    function setupDataTables() {
        dt = $("#dt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [],
            "bDestroy": true,
            "filter": false,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": { action: "property_events_list" }
            },
            "columns": [
                { data: "name", width: "50%" },
                { data: "active", width: "25%", render:
                    function(data, type, row) {
                        var textClass = data == "1" ? "text-success" : "text-danger";
                        return  "<b><span class='" + textClass + "'>" +  (data == 1 ? "Active" : "Inactive") + "</span></b>";
                    }
                },
                { data: "date_created", width: "25%" },
                { data: "id", visible: false }
            ],
            "fnDrawCallback": function( oSettings ) {
                var table = $("#dt").dataTable();
                $('#dt tbody tr').on("click", function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    window.location = actionUrl + "/" + data.id;
                });
            }
        });
    }

</script>