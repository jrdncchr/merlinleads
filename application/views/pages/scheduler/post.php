<style>
    .social {
        cursor: pointer;
    }
    .account-on {
        color: #00438A;
        border-bottom: 3px solid #00438A;
        padding-bottom: 2px;
    }
</style>

<h4 style="text-align: center; font-weight: bold; margin-bottom: 15px;"><i class="fa fa-file-text-o"></i> Posts</h4>

<div class="row">
    <div class="col-sm-12">
        <button id="add-btn" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Add Post</button>
        <button disabled class="btn btn-default btn-sm pull-right">Post</button>
        <a href="<?php echo base_url() . 'scheduler/category'; ?>" class="btn btn-default btn-sm pull-right" style="margin-right: 10px;">Categories</a>
<!--        <a href="--><?php //echo base_url() . 'scheduler/queue'; ?><!--" class="btn btn-default btn-sm pull-right" style="margin-right: 10px;">Queues</a>-->
        <a href="<?php echo base_url() . 'scheduler'; ?>" class="btn btn-default btn-sm pull-right" style="margin-right: 10px;">Scheduler</a>
    </div>
</div>

<div class="row" style="margin-top: 20px;">
    <div class="col-xs-12">
        <div class="table-responsive">
            <table id="schedulerContentDt" cellpadding="0" cellspacing="0" border="0" class="display table table-striped">
                <thead>
                <tr>
                    <th>Category</th>
                    <th>Facebook Snippet</th>
                    <th>LinkedIn Snippet</th>
                    <th>Twitter Snippet</th>
                    <th>URL</th>
                    <th>Date Created</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
</div>

<div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="form-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="form-modal-label">Add Post</h4>
            </div>
            <div class="modal-body" style="padding: 5px 20px;">
                <div class="notice"></div>
                <div class="checkbox">
                    <label>
                        <input id="post-otp" type="checkbox"> One time post?
                    </label>
                </div>
                <div class="row" id="date-section" style="display: none;">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="post-otp-date">* Date</label>
                            <input type="text" id="post-otp-date" class="form-control" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="post-otp-time">* Time</label>
                            <select id="post-otp-time" class="form-control">
                                <option value="">Select Time</option>
                                <?php foreach($available_times as $t): ?>
                                    <option value="<?php echo $t; ?>"><?php echo $t; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="category-section">
                    <label for="post-category">* Category</label>
                    <select id="post-category" class="form-control required">
                        <?php foreach($category as $c): ?>
                            <option value="<?php echo $c->category_id; ?>"><?php echo $c->category_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="post-facebook-snippet">* Facebook Snippet</label>
                    <textarea class="form-control required" id="post-facebook-snippet" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="post-linkedin-snippet">* LinkedIn Snippet</label>
                    <textarea class="form-control required" id="post-linkedin-snippet" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="post-twitter-snippet">* Twitter Snippet</label>
                    <textarea class="form-control required" id="post-twitter-snippet" rows="2"></textarea>
                </div>
                <div class="checkbox">
                    <label>
                        <input id="post-bp" type="checkbox"> Generate a Blog Post?
                    </label>
                </div>
                <div id="post-bp-section" class="row well" style="display: none;">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="post-bp-template"> Template</label>
                            <select id="post-bp-template" class="form-control">
                                <option value="">Select Template</option>
                                <?php foreach($templates as $t): ?>
                                    <option value="<?php echo  $t->bp_id?>"><?php echo $t->bp_template_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button id="post-bp-generate" class="btn btn-sm btn-block btn-default">Generate</button>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="post-bp-headline">* Headline</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="post-bp-headline" />
                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="post-bp-body">* Body</label>
                            <div class="input-group input-group-sm">
                                <textarea class="form-control" id="post-bp-body" style="height: 60px;"></textarea>
                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="post-bp-keywords">* Keywords</label>
                            <div class="input-group input-group-sm">
                                <textarea class="form-control" id="post-bp-keywords" style="height: 60px;"></textarea>
                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="post-url">Url</label>
                    <input type="text" class="form-control url" id="post-url" />
                </div>
                <div id="accounts-section" class="form-group" style="display: none;">
                    <label>* Accounts</label>
                    <div id="accounts">
                        <?php if(isset($main_f->facebook_feed_posting)) { ?>
                            <?php if(isset($fb['valid_access_token'])) { ?>
                                <i class="fa fa-facebook-square fa-2x social account-facebook"></i>
                            <?php } ?>
                        <?php } ?>


                        <?php if(isset($main_f->twitter_feed_posting)) { ?>
                            <?php if($twitter['has_access_key']) { ?>
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
    var actionUrl = "<?php echo base_url() . "scheduler/post_action" ?>";
    var dt, selected, selectedRows;

    $(document).ready(function() {
        initDt();

        $('#post-otp-date').datepicker({ dateFormat: 'yy-mm-dd' });

        $('#post-bp').on('change', function() {
            if($(this).is(':checked')) {
                $('#post-bp-section').slideDown('fast').find('.form-control').addClass('required');
                $('#post-url').addClass('required');
            } else {
                $('#post-bp-section').slideUp('fast').find('.form-control').removeClass('required');
                $('#post-url').removeClass('required');
            }
        });

        $('#add-btn').on('click', function() {
            $('#delete-btn').hide();
            selectedId = 0;
            var modal = $('#form-modal');
            modal.find('.modal-title').html('Add Post');
            modal.modal({
                show: true,
                keyboard: false,
                backdrop: 'static'
            });
            modal.find('.fa-facebook-square').removeClass('account-on');
            modal.find('.fa-twitter-square').removeClass('account-on');
            modal.find('.fa-linkedin-square').removeClass('account-on');
            modal.find('.modal-title').html('Add Post');
        });

        $('#post-otp').on('change', function() {
            if($(this).is(':checked')) {
                $('#date-section').show();
                $('#category-section').hide();
                $('#post-category').removeClass('required');
                $('#post-otp-date').addClass('required');
                $('#post-otp-time').addClass('required');
                $('#accounts-section').show();
            } else {
                $('#date-section').hide();
                $('#category-section').show();
                $('#post-category').addClass('required');
                $('#post-otp-date').removeClass('required');
                $('#post-otp-time').removeClass('required');
                $('#accounts-section').hide();
            }
        });

        $('#save-btn').on('click', function() {
            if(validator.validateForm($('#form-modal'))) {
                var otp = $('#post-otp').is(':checked') ? 1 : 0;
                var bp = $('#post-bp').is(':checked') ? 1 : 0;
                var data = {
                    action: 'save',
                    post: {
                        post_facebook_snippet: $('#post-facebook-snippet').val(),
                        post_twitter_snippet: $('#post-twitter-snippet').val(),
                        post_linkedin_snippet: $('#post-linkedin-snippet').val(),
                        post_url: $('#post-url').val(),
                        otp: otp,
                        bp: bp,
                        bp_headline: $('#post-bp-headline').val(),
                        bp_body: $('#post-bp-body').val(),
                        bp_keywords: $('#post-bp-keywords').val()
                    }
                };
                if(bp) {
                    data.post.bp_template = $('#post-bp-template').val();
                }
                if(otp) {
                    data.post.otp_date = $('#post-otp-date').val();
                    data.post.otp_time = $('#post-otp-time').val();
                    var modules = "";
                    $('#accounts-section').find('.social').each(function() {
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
                    data.post.otp_modules = modules;
                } else {
                    data.post.post_category_id = $('#post-category').val();
                }
                if(selectedId > 0) {
                    data.post.post_id = selectedId;
                }
                loading('info', 'Saving post...');
                $.post(actionUrl, data, function(res) {
                    if(res.success) {
                        $('#form-modal').modal('hide');
                        loading('success', 'Saving post successful!');
                        dt.fnReloadAjax();
                    }
                }, 'json');
            }

        });

        $('#delete-btn').on('click', function() {
            var ok = confirm("Are you sure to delete this post?");
            if(ok) {
                loading('info', 'Deleting post...');
                $.post(actionUrl, {action: 'delete', post_id: selectedId}, function(res) {
                    if(res.success) {
                        $('#form-modal').modal('hide');
                        loading('success', 'Deleting post successful!');
                        dt.fnReloadAjax();
                    }
                }, 'json');
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

    });

    function initDt() {
        dt = $("#schedulerContentDt").dataTable({
            "bJQueryUI": true,
            "aaSorting": [5],
            "bDestroy": true,
            "filter": true,
            "ajax": {
                "type": "POST",
                "url": actionUrl,
                "data": {action: "list"}
            },
            columns: [
                {data: "category_name", width: "20%", render: function(data, type, row) {
                    return row.otp == "1" ?
                        "<span class='text-warning'>One Time Post</span>" :
                        "<span class='text-primary'>" + data + "</span>";
                    }
                },
                {data: "post_facebook_snippet", width: "20%"},
                {data: "post_twitter_snippet", width: "20%"},
                {data: "post_linkedin_snippet", width: "20%"},
                {data: "post_url", width: "10%", render: function(data, type, row) {
                    return data ?
                        '<i class="fa fa-check text-success"></i>' :
                        '<i class="fa fa-times text-danger"></i>';
                    }
                },
                {data: "post_date_created", width: "10%"},
                {data: "post_id", visible: false},
                {data: "post_category_id", visible: false}
            ],
            "fnDrawCallback": function (oSettings) {
                var table = $("#schedulerContentDt").dataTable();
                $('#schedulerContentDt tbody tr').on('dblclick', function () {
                    var pos = table.fnGetPosition(this);
                    var data = table.fnGetData(pos);
                    showEdit(data);
                });
            }
        });
    }

    function showEdit(data) {
        selectedId = data.post_id;
        var modal = $('#form-modal');
        modal.modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });
        modal.find('.modal-title').html('Edit Post');
        modal.find('.fa-facebook-square').removeClass('account-on');
        modal.find('.fa-twitter-square').removeClass('account-on');
        modal.find('.fa-linkedin-square').removeClass('account-on');

        $('#delete-btn').show();
        $('#post-facebook-snippet').val(data.post_facebook_snippet);
        $('#post-twitter-snippet').val(data.post_twitter_snippet);
        $('#post-linkedin-snippet').val(data.post_linkedin_snippet);
        $('#post-url').val(data.post_url);

        if(data.otp == 1) {
            $('#date-section').show();
            $('#category-section').hide();
            $('#post-category').removeClass('required');
            $('#post-otp').attr('checked', 'checked').attr('checked', true);
            $('#post-otp-date').val(data.otp_date).addClass('required');
            $('#post-otp-time').val(data.otp_time).addClass('required');
            $('#accounts-section').show();

            var modules = data.otp_modules.split(',');
            for(var i = 0; i < modules.length; i++) {
                if(modules[i] == 'Facebook') {
                    modal.find('.fa-facebook-square').addClass('account-on');
                } else if(modules[i] == 'Twitter') {
                    modal.find('.fa-twitter-square').addClass('account-on');
                } else if(modules[i] == 'LinkedIn') {
                    modal.find('.fa-linkedin-square').addClass('account-on');
                }
            }
        } else {
            $('#date-section').hide();
            $('#category-section').show();
            $('#post-otp').attr('checked', false);
            $('#post-category').val(data.post_category_id).addClass('required');
            $('#post-otp-date').removeClass('required');
            $('#post-otp-time').removeClass('required');
            $('#accounts-section').hide();
        }

        if(data.bp == 1) {
            $('#post-bp').attr('checked', 'checked');
            $('#post-bp-section').slideDown('fast').find('.form-control').addClass('required');
            $('#post-url').addClass('required');
            $('#post-bp-template').val(data.bp_template);
            $('#post-bp-headline').val(data.bp_headline);
            $('#post-bp-body').val(data.bp_body);
            $('#post-bp-keywords').val(data.bp_keywords);
        } else {
            $('#post-otp').removeAttr('checked');
            $('#post-bp-section').slideUp('fast').find('.form-control').removeClass('required');
            $('#post-url').removeClass('required');
        }

    }
</script>