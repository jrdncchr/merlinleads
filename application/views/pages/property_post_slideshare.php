<!-- Begin page content -->
<div class="col-xs-10 col-xs-offset-1">
    <div class='row'>
        <div class='col-xs-12'>
            <a href="<?php echo base_url() . 'property' ?>">&Leftarrow; Return to Properties Overview</a>
            <a href="<?php echo base_url() . 'property/edit/' . $po->id ?>" class="pull-right">&Rightarrow; Edit Property</a>
            <h4><i class="fa fa-share"></i> Post Property <small>[ <?php echo $selectedModule; ?> ]</small>
                <img src="<?php echo base_url() . IMG . 'ajax-loader-3.GIF'; ?>" class="img-responsive pull-right" style="display: none;" id="loader"></h4>
            <hr />
            <h4>Property Name: <strong><?php echo $po->name; ?></strong></h4>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#regular" data-toggle="tab">Regular</a></li>
                <?php
                /*
                 * ----- SLIDESHARE SLIDESHOW GENERATOR
                 */

                if(isset($features->slideshare_slide_generator)) { ?>
                <li><a href="#advance" data-toggle="tab">Advance</a></li>
                <?php } ?>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <!-- Basic Info Div -->
                <div class="tab-pane active" id="regular">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div id="postMessage"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Templates
                                <i class="fa fa-question-circle text-info helper" data-container="body" 
                                   data-toggle="popover" data-placement="top" data-content="Available Templates"></i>
                            </label>
                            <div class="col-xs-2">
                                <select id="selectTemplate" class="form-control">
                                    <?php echo $template_count; ?>
                                </select>
                            </div>
                            <div class="col-xs-2">
                                <button class="btn btn-primary" type='button' <?php if (isset($post)) echo "style='display: none;'"; ?> id="generateBtn">Generate</button>
                            </div>
                            <div class="col-xs-5">
                                <?php
                                if (isset($post)) {
                                    echo "<p id='status' class='text-danger control-label'>This template is already posted.</p>";
                                } else {
                                    echo "<p id='status' class='text-success control-label'>This template is available for posting.</p>";
                                }
                                ?>
                            </div>
                        </div>
                        <input type="text" class="form-control required hidden" value="<?php echo $po->id; ?>" id="poID" />
                        <input type="text" class="form-control required hidden" value="<?php echo $selectedModule; ?>" id="selectedModule" />
                        <div id="output">
                            <hr />
                            <div class="form-group">
                                <label for="type" class="col-xs-3 control-label">Title
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="Title"></i>
                                </label>
                                <div class='col-xs-9'>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control input-sm" value="<?php if (isset($pTitle)) echo $pTitle; ?>" id="title" />
                                        <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-xs-3 control-label">Description
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="Description"></i>
                                </label>
                                <div class="col-xs-9">
                                    <div class="input-group input-group-sm">
                                        <textarea class="form-control input-sm" style="min-height: 150px;" id="description"><?php if (isset($pDescription)) echo $pDescription ?></textarea>
                                        <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-xs-3 control-label">Keywords / Tags
                                    <i class="fa fa-question-circle text-info helper" data-container="body" 
                                       data-toggle="popover" data-placement="top" data-content="Keyword"></i>
                                </label>
                                <div class="col-xs-9">
                                    <div class="input-group input-group-sm">
                                        <textarea class="form-control input-sm" id="keyword" style="min-height: 80px;"><?php if (isset($pKeyword)) echo $pKeyword; ?></textarea>
                                        <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane" id="advance" style="padding-top: 20px;">
                    <div id="generateOptions">
                        <div class="row">
                            <div class="col-xs-6">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="type" class="col-xs-5 control-label">Type
                                            <i class="fa fa-question-circle text-info helper" data-container="body" 
                                               data-toggle="popover" data-placement="top" data-content="Type"></i>
                                        </label>
                                        <div class="col-xs-7">
                                            <select id="advanceType" class="form-control">
                                                <option value="Homes">Homes</option>
                                                <option value="Others" disabled="true">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="type" class="col-xs-5 control-label">Select Background 
                                            <i class="fa fa-question-circle text-info helper" data-container="body" 
                                               data-toggle="popover" data-placement="top" data-content="The background to be used in the generated slide."></i>
                                        </label>
                                        <div class="col-xs-7">
                                            <select class="form-control" id="bg">
                                                <?php
                                                if (isset($bg)) {
                                                    foreach ($bg as $image) {
                                                        ?>
                                                        <option value="<?php echo $image->image; ?>"><?php echo $image->title; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="type" class="col-xs-12 control-label"><b>Background Image</b></label>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <img id="bg-preview" src="<?php
                                        if (isset($bg)) {
                                            echo base_url() . IMG . "ppt/bg/" . $bg[0]->image;
                                        }
                                        ?>" class="img img-thumbnail" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div id="slidesListGenerator" class="row">
                            <div class="col-xs-6">
                                <label style="font-weight: bold;">Available Slides</label>
                                <p class="text-primary" style="font-size: 13px;"><i class="fa fa-exclamation-circle"></i> This are the data in the Images tab in <b>Edit Property</b> that have an image.</p>
                                <div class="panel panel-default">

                                    <ul id="availableSlides" class="list-group" ondrop="drop(event)" ondragover="allowDrop(event)" style="min-height: 300px;">
                                        <?php
                                        foreach ($availableSlides as $slide) {
                                            $forId = str_replace(' ', '', $slide['name']);
                                            echo '<li title="<img src=\'' . $slide['image'] . '\' class=\'img img-responsive img-thumbnail\' />" data-content="' . $slide['text'] . '" class="list-group-item" id="listItem' . $forId . '" draggable="true" ondragstart="drag(event)">' . $slide['name'] . '</li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <label style="font-weight: bold;">Slides to be Generated</label>
                                <p class="text-primary" style="font-size: 13px;"><i class="fa fa-exclamation-circle"></i> Manage the slide sequence in any order you want. Drag from the available slides in the left to the container below.</p>
                                <div class="panel panel-default">
                                    <ul id="slidesOrder" class="list-group" ondrop="drop(event)" ondragover="allowDrop(event)" style="min-height: 300px;">

                                    </ul>
                                </div>

                            </div>
                        </div>
                        <hr />
                    </div>

                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-xs-8">
                            <button type="button" id="generateSlideBtn" class="btn btn-primary">Generate Slide</button>
                            <div id="downloadDiv" style="display: none;">
                                <form class="form-horizontal">
                                    <h4>Download File</h4>
                                    <div class="form-group">
                                        <label for="type" class="col-xs-3 control-label">Download
                                            <i class="fa fa-question-circle text-info helper" data-container="body" 
                                               data-toggle="popover" data-placement="top" data-content="Download the ppt slide file"></i>
                                        </label>
                                        <div class="col-xs-9">
                                            <a id="downloadLink"><button type="button" class="btn btn-success">Download File</button></a>
                                        </div>
                                    </div>
                                    <hr />


                                </form>
                            </div>

                            <div id="postDiv" style="display: none;">


                                <?php
                                /*
                                 * ------ SLIDESHARE AUTO POSTING
                                 */
                                if(isset($features->slideshare_auto_posting)) { ?>

                                <h4>Post to Slideshare</h4>
                                <div class="alert alert-success" id="postSuccessMessage" style="display: none;"></div>
                                <div id="postInputs">
                                    <small><p class="text-info"><i>Enter your Slideshare username and password.</i></p></small>
                                    <form action="https://www.slideshare.net/api/1/upload_slideshow" method="post" enctype='multipart/form-data' name="ssuploadform" class="form-horizontal" target="_blank">

                                        <input name="api_key" type="hidden" size="20" value="1WUbB0I8" />

                                        <div class="form-group">
                                            <label for="type" class="col-xs-3 control-label">Username</label>
                                            <div class="col-xs-9">
                                                <input type="text" class="form-control" id="ssUsername" name="username" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="type" class="col-xs-3 control-label">Password</label>
                                            <div class="col-xs-9">
                                                <input type="password" class="form-control" id="ssPassword" name="password" />
                                            </div>
                                        </div>
                                        <hr />

                                        <input type="hidden" name="ts" value="">
                                        <input type="hidden" name="hash" value="">

                                        <input type="hidden" id="ssTitle" name="slideshow_title" />
                                        <input type="hidden" id="ssUpload" name="upload_url" />
                                        <textarea id="ssDescription" name="slideshow_description" style="display: none"></textarea>
                                        <textarea id="ssTags" name="slideshow_tags" style="display: none"></textarea>


                                        <div class="form-group">
                                            <label for="type" class="col-xs-3 control-label"></label>
                                            <div class="col-xs-9">
<!--                                                <button type="submit" onClick="return generateTimeHash(this.form)" class="btn btn-primary" id="generatePostBtn">Post to Slideshare</button>-->
                                                <button type="button" id="postToSlideshare" class="btn btn-primary">Post To Slideshare</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        $(document).ready(function () {
            $("#propertiesLink").addClass("active");
        });
    </script>