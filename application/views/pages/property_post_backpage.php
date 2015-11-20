<div class="col-xs-10 col-xs-offset-1">
    <div class='row'>
        <div class='col-xs-12'>
            <a href="<?php echo base_url() . 'property' ?>">&Leftarrow; Return to Properties Overview</a>
            <a href="<?php echo base_url() . 'property/edit/' . $po->id ?>" class="pull-right">&Rightarrow; Edit
                Property</a>
            <h4><i class="fa fa-share"></i> Post Property
                <small>[ <?php echo $selectedModule; ?> ]</small>
                <img src="<?php echo base_url() . IMG . 'ajax-loader-3.GIF'; ?>" class="img-responsive pull-right"
                     style="display: none;" id="loader"><span
                    style='float: right; font-size: 12px;'>Template [ <?php echo "Regular: $next | Video: $nextVideo"; ?>
                    ] </span></h4>
            <hr/>
            <h4>Property Name: <strong><?php echo $po->name; ?></strong></h4>

            <form id="post" class="form-horizontal col-xs-12">
                <!-- Regular Post -->
                <div id="backpageRegularPost">
                    <form role="form">
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
                                <button type="button" class="btn btn-primary btn-block" id="generateBtn">Generate
                                </button>
                            </div>
                            <div class="col-xs-2" id="postCompleteDiv" style="display: none;">
                                <button type="button" class="btn btn-success btn-block" id="postCompleteBtn">Post
                                    Complete
                                </button>
                            </div>
                            <div class="col-xs-2" id="postCompleteMessageDiv" style="display: none;"></div>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <div id="postMessage"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="text"><strong>Title: </strong><i>(Use capitals sparingly.)</i>
                                        <i class="fa fa-question-circle text-info helper" data-container="body"
                                           data-toggle="popover" data-placement="top" data-content="Title"></i>
                                    </label>

                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control input-sm" id="title">
                                        <a class="input-group-addon" id='copyTitle'><i class='fa fa-clipboard'></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="text"><strong>Description</strong>
                                        <i class="fa fa-question-circle text-info helper" data-container="body"
                                           data-toggle="popover" data-placement="top" data-content="Description"></i>
                                    </label>

                                    <div class="input-group input-group-sm">
                                        <textarea class="form-control" id="description"
                                                  style="height: 120px;"></textarea>
                                        <a class="input-group-addon" id='copyDescription'><i
                                                class='fa fa-clipboard'></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label for="text"><strong>Price: $</strong>
                                        <i class="fa fa-question-circle text-info helper" data-container="body"
                                           data-toggle="popover" data-placement="top" data-content="Price"></i>
                                    </label>

                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control input-sm" id="price"/>
                                        <a class="input-group-addon" id='copyPrice'><i class='fa fa-clipboard'></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label for="text"><strong>Location: </strong>
                                        <i class="fa fa-question-circle text-info helper" data-container="body"
                                           data-toggle="popover" data-placement="top" data-content="Location"></i>
                                    </label>

                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control input-sm" id="specificLocation">
                                        <a class="input-group-addon" id='copySpecificLocation'><i
                                                class='fa fa-clipboard'></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label for="text"><strong>Bedrooms: </strong>
                                        <i class="fa fa-question-circle text-info helper" data-container="body"
                                           data-toggle="popover" data-placement="top" data-content="br"></i>
                                    </label>

                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control input-sm" id="bedrooms"/>
                                        <a class="input-group-addon" id='copyBedrooms'><i
                                                class='fa fa-clipboard'></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <label for="text">
                                    <strong>Create a map link for your ad</strong>
                                    <i>(Use cross streets if you wish to remain anonymous)</i>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-7">
                                <div class="form-group">
                                    <label for="text">Address
                                        <i class="fa fa-question-circle text-info helper" data-container="body"
                                           data-toggle="popover" data-placement="top" data-content="Address"></i>
                                    </label>

                                    <div class="input-group input-group-sm">
                                        <input class="form-control input-sm" id="address"/>
                                        <a class="input-group-addon" id='copyAddress'><i
                                                class='fa fa-clipboard'></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <label for="text">Zip/Postal Code
                                        <i class="fa fa-question-circle text-info helper" data-container="body"
                                           data-toggle="popover" data-placement="top"
                                           data-content="Zip/Postal Code"></i>
                                    </label>

                                    <div class="input-group input-group-sm">
                                        <input class="form-control input-sm" id="zipcode"/>
                                        <a class="input-group-addon" id='copyZipcode'><i
                                                class='fa fa-clipboard'></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">or</div>
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label for="text">Cross Streets
                                        <i class="fa fa-question-circle text-info helper" data-container="body"
                                           data-toggle="popover" data-placement="top" data-content="Cross Streets"></i>
                                    </label>

                                    <div class="input-group input-group-sm">
                                        <input class="form-control input-sm" id="crossStreet"/>
                                        <a class="input-group-addon" id='copyCrossStreet'><i
                                                class='fa fa-clipboard'></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-1">
                                <label for="text"></label>

                                <div><p class="text-center">at</p></div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label for="text">Location</label>

                                    <div class="input-group input-group-sm">
                                        <input class="form-control input-sm" id="location"/>
                                        <a class="input-group-addon" id='copyLocation'><i
                                                class='fa fa-clipboard'></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <label for="text">Zip/Postal Code
                                        <i class="fa fa-question-circle text-info helper" data-container="body"
                                           data-toggle="popover" data-placement="top"
                                           data-content="Zip/Postal Code"></i>
                                    </label>

                                    <div class="input-group input-group-sm">
                                        <input class="form-control input-sm" id="zipcode2"/>
                                        <a class="input-group-addon" id='copyZipcode2'><i
                                                class='fa fa-clipboard'></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-9">
                                <div class="form-group">
                                    <label for="text">
                                        <strong>Email</strong>
                                    </label>

                                    <div class="input-group input-group-sm">
                                        <input class="form-control input-sm" id="email"/>
                                        <a class="input-group-addon" id='copyEmail'><i class='fa fa-clipboard'></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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