<!-- Begin page content -->
<div class="col-xs-10 col-xs-offset-1">
    <div class='row'>
        <div class='col-xs-12'>
            <a href="<?php echo base_url() . 'property' ?>">&Leftarrow; Return to Properties Overview</a>
            <a href="<?php echo base_url() . 'property/edit/' . $po->id ?>" class="pull-right">&Rightarrow; Edit Property</a>
            <h4><i class="fa fa-share"></i> Post Property <small>[ <?php echo $selectedModule; ?> ]</small>
                <img src="<?php echo base_url() . IMG . 'ajax-loader-3.GIF'; ?>" class="img-responsive pull-right" style="display: none;" id="loader"><span style='float: right; font-size: 12px;'>Template [ <?php echo "Regular: $next | Video: $nextVideo"; ?> ] </span></h4>
            <hr />
            <h4>Property Name: <strong><?php echo $po->name; ?></strong></h4>
            <?php
            if (isset($module)) {
                ?>
                <?php if ($module->status != "active") { ?>
                    <p class="text-danger"><i class="fa fa-exclamation"></i> You did not activated the module of this property yet. 
                <?php } else { ?>
                    <form id="post" class="form-horizontal col-xs-12">
                        <div class="form-group">
                            <label for="name" class="col-xs-3 control-label">Template Output Type
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Template Output Type"></i>
                            </label>
                            <div class="col-xs-7">
                                <select class="form-control" id="type">
                                    <option value="Regular">Regular</option>
                                    <option value="Video">Video</option>
                                </select>
                            </div>
                            <div class="col-xs-2" id="generateDiv">
                                <button type="button" class="btn btn-primary btn-block" id="generateBtn">Generate</button>
                            </div>
                            <div class="col-xs-2" id="postCompleteDiv" style="display: none;">
                                <button type="button" class="btn btn-success btn-block" id="postCompleteBtn">Post Complete</button>
                            </div>
                            <div class="col-xs-2" id="postCompleteMessageDiv" style="display: none;"></div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <div id="postMessage"></div>
                            </div>
                        </div>

                        <!-- Regular Post -->
                        <div id="craiglistRegularPost">
                            <form role="form">
                                <div class="row well well-sm">
                                    <p class="text-primary"><strong>Contact Details</strong></p>
                                    <div class="col-xs-3">
                                        <div class="form-group">
                                            <label for="text">Phone Number </label>
                                            <div class="input-group input-group-sm">
                                                <input class="form-control input-sm" id="phone" />
                                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-8 col-xs-offset-1">
                                        <div class="form-group">
                                            <label for="text">Contact Name </label>
                                            <div class="input-group input-group-sm">
                                                <input class="form-control input-sm" id="contactName" />
                                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class=" col-xs-7">
                                        <div class="form-group">
                                            <label for="text"><strong>Posting Title</strong>
                                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                                   data-toggle="popover" data-placement="top" data-content="Posting Title"></i>
                                            </label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control input-sm" id="postingTitle" placeholder="Posting Title">
                                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-xs-2 col-xs-offset-1">
                                        <div class="form-group">
                                            <label for="text"><strong>Specific Location</strong>
                                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                                   data-toggle="popover" data-placement="top" data-content="Specific Location"></i>
                                            </label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control input-sm" id="specificLocation" placeholder="Specific Location">
                                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                            <label for="text"><strong>Postal Code</strong>
                                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                                   data-toggle="popover" data-placement="top" data-content="Postal Title"></i>
                                            </label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control input-sm" id="postalCode" placeholder="Postal Title">
                                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label for="text"><strong>Posting Body</strong>
                                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                                   data-toggle="popover" data-placement="top" data-content="Posting Body"></i>
                                            </label>
                                            <div class="input-group input-group-sm">
                                                <textarea class="form-control" id="postingBody" style="height: 100px;" placeholder="Posting Body"></textarea>
                                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row well well-sm">
                                    <p class="text-primary"><strong>Posting Details</strong></p>
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                            <label for="text">Sqft </label>
                                            <div class="input-group input-group-sm">
                                                <input class="form-control input-sm" id="sqft" />
                                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                            <label for="text">Price($) </label>
                                            <div class="input-group input-group-sm">
                                                <input class="form-control input-sm" id="price" />
                                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2 col-xs-offset-1">
                                        <div class="form-group">
                                            <label for="text">Bedrooms </label>
                                            <input type="text" class="form-control input-sm" id="bedrooms" />
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                            <label for="text">Bathrooms </label>
                                            <input type="text" class="form-control input-sm" id="bathrooms" />
                                        </div>
                                    </div>
                                    <div class="col-xs-2 col-xs-offset-1">
                                        <div class="form-group">
                                            <label for="text">Housing Type </label>
                                            <input type="text" class="form-control input-sm" id="housingType" />
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                            <label for="text">Laundry </label>
                                            <input type="text" class="form-control input-sm" id="laundry" />
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                            <label for="text">Parking </label>
                                            <input type="text" class="form-control input-sm" id="parking" />
                                        </div>
                                    </div>

                                    <div class="col-xs-2  col-xs-offset-1">
                                        <div class="form-group">
                                            <label for="text">Start Time </label>
                                            <input type="text" class="form-control input-sm" id="startTime" />
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="form-group">
                                            <label for="text">End Time </label>
                                            <input type="text" class="form-control input-sm" id="endTime" />
                                        </div>
                                    </div>
                                    <div class="col-xs-2  col-xs-offset-1">
                                        <div class="form-group">
                                            <label for="text"></label>
                                            <label class="checkbox">
                                                <input type="checkbox" id="wheelchairAccessible" value="Wheelchair Accessible"> Wheelchair Access
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" id="noSmoking" value="No Smoking"> No Smoking
                                            </label>
                                            <label class="checkbox">
                                                <input type="checkbox" id="furnished" value="Furnished"> Furnished
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row well well-sm">
                                    <p class="text-primary"><strong>Other Details</strong></p>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="text">Street </label>
                                            <div class="input-group input-group-sm">
                                                <input class="form-control input-sm" id="street" />
                                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-xs-offset-1">
                                        <div class="form-group">
                                            <label for="text">Cross Street</label>
                                            <div class="input-group input-group-sm">
                                                <input class="form-control input-sm" id="crossStreet" />
                                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="form-group">
                                            <label for="text">City </label>
                                            <div class="input-group input-group-sm">
                                                <input class="form-control input-sm" id="city" />
                                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-2 col-xs-offset-1">
                                        <div class="form-group">
                                            <label for="text">State Abbr </label>
                                            <div class="input-group input-group-sm">
                                                <input class="form-control input-sm" id="stateAbbr" />
                                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </form>
                <?php } ?>
            <?php } else { ?>
                <p class="text-danger"><i class="fa fa-exclamation"></i> You did not activated the module of this property yet. 
                    <a href="<?php echo base_url() . 'property/module/' . $po->id ?>"> &Rightarrow; Go to Module</a></p>
            <?php }
            ?>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $("#propertiesLink").addClass("active");
    });
</script>