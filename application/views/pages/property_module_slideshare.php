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
            <ul class="nav nav-tabs" id="slideshare-tabs">
                <li class="active"><a href="#siat">Slides Image & Text</a></li>
                <li><a href="#activate">Activate</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">

                <!-- General -->
                <div class="tab-pane fade in active" id="siat">
                    <h3>Slides</h3>
                    <form class="form-horizontal col-xs-11">
                        <div class="form-group">
                            <label for="name" class="col-xs-3 control-label">Category
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Select Category"></i>
                            </label>
                            <div class="input-group input-group-sm col-xs-9">
                                <?php
                                if ($categories != "Default") {
                                    echo "<select id='category' class='form-control'>$categories</select>";
                                } else {
                                    echo "<input id='category' class='form-control' type='text' value='$module->category' disabled='true' />";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <label for="name" class="col-xs-6 control-label">Owner Image
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="Owner Image"></i>
                                </label>
                                <div class="input-group input-group-sm col-xs-6">
                                    <span class="input-group-btn">
                                        <div class="fileUpload btn btn-primary helper" data-container="body" data-toggle="popover" data-placement="right" data-html='true' 
                                             data-content="<?php
                                             if (isset($module)) {
                                                 if ($module->owner_image) {
                                                     $m = json_decode($module->owner_image, true);
                                                     echo "<img src='" . $m['image'] . "' class='img-thumbnail' />";
                                                 } else {
                                                     echo "No image yet.";
                                                 }
                                             } else {
                                                 echo "Upload Image";
                                             }
                                             ?>" id="<?php
                                             if (isset($module)) {
                                                 if ($module->owner_image) {
                                                     echo $m['image'];
                                                 }
                                             }
                                             ?>">
                                            <span><i class="fa fa-upload"></i></span>
                                            <input id="owner_image" class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <label for="name" class="col-xs-6 control-label">Logo Image
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="Logo Image"></i>
                                </label>
                                <div class="input-group input-group-sm col-xs-6">
                                    <span class="input-group-btn">
                                        <div class="fileUpload btn btn-primary helper" data-container="body" data-toggle="popover" data-placement="right" data-html='true' 
                                             data-content="<?php
                                             if (isset($module)) {
                                                 if ($module->logo_image) {
                                                     $m = json_decode($module->logo_image, true);
                                                     echo "<img src='" . $m['image'] . "' class='img-thumbnail' />";
                                                 } else {
                                                     echo "No image yet.";
                                                 }
                                             } else {
                                                 echo "Upload Image";
                                             }
                                             ?>" id="<?php
                                             if (isset($module)) {
                                                 if ($module->owner_image) {
                                                     echo $m['image'];
                                                 }
                                             }
                                             ?>">
                                            <span><i class="fa fa-upload"></i></span>
                                            <input id="logo_image" class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <div id="siatMessage"></div>
                            </div>
                        </div>

                        <div id="homes">
                            <div class="form-group">
                                <label for="name" class="col-xs-3 control-label">Front
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="Front"></i>
                                </label>
                                <div class="input-group input-group-sm col-xs-9">
                                    <span class="input-group-btn">
                                        <div class="fileUpload btn btn-primary helper" data-container="body" data-toggle="popover" data-placement="right" data-html='true' 
                                             data-content="<?php
                                             if (isset($module)) {
                                                 if ($module->front) {
                                                     $m = json_decode($module->front, true);
                                                     echo "<img src='" . $m['image'] . "' class='img-thumbnail' />";
                                                 } else {
                                                     echo "No image yet.";
                                                 }
                                             } else {
                                                 echo "Upload Image";
                                             }
                                             ?>" id="<?php
                                             if (isset($module)) {
                                                 if ($module->owner_image) {
                                                     echo $m['image'];
                                                 }
                                             }
                                             ?>">
                                            <span><i class="fa fa-upload"></i></span>
                                            <input id="front" class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                                        </div>
                                    </span>
                                    <input type="text" class="form-control" id="front-text" placeholder="Type bullet information here.." value='<?php
                                    if (isset($module)) {
                                        echo json_decode($module->front, true)['text'];
                                    }
                                    ?>'  />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-xs-3 control-label">Back
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="Back"></i>
                                </label>
                                <div class="input-group input-group-sm col-xs-9">
                                    <span class="input-group-btn">
                                        <div class="fileUpload btn btn-primary helper" data-container="body" data-toggle="popover" data-placement="right" data-html='true'  
                                             data-content="<?php
                                             if (isset($module)) {
                                                 if ($module->back) {
                                                     $m = json_decode($module->back, true);
                                                     echo "<img src='" . $m['image'] . "' class='img-thumbnail' />";
                                                 } else {
                                                     echo "No image yet.";
                                                 }
                                             } else {
                                                 echo "Upload Image";
                                             }
                                             ?>" id="<?php
                                             if (isset($module)) {
                                                 if ($module->owner_image) {
                                                     echo $m['image'];
                                                 }
                                             }
                                             ?>">
                                            <span><i class="fa fa-upload"></i></span>
                                            <input id="back" class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                                        </div>
                                    </span>
                                    <input type="text" class="form-control" id="back-text" placeholder="Type bullet information here.."  value='<?php
                                    if (isset($module)) {
                                        echo json_decode($module->back, true)['text'];
                                    }
                                    ?>' />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-xs-3 control-label">Kitchen
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="Kitchen"></i>
                                </label>
                                <div class="input-group input-group-sm col-xs-9">
                                    <span class="input-group-btn">
                                        <div class="fileUpload btn btn-primary helper" data-container="body" data-toggle="popover" data-placement="right" data-html='true' 
                                             data-content="<?php
                                             if (isset($module)) {
                                                 if ($module->kitchen) {
                                                     $m = json_decode($module->kitchen, true);
                                                     echo "<img src='" . $m['image'] . "' class='img-thumbnail' />";
                                                 } else {
                                                     echo "No image yet.";
                                                 }
                                             } else {
                                                 echo "Upload Image";
                                             }
                                             ?>" id="<?php
                                             if (isset($module)) {
                                                 if ($module->owner_image) {
                                                     echo $m['image'];
                                                 }
                                             }
                                             ?>">
                                            <span><i class="fa fa-upload"></i></span>
                                            <input id="kitchen" class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                                        </div>
                                    </span>
                                    <input type="text" class="form-control" id="kitchen-text" placeholder="Type bullet information here.."  value='<?php
                                    if (isset($module)) {
                                        echo json_decode($module->kitchen, true)['text'];
                                    }
                                    ?>'/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-xs-3 control-label">Dining Room
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="Dining Room"></i>
                                </label>
                                <div class="input-group input-group-sm col-xs-9">
                                    <span class="input-group-btn">
                                        <div class="fileUpload btn btn-primary helper" data-container="body" data-toggle="popover" data-placement="right" data-html='true' 
                                             data-content="<?php
                                             if (isset($module)) {
                                                 if ($module->dining_room) {
                                                     $m = json_decode($module->dining_room, true);
                                                     echo "<img src='" . $m['image'] . "' class='img-thumbnail' />";
                                                 } else {
                                                     echo "No image yet.";
                                                 }
                                             } else {
                                                 echo "Upload Image";
                                             }
                                             ?>" id="<?php
                                             if (isset($module)) {
                                                 if ($module->owner_image) {
                                                     echo $m['image'];
                                                 }
                                             }
                                             ?>">
                                            <span><i class="fa fa-upload"></i></span>
                                            <input id="dining_room" class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                                        </div>
                                    </span>
                                    <input type="text" class="form-control" id="dining_room-text" placeholder="Type bullet information here.."  value='<?php
                                    if (isset($module)) {
                                        echo json_decode($module->dining_room, true)['text'];
                                    }
                                    ?>' />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-xs-3 control-label">Living Room
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="Living Room"></i>
                                </label>
                                <div class="input-group input-group-sm col-xs-9">
                                    <span class="input-group-btn">
                                        <div class="fileUpload btn btn-primary helper" data-container="body" data-toggle="popover" data-placement="right" data-html='true' 
                                             data-content="<?php
                                             if (isset($module)) {
                                                 if ($module->living_room) {
                                                     $m = json_decode($module->living_room, true);
                                                     echo "<img src='" . $m['image'] . "' class='img-thumbnail' />";
                                                 } else {
                                                     echo "No image yet.";
                                                 }
                                             } else {
                                                 echo "Upload Image";
                                             }
                                             ?>" id="<?php
                                             if (isset($module)) {
                                                 if ($module->owner_image) {
                                                     echo $m['image'];
                                                 }
                                             }
                                             ?>">
                                            <span><i class="fa fa-upload"></i></span>
                                            <input id="living_room" class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                                        </div>
                                    </span>
                                    <input type="text" class="form-control" id="living_room-text" placeholder="Type bullet information here.."  value='<?php
                                    if (isset($module)) {
                                        echo json_decode($module->living_room, true)['text'];
                                    }
                                    ?>'/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-xs-3 control-label">Family Room
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="Family Room"></i>
                                </label>
                                <div class="input-group input-group-sm col-xs-9">
                                    <span class="input-group-btn">
                                        <div class="fileUpload btn btn-primary helper" data-container="body" data-toggle="popover" data-placement="right" data-html='true' 
                                             data-content="<?php
                                             if (isset($module)) {
                                                 if ($module->family_room) {
                                                     $m = json_decode($module->family_room, true);
                                                     echo "<img src='" . $m['image'] . "' class='img-thumbnail' />";
                                                 } else {
                                                     echo "No image yet.";
                                                 }
                                             } else {
                                                 echo "Upload Image";
                                             }
                                             ?>" id="<?php
                                             if (isset($module)) {
                                                 if ($module->owner_image) {
                                                     echo $m['image'];
                                                 }
                                             }
                                             ?>">
                                            <span><i class="fa fa-upload"></i></span>
                                            <input id="family_room" class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                                        </div>
                                    </span>
                                    <input type="text" class="form-control" id="family_room-text" placeholder="Type bullet information here.." value='<?php
                                    if (isset($module)) {
                                        echo json_decode($module->family_room, true)['text'];
                                    }
                                    ?>'  />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-xs-3 control-label">Master Bedroom
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="Master Bedroom"></i>
                                </label>
                                <div class="input-group input-group-sm col-xs-9">
                                    <span class="input-group-btn">
                                        <div class="fileUpload btn btn-primary helper" data-container="body" data-toggle="popover" data-placement="right" data-html='true' 
                                             data-content="<?php
                                             if (isset($module)) {
                                                 if ($module->master_bedroom) {
                                                     $m = json_decode($module->master_bedroom, true);
                                                     echo "<img src='" . $m['image'] . "' class='img-thumbnail' />";
                                                 } else {
                                                     echo "No image yet.";
                                                 }
                                             } else {
                                                 echo "Upload Image";
                                             }
                                             ?>" id="<?php
                                             if (isset($module)) {
                                                 if ($module->owner_image) {
                                                     echo $m['image'];
                                                 }
                                             }
                                             ?>">
                                            <span><i class="fa fa-upload"></i></span>
                                            <input id="master_bedroom" class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                                        </div>
                                    </span>
                                    <input type="text" class="form-control" id="master_bedroom-text" placeholder="Type bullet information here.." value='<?php
                                    if (isset($module)) {
                                        echo json_decode($module->master_bedroom, true)['text'];
                                    }
                                    ?>'  />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-xs-3 control-label">Master Bathroom
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="Master Bathroom"></i>
                                </label>
                                <div class="input-group input-group-sm col-xs-9">
                                    <span class="input-group-btn">
                                        <div class="fileUpload btn btn-primary helper" data-container="body" data-toggle="popover" data-placement="right" data-html='true' 
                                             data-content="<?php
                                             if (isset($module)) {
                                                 if ($module->master_bathroom) {
                                                     $m = json_decode($module->master_bathroom, true);
                                                     echo "<img src='" . $m['image'] . "' class='img-thumbnail' />";
                                                 } else {
                                                     echo "No image yet.";
                                                 }
                                             } else {
                                                 echo "Upload Image";
                                             }
                                             ?>" id="<?php
                                             if (isset($module)) {
                                                 if ($module->owner_image) {
                                                     echo $m['image'];
                                                 }
                                             }
                                             ?>">
                                            <span><i class="fa fa-upload"></i></span>
                                            <input id="master_bathroom" class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                                        </div>
                                    </span>
                                    <input type="text" class="form-control" id="master_bathroom-text" placeholder="Type bullet information here.." value='<?php
                                    if (isset($module)) {
                                        echo json_decode($module->master_bathroom, true)['text'];
                                    }
                                    ?>' />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-xs-3 control-label">Lower Level
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="LowerLevel"></i>
                                </label>
                                <div class="input-group input-group-sm col-xs-9">
                                    <span class="input-group-btn">
                                        <div class="fileUpload btn btn-primary helper" data-container="body" data-toggle="popover" data-placement="right" data-html='true' 
                                             data-content="<?php
                                             if (isset($module)) {
                                                 if ($module->lower_level) {
                                                     $m = json_decode($module->lower_level, true);
                                                     echo "<img src='" . $m['image'] . "' class='img-thumbnail' />";
                                                 } else {
                                                     echo "No image yet.";
                                                 }
                                             } else {
                                                 echo "Upload Image";
                                             }
                                             ?>" id="<?php
                                             if (isset($module)) {
                                                 if ($module->owner_image) {
                                                     echo $m['image'];
                                                 }
                                             }
                                             ?>">

                                            <span><i class="fa fa-upload"></i></span>
                                            <input id="lower_level" class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                                        </div>
                                    </span>
                                    <input type="text" class="form-control" id="lower_level-text" placeholder="Type bullet information here.." value='<?php
                                    if (isset($module)) {
                                        echo json_decode($module->lower_level, true)['text'];
                                    }
                                    ?>'  />
                                </div>
                            </div>
                        </div>

                        <hr />
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <button type="button" class="btn btn-primary btn-save pull-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Activate Div -->
                <div class="tab-pane fade in" id="activate">
                    <br />
                    <br />
                    <button class='btn btn-warning btn-lg center-block' id='generateBtn'>Generate(Testing)</button>
                    <?php
                    if (isset($module)) {
                        if ($module->status == "active") {
                            ?>
                            <div id="deactivateDiv">
                                <p class="text-warning text-center">This Craiglist module is active.</p>
                                <button class='btn btn-danger btn-lg center-block' id='deactivateBtn'>Deactivate</button>
                            </div>
                            <div id="activateDiv" style="display: none">
                                <p class="text-warning text-center"> <i class="fa fa-warning"></i>This Slideshare module is not yet activated.</p>
                                <p class='text-primary text-center'>Make sure that you had filled up all required <i class="fa fa-asterisk"></i> fields.</p>
                                <div id='errorMessage'></div>
                                <button class='btn btn-success btn-lg center-block' id='activateBtn'>Activate</button>
                            </div>
                        <?php } else { ?> 
                            <div id="activateDiv">
                                <p class="text-warning text-center"> <i class="fa fa-warning"></i>This Slideshare module is not yet activated.</p>
                                <p class='text-primary text-center'>Make sure that you had filled up all required <i class="fa fa-asterisk"></i> fields.</p>
                                <div id='errorMessage'></div>
                                <button class='btn btn-success btn-lg center-block' id='activateBtn'>Activate</button>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div id="activateDiv">
                            <p class="text-warning text-center"> <i class="fa fa-warning"></i>This Slideshare module is not yet activated.</p>
                            <p class='text-primary text-center'>Make sure that you had filled up all required <i class="fa fa-asterisk"></i> fields.</p>
                            <div id='errorMessage'></div>
                            <button class='btn btn-success btn-lg center-block' id='activateBtn'>Activate</button>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    $("#propertiesLink").addClass("active");
    });
</script>