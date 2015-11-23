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
                <div id="ebayRegularPost">
                    <div class="row">
                        <div class="form-group">
                            <label for="name" class="col-xs-3 control-label">Template Output Type
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="Template Output Type"></i>
                            </label>

                            <div class="col-xs-6">
                                <select class="form-control input-sm" id="type">
                                    <option value="Regular">Regular</option>
                                    <option value="Video">Video</option>
                                </select>
                            </div>
                            <div class="col-xs-2" id="generateDiv">
                                <button type="button" class="btn btn-sm btn-primary btn-block" id="generateBtn">Generate
                                </button>
                            </div>
                            <div class="col-xs-2" id="postCompleteDiv" style="display: none;">
                                <button type="button" class="btn btn-sm btn-success btn-block" id="postCompleteBtn">Post
                                    Complete
                                </button>
                            </div>
                        </div>
                        <hr/>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="input-group input-group-sm col-xs-12">
                                <div id="postMessage"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Title
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="Title"></i>
                            </label>

                            <div class="input-group input-group-sm col-xs-6">
                                <input type="text" class="form-control input-sm" id="title"/>
                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Price $
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="Price"></i>
                            </label>

                            <div class="input-group input-group-sm col-xs-6">
                                <input type="text" class="form-control input-sm" id="price"/>
                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Bedrooms
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="Bedrooms"></i>
                            </label>

                            <div class="input-group input-group-sm col-xs-6">
                                <input type="text" class="form-control input-sm" id="bedrooms"/>
                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Bathrooms
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="Bathrooms"></i>
                            </label>

                            <div class="input-group input-group-sm col-xs-6">
                                <input type="text" class="form-control input-sm" id="bathrooms"/>
                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Size(sq ft)
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="Size"></i>
                            </label>

                            <div class="input-group input-group-sm col-xs-6">
                                <input type="text" class="form-control input-sm" id="sqft"/>
                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Year Built
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="Year Built"></i>
                            </label>

                            <div class="input-group input-group-sm col-xs-6">
                                <input type="text" class="form-control input-sm" id="yearBuilt"/>
                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Description
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="Description"></i>
                            </label>

                            <div class="input-group input-group-sm col-xs-6">
                                <textarea class="form-control input-sm" style="height: 100px;"
                                          id="description"></textarea>
                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Email
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="Email"></i>
                            </label>

                            <div class="input-group input-group-sm col-xs-6">
                                <input type="text" class="form-control input-sm" id="email"/>
                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Phone
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="Phone"></i>
                            </label>

                            <div class="input-group input-group-sm col-xs-6">
                                <input type="text" class="form-control input-sm" id="phone"/>
                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Street or Intersection
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="Street or Intersection"></i>
                            </label>

                            <div class="input-group input-group-sm col-xs-6">
                                <input type="text" class="form-control input-sm" id="street"/>
                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">Zip Code
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="Zip Code"></i>
                            </label>

                            <div class="input-group input-group-sm col-xs-6">
                                <input type="text" class="form-control input-sm" id="zipcode"/>
                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">City
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="City"></i>
                            </label>

                            <div class="input-group input-group-sm col-xs-6">
                                <input type="text" class="form-control input-sm" id="city"/>
                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-xs-3 control-label">State
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="State"></i>
                            </label>

                            <div class="input-group input-group-sm col-xs-6">
                                <input type="text" class="form-control input-sm" id="state"/>
                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
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