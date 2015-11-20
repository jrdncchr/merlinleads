<style>

table.dataTable tbody tr.selected {
    background-color: initial !important;
    border: none;
    /*background-color: #99e6e6;*/
}
</style>

<div class='row'>
    <div class='col-xs-12'>
        <h4 style="margin-top: 0 !important;">Modules</h4>
        <table id="modules" class="table table-striped display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th></th>   
                <th>Module Name</th>
                <th>Enabled</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    var dt;

    $(document).ready(function() {
        $("#modulesTopLink").addClass("custom-nav-active");
        $("#modulesSideLink").addClass("custom-nav-active");

        dt = $('#modules').dataTable({
            "filter": false,
            "bJQueryUI": true,
            "bDestroy": true,
            "ajax": {
                "url":  "<?php echo base_url() . "admin/modules"; ?>",
                "type": "POST",
                "data": {action: "list"}
            },
            columns: [
                { data: "module_id", visible: false },
                { data: "module_name" },
                { data: "module_enabled", render: 
                    function(data, type, row) {
                        var checked = data == "1" ? "checked" : "";
                        return  "<input data-module-id='" + row.module_id + "' data-size='mini' type='checkbox' " + checked + " />";
                    }
                }
            ],
            "fnRowCallback": function( nRow, data, iDisplayIndex, iDisplayIndexFull) {
                $('input', nRow).off('change').change(function(row) {
                    if($(this).is(":checked")) {
                        checkedRows.push(data.category_id);
                    } else {
                        var index = checkedRows.indexOf(data.category_id);
                        if (index > -1) {
                            checkedRows.splice(index, 1);
                        }
                    }
                });
            },
            "fnDrawCallback": function( oSettings ) {
                $("input[type='checkbox']").bootstrapSwitch({
                    onSwitchChange: function(event, state) {
                        $.post("<?php echo base_url() . "admin/modules"; ?>", {
                            action: "toggle",
                            module_id: event.target.dataset.moduleId,
                            module_enabled: state ? 1 : 0
                        });
                    }
                });
            }
        });
    });

</script>