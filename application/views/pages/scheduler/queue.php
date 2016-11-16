<h4 style="text-align: center; font-weight: bold; margin-bottom: 15px;">Scheduler - Qeueus</h4>

<div class="centered-pills">
    <ul class="nav nav-pills">
        <li role="presentation">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                Scheduler <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li role="presentation"><a href="<?php echo base_url() . 'scheduler/'; ?>">Weekly</a></li>
                <li role="presentation"><a href="<?php echo base_url() . 'scheduler/monthly'; ?>">Monthly</a></li>
            </ul>
        </li>
        <li role="presentation" class="active"><a href="<?php echo base_url() . 'scheduler/queue'; ?>">Queues</a></li>
        <li role="presentation"><a href="<?php echo base_url() . 'scheduler/category'; ?>">Categories</a></li>
        <li role="presentation"><a href="<?php echo base_url() . 'scheduler/post'; ?>">Posts</a></li>
    </ul>
    <hr style="border-style: dotted" />
</div>

<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <div class="form-inline">
            <div class="form-group">
                <label for="until-date">Until Date: </label>
                <input type="text" class="form-control" id="until-date" value="<?php echo $until_date; ?>" />
            </div>
        </div>
        <br />
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

        $('#until-date').datepicker({
            dateFormat : 'MM d, yy',
            changeMonth: true,
            changeYear: true,
            minDate: 0,
            maxDate: "+2Y",
            onSelect: function(dateText) {
                initDt();
            },
            defaultDate: new Date($(this).datepicker('getDate'))
        });
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
                "data": {action: "get_queue", until_date: $('#until-date').val()}
            },
            columns: [
                {data: "schedule", width: "18%"},
                {data: "type",  width: "13%", render: function(data, type, row) {
                        return data == "Weekly" ?
                            "<span class='text-primary'>" + data + "</span>" :
                            "<span class='text-danger'>" + data + "</span>"
                    }
                },
                {data: "library", width: "14%", render: function(data, type, row) {
                    return row.library == "user" ?
                        "<span class='badge badge-user-lib'>User Library</span>" :
                        "<span class='badge badge-merlin-lib'>Merlin Library</span>";
                    }
                },
                {data: "category", width: "15%"},
                {data: "post_name", width: "25%"}
            ]
        });
    }

</script>