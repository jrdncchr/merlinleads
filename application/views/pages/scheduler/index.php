<style>
    .table thead tr th {
        padding: 15px;
        font-weight: bold;
        /*background-color: #00438A;*/
        font-size: 16px;
        text-align: center;;
        /*color: white;*/
        border: none !important;
        color: slategray;
    }

    .available_time {
        text-align: center;
        font-size: 16px !important;
        background-color: white !important;
        border-right: 1px solid #DDDDDD !important;
        color: lightslategray;
    }

    .scheduler_block {
        text-align: center;
        margin-bottom: 7px !important;
        cursor: pointer;
    }
    .scheduler_block:hover {
        font-weight: bold;
    }

    .scheduler_block p.modules {
        line-height: 5px;
    }
    .merlin-block {
        background-color: #C2EAE9;
    }
    .user-block {
        background-color: #F8EFB6;
    }
    .block-inactive {
        background-color: #808080;
    }
</style>

<h4 style="text-align: center; font-weight: bold; margin-bottom: 15px;">Scheduler - Weekly</h4>

<div class="centered-pills" style="margin-bottom: 10px;">
    <ul class="nav nav-pills">
        <li role="presentation" class="active">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                Scheduler <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li role="presentation"><a href="<?php echo base_url() . 'scheduler/'; ?>">Weekly</a></li>
                <li role="presentation"><a href="<?php echo base_url() . 'scheduler/monthly'; ?>">Monthly</a></li>
            </ul>
        </li>
        <li role="presentation"><a href="<?php echo base_url() . 'scheduler/queue'; ?>">Queues</a></li>
        <li role="presentation"><a href="<?php echo base_url() . 'scheduler/category'; ?>">Categories</a></li>
        <li role="presentation"><a href="<?php echo base_url() . 'scheduler/post'; ?>">Posts</a></li>
    </ul>
</div>


<button class="btn btn-success btn-sm" id="add-timeslot-btn"><i class="fa fa-plus-circle"></i> Add Timeslot</button>

<div class="row">
    <div class="col-sm-12">
        <table class="table table-striped" style="margin-top: 10px; border: 1px solid #dddddd">
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
                                    <div class="scheduler_block panel panel-default <?php echo $s->library == 'merlin' ? 'merlin-block' : 'user-block'; ?> <?php echo $s->status != 'Active' ? 'block-inactive' : 'k'; ?>">
                                    <input type="hidden" class="s_scheduler_id" value="<?php echo $s->scheduler_id; ?>" />
                                    <input type="hidden" class="s_modules" value="<?php echo $s->modules; ?>" />
                                    <input type="hidden" class="s_day" value="<?php echo $s->day; ?>" />
                                    <input type="hidden" class="s_time" value="<?php echo $s->time; ?>" />
                                    <input type="hidden" class="s_library" value="<?php echo $s->library; ?>" />
                                    <input type="hidden" class="s_category_id" value="<?php echo $s->category_id; ?>" />
                                    <input type="hidden" class="s_property_id" value="<?php echo $s->property_id; ?>" />
                                    <input type="hidden" class="s_profile_id" value="<?php echo $s->profile_id; ?>" />
                                    <input type="hidden" class="s_date" value="<?php echo $s->date; ?>" />
                                    <input type="hidden" class="s_status" value="<?php echo $s->status; ?>" />
                                    <p><?php echo $s->category->category_name; ?></p>
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
                            <label for="library">* Library</label>
                            <select id="library" class="form-control required">
                                <option value="">Select Library</option>
                                <option value="merlin">Merlin Library</option>
                                <option value="user">User Library</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6" id="category-section" style="display: none;">
                        <div class="form-group">
                            <label for="category-user">* Category</label>
                            <select id="category-user" class="form-control" style="display: none;">
                                <option value="">Select Category</option>
                                <?php foreach($user_category as $c): ?>
                                    <option value="<?php echo $c->category_id; ?>"><?php echo $c->category_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select id="category-merlin" class="form-control" style="display: none;">
                                <option value="">Select Category</option>
                                <?php foreach($merlin_category as $c): ?>
                                    <option value="<?php echo $c->category_id; ?>"><?php echo $c->category_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>* Accounts</label>
                    <div id="accounts">
                        <?php if(isset($main_f->facebook_feed_posting)) { ?>
                            <?php if(isset($fb['valid_access_token'])) { ?>
                                <i class="fa fa-facebook-square fa-2x social account-facebook"></i>
                            <?php } ?>
                        <?php } ?>


                        <?php if(isset($main_f->twitter_feed_posting)) { ?>
                            <?php if($twitter['has_access_key']  && isset($twitter['user_info'])) { ?>
                                <i class="fa fa-twitter-square fa-2x social account-twitter"></i>
                            <?php } ?>
                        <?php } ?>


                        <?php if(isset($main_f->linkedin_feed_posting)) { ?>
                            <?php if(isset($linkedIn['access_token'])) { ?>
                                <?php if(!$linkedIn['expired_access_token']) { ?>
                                    <i class="fa fa-linkedin-square fa-2x social account-linkedin"></i>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>

                        <?php if(!$user->fb_access_token && !$user->twitter_access_token && !$user->li_access_token) { ?>
                            <span class="text-danger">No accounts setup yet. <a href="<?php echo base_url() . 'main/myaccount/integrations'; ?>">Setup Now.</a></span>
                        <?php } ?>

                        <br />
                        <a href="<?php echo base_url() . 'main/myaccount/integrations'; ?>">Setup your social accounts now.</a>
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
                category_id : selectedBlock.find('.s_category_id').val(),
                time : selectedBlock.find('.s_time').val(),
                day : selectedBlock.find('.s_day').val(),
                library : selectedBlock.find('.s_library').val(),
                property_id : selectedBlock.find('.s_property_id').val(),
                profile_id : selectedBlock.find('.s_profile_id').val()
            };

            $('#delete-btn').show();
            var modal = $('#form-modal');
            modal.modal({
                show: true,
                backdrop: 'static',
                keyboard: false
            });

            modal.find('.modal-title').html('Edit Timeslot');
            $('#time').val(scheduler.time);
            $('#day').val(scheduler.day);
            $('#library').val(scheduler.library);
            $('#category-section').show();
            if(scheduler.library == 'user') {
                $('#category-merlin').hide();
                $('#category-merlin-options').hide();
                $('#category-user').show().val(scheduler.category_id);
            } else if(scheduler.library == 'merlin') {
                $('#category-user').hide();
                $('#category-merlin').show().val(scheduler.category_id);
                $('#category-merlin-options').show();
                $('#property').val(scheduler.property_id);
                $('#profile').val(scheduler.profile_id);
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

        $('#library').on('change', function() {
            var library = $(this).val();
            if(library) {
                $('#category-section').show();
                if(library == 'merlin') {
                    $('#category-merlin').addClass('required').show();
                    $('#category-merlin-options').hide();
                    $('#category-user').removeClass('required').hide();
                    $('#property').removeClass('required');
                    $('#profile').removeClass('required');
                } else if(library == 'user') {
                    $('#category-user').addClass('required').show();
                    $('#category-merlin').removeClass('required').hide();
                    $('#category-merlin-options').hide();
                    $('#property').removeClass('required');
                    $('#profile').removeClass('required');
                }
            } else {
                $('#category-section').hide();
                $('#category-merin-options').hide();
            }
        });

        $('#form-modal').on("hidden.bs.modal", function() {
            $('#category-section').hide();
            $('#category-merlin-options').hide();
        });

        $('#save-btn').on('click', function() {
            if(validator.validateForm($('#form-modal'))) {
                var library = $('#library').val();
                var data = {
                    action: 'save',
                    scheduler : {
                        day : $('#day').val(),
                        time: $('#time').val(),
                        library: library,
                        category_id: library == 'user' ? $('#category-user').val() : $('#category-merlin').val()
                    }
                };
                if(library == 'property') {
                    data.scheduler.property_id = $('#property').val();
                    data.scheduler.profile_id = $('#profile').val();
                }
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

        $('#delete-btn').on('click', function() {
            var ok = confirm("Are you sure to delete this scheduler?");
            if(ok) {
                loading('info', 'Deleting scheduler...');
                $.post(actionUrl, {action: 'delete', scheduler_id: schedulerId}, function(res) {
                    if(res.success) {
                        loading('success', 'Deleting scheduler successful!');
                        setTimeout(function() {
                            location.reload(true);
                        }, 500);
                    }
                }, 'json');
            }
        })
    })
</script>