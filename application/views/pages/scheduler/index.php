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
    .social {
        cursor: pointer;
    }
    .account-on {
        color: #00438A;
        border-bottom: 3px solid #00438A;
        padding-bottom: 2px;
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
                                    <input type="hidden" class="s_day" value="<?php echo $s->day; ?>" />
                                    <input type="hidden" class="s_time" value="<?php echo $s->time; ?>" />
                                    <input type="hidden" class="s_type" value="<?php echo $s->type; ?>" />
                                    <input type="hidden" class="s_library_id" value="<?php echo $s->library_id; ?>" />
                                    <input type="hidden" class="s_property_id" value="<?php echo $s->property_id; ?>" />
                                    <input type="hidden" class="s_date" value="<?php echo $s->date; ?>" />
                                    <input type="hidden" class="s_status" value="<?php echo $s->status; ?>" />
                                    <p><?php echo $s->library->library_name; ?></p>
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
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="day">* Day</label>
                            <select id="day" class="form-control required">
                                <option value="">Select Day</option>
                                <?php foreach(array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday') as $d): ?>
                                    <option value="<?php echo $d; ?>"><?php echo $d; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="time">* Time</label>
                            <select id="time" class="form-control required">
                                <option value="">Select Time</option>
                                <?php foreach($available_times as $t): ?>
                                    <option value="<?php echo $t; ?>"><?php echo $t; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="type">* Type</label>
                            <select id="type" class="form-control required">
                                <option value="">Select Type</option>
                                <option value="merlin">Merlin Library</option>
                                <option value="user">User Library</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6" id="library-section" style="display: none;">
                        <div class="form-group">
                            <label for="library-user">* Library</label>
                            <select id="library-user" class="form-control" style="display: none;">
                                <option value="">Select Library</option>
                                <?php foreach($user_library as $l): ?>
                                    <option value="<?php echo $l->library_id; ?>"><?php echo $l->library_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select id="library-merlin" class="form-control" style="display: none;">
                                <option value="">Select Library</option>
                                <?php foreach($merlin_library as $l): ?>
                                    <option value="<?php echo $l->library_id; ?>"><?php echo $l->library_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>* Accounts</label>
                    <div id="accounts">
                        <i class="fa fa-facebook-square fa-2x social account-facebook"></i>
                        <i class="fa fa-twitter-square fa-2x social account-twitter"></i>
                        <i class="fa fa-linkedin-square fa-2x social account-linkedin"></i>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm pull-left" id="delete-btn">Delete</button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="save-btn">Save</button>
            </div>
        </div>
    </div>
</div>


<script>
    var actionUrl = "<?php echo base_url() . 'scheduler/scheduler_action'; ?>";
    var schedulerId = 0;

    $(function() {
        $('#add-timeslot-btn').on('click', function() {
            schedulerId = 0;
            $('#delete-btn').hide();
            var modal = $('#form-modal');
            modal.modal({
                show: true,
                backdrop: 'static',
                keyboard: false
            });
            modal.find('.fa-facebook-square').removeClass('account-on');
            modal.find('.fa-twitter-square').removeClass('account-on');
            modal.find('.fa-linkedin-square').removeClass('account-on');
            modal.find('.modal-title').html('Add Timeslot');
        });

        $('.scheduler_block').on('click', function() {
            var selectedBlock = $(this);
            schedulerId = selectedBlock.find('.s_scheduler_id').val();
            var scheduler = {
                library_id : selectedBlock.find('.s_library_id').val(),
                time : selectedBlock.find('.s_time').val(),
                day : selectedBlock.find('.s_day').val(),
                type : selectedBlock.find('.s_type').val()
            };
            $('#delete-btn').show();
            var modal = $('#form-modal');
            modal.modal({
                show: true,
                backdrop: 'static',
                keyboard: false
            });
            modal.find('.modal-title').html('Edit Timeslot');
            $('#library').val(scheduler.library_id);
            $('#time').val(scheduler.time);
            $('#day').val(scheduler.day);
            $('#type').val(scheduler.type);
            $('#library-section').show();
            if(scheduler.type == 'user') {
                $('#library-merlin').hide();
                $('#library-user').show().val(scheduler.library_id);
            } else if(scheduler.type == 'merlin') {
                $('#library-user').hide();
                $('#library-merlin').show().val(scheduler.library_id);
            }

            if(selectedBlock.find('.fa-facebook').length > 0) {
                modal.find('.fa-facebook-square').addClass('account-on');
            } else {
                modal.find('.fa-facebook-square').removeClass('account-on');
            }
            if(selectedBlock.find('.fa-twitter').length > 0) {
                modal.find('.fa-twitter-square').addClass('account-on');
            } else {
                modal.find('.fa-twitter-square').removeClass('account-on');
            }
            if(selectedBlock.find('.fa-linkedin').length > 0) {
                modal.find('.fa-linkedin-square').addClass('account-on');
            } else {
                modal.find('.fa-linkedin-square').removeClass('account-on');
            }
        });

        $('.social').on('click', function() {
            var modal = $('#form-modal');
            if(!$(this).hasClass('account-on')) {
                $(this).addClass('account-on');
            } else {
                $(this).removeClass('account-on');
            }
        });

        $('#type').on('change', function() {
            var type = $(this).val();
            if(type) {
                $('#library-section').show();
                if(type == 'merlin') {
                    $('#library-merlin').addClass('required').show();
                    $('#library-user').removeClass('required').hide();
                } else if(type == 'user') {
                    $('#library-user').addClass('required').show();
                    $('#library-merlin').removeClass('required').hide();
                }
            } else {
                $('#library-section').hide();
            }
        });

        $('#form-modal').on("hidden.bs.modal", function() {
            $('#library-section').hide();
        });

        $('#save-btn').on('click', function() {
            if(validator.validateForm($('#form-modal'))) {
                var type = $('#type').val();
                var data = {
                    action: 'save',
                    scheduler : {
                        day : $('#day').val(),
                        time: $('#time').val(),
                        type: type,
                        library_id: type == 'user' ? $('#library-user').val() : $('#library-merlin').val()
                    }
                };
                var modules = "";
                $('#accounts').find('.social').each(function() {
                    if($(this).hasClass('account-on')) {
                        if($(this).hasClass('account-facebook')) {
                            modules += "Facebook";
                        } else if($(this).hasClass('account-twitter')) {
                            modules += "Twitter";
                        } else if($(this).hasClass('account-linkedin')) {
                            modules += "LinkedIn";
                        }
                        modules += ",";
                    }
                });
                modules = modules.substring(0, modules.length - 1);
                if(modules == "") {
                    validator.displayAlertError($('#form-modal'), true, "Select at least one account.");
                    return false;
                }
                data.scheduler.modules = modules;
                if(schedulerId > 0) {
                    data.scheduler.scheduler_id = schedulerId;
                }
                loading('info', 'Saving scheduler...');
                $.post(actionUrl, data, function(res) {
                    if(res.success) {
                        loading('success', 'Saving scheduler successful!');
                        setTimeout(function() {
                            location.reload(true);
                        }, 500);
                    }
                }, 'json');
            }
        });
    })
</script>