<!-- Begin page content -->
<div class="col-xs-10">
    <div class='row'>
        <div class='col-xs-12'>
            <a href="<?php echo base_url() . 'property' ?>">&Leftarrow; Return to Properties Overview</a>
            <a href="<?php echo base_url() . 'property/edit/' . $po->id ?>" class="pull-right">&Rightarrow; Edit Property</a>
            <h3><i class="fa fa-share"></i> Edit Property Module <small>[ <?php echo $selectedModule; ?> ]</small>
                <img src="<?php echo base_url() . IMG . 'ajax-loader-3.GIF'; ?>" class="img-responsive pull-right" style="display: none;" id="loader"></h3>
            <hr />

            <h4>Property Name: <strong><?php echo $po->name; ?></strong></h4>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="module-tabs">
                <li class="active"><a href="#moduleBasics">Basics</a></li>
                <li><a href="#headlineStatements">Headline Statements</a></li>
                <li><a href="#callToAction">Call to Action</a></li>
                <li><a href="#openHouse">Open House</a></li>
                <li><a href="#optionalFields">Optional Fields</a></li>
                <li><a href="#video">Video</a></li>
                <li><a href="#moduleActivate">Activate</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">

                <!-- General -->
                <div class="tab-pane fade in active" id="moduleBasics">
                    <h3>General</h3>
                    <form class="form-horizontal col-xs-11">
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <div id="basicsMessage"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" id="status" style="display: none;" value="<?php
                            if (isset($module)) {
                                echo $module->status;
                            }
                            ?>" />
                            <label for="name" class="col-xs-3 control-label">Price
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Price"></i>
                            </label>
                            <div class="input-group input-group-sm col-xs-9">
                                <input type="text" id="price" class="form-control" value="<?php
                                if (isset($module)) {
                                    echo $module->price;
                                }
                                ?>" placeholder="Price" />
                                <!--<span class="input-group-addon"><li class="fa fa-asterisk"></li></span>-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-xs-3 control-label">Housing Type
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Housing Type"></i>
                            </label>
                            <div class="input-group input-group-sm col-xs-9">
                                <select id="housingType" class="form-control"><?php echo $housing_type; ?></select>
                                <!--<span class="input-group-addon"><li class="fa fa-asterisk"></li></span>-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-xs-3 control-label">Bath
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Bath"></i>
                            </label>
                            <div class="input-group input-group-sm col-xs-9">
                                <select id="bath" class="form-control"><?php echo $bath; ?></select>
                                <!--<span class="input-group-addon"><li class="fa fa-asterisk"></li></span>-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-xs-3 control-label">Laundry
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Laundry"></i>
                            </label>
                            <div class="input-group input-group-sm col-xs-9">
                                <select id="laundry" class="form-control"><?php echo $laundry; ?></select>
                                <!--<span class="input-group-addon"><li class="fa fa-asterisk"></li></span>-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-xs-3 control-label">Parking
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Parking"></i>
                            </label>
                            <div class="input-group input-group-sm col-xs-9">
                                <select id="parking" class="form-control"><?php echo $parking; ?></select>
                                <!--<span class="input-group-addon"><li class="fa fa-asterisk"></li></span>-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-xs-3 control-label">Others
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Others"></i>
                            </label>
                            <div class="input-group input-group-sm col-xs-9">
                                <div class="checkbox">
                                    <label>
                                        <input id="wheelchairAccessible" type="checkbox" <?php
                                        if (isset($module)) {
                                            if ($module->wheelchair_accessible == "yes") {
                                                echo "checked";
                                            }
                                        }
                                        ?>> Wheelchair accessible
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input id="noSmoking" type="checkbox" <?php
                                        if (isset($module)) {
                                            if ($module->no_smoking == "yes") {
                                                echo "checked";
                                            }
                                        }
                                        ?>> No smoking
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input id="furnished" type="checkbox" <?php
                                        if (isset($module)) {
                                            if ($module->furnished == "yes") {
                                                echo "checked";
                                            }
                                        }
                                        ?>> Furnished
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-xs-3 control-label">Cross Street
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Cross Street"></i>
                            </label>
                            <div class="input-group input-group-sm col-xs-9">
                                <textarea id="crossStreet" class="form-control" style="height: 80px"><?php
                                    if (isset($module)) {
                                        echo $module->cross_street;
                                    }
                                    ?></textarea>
                                <!--<span class="input-group-addon"><li class="fa fa-asterisk"></li></span>-->
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <button type="button" class="btn btn-primary btn-save-module pull-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Headline Statements -->
                <div class="tab-pane fade in" id="headlineStatements">
                    <button type="button" class="btn btn-primary btn-sm pull-right" data-backdrop="static" data-keyboard="false" data-toggle="modal"  data-target="#hsModal">Headline Library</button>
                    <h3>Headline Statements</h3>
                    <form class="form-horizontal col-xs-11">
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <div id="headlineStatementsMessage"></div>
                            </div>
                        </div>
                        <?php
                        if (isset($module)) {
                            $hs = explode('|', $module->headline_statements);
                        }
                        for ($i = 1; $i <= 10; $i++) {
                            ?>
                            <div class="form-group">
                                <label for="name" class="col-xs-3 control-label">Headline Statement #<?php echo $i; ?>
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="Headline Statement"></i>
                                </label>
                                <div class="input-group input-group-sm col-xs-9">
                                    <input type="text" class="form-control required x-hs" value="<?php
                                    if (isset($module)) {
                                        echo $hs[$i - 1];
                                    }
                                    ?>" placeholder="Headline Statement">
                                    <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                                </div>
                            </div>
                        <?php } ?>
                        <hr />
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <button type="button" class="btn btn-primary btn-save-module pull-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Call to Action -->
                <div class="tab-pane fade in" id="callToAction">
                    <button class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#ctaModal" data-backdrop="static" data-keyboard="false" >Call To Action Library</button>
                    <h3>Call to Action</h3>
                    <form class="form-horizontal col-xs-11">
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <div id="callToActionMessage"></div>
                            </div>
                        </div>
                        <?php
                        if (isset($module)) {
                            $cta = explode('|', $module->cta);
                        }
                        for ($i = 1; $i <= 10; $i++) {
                            ?>
                            <div class="form-group">
                                <label for="name" class="col-xs-3 control-label">Call to Action #<?php echo $i; ?>
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="Call to Action"></i>
                                </label>
                                <div class="input-group input-group-sm col-xs-9">
                                    <input type="text" class="form-control required x-cta" value="<?php
                                    if (isset($module)) {
                                        echo $cta[$i - 1];
                                    }
                                    ?>" placeholder="Call to Action">
                                    <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                                </div>
                            </div>
                        <?php } ?>
                        <hr />
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <button type="button" class="btn btn-primary btn-save-module pull-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Open House -->
                <div class="tab-pane fade in" id="openHouse">
                    <h3>Open House</h3>
                    <form class="form-horizontal col-xs-11">
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <div id="openHouseMessage"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-xs-3 control-label">Date
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Date"></i>
                            </label>
                            <div class="input-group input-group-sm col-xs-9">
                                <input type="text" class="form-control" id="ohDate" value="<?php
                                if (isset($module)) {
                                    echo $module->oh_date;
                                }
                                ?>" placeholder="Click to select a Date">
                                <input type="text" id="ohDateValue" class="hidden" value="<?php
                                if (isset($module)) {
                                    echo $module->oh_date;
                                }
                                ?>">
                                <!--<span class="input-group-addon"><li class="fa fa-asterisk"></li></span>-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-xs-3 control-label">Start Time
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Start Time"></i>
                            </label>
                            <div class="input-group input-group-sm col-xs-9">
                                <input type="text" class="form-control" id="ohStartTime" value="<?php
                                if (isset($module)) {
                                    echo $module->oh_start_time;
                                }
                                ?>" placeholder="Starting Time">
                                <!--<span class="input-group-addon"><li class="fa fa-asterisk"></li></span>-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-xs-3 control-label">End Time
                                <i class="fa fa-question-circle text-info helper" data-container="End Time" 
                                   data-toggle="popover" data-placement="top" data-content="Date"></i>
                            </label>
                            <div class="input-group input-group-sm col-xs-9">
                                <input type="text" class="timepicker-2 form-control" id="ohEndTime" value="<?php
                                if (isset($module)) {
                                    echo $module->oh_end_time;
                                }
                                ?>" placeholder="End Time">
                                <!--<span class="input-group-addon"><li class="fa fa-asterisk"></li></span>-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-xs-3 control-label">Open House Notes
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Open House Notes"></i>
                            </label>
                            <div class="input-group input-group-sm col-xs-9">
                                <textarea class="form-control" style="height: 100px;" id="ohNotes" placeholder="Open House Notes"><?php
                                    if (isset($module)) {
                                        echo $module->oh_notes;
                                    }
                                    ?></textarea>
                                <!--<span class="input-group-addon"><li class="fa fa-asterisk"></li></span>-->
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <button type="button" class="btn btn-primary btn-save-module pull-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Optional Fields -->
                <div class="tab-pane fade in" id="optionalFields">
                    <h3>Optional Fields</h3>
                    <form class="form-horizontal col-xs-11">
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <div id="optionalFieldsMessage"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-xs-3 control-label">Ad Tags
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Ad Tags"></i>
                            </label>
                            <div class="input-group input-group-sm col-xs-9">
                                <textarea class="form-control" style="height: 100px;" id="ofAdTags" placeholder="Ad Tags"><?php
                                    if (isset($module)) {
                                        echo $module->ad_tags;
                                    }
                                    ?></textarea>
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <button type="button" class="btn btn-primary btn-save-module pull-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Video -->
                <div class="tab-pane fade in" id="video">
                    <h3>Video</h3>
                    <form class="form-horizontal col-xs-11">
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <div id="videoMessage"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-xs-3 control-label">Youtube URL
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Youtube URL"></i>
                            </label>
                            <div class="input-group input-group-sm col-xs-9">
                                <input type="text" class="form-control url" id="videoYoutubeUrl" value="<?php
                                if (isset($module)) {
                                    echo $module->youtube_url;
                                }
                                ?>" placeholder="Youtube URL">
                                <!--<span class="input-group-addon"><li class="fa fa-asterisk"></li></span>-->
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <button type="button" class="btn btn-primary btn-sm pull-right"  data-toggle="modal" data-target="#vtModal" data-backdrop="static" data-keyboard="false">Video Term Library</button>
                                <h4>Headline Statements</h4>
                            </div>
                        </div>
                        <?php
                        if (isset($module)) {
                            $videoTerm = explode('|', $module->video_term);
                        }
                        for ($i = 1; $i <= 10; $i++) {
                            ?>
                            <div class="form-group">
                                <label for="name" class="col-xs-3 control-label">Video Term #<?php echo $i; ?>
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="Video Term"></i>
                                </label>
                                <div class="input-group input-group-sm col-xs-9">
                                    <input type="text" class="form-control x-vt video-term" value="<?php
                                    if (isset($module)) {
                                        echo $videoTerm[$i - 1];
                                    }
                                    ?>" placeholder="Video Term">
                                    <!--<span class="input-group-addon"><li class="fa fa-asterisk"></li></span>-->
                                </div>
                            </div>
                        <?php } ?>
                        <hr />

                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <button class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#ctaVideoModal" data-backdrop="static" data-keyboard="false" >Call To Action Library</button>
                                <h4>Call to Action</h4>
                            </div>
                        </div>
                        <?php
                        if (isset($module)) {
                            $videoCta = explode('|', $module->video_cta);
                        }
                        for ($i = 1; $i <= 10; $i++) {
                            ?>
                            <div class="form-group">
                                <label for="name" class="col-xs-3 control-label">Video Call to Action #<?php echo $i; ?>
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="Video Call to Action"></i>
                                </label>
                                <div class="input-group input-group-sm col-xs-9">
                                    <input type="text" class="form-control video-cta" value="<?php
                                    if (isset($module)) {
                                        echo $videoCta[$i - 1];
                                    }
                                    ?>" placeholder="Video call to action"
                                           data-toggle="popover" data-placement="right">
                                </div>
                            </div>
                        <?php } ?>
                        <hr />
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <button type="button" class="btn btn-primary btn-save-module pull-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Activate Div -->
                <div class="tab-pane fade in" id="moduleActivate">
                    <br />
                    <br />
                    <?php
                    if (isset($module)) {
                        if ($module->status == "active") {
                            ?>
                            <div id="deactivateDiv">
                                <p class="text-warning text-center">This Craiglist module is active.</p>
                                <button class='btn btn-danger btn-lg center-block' id='moduleDeactivateBtn'>Deactivate</button>
                            </div>
                            <div id="activateDiv" style="display: none">
                                <p class="text-warning text-center"> <i class="fa fa-warning"></i>This Craiglist module is not yet activated.</p>
                                <p class='text-primary text-center'>Make sure that you had filled up all required <i class="fa fa-asterisk"></i> fields.</p>
                                <div id='errorMessage'></div>
                                <button class='btn btn-success btn-lg center-block' id='moduleActivateBtn'>Activate</button>
                            </div>
                        <?php } else { ?> 
                            <div id="activateDiv">
                                <p class="text-warning text-center"> <i class="fa fa-warning"></i>This Craiglist module is not yet activated.</p>
                                <p class='text-primary text-center'>Make sure that you had filled up all required <i class="fa fa-asterisk"></i> fields.</p>
                                <div id='errorMessage'></div>
                                <button class='btn btn-success btn-lg center-block' id='moduleActivateBtn'>Activate</button>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div id="activateDiv">
                            <p class="text-warning text-center"> <i class="fa fa-warning"></i>This Craiglist module is not yet activated.</p>
                            <p class='text-primary text-center'>Make sure that you had filled up all required <i class="fa fa-asterisk"></i> fields.</p>
                            <div id='errorMessage'></div>
                            <button class='btn btn-success btn-lg center-block' id='moduleActivateBtn'>Activate</button>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Regular Headline Statements Modal -->
<div class="modal fade" id="hsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Headline Statement Library</h4>
            </div>
            <div class="modal-body">
                <p id="hsModalSelectedCount" class="text-danger">You need to select <b>10</b> more items.</p>
                <select multiple class="form-control" id="hsPre" style="height: 200px;"><?php echo $headlineStatements; ?></select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="hsModalDoneBtn">Done</button>
            </div>
        </div>
    </div>
</div>

<!-- Regular Call To Actions Modal -->
<div class="modal fade" id="ctaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Call To Action Library</h4>
            </div>
            <div class="modal-body">
                <p id="ctaModalSelectedCount" class="text-danger">You need to select <b>10</b> more items.</p>
                <select id="ctaModalList" class="form-control" style="height: 200px;" multiple><?php echo $callToActions; ?></select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="ctaModalDoneBtn" disabled="true">Done</button>
            </div>
        </div>
    </div>
</div>

<!-- Video Term Modal -->
<div class="modal fade" id="vtModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Video Term Library</h4>
            </div>
            <div class="modal-body">
                <p id="vtModalSelectedCount" class="text-danger">You need to select <b>10</b> more items.</p>
                <select multiple class="form-control" id="vtSelect" style="height: 200px;"><?php echo $videoTerms; ?></select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="vtModalDoneBtn">Done</button>
            </div>
        </div>
    </div>
</div>

<!-- Video Call To Actions Modal -->
<div class="modal fade" id="ctaVideoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Video Call To Action Library</h4>
            </div>
            <div class="modal-body">
                <p id="ctaVideoModalSelectedCount" class="text-danger">You need to select <b>10</b> more items.</p>
                <select id="ctaVideoModalList" class="form-control" style="height: 200px;" multiple><?php echo $videoCallToActions; ?></select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="ctaVideoModalDoneBtn" disabled="true">Done</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#propertiesLink").addClass("active");
    });
</script>