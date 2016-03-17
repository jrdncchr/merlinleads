<!-- Begin page content -->
<div class="col-xs-12">
    <div class='row'>
        <div class='col-xs-12'>
            <a href="<?php echo base_url() . 'property' ?>">&Leftarrow; Return to Properties Overview</a>
            <h4><i class="fa fa-share"></i> Post Property <small>[ <?php echo $selectedModule; ?> ]</small></h4>
            <hr />
            <h4>Property Name: <strong><?php echo $po->name; ?></strong></h4>
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <div class="col-xs-12">
                        <div id="postMessage"></div>
                    </div>
                    <div class="col-xs-12">
                        <div role="tabpanel">

                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#basic" aria-controls="home" role="tab" data-toggle="tab">Basic</a></li>
                                <li role="presentation" style="display: none;"><a href="#autopost" aria-controls="profile" role="tab" data-toggle="tab">Auto Post</a></li>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="basic">
                                    <div class="col-md-6">
                                        <form role="form">
                                            <div class="form-group">
                                                <div id="basicMessage"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="templateNo">Templates</label>
                                                <select id="templateNo" class="form-control">
                                                    <?php
                                                    if(isset($template_count)) {
                                                        for($i = 1; $i <= $template_count; $i++) {?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i == 1 ? "Main" : $i; ?></option>
                                                        <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="tweet">Tweet</label>
                                                <div class="input-group input-group-sm">
                                                    <textarea class="form-control input-sm" id="tweet" style="min-height: 80px;"></textarea>
                                                    <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary" type="button" id="generateBtn">Generate</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="autopost">
                                    <?php if ($user->advance_twitter_verified) { ?>
                                        <div class="col-xs-4">
                                            <h5>URL to include in the tweet:</h5>
                                            <div class="radio">
                                                <label><input type="radio" id="rbProperty" name="option" value="Property Website" checked="true"> Use the Property Site URL from Property Details</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" id="rbCustom" name="option" value="Custom"> Input Custom URL</label>
                                            </div>
                                            <input type="text" class="form-control" id="customUrl" disabled="true" />
                                            <hr />
                                            <p style="font-weight: lighter;">This module will automatically tweet once a day in your provided twitter account. The tweet will include a keyword from the Property Details and a Shortened Link from the above option.</p>
                                            <?php if(!$twitter_module->autopost) { ?>
                                                <button type="button" class="btn btn-primary" id="enableBtn">Enable Auto Post</button>
                                                <button type="button" class="btn btn-danger" id="disableBtn" style="display: none;">Disable Auto Post</button>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-primary" id="enableBtn" style="display: none;">Enable Auto Post</button>
                                                <button type="button" class="btn btn-danger" id="disableBtn">Disable Auto Post</button>
                                            <?php }    ?>

                                        </div>
                                        <div class="col-xs-8">
                                            <h5>Latest Tweets</h5>
                                            <table class="table table-responsive table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Date Posted</th>
                                                    <th>Tweet</th>
                                                    <th>Url Link</th>
                                                </tr>
                                                </thead>

                                                <?php
                                                if ($tweets) {
                                                    foreach ($tweets as $t) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $t->date_created; ?></td>
                                                            <td><?php echo $t->tweet; ?></td>
                                                            <td><?php echo $t->url; ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-xs-12 alert alert-danger"><i class="fa fa-exclamation"></i> You do not have the requirements for this module yet, please setup your twitter credentials found in the <a href="<?php echo base_url() . "main/myaccount" ?>">My Account Advance tab.</a></div>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#propertiesLink").addClass("active");
    });
</script>