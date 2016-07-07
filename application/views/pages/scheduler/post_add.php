<style>
    .social {
        cursor: pointer;
    }
    .account-on {
        color: #00438A;
        border-bottom: 3px solid #00438A;
        padding-bottom: 2px;
    }
    .counter {
        color: darkgray;
        font-size: 12px;
    }
</style>
<ol class="breadcrumb">
    <li><a href="<?php echo base_url() . 'scheduler'; ?>">Scheduler</a></li>
    <li><a href="<?php echo base_url() . 'scheduler/post' ?>">Post</a></li>
    <li class="active">Add Post</li>
</ol>
<h4 style="text-align: center; font-weight: bold; margin-bottom: 15px;">Add Post</h4>

<div class="row" id="app">
    <div id="main-form">
        <div class="col-sm-12">
            <div class="notice"></div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="post-name">* Post Name</label>
                <input type="text" class="form-control required" id="post-name" v-model="form.post_name" />
            </div>
            <div class="form-group">
                <label for="post-type">* Type</label>
                <select id="post-type" class="form-control" v-model="type" v-on:change="toggleTypeView">
                    <option value="Evergreen">Evergreen</option>
                    <option value="OTP">One Time Post</option>
                </select>
            </div>
            <div class="form-group">
                <label for="post-otp-date">Use Merlin Library to generate a content: </label>
                <button v-on:click="showFormModal" class="btn-block btn btn-default btn-sm"> Merlin Library</button>
            </div>
            <div class="row" id="otp-section" style="display: none;">
                <div class="col-sm-12" style="margin-top: 15px;">
                    <div class="form-group">
                        <label for="post-otp-date">* Date</label>
                        <input type="text" id="post-otp-date" v-model="form.otp_date" class="form-control" />
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="post-otp-time">* Time</label>
                        <select v-model="form.otp_time" id="post-otp-time" class="form-control">
                            <option value="">Select Time</option>
                            <?php foreach($available_times as $t): ?>
                                <option value="<?php echo $t; ?>"><?php echo $t; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
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
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group" id="evergreen-section" style="<?php if(isset($post)) { if($post->otp == 1) { echo 'display: none;'; } } ?>">
                <label for="post-category">* Category</label>
                <select id="post-category" v-model="form.post_category_id" class="form-control required">
                    <option value="">Select Category</option>
                    <?php foreach($category as $c): ?>
                        <option value="<?php echo $c->category_id; ?>"><?php echo $c->category_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="post-url">Url</label>
                <input type="text" class="form-control url" id="post-url" v-model="form.post_url" value="{{ form.post_url }}" />
            </div>
            <div class="form-group">
                <label for="post-facebook-snippet">* Facebook Snippet</label>
                <textarea class="form-control required" v-model="form.post_facebook_snippet" id="post-facebook-snippet" rows="3">{{ form.post_facebook_snippet }}</textarea>
            </div>
            <div class="form-group">
                <label for="post-linkedin-snippet">* LinkedIn Snippet</label>
                <textarea class="form-control required" maxlength="600" v-model="form.post_linkedin_snippet" id="post-linkedin-snippet" rows="3">{{ form.post_linkedin_snippet }}</textarea>
                <span  class="pull-right counter">0/600 characters</span>
            </div>
            <div class="form-group">
                <label for="post-twitter-snippet">* Twitter Snippet</label>
                <textarea class="form-control required" maxlength="140" v-model="form.post_twitter_snippet" id="post-twitter-snippet" rows="3">{{ form.post_twitter_snippet }}</textarea>
                <span class="pull-right counter">0/140 characters</span>
            </div>
            <br />
            <button id="save-btn" class="btn btn-sm btn-success pull-right" v-on:click="savePost">Save</button>
            <?php if(isset($post->post_id)) { ?>
            <button class="btn btn-default btn-sm pull-right" v-on:click="deletePost" style="margin-right: 10px;">Delete</button>
            <?php } ?>

        </div>
    </div>


    <div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="form-modal-label">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="form-modal-label">Merlin Library - Blog Post</h4>
                </div>
                <div class="modal-body" style="padding: 20px 20px;">
                    <div class="alert alert-info"><i class="fa fa-question-circle"></i> Select your desired options and click the generate button. It will generate contents for you to post in your blog.</div>
                    <div class="notice"></div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="merlin-library-category">* Merlin Category</label>
                                        <select id="merlin-library-category" class="form-control required" v-model="form.bp_category_id" v-on:change="bpCategoryChange">
                                            <option value="">Select Category</option>
                                            <?php foreach($merlin_category as $c): ?>
                                                <option value="<?php echo $c->category_id; ?>"><?php echo $c->category_name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="merlin-library-profile">* User Profile</label>
                                        <select id="merlin-library-profile" class="form-control required" v-model="form.bp_profile_id">
                                            <option value="">Select Profile</option>
                                            <?php foreach($profile as $p): ?>
                                                <option value="<?php echo $p->id; ?>"><?php echo $p->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="merlin-library-cz">* City / Zip Code</label>
                                        <select id="merlin-library-cz" class="form-control required" v-model="form.bp_cz_id">
                                            <option value="">Select City / Zip Code</option>
                                            <?php foreach($city_zipcode as $cz): ?>
                                                <option value="<?php echo $cz->czu_cz_id;?>"><?php echo $cz->cz_city . " / " . $cz->cz_zipcode; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="post-bp-topic">* Topic</label>
                                        <select id="post-bp-topic" class="form-control required" v-model="form.bp_topic_id">
                                            <option value="">Select Topic</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button v-on:click="bpGenerate" class="btn btn-sm btn-block btn-default">Generate</button>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="alert alert-info" style="margin-bottom: 10px;"><i class="fa fa-exclamation"></i> After copying the generated content to your blog, make sure to enter you blog url here:</div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="post-bp-url">* Url</label>
                                        <input id="post-bp-url" type="text" class="form-control url" v-model="form.post_url" value="{{ form.post_url }}" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="post-bp-headline">* Headline</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" id="post-bp-headline" v-model="form.bp_headline" value="{{ form.bp_headline }}" disabled />
                                            <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="post-bp-body">* Body</label>
                                        <div class="input-group input-group-sm">
                                            <textarea class="form-control" id="post-bp-body" style="height: 60px;" v-model="form.bp_body" disabled>{{ form.bp_body }}</textarea>
                                            <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="post-bp-keywords">* Keywords</label>
                                        <div class="input-group input-group-sm">
                                            <textarea class="form-control" id="post-bp-keywords" style="height: 60px;" v-model="form.bp_keywords" disabled>{{ form.bp_keywords }}</textarea>
                                            <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="post-bp-subject-line">* Subject Line</label>
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control" id="post-bp-subject-line" v-model="form.bp_subject_line" value="{{ form.bp_subject_line }}"disabled />
                                            <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="post-bp-email-content">* Email Content</label>
                                        <div class="input-group input-group-sm">
                                            <textarea class="form-control" id="post-bp-email-content" style="height: 60px;" v-model="form.bp_email_content" disabled>{{ form.bp_email_content }}</textarea>
                                            <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success btn-sm" v-on:click="bpComplete">Complete</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    var actionUrl = "<?php echo base_url() . "scheduler/post_action" ?>";

    var data = {
        type : 'Evergreen',
        post_id: <?php echo isset($post) ? json_encode($post->post_id) : '\'\'' ?>,
        form : {
            post_name : <?php echo isset($post) ? json_encode($post->post_name) : '\'\'' ?>,
            post_category_id : <?php echo isset($post) ? json_encode($post->post_category_id) : '\'\'' ?>,
            post_facebook_snippet : <?php echo isset($post) ? json_encode($post->post_facebook_snippet) : '\'\'' ?>,
            post_twitter_snippet : <?php echo isset($post) ? json_encode($post->post_twitter_snippet) : '\'\'' ?>,
            post_linkedin_snippet : <?php echo isset($post) ? json_encode($post->post_linkedin_snippet) : '\'\'' ?>,
            post_url : <?php echo isset($post) ? json_encode($post->post_url) : '\'\'' ?>,
            otp : <?php echo isset($post) ? json_encode($post->otp) : '0' ?>,
            otp_date : <?php echo isset($post) ? json_encode($post->otp_date) : '\'\'' ?>,
            otp_time : <?php echo isset($post) ? json_encode($post->otp_time) : '\'\'' ?>,
            otp_modules : <?php echo isset($post) ? json_encode($post->otp_modules) : '\'\'' ?>,
            bp : 0,
            bp_category_id : '',
            bp_profile_id : '',
            bp_cz_id : '',
            bp_topic_id : '',
            bp_headline : '',
            bp_body : '',
            bp_keywords : '',
            bp_subject_line: '',
            bp_email_content: ''
        }
    };

    var vm = new Vue({
        el: '#app',
        data: data,
        methods: {
            toggleTypeView: function() {
                if(data.type == "OTP") {
                    data.form.otp = 1;
                    $('#otp-section').show();
                    $('#evergreen-section').hide();
                    $('#post-category').removeClass('required');
                    $('#post-otp-date').addClass('required');
                    $('#post-otp-time').addClass('required');
                    $('#accounts-section').show();
                } else {
                    data.form.otp = 0;
                    $('#otp-section').hide();
                    $('#evergreen-section').show();
                    $('#post-category').addClass('required');
                    $('#post-otp-date').removeClass('required');
                    $('#post-otp-time').removeClass('required');
                    $('#accounts-section').hide();
                }
            },
            showFormModal: function() {
                $('#form-modal').modal({
                    show: true,
                    keyboard: false,
                    backdrop: 'static'
                });
            },
            bpGenerate: function() {
                loading('info', 'Generating blog post, please wait...');
                if(validator.validateForm($('#form-modal'))) {
                    data.form.bp = 1;
                    var postData = {
                        action : 'generate',
                        topic_id : data.form.bp_topic_id,
                        profile_id : data.form.bp_profile_id,
                        area : data.form.bp_area_id
                    };
                    $.post(actionUrl, postData, function(res) {
                        data.form.bp_headline = res.headline;
                        data.form.bp_body = res.body;
                        data.form.bp_keywords = res.keywords;
                        data.form.post_facebook_snippet = res.facebook_snippet;
                        data.form.post_twitter_snippet = res.twitter_snippet;
                        data.form.post_linkedin_snippet = res.linkedin_snippet;
                        data.form.bp_subject_line = res.subject_line;
                        data.form.bp_email_content = res.email_content;
                        $('#post-bp-headline').attr('disabled', false);
                        $('#post-bp-body').attr('disabled', false);
                        $('#post-bp-keywords').attr('disabled', false);
                        $('#post-bp-subject-line').attr('disabled', false);
                        $('#post-bp-email-content').attr('disabled', false);
                        loading('success', 'Generating blog post successful!');
                    }, 'json');
                }
            },
            bpComplete: function() {
                if(validator.validateUrl($('#post-bp-url').val())) {
                    $('#form-modal').modal('hide');
                    validator.displayInputError($('#post-bp-url'), false);
                } else {
                    validator.displayInputError($('#post-bp-url'), true);
                    validator.displayAlertError($('#form-modal'), true, 'You must enter back your correct generated blog url.');
                }
            },
            bpCategoryChange: function() {
                $.post(actionUrl, {action: 'category_change', 'category_id': data.form.bp_category_id}, function(res) {
                    $('#post-bp-topic').html(res);
                });
            },
            savePost: function() {
                if(validator.validateForm($('#main-form'))) {
                    if(data.form.otp == 1) {
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
                            validator.displayAlertError($('#main-form'), true, "Select at least one account.");
                            return false;
                        }
                        data.form.otp_modules = modules;
                    }
                    loading('info', 'Saving post, please wait...');
                    $.post(actionUrl, {action: 'save', post: data.form}, function(res) {
                        if(res.success) {
                            loading('success', 'Saving post successful!');
                            setTimeout(function() {
                                window.location = base_url + 'scheduler/post';
                            }, 500);
                        }
                    }, 'json');
                }
            },
            deletePost: function() {
                var ok = confirm("Are you sure to delete this post?");
                if(ok) {
                    loading('info', 'Deleting post, please wait...');
                    $.post(actionUrl, {action: 'delete', post_id: data.post_id}, function(res) {
                        if(res.success) {
                            loading('success', 'Deleting post successful!');
                            setTimeout(function() {
                                window.location = base_url + 'scheduler/post';
                            }, 500);
                        }
                    }, 'json');
                }
            }
        }
    });

    $(function() {
        $('#post-otp-date').datepicker({ dateFormat: 'yy-mm-dd' });

        $('#post-linkedin-snippet').keyup(updateCount).keydown(updateCount);
        $('#post-twitter-snippet').keyup(updateCount).keydown(updateCount);

        function updateCount() {
            var id = $(this).attr('id');
            if(id == 'post-linkedin-snippet') {
                $(this).parent().find('.counter').html($(this).val().length + "/600 characters");
            } else if(id == 'post-twitter-snippet') {
                $(this).parent().find('.counter').html($(this).val().length + "/140 characters");
            }
        }

        $('.social').on('click', function() {
            var modal = $('#form-modal');
            if(!$(this).hasClass('account-on')) {
                $(this).addClass('account-on');
            } else {
                $(this).removeClass('account-on');
            }
        });

        <?php if(isset($post))  { ?>
            var modules = <?php echo json_encode($post->otp_modules); ?>;
        console.log(modules);
            var split = modules.split(',');
            for(var i = 0; i < split.length; i++) {

                if(split[i] == "Facebook") {
                    $('.account-facebook').addClass('account-on');
                } else if(split[i] == "Twitter") {
                    $('.account-twitter').addClass('account-on');
                }  else if(split[i] == "LinkedIn") {
                    $('.account-linkedin').addClass('account-on');
                }
            }
        <?php } ?>

    });
</script>