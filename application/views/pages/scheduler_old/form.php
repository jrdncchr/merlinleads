<div class="col-xs-10 col-xs-offset-1">
    <div class='row'>
        <div class='col-xs-12'>
            <a href="<?php echo base_url() . 'scheduler' ?>">&Leftarrow; Return to Scheduler Overview</a>
            <h4><i class="fa fa-clock-o"></i> Scheduler Form</h4>
            <hr/>

            <ul id="schedulerTabs" class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#tab-settings" role="tab" data-toggle="tab">Settings</a>
                </li>
                <li role="presentation">
                    <a href="#tab-content" role="tab" data-toggle="tab">Content</a>
                </li>
                <li role="presentation">
                    <a href="#tab-posts" role="tab" data-toggle="tab">Posts</a>
                </li>
            </ul>

            <div id="addEditForm" class="tab-content" style="padding-top: 10px;">
                <div id="tab-settings" class="tab-pane active" role="tabpanel" >

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="alert-danger"></div>
                            <?php if(sizeof($module) == 0) { ?>
                                <div class="alert alert-danger"><i class="fa fa-exclamation"></i>
                                    You don't have any integrations to any social media yet.
                                    <a href="<?php echo base_url() . "main/myaccount/integrations"; ?>">Integrate now.</a>
                                </div>
                            <?php } ?>
                            <div class="alert alert-warning"><i class="fa fa-question-circle"></i> A module will only be available if you've integrated your social account. <a href="<?php echo base_url() . "main/myaccount/integrations"; ?>">Integrate now.</a></div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Module</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="module" class="control-label">* Module</label>
                                    <select id="module" class="form-control required">
                                        <option value="">Select Module</option>
                                        <?php foreach($module as $m): ?>
                                            <option value="<?php echo $m->module_id; ?>"
                                                <?php echo isset($scheduler) ?
                                                    ($scheduler->module_id == $m->module_id ? "selected" : "") : "" ?>
                                                ><?php echo $m->module_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="status" class="control-label">* Status</label>
                                    <div>
                                        <input id="status" type='checkbox' data-on-text="Active" data-off-text="Inactive"
                                            <?php echo isset($scheduler) ?
                                            ($scheduler->status == "Inactive" ? "" : "checked") : "" ?> />
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Schedule</h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="interval" class="control-label">* Intervals</label>
                                    <select id="interval" class="form-control required">
                                        <option value="">Select Interval</option>
                                        <?php foreach($interval as $i): ?>
                                            <option value="<?php echo $i->code; ?>"
                                                <?php echo isset($scheduler) ?
                                                    ($scheduler->interval_code == $i->code ? "selected" : "") : "" ?>>
                                                <?php echo $i->scheduler_interval; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group" <?php echo isset($scheduler) ? ($scheduler->interval_code != "S" ? "" :'style="display: none;"'): '' ?>>
                                    <label for="day" class="control-label">* Day</label>
                                    <select id="day" class="form-control required">
                                        <option value="Sunday" <?php echo isset($scheduler) ? ($scheduler->day == "Sunday" ? "selected" : "") : "" ?>>Sunday</option>
                                        <option value="Monday" <?php echo isset($scheduler) ? ($scheduler->day == "Monday" ? "selected" : "") : "" ?>>Monday</option>
                                        <option value="Tuesday" <?php echo isset($scheduler) ? ($scheduler->day == "Tuesday" ? "selected" : "") : "" ?>>Tuesday</option>
                                        <option value="Wednesday" <?php echo isset($scheduler) ? ($scheduler->day == "Wednesday" ? "selected" : "") : "" ?>>Wednesday</option>
                                        <option value="Thursday" <?php echo isset($scheduler) ? ($scheduler->day == "Friday" ? "selected" : "") : "" ?>>Thursday</option>
                                        <option value="Friday" <?php echo isset($scheduler) ? ($scheduler->day == "Saturday" ? "selected" : "") : "" ?>>Friday</option>
                                    </select>
                                </div>
                                <div class="form-group" <?php echo isset($scheduler) ? ($scheduler->interval_code == "S" ? "" :'style="display: none;"'): 'style="display: none;"' ?>>
                                    <label for="date" class="control-label">* Date</label>
                                    <input type="date" class="form-control" id="date" value="<?php echo isset($scheduler) ? $scheduler->date : ''; ?>"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="time" class="control-label">* Time</label>
                                    <select id="time" class="form-control required">
                                        <option value="">Select Time</option>
                                        <?php foreach($time as $t): ?>
                                            <option value="<?php echo $t->id; ?>"
                                                <?php echo isset($scheduler) ? ($scheduler->time_id == $t->id ? "selected" : "") : "" ?>
                                                ><?php echo $t->time; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="tab-content" class="tab-pane" role="tabpanel">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Content</h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12">

                                <div class="form-group">
                                    <label for="type" class="control-label">* Type</label>
                                    <select class="form-control required" id="type">
                                        <option value="">Select Type</option>
                                        <option value="Merlin Library" <?php echo isset($scheduler) ? ($scheduler->type == "Merlin Library" ? "selected" : "") : "" ?>>Merlin Library</option>
                                        <option value="Library" <?php echo isset($scheduler) ? ($scheduler->type == "Library" ? "selected" : "") : "" ?>>User Library</option>
                                        <option value="Custom" <?php echo isset($scheduler) ? ($scheduler->type == "Custom" ? "selected" : "") : "" ?>>One Time Only</option>
                                    </select>
                                </div>

                                <div id="contentCustom" class="scheduler-content" <?php echo isset($scheduler) ? ($scheduler->type == "Custom" ? "" : "style='display:none;'") : "style='display:none;'"; ?>>
                                    <div class="alert alert-warning"><i class="fa fa-question-circle"></i> Custom type will only use this template for every post.</div>
                                    <div class="form-group">
                                        <label for="headline" class="control-label">* Headline</label>
                                        <input type="text" class="form-control" id="customHeadline"
                                            value="<?php echo isset($scheduler->content) ? ($scheduler->content ? $scheduler->content->headline : "") : "" ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="body" class="control-label">* Body</label>
                                        <textarea rows="3" class="form-control" style="height: 90px;" id="customBody"><?php echo isset($scheduler->content) ? ($scheduler->content ? $scheduler->content->content : "") : "" ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="keywords" class="control-label">* Keywords</label>
                                        <textarea rows="2" class="form-control" style="height: 60px;" id="customKeywords"><?php echo isset($scheduler->content) ? ($scheduler->content ? $scheduler->content->keywords : "") : "" ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="url" class="control-label">URL</label>
                                        <input type="url" class="form-control" id="customUrl" placeholder="ex. http://www.merlinleads.com"
                                               value="<?php echo isset($scheduler->content) ? ($scheduler->content ? $scheduler->content->url : "") : "" ?>" />
                                    </div>
                                </div>

                                <div id="contentLibrary" class="scheduler-content" <?php echo isset($scheduler) ? ($scheduler->type == "Library" ? "" : "style='display:none;'") : "style='display:none;'" ?>>
                                    <div class="alert alert-warning"><i class="fa fa-question-circle"></i>
                                        User Library type will post templates from your library. It will post in ascending order by create date.
                                        If you don't have any library yet, please <a href="<?php echo base_url() . 'scheduler/library' ;?>">create a library first and add your templates.</a>
                                    </div>
                                    <div class="form-group">
                                        <label for="library" class="control-label">* User Library</label>
                                        <select class="form-control" id="library">
                                            <option value="">Select Library</option>
                                            <?php foreach($library as $l): ?>
                                                <option value="<?php echo $l->id; ?>" <?php echo isset($scheduler) ? ($scheduler->library_id == $l->id ? "selected" : "") : "" ?>><?php echo $l->name . " [ " . $l->template_count . " Templates ]"  ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div id="contentMerlinLibrary" class="scheduler-content" <?php echo isset($scheduler) ? ($scheduler->type == "Merlin Library" ? "" : "style='display:none;'") : "style='display:none;'" ?>>
                                    <div class="alert alert-warning"><i class="fa fa-question-circle"></i>
                                        Merlin Library type will post templates from our library. It will post in ascending order by create date.
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="merlin-library" class="control-label">* Merlin Library</label>
                                                <select class="form-control" id="merlin-library">
                                                    <option value="">Select Library</option>
                                                    <?php foreach($merlin_library as $ml): ?>
                                                        <option value="<?php echo $ml->id; ?>" <?php echo isset($scheduler) ? ($scheduler->library_id == $ml->id ? "selected" : "") : "" ?>><?php echo $ml->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="merlin-library-category" class="control-label">* Category</label>
                                                <select class="form-control" id="merlin-library-category">
                                                    <option value="">Select Category</option>
                                                    <?php foreach($merlin_category as $mc): ?>
                                                        <option value="<?php echo $mc->category_id; ?>" <?php echo isset($scheduler) ? ($scheduler->category_id == $mc->category_id ? "selected" : "") : "" ?>><?php echo $mc->category_name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="merlin-library-property" class="control-label">* Property</label>
                                                <select class="form-control" id="merlin-library-property">
                                                    <option value="">Select Property</option>
                                                    <?php foreach($property as $p): ?>
                                                        <option value="<?php echo $p->property_id; ?>" <?php echo isset($scheduler) ? ($scheduler->property_id == $p->property_id ? "selected" : "") : "" ?>><?php echo $p->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label">* Post Content</label>
                                                <button class="btn btn-primary btn-block" id="merlin-library-generate-btn">Generate</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="merlin-library-property" class="control-label">* Post URL</label>
                                                <input type="text" class="form-control" id="merlin-library-property" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div id="tab-posts" class="tab-pane" role="tabpanel">
                    <div class="panel panel-default">

                        <table id="schedulerPostsDt" class="table-bordered" style="width: 100%;">
                            <thead>
                            <tr>
                                <th>Date Posted</th>
                                <th>Module</th>
                                <th>Link</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                    </div>

                </div>

            </div>
            <button class="btn btn-sm" <?php if(!isset($scheduler)) { echo "style='display:none';"; } ?> id="deleteBtn">Delete Scheduler</button>

            <button id="saveBtn" class="btn btn-success btn-sm pull-right">Save Scheduler</button>
        </div>

    </div>
</div>

<div id="confirmModalContent" style="display: none;">
    <p class="text-danger"><i class="fa fa-exclamation"></i> Are you sure to delete this scheduler?</p>
</div>

<script>
    var schedulerId = "<?php echo isset($scheduler) ? $scheduler->id : "" ?>";
    var contentId = "<?php echo isset($scheduler) ? $scheduler->content_id : "" ?>";
    var actionUrl = "<?php echo base_url(); ?>scheduler/action";
    var dt, statusSwitch;

    $(function() {
        $('#schedulerTabs a').click(function (e) {
            e.preventDefault();
            $(this).tab('show')
        });

        statusSwitch = $("input[type='checkbox']").bootstrapSwitch();

        $("#type").on("change", function() {

            $(".scheduler-content").hide();
            var type = $(this).val();
            if(type == "Custom") {
                $("#contentCustom").show();
            } else if(type == "Library") {
                $("#contentLibrary").show();
            } else if(type == "Merlin Library") {
                $("#contentMerlinLibrary").show();
            }
        });

        $('#merlin-library').on('change', function() {
            var libraryId = $(this).val();
            $.post(actionUrl, {action: 'merlin_category_option', library_id: libraryId}, function(html) {
                $('#merlin-library-category').append(html);
            });
        });

        $('#interval').on('change', function() {
            if($(this).val() == "E") {
                $('#day').parents('.form-group').hide();
                $('#date').parents('.form-group').hide();
            } else if($(this).val() == "S") {
                $('#day').parents('.form-group').hide();
                $('#date').parents('.form-group').show();
            } else {
                $('#day').parents('.form-group').show();
                $('#date').parents('.form-group').hide();
            }
        });

        $('#saveBtn').on('click', function() {

            if(validateScheduler()) {
                var validUrl = true;
                if($('#url').val()) {
                    var regex = /\b(?:(?:https?|ftp):\/\/www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i;
                    if(!regex.test($('#url').val())) {
                        validUrl = false;
                        loading('danger', "Invalid URL, make sure to add www.");
                    }
                }
                if(validUrl) {
                    loading('info', 'Saving scheduler...');
                    var data = {
                        action : 'save',
                        scheduler : {
                            module_id       : $('#module').val(),
                            status          : statusSwitch.bootstrapSwitch('state') ? "Active" : "Inactive",
                            interval_code   : $('#interval').val(),
                            time_id         : $('#time').val(),
                            day             : $('#day').val(),
                            type            : $('#type').val()
                        },
                        content : {}
                    };

                    if($('#interval').val() == 'E') {
                        data.scheduler.day = 'Everyday';
                        data.scheduler.date = '';
                    } else if($('#interval').val() == 'S') {
                        data.scheduler.date = $('#date').val();
                        data.scheduler.day = '';
                    }

                    if($('#type').val() == 'Custom') {
                        data.content.headline = $('#customHeadline').val();
                        data.content.content = $('#customBody').val();
                        data.content.keywords = $('#customKeywords').val();
                        data.content.url = $('#customUrl').val();
                        if(contentId != "") {
                            data.content.id = contentId;
                        }
                    } else if($("#type").val() == 'Library') {
                        data.scheduler.library_id = $("#library").val();
                    } else if($("#type").val() == 'Merlin Library') {
                        data.scheduler.library_id = $("#merlin-library").val();
                        data.scheduler.category_id = $("#merlin-library-category").val();
                    }

                    if(schedulerId != "") {
                        data.scheduler.id = schedulerId;
                    }


                    $.post(actionUrl, data, function(res) {
                        if(res.success) {
                            schedulerId = schedulerId == "" ? res.scheduler_id : schedulerId;
                            contentId = contentId == "" ? res.content_id : contentId;
                            $("#deleteBtn").show();
                            loading('success', "Saving successful!");
                        } else {
                            loading('danger', res.message);
                        }
                    }, 'json');
                }
            }

        });

        $("#deleteBtn").on("click", function() {
            $("#globalConfirmModalContent").html($("#confirmModalContent").html());
            $("#globalConfirmModal").find(".modal-title").html("Delete Scheduler");
            $("#globalConfirmModal").modal({
                show: true,
                backdrop: true
            });
            $("#globalConfirmBtn").off("click").on("click", function() {
                $.post(actionUrl,
                    { action: 'delete', scheduler_id: schedulerId, content_id: contentId },
                    function(res) {
                        if(res.success) {
                            window.location = base_url + "scheduler";
                        } else {
                            loading('error', res.message);
                                         }
                }, 'json');
            });
        });

        initDt();
    });


    // VALIDATE
    function validateScheduler() {
        var valid = true;
        $('#addEditForm').find('.required').each(function() {
            if ($(this).val() == "") {
                $(this).addClass('input-error');
                valid = false;
            } else {
                $(this).removeClass('input-error');
            }
        });
        var type = $("#type").val();
        if(type == "Custom") {
            if($("#customHeadline").val() == "") {
                $("#customHeadline").addClass('input-error');
                valid = false;
            } else {
                $("#customHeadline").removeClass('input-error');
            }
            if($("#customBody").val() == "") {
                $("#customBody").addClass('input-error');
                valid = false;
            } else {
                $("#customBody").removeClass('input-error');
            }
            if($("#customKeywords").val() == "") {
                $("#customKeywords").addClass('input-error');
                valid = false;
            } else {
                $("#customKeywords").removeClass('input-error');
            }
        } else if(type == "Library") {
            if($("#library").val() == "") {
                $("#library").addClass('input-error');
                valid = false;
            } else {
                $("#library").removeClass('input-error');
            }
        }
        if (!valid) {
            loading("danger", "A required field is empty.");
        }
        return valid;
    }

    function initDt() {
        dt = $("#schedulerPostsDt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [],
            "bDestroy": true,
            "filter": false,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": {action: "posts_list", scheduler_id: schedulerId}
            },
            columns: [
                {data: "date_posted"},
                {data: "module"},
                {data: "link",
                    render: function(data, type, row) {
                        return "<a target='_blank' href='" + data.toString() + "'>" +
                        "<i class='fa fa-eye'></i> " +
                        "View Post</a>";
                    }
                }
            ]
        });
    }
</script>