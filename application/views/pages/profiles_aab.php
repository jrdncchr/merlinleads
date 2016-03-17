<div class="container">

<a href="<?php echo base_url() . 'profiles' ?>">&Leftarrow; Return to Profiles Overview</a>
<h4 style="text-align: center; font-weight: bold;">
    <i class="fa fa-user"></i> <?php echo $h2; ?>
    <img src="<?php echo base_url() . IMG . 'ajax-loader-3.GIF'; ?>" class="img-responsive pull-right"
         style="display: none;" id="loader">
</h4>
<hr style="margin: 20px 150px;"/>
<div class="alert alert-info" id="message">
    Please fill up all required <i class="fa fa-asterisk"></i> fields.
</div>

<!-- Nav tabs -->
<ul class="nav nav-tabs" id="profileTabs">
    <li class="active"><a href="#basic" id="basicTab">Agent Info</a></li>
    <li><a href="#testimonials" id="testimonialsTab">Testimonials</a></li>
    <li><a href="#advance" id="advanceTab">Broker Info</a></li>
    <li><a href="#social" id="socialTab">Social Media</a></li>
    <li><a href="#images">Images</a></li>
    <li><a href="#activate">Activate</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content" id="all">
<!-- Basic Info Div -->
<div class="tab-pane active" id="basic">
    <br/>

    <div id="basicMessage"></div>
    <div class="col-xs-11">
        <div class="form-horizontal">
            <input type="text" value="Agent and Broker" id="profileType" class="hidden"/>
            <input type="text" value="<?php if (isset($profile)) echo $profile->status; ?>" id="status" class="hidden"/>

            <div class="form-group">
                <label for="username" class="col-xs-3 control-label">Profile Name
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter the profile name."></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="text" class="form-control required"
                           value="<?php if (isset($profile)) echo $profile->name; ?>" id="profileName"
                           placeholder="Profile Name">
                    <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                </div>
            </div>
            <div class="form-group">
                <label for="firstName" class="col-xs-3 control-label">First Name
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter profile first name."></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="text" class="form-control required"
                           value="<?php if (isset($profile)) echo $profile->firstname; ?>" id="firstname"
                           placeholder="First Name">
                    <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                </div>
            </div>
            <div class="form-group">
                <label for="lastName" class="col-xs-3 control-label">Last Name
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter profile last name."></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="text" class="form-control required"
                           value="<?php if (isset($profile)) echo $profile->lastname; ?>" id="lastname"
                           placeholder="Last Name">
                    <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-xs-3 control-label">Company
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter profile company"></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="email" class="form-control required"
                           value="<?php if (isset($profile)) echo $profile->company; ?>" id="company"
                           placeholder="Company">
                    <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-xs-3 control-label">Slogan
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter profile Slogan"></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="email" class="form-control"
                           value="<?php if (isset($profile)) echo $profile->slogan; ?>" id="slogan"
                           placeholder="Slogan">
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-xs-3 control-label">Phone
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter your profile phone."></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="text" class="form-control required"
                           value="<?php if (isset($profile)) echo $profile->phone; ?>" id="phone" placeholder="Phone">
                    <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-xs-3 control-label">Email
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter profile email or contact."></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="text" class="form-control required email"
                           value="<?php if (isset($profile)) echo $profile->email; ?>" id="email"
                           placeholder="Email or Contact">
                    <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-xs-3 control-label">Contact Webpage
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter contact webpage"></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="text" class="form-control url"
                           value="<?php if (isset($profile)) echo $profile->webpage; ?>" id="contactWebpage"
                           placeholder="Contact Webpage">
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-xs-3 control-label">Year Started
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter Year Started"></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="text" class="form-control"
                           value="<?php if (isset($profile)) echo $profile->year_started; ?>" id="yearStarted"
                           placeholder="Year Started">
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-xs-3 control-label">About
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top"
                       data-content="Couple of sentence about this profile."></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <textarea class="form-control required" style="min-height: 80px;" id="about"
                              placeholder="Couple of sentence about this profile."><?php if (isset($profile)) echo $profile->about; ?></textarea>
                    <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                </div>
            </div>
            <hr/>
            <div class="form-group">
                <label for="phone" class="col-xs-3 control-label">Link to Free search
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter link to free search"></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="text" class="form-control url" id="linkFreeSearch"
                           value="<?php if (isset($profile)) echo $profile->free_search_link; ?>"
                           placeholder="http://link-to-free-search.com">
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-xs-3 control-label">Link to all listings
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter link to all current listings"></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="text" class="form-control url"
                           value="<?php if (isset($profile)) echo $profile->current_listing_link; ?>"
                           id="linkCurrentListing" placeholder="http://link-to-all-current-listings.com">
                </div>
            </div>
            <hr/>
            <div class="form-group">
                <div class="input-group input-group-sm col-xs-12">
                    <button type="button" class="btn btn-primary pull-right x-save">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Testimonials Div -->
<div class="tab-pane" id="testimonials">
    <br/>

    <div class="form-horizontal">
        <div class="col-xs-11">
            <div id="testimonialsList">
                <?php if (isset($profile)) $testimonials = explode('|', $profile->testimonials); ?>
                <?php for ($i = 0; $i < 10; $i++) { ?>
                    <div class="form-group">
                        <label for="password" class="col-xs-3 control-label">Testimonial #<?php echo $i + 1; ?>
                            <i class="fa fa-question-circle text-info helper" data-container="body"
                               data-toggle="popover" data-placement="top" data-content="Enter a testimonial."></i>
                        </label>

                        <div class="input-group input-group-sm col-xs-9">
                            <input type="text" class="form-control x-testimonial"
                                   value="<?php if (isset($profile)) echo $testimonials[$i]; ?>"
                                   placeholder="Enter a testimonial">
                        </div>
                    </div>
                <?php } ?>
            </div>

            <hr/>
            <div class="form-group">
                <div class="input-group input-group-sm col-xs-12">
                    <button type="button" class="btn btn-primary pull-right x-save">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Broker Div -->
<div class="tab-pane" id="advance">
    <br/>

    <div id="advanceMessage"></div>
    <div class="form-horizontal">
        <div class="col-xs-11">
            <div class="form-group">
                <label for="firstName" class="col-xs-3 control-label">Company Website
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter Company Website"></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="text" class="form-control url"
                           value="<?php if (isset($profile)) echo $profile->company_website; ?>" id="companyWebsite"
                           placeholder="http://company-website.com">
                </div>
            </div>
            <div class="form-group">
                <label for="firstName" class="col-xs-3 control-label">Broker Name
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter Broker Name"></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="text" class="form-control"
                           value="<?php if (isset($profile)) echo $profile->broker_name; ?>" id="brokerName"
                           placeholder="Broker Name">
                    <!--<span class="input-group-addon"><li class="fa fa-asterisk"></li></span>-->
                </div>
            </div>
            <div class="form-group">
                <label for="firstName" class="col-xs-3 control-label">Broker Address
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter Broker Address"></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="text" class="form-control"
                           value="<?php if (isset($profile)) echo $profile->broker_address; ?>" id="brokerAddress"
                           placeholder="Broker Address">
                    <!--<span class="input-group-addon"><li class="fa fa-asterisk"></li></span>-->
                </div>
            </div>
            <div class="form-group">
                <label for="firstName" class="col-xs-3 control-label">Broker Phone
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter Broker Phone"></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="text" class="form-control"
                           value="<?php if (isset($profile)) echo $profile->broker_phone; ?>" id="brokerPhone"
                           placeholder="Broker Phone">
                    <!--<span class="input-group-addon"><li class="fa fa-asterisk"></li></span>-->
                </div>
            </div>
            <div class="form-group">
                <label for="firstName" class="col-xs-3 control-label">Broker License No.
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter Broker License No."></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="text" class="form-control"
                           value="<?php if (isset($profile)) echo $profile->broker_license; ?>" id="brokerLicenseNo"
                           placeholder="Broker License No.">
                    <!--<span class="input-group-addon"><li class="fa fa-asterisk"></li></span>-->
                </div>
            </div>
            <hr/>
            <div class="form-group">
                <div class="input-group input-group-sm col-xs-12">
                    <button type="button" class="btn btn-primary pull-right x-save">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Social Div -->
<div class="tab-pane" id="social">
    <br/>

    <div id="socialMessage"></div>
    <div class="form-horizontal">
        <div class="col-xs-11">
            <div class="form-group">
                <label for="url" class="col-xs-4 control-label">Listing Book URL
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Listing Book URL"></i>
                </label>

                <div class="input-group input-group-sm col-xs-8">
                    <input type="text" class="form-control url"
                           value="<?php if (isset($profile)) echo $profile->listing_book_url; ?>" id="listingBookUrl">
                </div>
            </div>
            <div class="form-group">
                <label for="url" class="col-xs-4 control-label">Facebook URL
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Facebook URL"></i>
                </label>

                <div class="input-group input-group-sm col-xs-8">
                    <input type="text" class="form-control url"
                           value="<?php if (isset($profile)) echo $profile->facebook_url; ?>" id="facebookUrl">
                </div>
            </div>
            <div class="form-group">
                <label for="url" class="col-xs-4 control-label">Twitter URL
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Twitter URL"></i>
                </label>

                <div class="input-group input-group-sm col-xs-8">
                    <input type="text" class="form-control url"
                           value="<?php if (isset($profile)) echo $profile->twitter_url; ?>" id="twitterUrl">
                </div>
            </div>
            <div class="form-group">
                <label for="url" class="col-xs-4 control-label">LinkedIn URL
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="LinkedIn URL"></i>
                </label>

                <div class="input-group input-group-sm col-xs-8">
                    <input type="text" class="form-control url"
                           value="<?php if (isset($profile)) echo $profile->linkedin_url; ?>" id="linkedInUrl">
                </div>
            </div>
            <div class="form-group">
                <label for="url" class="col-xs-4 control-label">Youtube Channel URL
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Youtube Channel URL"></i>
                </label>

                <div class="input-group input-group-sm col-xs-8">
                    <input type="text" class="form-control url"
                           value="<?php if (isset($profile)) echo $profile->youtube_channel_url; ?>"
                           id="youtubeChannelUrl">
                </div>
            </div>
            <hr/>
            <div class="form-group">
                <div class="input-group input-group-sm col-xs-12">
                    <button type="button" class="btn btn-primary pull-right x-save">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tab-pane" id="images">
    <form class="form-horizontal col-xs-11" role="form">
        <h3>General</h3>

        <div class="form-group">
            <?php
            if (isset($profile)) {
                $owner_image = json_decode($profile->owner_image);
            }
            ?>
            <div class="row">
                <label for="type" class="col-xs-3 control-label">Owner Image
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="User Logo used about the owner"></i>
                </label>

                <div class="col-xs-7">
                    <input type="text" class="form-control input-sm image-text" value="<?php
                    echo(isset($owner_image->text) ? $owner_image->text : "");
                    ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div id="owner_image" class="image-list">
                        <div class="show-image">
                            <div class="fileUpload ">
                                <div class="lgt-image image1" style="background-image: url('<?php
                                echo(isset($owner_image->image1) ? $owner_image->image1 : base_url() . IMG . "img-placeholder.png");
                                ?>')"></div>
                                <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i>
                                </button>
                                <span></span>
                                <input class="upload" type="file" name="files[]"
                                       data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                            </div>
                        </div>
                        <div class="show-image">
                            <div class="fileUpload ">
                                <div class="lgt-image image2" style="background-image: url('<?php
                                echo(isset($owner_image->image2) ? $owner_image->image2 : base_url() . IMG . "img-placeholder.png");
                                ?>')"></div>
                                <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i>
                                </button>
                                <span></span>
                                <input class="upload" type="file" name="files[]"
                                       data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                            </div>
                        </div>
                        <div class="show-image">
                            <div class="fileUpload ">
                                <div class="lgt-image image3" style="background-image: url('<?php
                                echo(isset($owner_image->image3) ? $owner_image->image3 : base_url() . IMG . "img-placeholder.png");
                                ?>')"></div>
                                <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i>
                                </button>
                                <span></span>
                                <input class="upload" type="file" name="files[]"
                                       data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="form-group">
            <?php
            if (isset($profile)) {
                $logo_image = json_decode($profile->logo_image);
            }
            ?>
            <div class="row">
                <label for="name" class="col-xs-3 control-label">Logo Image
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Logo about the company or property"></i>
                </label>

                <div class="col-xs-7">
                    <input type="text" class="form-control input-sm image-text" value="<?php
                    echo(isset($logo_image->text) ? $logo_image->text : "");
                    ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div id="logo_image" class="image-list">
                        <div class="show-image">
                            <div class="fileUpload">
                                <div class="lgt-image image1" style="background-image: url('<?php
                                echo(isset($logo_image->image1) ? $logo_image->image1 : base_url() . IMG . "img-placeholder.png");
                                ?>')"></div>
                                <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i>
                                </button>
                                <span></span>
                                <input class="upload" type="file" name="files[]"
                                       data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                            </div>
                        </div>
                        <div class="show-image">
                            <div class="fileUpload ">
                                <div class="lgt-image image2" style="background-image: url('<?php
                                echo(isset($logo_image->image2) ? $logo_image->image2 : base_url() . IMG . "img-placeholder.png");
                                ?>')"></div>
                                <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i>
                                </button>
                                <span></span>
                                <input class="upload" type="file" name="files[]"
                                       data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                            </div>
                        </div>
                        <div class="show-image">
                            <div class="fileUpload">
                                <div class="lgt-image image3" style="background-image: url('<?php
                                echo(isset($logo_image->image3) ? $logo_image->image3 : base_url() . IMG . "img-placeholder.png");
                                ?>')"></div>
                                <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i>
                                </button>
                                <span></span>
                                <input class="upload" type="file" name="files[]"
                                       data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?php
            if (isset($profile)) {
                $broker_image = json_decode($profile->broker_image);
            }
            ?>
            <div class="row">
                <label for="name" class="col-xs-3 control-label">Broker Logo Image
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Logo about the company or property"></i>
                </label>

                <div class="col-xs-7">
                    <input type="text" class="form-control input-sm image-text" value="<?php
                    echo(isset($broker_image->text) ? $broker_image->text : "");
                    ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div id="broker_image" class="image-list">
                        <div class="show-image">
                            <div class="fileUpload">
                                <div class="lgt-image image1" style="background-image: url('<?php
                                echo(isset($broker_image->image1) ? $broker_image->image1 : base_url() . IMG . "img-placeholder.png");
                                ?>')"></div>
                                <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i>
                                </button>
                                <span></span>
                                <input class="upload" type="file" name="files[]"
                                       data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                            </div>
                        </div>
                        <div class="show-image">
                            <div class="fileUpload ">
                                <div class="lgt-image image2" style="background-image: url('<?php
                                echo(isset($broker_image->image2) ? $broker_image->image2 : base_url() . IMG . "img-placeholder.png");
                                ?>')"></div>
                                <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i>
                                </button>
                                <span></span>
                                <input class="upload" type="file" name="files[]"
                                       data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                            </div>
                        </div>
                        <div class="show-image">
                            <div class="fileUpload">
                                <div class="lgt-image image3" style="background-image: url('<?php
                                echo(isset($broker_image->image3) ? $broker_image->image3 : base_url() . IMG . "img-placeholder.png");
                                ?>')"></div>
                                <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i>
                                </button>
                                <span></span>
                                <input class="upload" type="file" name="files[]"
                                       data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <hr/>
        <div class="col-xs-12">
            <button type="button" class="btn btn-primary save-image-btn pull-right btn-sm">Save</button>
        </div>
        <br/>

    </form>

</div>

<!-- Activate Div -->
<div class="tab-pane" id="activate">
    <br/>
    <br/>
    <?php
    if (isset($profile)) {
        if ($profile->status == "Active") {
            ?>
            <div id="deactivateDiv">
                <p class="text-warning text-center">This profile is active.</p>

                <p class='text-primary text-center'>When deactivated, this profile will no longer be available in your
                    tools profile information.</p>
                <button class='btn btn-danger btn-lg center-block' id='deactivateBtn'>Deactivate</button>
            </div>
        <?php } else { ?>
            <div id="activateDiv">
                <p class="text-warning text-center"><i class="fa fa-warning"></i>This profile is not yet activated.</p>

                <p class='text-primary text-center'>When activated, this profile will now be available in your tools
                    profile information.</p>

                <p class='text-primary text-center'>Make sure that you had filled up all required <i
                        class="fa fa-asterisk"></i> fields.</p>

                <div id='errorMessage'></div>
                <button class='btn btn-success btn-lg center-block' id='activateBtn'>Activate</button>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div id="activateDiv">
            <p class="text-warning text-center"><i class="fa fa-warning"></i> This profile is not yet activated.</p>

            <p class='text-primary text-center'>When activated, this profile will now be available in your tools profile
                information.</p>

            <p class='text-primary text-center'>Make sure that you had filled up all required <i
                    class="fa fa-asterisk"></i> fields.</p>

            <div id='errorMessage'></div>
            <button class='btn btn-success btn-lg center-block' id='activateBtn'>Activate</button>
        </div>
    <?php } ?>
</div>

</div>


</div>

<script>
    $(document).ready(function () {
        $("#profilesLink").addClass("active");
    });
</script>
