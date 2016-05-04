<style>
    .table thead tr th {
        padding: 15px;
        font-weight: bold;
        background-color: #00438A;
        font-size: 16px;
        text-align: center;;
        color: white;
        border: none !important;
    }

    .available_time {
        background-color: lightyellow !important;
        color: black;
        text-align: center;
        font-size: 16px !important;
    }

    .scheduler_block {
        text-align: center;
        margin-bottom: 7px !important;
        cursor: pointer;
    }
    .scheduler_block:hover {
        background-color: lightyellow;
    }

    .scheduler_block p.modules {
        line-height: 5px;
    }
</style>

<h4 style="text-align: center; font-weight: bold; margin-bottom: 15px;"><i class="fa fa-calendar"></i> Scheduler</h4>
<div class="row">
    <div class="col-sm-12">
        <button class="btn btn-success btn-sm" id="add-timeslot-btn"><i class="fa fa-plus-circle"></i> Add Timeslot</button>
        <a href="<?php echo base_url() . 'scheduler/content'; ?>" class="btn btn-default btn-sm pull-right">Contents</a>
        <a href="<?php echo base_url() . 'scheduler/library'; ?>" class="btn btn-default btn-sm pull-right" style="margin-right: 10px;">Libraries</a>
        <a href="<?php echo base_url() . 'scheduler/queue'; ?>" class="btn btn-default btn-sm pull-right" style="margin-right: 10px;">Queues</a>
        <button disabled class="btn btn-default btn-sm pull-right" style="margin-right: 10px;">Scheduler</button>
    </div>
</div>

<div class="row" style="margin-top: 10px;">
    <div class="col-sm-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><i class="fa fa-clock-o"></i></th>
                    <th>Sunday</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($available_times as $t): ?>
                    <tr>
                        <td class="available_time"><?php echo $t; ?></td>
                        <?php foreach(array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday') as $d): ?>
                        <td>
                            <?php foreach($scheduler as $s): ?>
                                <?php if($s->day == $d && $s->time == $t) { ?>
                                    <div class="scheduler_block panel panel-default">
                                    <input type="hidden" class="s_scheduler_id" value="<?php echo $s->scheduler_id; ?>" />
                                    <input type="hidden" class="s_modules" value="<?php echo $s->modules; ?>" />
                                    <input type="hidden" class="s_otp" value="<?php echo $s->otp; ?>" />
                                    <input type="hidden" class="s_day" value="<?php echo $s->day; ?>" />
                                    <input type="hidden" class="s_time" value="<?php echo $s->time; ?>" />
                                    <input type="hidden" class="s_type" value="<?php echo $s->type; ?>" />
                                    <input type="hidden" class="s_library_id" value="<?php echo $s->library_id; ?>" />
                                    <input type="hidden" class="s_property_id" value="<?php echo $s->property_id; ?>" />
                                    <input type="hidden" class="s_date" value="<?php echo $s->date; ?>" />
                                    <input type="hidden" class="s_status" value="<?php echo $s->status; ?>" />
                                    <p><?php echo $s->library_name; ?></p>
                                    <p class="modules">
                                    <?php
                                    $modules = explode(',', $s->modules);
                                    foreach($modules as $m) {
                                        if($m == "Facebook") {
                                            echo "<i class='fa fa-facebook'></i> ";
                                        } else if($m == "Twitter") {
                                            echo "<i class='fa fa-twitter'></i> ";
                                        } else if($m == "LinkedIn") {
                                            echo "<i class='fa fa-linkedin'></i> ";
                                        } else if($m == "All") {
                                            echo "<i class='fa fa-asterisk'></i> ";
                                        }
                                    }
                                    ?>
                                    </p>
                                    </div>
                                <?php } ?>
                            <?php endforeach; ?>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="form-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="form-modal-label">Add Timeslot</h4>
            </div>
            <div class="modal-body" style="padding-bottom: 0;">
                <div class="notice"></div>
                <div class="form-group">
                    <label for="time">* Time</label>
                    <select id="time" class="form-control required">
                        <?php foreach($available_times as $t): ?>
                            <option value="<?php echo $t; ?>"><?php echo $t; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="library">* Library</label>
                    <select id="library" class="form-control required">
                        <option value="CWoP">Content without post</option>
                        <option value="CWoP">Content with post</option>
                        <option value="CWoP">Cross Promotional</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>* Accounts</label>
                    <div>
                        <i class="fa fa-facebook-square fa-2x"></i>
                        <i class="fa fa-twitter-square fa-2x"></i>
                        <i class="fa fa-linkedin-square fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="save-btn">Save</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(function() {
        $('#add-timeslot-btn').on('click', function() {
            $('#form-modal').modal({
                show: true,
                backdrop: 'static',
                keyboard: false
            })
        });
        $('.scheduler_block').on('click', function() {
            $('#form-modal').modal({
                show: true,
                backdrop: 'static',
                keyboard: false
            })
        });
    });
</script>