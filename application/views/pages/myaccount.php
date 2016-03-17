<style>
    .form-control-static {
        font-weight: bold;
    }
</style>

<a href="<?php echo base_url() . 'property' ?>">&Leftarrow; Return to Properties</a>
<h4 style="text-align: center; font-weight: bold; margin-bottom: 20px;"><i class="fa fa-user"></i> My Account</h4>


<div class="alert-info" id="message"></div>

<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li <?php echo !$redirect ? "class='active'" : '' ?>><a href="#subscription" data-toggle="tab">Subscription</a></li>
    <li><a href="#basic" data-toggle="tab">Basic</a></li>
    <li><a href="#passwordDiv" data-toggle="tab">Password</a></li>
    <li <?php echo $redirect != '' ? "class='active'" : '' ?>><a href="#advance" data-toggle="tab">Integrations</a></li>
    <li><a href="#card" data-toggle="tab">Card</a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane <?php echo !$redirect ? 'active' : '' ?>" id="subscription">

        <div class="row">
            <div class="col-xs-12" style="margin-top: 20px;">
                <a href="<?php echo base_url() . "main/upgrade"; ?>" class="btn btn-sm btn-primary"><i
                        class="fa fa-shopping-cart"></i> Upgrade Subscription</a>

                <?php if(isset($subscriptions)) { ?>
                    <?php
                    if(isset($_SESSION['message'])) { ?>
                        <div class='alert alert-danger'>
                            <i class="fa fa-exclamation"></i>
                            <?php
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                            ?>

                        </div>
                    <?php } ?>

                <?php } else { ?>
                    <div class="alert alert-info">You don't have any subscription yet, <a href="<?php echo base_url() . "main/upgrade"; ?>"> Upgrade Now.</a></div>
                <?php } ?>
            </div>

            <div class="col-xs-6" style="margin-top: 10px;">

                <div class="panel panel-default">
                    <div class="panel-heading">Plan</div>
                    <div class="panel-body">
                        <?php
                        if(isset($subscriptions)) {
                            for ($i = 0; $i < sizeof($subscriptions); $i++) {
                                ?>

                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Name:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-static"><?php echo $subscriptions[$i]->plan->name; ?></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Properties:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-static"><?php echo $property_count . " / " . $subscriptions[$i]->plan->features->number_of_properties; ?></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Profiles:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-static"><?php echo $profile_count . " / " .$subscriptions[$i]->plan->features->number_of_profiles; ?></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Start Date:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-static"><?php echo date("F d, Y \a\\t H:i", $subscriptions[$i]->start); ?></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">End Date:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-static"><?php echo date("F d, Y \a\\t H:i", $subscriptions[$i]->current_period_end); ?></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"></label>
                                        <div class="col-sm-9">
                                            <form action="<?php echo base_url() . 'stripe_api/cancel_subscription' ?>" method="POST" onsubmit="return confirm('Cancel subscription confirmation.');">
                                                <input type="text" value="<?php echo $subscriptions[$i]->id; ?>" name="id" style="display: none;" />
                                                <input type="text" value="<?php echo $subscriptions[$i]->plan->name; ?>" name="planName" style="display: none;" />
                                                <button class="btn btn-default btn-sm">Cancel Subscription</i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            }
                        } ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-xs-12">

                </div>
            </div>
        <!-- <h6>Addons</h6>
                        <?php if (isset($user_addons)) { ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Addon</th>
                                    <th>Properties</th>
                                    <th>Profiles</th>
                                    <th>Start date</th>
                                    <th>End date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user_addons as $addon) { ?>
                                <tr>
                                    <td>
                                        <b><?php echo $addon->addon_name; ?></b>
                                    </td>
                                    <td>
                                        <?php echo $addon->number_of_property; ?>
                                    </td>
                                    <td>
                                        <?php echo $addon->number_of_profile; ?>
                                    </td>
                                    <td>
                                        <?php echo date_format(date_create($addon->start_date), "F d, Y \a\\t H:iA"); ?>
                                    </td>
                                    <td>
                                        <?php echo date_format(date_create($addon->end_date), "F d, Y \a\\t H:iA"); ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php } else { ?>
                        <p><small><i>You don't have any addons yet.</i></small></p>
                        <?php } ?> -->
        <div class="row" style="display: none;">
            <div class="col-xs-5">
                <p><i>Pausing an account will disable auto posting, and all the details on this account will not be changed.</i></p>
                <button class="btn btn-sm btn-danger">Pause Account</button>

            </div>
        </div>


</div>
<!-- Basic Info Div -->
<div class="tab-pane" id="basic">
    <br/>
    <h4 style="font-weight: bold;">Basic Information</h4>

    <div class="col-xs-9 col-xs-offset-1">
        <div class="form-horizontal">
            <div class="form-group">
                <div class="input-group input-group-sm col-xs-12">
                    <div id="basicMessage"></div>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-xs-3 control-label">Email Address
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top"
                       data-content="Enter your email address."></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="email" class="form-control required"
                           value='<?php echo $user->email; ?>' id="email"
                           placeholder="Email Address" disabled>
                    <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                </div>
            </div>
            <div class="form-group">
                <label for="firstName" class="col-xs-3 control-label">First Name
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter you first name."></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="text" class="form-control required" value='<?php echo $user->firstname; ?>'
                           id="firstname" placeholder="First Name">
                    <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                </div>
            </div>
            <div class="form-group">
                <label for="lastName" class="col-xs-3 control-label">Last Name
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter you last name."></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="text" class="form-control required" value='<?php echo $user->lastname; ?>'
                           id="lastname" placeholder="Last Name">
                    <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                </div>
            </div>
            <div class="form-group">
                <label for="phone" class="col-xs-3 control-label">Primary Phone
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter your primary phone."></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="text" class="form-control required" value='<?php echo $user->phone; ?>' id="phone"
                           placeholder="Primary Phone">
                    <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                </div>
            </div>
            <hr/>
            <div class="form-group">
                <label for="country" class="col-xs-3 control-label">Country
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Select from the dropdown"></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <select class="form-control required" id="country">
                        <option value="">-- Select Country --</option>
                        <option
                            value="United States" <?php if ($user->country == "United States") echo "selected='selected'"; ?>>
                            United States
                        </option>
                        <option value="Canada" <?php if ($user->country == "Canada") echo "selected='selected'"; ?>>
                            Canada
                        </option>
                    </select>
                    <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                </div>
            </div>
            <div class="form-group">
                <label for="state" class="col-xs-3 control-label">State / Provice
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Select from the dropdown"></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <select class="form-control" id="state"><?php echo $states; ?></select>
                    <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                </div>
            </div>
            <hr/>
            <div class="form-group">
                <div class="input-group input-group-sm col-xs-12">
                    <button type="button" id="updateBasicInfoBtn" class="btn btn-primary pull-right">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Password Div -->
<div class="tab-pane" id="passwordDiv">
    <br/>

    <div class="col-xs-9 col-xs-offset-1">
        <h4 style="font-weight: bold;">Change Password</h4>

        <div class="form-horizontal">
            <div class="form-group">
                <div class="input-group input-group-sm col-xs-12">
                    <div id="passwordMessage"></div>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-xs-3 control-label">Password
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter your current password."></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="password" class="form-control" id="currentPassword" placeholder="Current Password">
                    <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-xs-3 control-label">New Password
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter your new password."></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="password" class="form-control" id="newPassword" placeholder="New Password"/>
                    <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-xs-3 control-label">Confirm Password
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top"
                       data-content="Re-type your password for confirmation."></i>
                </label>

                <div class="input-group input-group-sm col-xs-9">
                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password"/>
                    <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                </div>
            </div>
            <hr/>
            <div class="form-group">
                <div class="input-group input-group-sm col-xs-12">
                    <button type="button" id="updatePasswordBtn" class="btn btn-primary pull-right">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Advance Div -->
<div class="tab-pane <?php echo $redirect ? 'active' : '' ?>" id="advance">
    <div class="tabbable tabs-left" style="margin-top: 20px; text-overflow: ellipsis">
        <ul class="nav nav-tabs">
            <li <?php echo ($redirect == "twitter" || $redirect == "" || $redirect == "integrations") ? ' class="active"' : '' ?>><a href="#integration-twitter" data-toggle="tab">Twitter</a></li>
            <li <?php echo $redirect == 'facebook' ? "class='active'" : '' ?>><a href="#integration-facebook" data-toggle="tab">Facebook</a></li>
            <li <?php echo $redirect == 'linkedin' ? "class='active'" : '' ?>><a href="#integration-linkedin" data-toggle="tab">Linked In</a>
        </ul>

        <div class="tab-content">
            <!-- Twitter -->
            <div class="tab-pane <?php echo ($redirect == "twitter" || $redirect == "" || $redirect == "integrations") ? 'active' : '' ?>" id="integration-twitter" style="margin-left: 145px;">
                <?php
                if(isset($main_f->twitter_feed_posting)) { ?>
                    <?php if($twitter['has_access_key']) { ?>
                        <p class="text-success"><i class="fa fa-check-circle"></i> You have authorized Twitter integration into your account! </p>
                        <img class="img img-thumbnail" src="<?php echo $twitter['user_info']->profile_image_url ?>" />
                        <?php echo $twitter['user_info']->description; ?>
                        <br /><br />
                    <?php } ?>
                    <p><i>Authorize your Twitter</i></p>
                    <a class="btn btn-sm btn-primary" href="<?php echo $twitter['auth_url']; ?>"><i class="fa fa-twitter-square"></i> Authorize Twitter Posting</a>
                <?php } else { ?>
                    <p class="text-warning"><i class="fa fa-exclamation-circle"></i> Sorry your package/plan doesn't allow you to use this feature.</p>
                    <a href="<?php echo base_url() . "main/upgrade"; ?>" class="btn btn-sm btn-primary"><i
                            class="fa fa-shopping-cart"></i> Upgrade Subscription</a></h4>
                <?php } ?>
            </div>

            <!-- Facebook -->
            <div class="tab-pane <?php echo $redirect == 'facebook' ? 'active' : '' ?>" id="integration-facebook">
                <?php
                if(isset($main_f->facebook_feed_posting)) { ?>
                    <?php if(isset($fb['valid_access_token'])) { ?>
                        <p class="text-success"><i class="fa fa-check-circle"></i> You have authorized Facebook integration into your account! </p>
                        <p>Expiry Date: <b><?php echo $fb['expires_at']; ?></b></p>
                        <img class="img img-thumbnail" src="//graph.facebook.com/<?php echo $fb['user']['id']?>/picture" />
                        <?php echo $fb['user']['name']; ?>
                        <br /><br />
                        <p><i>Authorize your Facebook integration again before it expires.</i></p>
                        <a class="btn btn-sm btn-primary" href="<?php echo $fb['login_url']; ?>"><i class="fa fa-facebook-square"></i> Authorize Facebook Posting</a>
                    <?php } else { ?>
                        <?php if(isset($fb['expired_access_token'])) { ?>
                            <p class="text-warning">Your Facebook access token had already expired, please authorize your Facebook again.</p>
                        <?php } else { ?>
                            <p class="text-warning">You have NOT yet authorized Facebook integration into your account yet.</p>
                        <?php } ?>

                        <a class="btn btn-sm btn-primary" href="<?php echo $fb['login_url']; ?>"><i class="fa fa-facebook-square"></i> Authorize Facebook Posting</a>
                    <?php }  ?>
                <?php } else { ?>
                    <p class="text-warning"><i class="fa fa-exclamation-circle"></i> Sorry your package/plan doesn't allow you to use this feature.</p>
                    <a href="<?php echo base_url() . "main/upgrade"; ?>" class="btn btn-sm btn-primary"><i
                            class="fa fa-shopping-cart"></i> Upgrade Subscription</a></h4>
                <?php } ?>
            </div>

            <!-- Linked In -->
            <div class="tab-pane <?php echo $redirect == 'linkedin' ? 'active' : '' ?>" id="integration-linkedin">
                <?php
                if(isset($main_f->linkedin_feed_posting)) { ?>
                    <?php if(isset($linkedIn['access_token'])) { ?>
                        <?php if(!$linkedIn['expired_access_token']) { ?>
                            <p class="text-success"><i class="fa fa-check-circle"></i> You have authorized LinkedIn integration into your account! </p>
                            <p>Expiry Date: <b><?php echo $linkedIn['expires_at']; ?></b></p>
                            <img class="img img-thumbnail" src="<?php echo $linkedIn['user']->pictureUrl; ?>" />
                            <?php echo $linkedIn['user']->formattedName; ?>
                            <br /><br />
                            <p><i>Authorize your LinkedIn integration again before it expires.</i></p>
                        <?php } else { ?>
                            <p class="text-warning">Your LinkedIn access token had already expired, please authorize your LinkedIn again.</p>
                        <?php }  ?>
                    <?php } else {  ?>
                        <p class="text-warning">You have NOT yet authorized LinkedIn integration into your account yet.</p>
                    <?php } ?>
                    <a href="<?php echo $linkedIn['auth_url']; ?>" class="btn btn-sm btn-primary"><i class="fa fa-linkedin-square"></i> Authorize LinkedIn Posting</a>
                <?php } else { ?>
                    <p class="text-warning"><i class="fa fa-exclamation-circle"></i> Sorry your package/plan doesn't allow you to use this feature.</p>
                    <a href="<?php echo base_url() . "main/upgrade"; ?>" class="btn btn-sm btn-primary"><i
                            class="fa fa-shopping-cart"></i> Upgrade Subscription</a></h4>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Card Div -->
<div class="tab-pane" id="card">
<br/>

<div class="col-xs-8 col-xs-offset-2">
<div class="form-horizontal" id="cardForm">
<div class="form-group">
    <div class="input-group input-group-sm col-xs-12">
        <h4 style="font-weight: bold;">Card Information
            <a id="showCreateCard" class="pull-right" style="cursor: pointer;"><small>Create/Change Card</small></a>
            <a id="showRetrieveCard" class="pull-right" style="cursor: pointer; display:none;"><small>Show Old/Current Card</small></a>
        </h4>
    </div>
</div>

<div class="form-group">
    <div class="input-group input-group-sm col-xs-12">
        <div id="cardMessage"></div>
    </div>
</div>

<div id="createCardDiv" style="display: none;">
    <div class="form-group">
        <label for="card_number" class="col-xs-3 control-label">Card Number
            <i class="fa fa-question-circle text-info helper" data-container="body"
               data-toggle="popover" data-placement="top" data-content="The card number, as a string without any separators."></i>
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="number" class="form-control" id="card_number" />
            <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
        </div>
    </div>

    <div class="form-group">
        <label for="cvc" class="col-xs-3 control-label">CVC
            <i class="fa fa-question-circle text-info helper" data-container="body"
               data-toggle="popover" data-placement="top" data-content="Card security code."></i>
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="number" class="form-control" id="cvc" "/>
        </div>
    </div>

    <div class="form-group">
        <label for="exp_month" class="col-xs-3 control-label">Expiration Month
            <i class="fa fa-question-circle text-info helper" data-container="body"
               data-toggle="popover" data-placement="top" data-content="Two digit number representing the card's expiration month."></i>
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="number" class="form-control" min="1" max="2" id="exp_month" placeholder="MM"/>
            <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
        </div>
    </div>

    <div class="form-group">
        <label for="exp_year" class="col-xs-3 control-label">Expiration Year
            <i class="fa fa-question-circle text-info helper" data-container="body"
               data-toggle="popover" data-placement="top" data-content="Two or four digit number representing the card's expiration year."></i>
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="number" class="form-control" min="4" max="4" id="exp_year" placeholder="YYYY"/>
            <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
        </div>
    </div>

    <div class="form-group">
        <label for="cardholder_name" class="col-xs-3 control-label">Name
            <i class="fa fa-question-circle text-info helper" data-container="body"
               data-toggle="popover" data-placement="top" data-content="Cardholder's full name."></i>
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="text" class="form-control" id="cardholder_name"/>
        </div>
    </div>

    <div class="form-group">
        <label for="address" class="col-xs-3 control-label">Address City</label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="text" id="address_city" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label for="address" class="col-xs-3 control-label">Address Country
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="text" id="address_country" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label for="address" class="col-xs-3 control-label">Address Line 1
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="text" id="address_line1" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label for="address" class="col-xs-3 control-label">Address Line 2
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="text" id="address_line2" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label for="address" class="col-xs-3 control-label">Address State
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="text" id="address_state" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label for="address" class="col-xs-3 control-label">Address Zip
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="number" id="address_zip" class="form-control" />
        </div>
    </div>

    <div class="form-group">
        <div class="input-group input-group-sm col-xs-12">
            <button type="button" id="saveCardBtn" class="btn btn-primary pull-right">Save Card</button>
        </div>
    </div>
</div>

<div id="retrieveCardDiv">
    <div class="form-group" id="last4Div">
        <label for="last4" class="col-xs-3 control-label">Last 4</label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="number" class="form-control" value="<?php if(isset($card->last4)) { echo $card->last4; } ?>" readonly="true"/>
        </div>
    </div>

    <div class="form-group">
        <label for="exp_month" class="col-xs-3 control-label">Expiration Month
            <i class="fa fa-question-circle text-info helper" data-container="body"
               data-toggle="popover" data-placement="top" data-content="Two digit number representing the card's expiration month."></i>
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="number" id="u_exp_month" min="1" max="2" class="form-control" placeholder="MM" value="<?php if(isset($card->exp_month)) { echo $card->exp_month; } ?>" />
            <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
        </div>
    </div>

    <div class="form-group">
        <label for="exp_year" class="col-xs-3 control-label">Expiration Year
            <i class="fa fa-question-circle text-info helper" data-container="body"
               data-toggle="popover" data-placement="top" data-content="Two or four digit number representing the card's expiration year."></i>
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="number" id="u_exp_year" min="4" max="4" class="form-control" placeholder="YYYY" value="<?php if(isset($card->exp_year)) { echo $card->exp_year; } ?>" />
            <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
        </div>
    </div>
    <div class="form-group">
        <label for="cardholder_name" class="col-xs-3 control-label">Name
            <i class="fa fa-question-circle text-info helper" data-container="body"
               data-toggle="popover" data-placement="top" data-content="Cardholder's full name."></i>
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="text" id="u_cardholder_name" class="form-control" value="<?php if(isset($card->name)) { echo $card->name; } ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="address" class="col-xs-3 control-label">Address City</label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="text" id="u_address_city" class="form-control" value="<?php if(isset($card->address_city)) { echo $card->address_city; } ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="address" class="col-xs-3 control-label">Address Country
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="text" id="u_address_country" class="form-control" value="<?php if(isset($card->address_country)) { echo $card->address_country; } ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="address" class="col-xs-3 control-label">Address Line 1
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="text" id="u_address_line1" class="form-control" value="<?php if(isset($card->address_line1)) { echo $card->address_line1; } ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="address" class="col-xs-3 control-label">Address Line 2
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="text" id="u_address_line2" class="form-control" value="<?php if(isset($card->address_line2)) { echo $card->address_line2; } ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="address" class="col-xs-3 control-label">Address State
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="text" id="u_address_state" class="form-control" value="<?php if(isset($card->address_state)) { echo $card->address_state; } ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="address" class="col-xs-3 control-label">Address Zip
        </label>
        <div class="input-group input-group-sm col-xs-9">
            <input type="number" id="u_address_zip" class="form-control" value="<?php if(isset($card->address_zip)) { echo $card->address_zip; } ?>"/>
        </div>
    </div>
    <div class="form-group">
        <div class="input-group input-group-sm col-xs-12">
            <button type="button" id="updateCardBtn" class="btn btn-primary pull-right">Update Card</button>
        </div>
    </div>
</div>

</div>
</div>
</div>

</div>
<script>
    $(document).ready(function () {
        $("#myAccountLink").addClass("active");
    });
</script>
