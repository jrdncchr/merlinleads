<div id="addProperty">
<a href="<?php echo base_url() . 'property' ?>">&Leftarrow; Return to Properties Overview</a>
<h4 style="text-align: center; font-weight: bold;"><?php echo $h2; ?>
    <img src="<?php echo base_url() . IMG . 'ajax-loader-3.GIF'; ?>" class="img-responsive pull-right" style="display: none;" id="loader">
</h4>
<hr style="margin: 20px 170px;" />
<!-- Nav tabs -->
<ul class="nav nav-tabs" id="main-tabs">
    <li <?php echo $redirect == "" ? 'class="active"' : ''; ?>><a href="#property-tab">Property Details</a></li>
    <li <?php echo $redirect == "classified" ? 'class="active"': ''; ?>><a href="#classified-tab">Classified Module Details</a></li>
    <li <?php  echo $redirect == "images" ? 'class="active"': ''; ?>><a href="#images-tab">Images</a></li>
</ul>

<div class="tab-content">

<!--
PROPERTY
-->
<div class="tab-pane fade in <?php echo $redirect == "" ? 'active': ''; ?>" id="property-tab">
<?php if (isset($po)) { ?>
    <h4>Property Name: <strong><?php echo $po->name; ?></strong></h4>
<?php } ?>
<div class="alert alert-info" id="message">
    Changing tabs will auto save. Please fill up all required <i class="fa fa-asterisk"></i> fields.
</div>
<!-- Nav tabs -->
<ul class="nav nav-tabs" id="propertyTabs">
    <li class="active"><a href="#basic">Basic Info</a></li>
    <li><a href="#detail">Detail Info</a></li>
    <li><a href="#typeAndFeatures">Property Type & Features</a></li>
    <li><a href="#keywords">Keywords</a></li>
    <li><a href="#links">Links</a></li>
    <li><a href="#activate">Activate</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
<!-- Basic Info -->
<div class="tab-pane fade in active" id="basic">
    <h3>Basic Info <a target="_blank" class="pull-right" style="font-size: 20px;" href="http://support.merlinleads.com/property-input-basic-info/"><i class="fa fa-question-circle"></i> Help</a></h3>
    <form class="form-horizontal col-xs-11">
        <input type="text" value="<?php if (isset($po)) echo $po->status; ?>" id="status" class="hidden" />
        <div class="form-group">
            <div class="input-group input-group-sm col-xs-12">
                <div id="basicMessage"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="type" class="col-xs-3 control-label">Profile
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Select a Profile"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <select class="form-control required" id="profile" readonly="true"><?php echo $selected_profile; ?></select>
                <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-xs-3 control-label">Property Name
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter a name to keep track of property, usually the street address"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control required" id="name" value="<?php if (isset($po)) echo $po->name; ?>" placeholder="Property Name">
                <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
            </div>
        </div>
        <div class="form-group">
            <label for="type" class="col-xs-3 control-label">Property Type
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Click the input field and a popup will show, select a category and type."></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control required" id="propertyType" value="<?php if (isset($property)) echo $property->property_type; ?>" />
                <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
            </div>
        </div>
        <div class="form-group">
            <label for="saletype" class="col-xs-3 control-label">Sale Type
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Select a sale type from the drop down"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <select class="form-control required" id="saleType"><?php echo $sale_types; ?></select>
                <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
            </div>
        </div>
        <hr />
        <div class="form-group">
            <label for="address" class="col-xs-3 control-label">Street Address
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter Street Address"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control required" value="<?php if (isset($property)) echo $property->address; ?>" id="address" placeholder="Street Address">
                <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
            </div>
        </div>
        <div class="form-group">
            <label for="city" class="col-xs-3 control-label">City
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter City - O'fallon"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control required" value="<?php if (isset($property)) echo $property->city; ?>" id="city" placeholder="City">
                <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
            </div>
        </div>
        <div class="form-group">
            <label for="city" class="col-xs-3 control-label">City Spelling 2
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter alternative spelling for City - O Fallon.  Enter regular spelling if there isn't a different one."></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control" value="<?php if (isset($property)) echo $property->city2; ?>" id="city2" placeholder="City Spelling 1">
            </div>
        </div>
        <div class="form-group">
            <label for="city" class="col-xs-3 control-label">City Spelling 3
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter alternative spelling for City - OFallon. Enter regular spelling if there isn't a different one."></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control" value="<?php if (isset($property)) echo $property->city3; ?>" id="city3" placeholder="City Spelling 2">
            </div>
        </div>
        <div class="form-group">
            <label for="zipcode" class="col-xs-3 control-label">Zip Code
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter Zip Code"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control required" value="<?php if (isset($property)) echo $property->zipcode; ?>" id="zipcode" placeholder="Zip Code">
                <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
            </div>
        </div>
        <div class="form-group">
            <label for="country" class="col-xs-3 control-label">Country
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Select from the dropdown"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <select class="form-control required" id="country">
                    <option value="">-- Select Country --</option>
                    <option value="United States" <?php if (isset($property)) if ($property->country == "United States") echo "selected"; ?>>United States</option>
                    <option value="Canada" <?php if (isset($property)) if ($property->country == "Canada") echo "selected"; ?>>Canada</option>
                </select>
                <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
            </div>
        </div>
        <div class="form-group">
            <label for="state" class="col-xs-3 control-label">State / Provice
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Select from the dropdown"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <select class="form-control required" id="state">
                    <option value="">-- Select a Country First --</option>
                    <?php if (isset($property)) echo $states; ?>
                </select>
                <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
            </div>
        </div>
        <div class="form-group">
            <label for="area" class="col-xs-3 control-label">Area
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter a local name for the location of the property - subdivision, county, neighborhood, etc..."></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control required" value="<?php if (isset($property)) echo $property->area; ?>" id="area" placeholder="Area">
                <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
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

<!-- Detail -->
<div class="tab-pane fade" id="detail">
    <h3>Detail Info <a target="_blank" class="pull-right" style="font-size: 20px;" href="http://support.merlinleads.com/property-details-detail-info-tab/"><i class="fa fa-question-circle"></i> Help</a></h3>
    <form class="form-horizontal col-xs-11">
        <div class="form-group">
            <div class="input-group input-group-sm col-xs-12">
                <div id="detailMessage"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="advance" class="col-xs-3 control-label">MLS/Main Description
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter the MLS description or make one - up to 1,000 characters"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <textarea class="form-control required" id="mlsDescription" style="min-height: 80px;" placeholder="Enter MLS Description"><?php if (isset($property)) echo $property->mls_description; ?></textarea>
                <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
            </div>
        </div>
        <div class="form-group">
            <label for="advance" class="col-xs-3 control-label">MLS ID#
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter MLS ID # or leave blank"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control" value="<?php if (isset($property)) echo $property->mls_id; ?>" id="mlsID" placeholder="Enter MLS ID#">
            </div>
        </div>
        <hr />
        <div id="bullets">
            <?php
            if (isset($property))
                $bullets = explode('|', $property->bullets);
            for ($i = 0; $i < 10; $i++) {
                ?>
                <div class="form-group">
                    <label for="bullet" class="col-xs-3 control-label">Bullet #<?php echo $i + 1; ?>
                        <i class="fa fa-question-circle text-info helper" data-container="body"
                           data-toggle="popover" data-placement="top" data-content="Enter a brief feature about the property or community - 1 sentence or a couple of words"></i>
                    </label>
                    <div class="input-group input-group-sm col-xs-9">
                        <input type="text" class="form-control x-bullet required" value='<?php if (isset($property)) echo $bullets[$i]; ?>' placeholder="Bullet">
                        <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                    </div>
                </div>
            <?php } ?>
        </div>
        <hr />
        <div class="form-group">
            <label for="school" class="col-xs-3 control-label">School District
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter School District"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control required" value="<?php if (isset($property)) echo $property->school_district; ?>" id="schooldDistrict" placeholder="School District">
                <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
            </div>
        </div>
        <div class="form-group">
            <label for="school" class="col-xs-3 control-label">High School
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter High School"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control required" value="<?php if (isset($property)) echo $property->highschool; ?>" id="highschool" placeholder="High School">
                <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
            </div>
        </div>
        <div class="form-group">
            <label for="school" class="col-xs-3 control-label">Middle School
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter Middle School"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control" value="<?php if (isset($property)) echo $property->middleschool; ?>" id="middleschool" placeholder="Middle School">
            </div>
        </div>
        <div class="form-group">
            <label for="school" class="col-xs-3 control-label">Elementary School
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter Elementary School"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control" value="<?php if (isset($property)) echo $property->elementaryschool; ?>" id="elementaryschool" placeholder="Elementary School">
            </div>
        </div>
        <hr />
        <div class="form-group">
            <label for="advance" class="col-xs-3 control-label">No. of Bedrooms
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter the number of bedrooms - 2 or Two"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control" value="<?php if (isset($property)) echo $property->no_bedrooms; ?>" id="noBedrooms" placeholder="Enter No. of Bedrooms">
            </div>
        </div>
        <div class="form-group">
            <label for="advance" class="col-xs-3 control-label">No. of Bathrooms
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter the number of bathrooms - 1.5 or 1 full / 1 half""></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control" value="<?php if (isset($property)) echo $property->no_bathrooms; ?>" id="noBathrooms" placeholder="Enter No. of Bathrooms">
            </div>
        </div>
        <div class="form-group">
            <label for="advance" class="col-xs-3 control-label">Building Square ft.
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter the main building square footage - 1,500"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control" value="<?php if (isset($property)) echo $property->building_sqft; ?>" id="buildingSqFt" placeholder="Enter the Building Square ft.">
            </div>
        </div>
        <div class="form-group">
            <label for="advance" class="col-xs-3 control-label">Year Built
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter Year Built"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control" value="<?php if (isset($property)) echo $property->year_built; ?>" id="yearBuilt" placeholder="Year Built">
            </div>
        </div>
        <div class="form-group">
            <label for="advance" class="col-xs-3 control-label">Lot/Land Size
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter the size in Square Foot or Acres - 8,600 Sq Ft or 3.5 Acres"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control" value="<?php if (isset($property)) echo $property->lot_size; ?>" id="lotSize" placeholder="Lot Size">
            </div>
        </div>
        <hr />
        <div class="form-group">
            <div class="col-xs-12">
                <button type="button" class="btn btn-primary btn-save pull-right btn-sm">Save</button>
            </div>
        </div>
    </form>
</div>

<!-- Features -->
<div class="tab-pane fade" id="typeAndFeatures">
    <h3>Type and Features <a target="_blank" class="pull-right" style="font-size: 20px;" href="http://support.merlinleads.com/property-details-type-and-features-tab/"><i class="fa fa-question-circle"></i> Help</a></h3>
    <form class="form-horizontal col-xs-11">
        <div class="form-group">
            <div class="input-group input-group-sm col-xs-12">
                <div id="typeAndFeaturesMessage"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="advance" class="col-xs-3 control-label">Main Term
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Select from the drop down box"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <select class="form-control required" id="main"><?php echo $feature_main; ?></select>
                <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
            </div>
        </div>
        <div class="form-group">
            <label for="advance" class="col-xs-3 control-label">Secondary Term
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Select from the drop down box - could be the singular form of the main term"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <select class="form-control required" id="secondary"><?php echo $feature_secondary; ?></select>
                <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
            </div>
        </div>
        <hr />
        <div id="features">
            <?php if (isset($property)) $features = explode('|', $property->features); ?>
            <div class="form-group">
                <label for="feature" class="col-xs-3 control-label">Feature #1
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter a word or two describing a feature of the property - 3 Bedroom, Luxury, Historic"></i>
                </label>
                <div class="input-group input-group-sm col-xs-9">
                    <div class="input-group">
                        <input type="text" class="form-control x-feature required" value="<?php if (isset($property)) echo $features[0] ?>" id="feature1" placeholder="Feature">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" id="feature1Btn" type="button"><i class="fa fa-lg fa-lightbulb-o"></i></button>
                                            </span>
                    </div>
                    <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                </div>
            </div>
            <div class="form-group">
                <label for="feature" class="col-xs-3 control-label">Feature #2
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter a word or two describing a feature of the property - Lake Front, Ranch, Foreclosure"></i>
                </label>
                <div class="input-group input-group-sm col-xs-9">
                    <div class="input-group">
                        <input type="text" class="form-control x-feature required" value="<?php if (isset($property)) echo $features[1] ?>" id="feature2" placeholder="Feature">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" id="feature2Btn" type="button"><i class="fa fa-lg fa-lightbulb-o"></i></button>
                                            </span>
                    </div>
                    <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                </div>
            </div>
            <div class="form-group">
                <label for="feature" class="col-xs-3 control-label">Feature #3
                    <i class="fa fa-question-circle text-info helper" data-container="body"
                       data-toggle="popover" data-placement="top" data-content="Enter a word or two describing a feature of the property - 2 Story, Short Sale, Rental"></i>
                </label>
                <div class="input-group input-group-sm col-xs-9">
                    <div class="input-group">
                        <input type="text" class="form-control x-feature required" value="<?php if (isset($property)) echo $features[2]; ?>" id="feature3" placeholder="Feature">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" id="feature3Btn" type="button"><i class="fa fa-lg fa-lightbulb-o"></i></button>
                                            </span>
                    </div>
                    <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
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

<!-- Keywords -->
<div class="tab-pane fade" id="keywords">
    <h3>Keywords <a target="_blank" class="pull-right" style="font-size: 20px;" href="http://support.merlinleads.com/property-details-keywords-tab/"><i class="fa fa-question-circle"></i> Help</a></h3>
    <form class="form-horizontal col-xs-12">
        <div class="form-group">
            <div class="input-group input-group-sm col-xs-12">
                <div id="keywordsMessage" class="alert alert-info"><i class="fa fa-info"></i> Keyword field is disabled. Change the feature/main/secondary words until it gives you what you are looking for. And if you still don't find the keyword you are looking for, you could always change it before posting it. </div>
            </div>
        </div>
        <div id="keywords">
            <?php
            if (isset($property))
                $keywords = explode('|', $property->keywords);
            for ($i = 1; $i <= 18; $i++) {
                ?>
                <div class="row">
                    <div class="col-xs-4">
                        <?php if ($i != 15) { ?>
                            <i class="fa fa-question-circle text-info helper" data-container="body"
                               data-toggle="popover" data-placement="top" data-content="Select from the drop down box"></i>
                            <div class="btn-group btn-group-xs keybtn-group<?php echo $i; ?>" data-toggle="buttons">
                                <label class="btn btn-default active" id="keybtn-group<?php echo $i; ?>-option1">
                                    <input type="radio" name="options"> City
                                </label>
                                <label class="btn btn-default" id="keybtn-group<?php echo $i; ?>-option2">
                                    <input type="radio" name="options"> City 2
                                </label>
                                <label class="btn btn-default" id="keybtn-group<?php echo $i; ?>-option3">
                                    <input type="radio" name="options"> City 3
                                </label>
                                <?php if ($i < 16) { ?>
                                    <label class="btn btn-default" id="keybtn-group<?php echo $i; ?>-option4">
                                        <input type="radio" name="options"> Area
                                    </label>
                                    <label class="btn btn-default" id="keybtn-group<?php echo $i; ?>-option5">
                                        <input type="radio" name="options"> ZipCode
                                    </label>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form-group col-xs-8">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control x-keyword required" value="<?php if (isset($property)) echo $keywords[$i - 1]; ?>" id="keyword<?php echo $i; ?>" placeholder="Keyword <?php echo $i; ?>" readonly="true">
                            <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <hr />
        <div class="form-group">
            <div class="input-group input-group-sm col-xs-12">
                <button type="button" class="btn btn-primary btn-save pull-right">Save</button>
            </div>
        </div>
    </form>
</div>

<!-- Links -->
<div class="tab-pane fade" id="links">
    <h3>Links <a target="_blank" class="pull-right" style="font-size: 20px;" href="http://support.merlinleads.com/property-details-link-inputs/"><i class="fa fa-question-circle"></i> Help</a></h3>
    <form class="form-horizontal col-xs-11">
        <div class="form-group">
            <div class="input-group input-group-sm col-xs-12">
                <div id="linksMessage"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="link" class="col-xs-3 control-label">Property Website URL
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter the property website link - http://yoursite.com/property"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control url" value="<?php if (isset($property)) echo $property->webpage; ?>" id="propertyWebpageLUrl" placeholder="Enter a Property URL, include http://">
            </div>
        </div>
        <div class="form-group">
            <label for="link" class="col-xs-3 control-label">Driving Instructions
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Driving Instructions"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <textarea class="form-control required" id="drivingInstructions" style="min-height: 100px;" placeholder="Driving Instructions here"><?php if (isset($property)) echo $property->driving_instructions; ?></textarea>
                <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
            </div>
        </div>
        <div class="form-group">
            <label for="link" class="col-xs-3 control-label">Map URL
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter the webpage on your site where a visitor can see a location map for the property - http://yoursite.com/listing_map"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control url" value="<?php if (isset($property)) echo $property->map_url; ?>" id="mapUrl" placeholder="Enter a map URL, include http://">
            </div>
        </div>
        <div class="form-group">
            <label for="link" class="col-xs-3 control-label">Other Listing in "city" URL
                <i class="fa fa-question-circle text-info helper" data-container="body"
                   data-toggle="popover" data-placement="top" data-content="Enter the a webpage on your site that would have same city listings as your property that you are posting - http://yoursite.com/city"></i>
            </label>
            <div class="input-group input-group-sm col-xs-9">
                <input type="text" class="form-control url" value="<?php if (isset($property)) echo $property->other_url; ?>" id="otherListingURL" placeholder="Enter a Other Listing URL, include http://">
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
<div class="tab-pane" id="activate">
    <br />
    <br />
    <?php
    if (isset($po)) {
        if ($po->status == "Active") {
            ?>
            <div id="deactivateDiv">
                <p class="text-success text-center"><i class="fa fa-check fa-lg"></i> This property is active.</p>
                <hr />
                <button class='btn btn-danger center-block' id='deactivateBtn'>Deactivate</button>
            </div>
        <?php } else { ?>
            <div id="activateDiv">
                <p class="text-warning text-center"> <i class="fa fa-warning"></i>This property is not yet activated.</p>
                <p class='text-primary text-center'>Make sure that you had filled up all required <i class="fa fa-asterisk"></i> fields.</p>
                <div id='errorMessage'></div>
                <hr />
                <button class='btn btn-success center-block' id='activateBtn'>Activate</button>
            </div>
            <div id="deactivateDiv" style="display: none;">
                <p class="text-success text-center"><i class="fa fa-check fa-lg"></i> This property is active.</p>
                <hr />
                <button class='btn btn-danger center-block' id='deactivateBtn'>Deactivate</button>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div id="activateDiv">
            <p class="text-warning text-center"> <i class="fa fa-warning"></i>This property is not yet activated.</p>
            <p class='text-primary text-center'>Make sure that you had filled up all required <i class="fa fa-asterisk"></i> fields.</p>
            <div id='errorMessage'></div>
            <hr />
            <button class='btn btn-success center-block' id='activateBtn'>Activate</button>
        </div>
        <div id="deactivateDiv" style="display: none;">
            <p class="text-success text-center"><i class="fa fa-check fa-lg"></i> This property is active.</p>
            <hr />
            <button class='btn btn-danger center-block' id='deactivateBtn'>Deactivate</button>
        </div>
    <?php } ?>
    <div style="height: 150px"></div>
</div>
</div>
</div>

<!--
CLASSIFIEDS
-->
<div class="tab-pane fade in <?php echo $redirect == "classified" ? 'active': ''; ?>" id="classified-tab">
<?php if (isset($po)) { ?>
    <h4>Property Name: <strong><?php echo $po->name; ?></strong> <a target="_blank" class="pull-right" style="font-size: 20px; margin-right: 10px;" href="http://support.merlinleads.com/property-images/"><i class="fa fa-question-circle"></i> Help</a></h4>
<?php } ?>
<div class="alert alert-info" id="message">
    Changing tabs will auto save. Please fill up all required <i class="fa fa-asterisk"></i> fields.
</div>
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
<!-- Basics -->
<div class="tab-pane fade in active" id="moduleBasics">
    <h3>General <a target="_blank" class="pull-right" style="font-size: 20px;" href="http://support.merlinleads.com/property-classified-basic-tab/"><i class="fa fa-question-circle"></i> Help</a></h3>
    <form class="form-horizontal col-xs-11">
        <div class="form-group">
            <div class="input-group input-group-sm col-xs-12">
                <div id="basicsMessage"></div>
            </div>
        </div>
        <div class="form-group">
            <input type="text" id="moduleStatus" style="display: none;" value="<?php
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
    <h3>Headline Statements <a target="_blank" class="pull-right" style="font-size: 20px;" href="http://support.merlinleads.com/property-classified-headline-statements/"><i class="fa fa-question-circle"></i> Help</a> <button class="btn btn-primary btn-xs pull-right" style="margin-right: 15px;" data-toggle="modal" data-target="#hsModal" data-backdrop="static" data-keyboard="false" >Headline Statement Library</button></h3>
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
    <h3>Call To Action <a target="_blank" class="pull-right" style="font-size: 20px;" href="http://support.merlinleads.com/property-classified-call-to-action/"><i class="fa fa-question-circle"></i> Help</a> <button class="btn btn-primary btn-xs pull-right" style="margin-right:15px;" data-toggle="modal" data-target="#ctaModal" data-backdrop="static" data-keyboard="false" >Call To Action Library</button></h3>

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
    <h3>Open House <a target="_blank" class="pull-right" style="font-size: 20px;" href="http://support.merlinleads.com/property-classified-open-house/"><i class="fa fa-question-circle"></i> Help</a></h3>
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
    <h3>Optional Fields <a target="_blank" class="pull-right" style="font-size: 20px;" href="http://support.merlinleads.com/property-classified-optional-fields/"><i class="fa fa-question-circle"></i> Help</a></h3>
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
    <h3>Video <a target="_blank" class="pull-right" style="font-size: 20px;" href="http://support.merlinleads.com/classified-video-inputs/"><i class="fa fa-question-circle"></i> Help</a></h3>
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
            <div id="moduleDeactivateDiv">
                <p class="text-success text-center"><i class="fa fa-check fa-lg"></i> This classified module is active.</p>
                <hr />
                <button class='btn btn-danger center-block' id='moduleDeactivateBtn'>Deactivate</button>
            </div>
            <div id="moduleActivateDiv" style="display: none">
                <p class="text-warning text-center"> <i class="fa fa-warning"></i>This classified module is not yet activated.</p>
                <p class='text-primary text-center'>Make sure that you had filled up all required <i class="fa fa-asterisk"></i> fields.</p>
                <div id='errorMessage'></div>
                <hr />
                <button class='btn btn-success center-block' id='moduleActivateBtn'>Activate</button>
            </div>
        <?php } else { ?>
            <div id="moduleDeactivateDiv" style="display: none">
                <p class="text-success text-center"><i class="fa fa-check fa-lg"></i> This classified module is active.</p>
                <hr />
                <button class='btn btn-danger center-block' id='moduleDeactivateBtn'>Deactivate</button>
            </div>
            <div id="moduleActivateDiv">
                <p class="text-warning text-center"> <i class="fa fa-warning"></i>This classified module is not yet activated.</p>
                <p class='text-primary text-center'>Make sure that you had filled up all required <i class="fa fa-asterisk"></i> fields.</p>
                <div id='errorMessage'></div>
                <hr />
                <button class='btn btn-success center-block' id='moduleActivateBtn'>Activate</button>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div id="moduleDeactivateDiv" style="display: none">
            <p class="text-success text-center"><i class="fa fa-check fa-lg"></i> This classified module is active.</p>
            <hr />
            <button class='btn btn-danger center-block' id='moduleDeactivateBtn'>Deactivate</button>
        </div>
        <div id="moduleActivateDiv">
            <p class="text-warning text-center"> <i class="fa fa-warning"></i>This classified module is not yet activated.</p>
            <p class='text-primary text-center'>Make sure that you had filled up all required <i class="fa fa-asterisk"></i> fields.</p>
            <div id='errorMessage'></div>
            <hr />
            <button class='btn btn-success center-block' id='moduleActivateBtn'>Activate</button>
        </div>
    <?php } ?>
    <div style="height: 150px"></div>
</div>

</div>
</div>

<!--
IMAGES
-->
<div class="tab-pane fade in <?php echo $redirect == "images" ? 'active': ''; ?>" id="images-tab" style="min-height: 400px;">
<?php if (isset($po)) { ?>
    <h4>Property Name: <strong><?php echo $po->name; ?></strong> <a target="_blank" class="pull-right" style="font-size: 20px; margin-right: 10px;" href="http://support.merlinleads.com/property-images/"><i class="fa fa-question-circle"></i> Help</a></h4>
<?php } ?>
<div class="alert alert-info" id="images-tab-message">
    <p><i class="fa fa-info"></i> Click on the <i class='fa fa-camera'></i> to upload/add images on the selected field.</p>
    <p><i class="fa fa-info"></i> Make sure to upload an owner and logo image in your selected Profile.</p>
</div>
<h4>Property Images</h4>
<form class="form-horizontal col-xs-12" role="form">
<div class="form-group">
    <?php
    if (isset($images)) {
        $front = json_decode($images->front);
    }
    ?>
    <div class="row">
        <label for="type" class="col-xs-3 control-label">Front
            <i class="fa fa-question-circle text-info helper" data-container="body"
               data-toggle="popover" data-placement="top" data-content="Front Image of the Property"></i>
        </label>
        <div class="col-xs-7">
            <input type="text" class="form-control input-sm image-text" value="<?php
            echo (isset($front->text) ? $front->text : "");
            ?>"/>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div id="front" class="image-list">
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image1" style="background-image: url('<?php
                        echo (isset($front->image1) ? $front->image1 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image2" style="background-image: url('<?php
                        echo (isset($front->image2) ? $front->image2 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image3" style="background-image: url('<?php
                        echo (isset($front->image3) ? $front->image3 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <?php
    if (isset($images)) {
        $back = json_decode($images->back);
    }
    ?>
    <div class="row">
        <label for="type" class="col-xs-3 control-label">Back
            <i class="fa fa-question-circle text-info helper" data-container="body"
               data-toggle="popover" data-placement="top" data-content="Back Image of the Property"></i>
        </label>
        <div class="col-xs-7">
            <input type="text" class="form-control input-sm image-text" value="<?php
            echo (isset($back->text) ? $back->text : "");
            ?>"/>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div id="back" class="image-list">
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image1" style="background-image: url('<?php
                        echo (isset($back->image1) ? $back->image1 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image2" style="background-image: url('<?php
                        echo (isset($back->image2) ? $back->image2 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image3" style="background-image: url('<?php
                        echo (isset($back->image3) ? $back->image3 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <?php
    if (isset($images)) {
        $kitchen = json_decode($images->kitchen);
    }
    ?>
    <div class="row">
        <label for="type" class="col-xs-3 control-label">Kitchen
            <i class="fa fa-question-circle text-info helper" data-container="body"
               data-toggle="popover" data-placement="top" data-content="Kitchen Image of the Property"></i>
        </label>
        <div class="col-xs-7">
            <input type="text" class="form-control input-sm image-text" value="<?php
            echo (isset($kitchen->text) ? $kitchen->text : "");
            ?>"/>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div id="kitchen" class="image-list">
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image1" style="background-image: url('<?php
                        echo (isset($kitchen->image1) ? $kitchen->image1 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image2" style="background-image: url('<?php
                        echo (isset($kitchen->image2) ? $kitchen->image2 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image3" style="background-image: url('<?php
                        echo (isset($kitchen->image3) ? $kitchen->image3 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <?php
    if (isset($images)) {
        $dining_room = json_decode($images->dining_room);
    }
    ?>
    <div class="row">
        <label for="type" class="col-xs-3 control-label">Dining Room
            <i class="fa fa-question-circle text-info helper" data-container="body"
               data-toggle="popover" data-placement="top" data-content="Dining Room Image of the Property"></i>
        </label>
        <div class="col-xs-7">
            <input type="text" class="form-control input-sm image-text" value="<?php
            echo (isset($dining_room->text) ? $dining_room->text : "");
            ?>"/>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div id="dining_room" class="image-list">
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image1" style="background-image: url('<?php
                        echo (isset($dining_room->image1) ? $dining_room->image1 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image2" style="background-image: url('<?php
                        echo (isset($dining_room->image2) ? $dining_room->image2 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image3" style="background-image: url('<?php
                        echo (isset($dining_room->image3) ? $dining_room->image3 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <?php
    if (isset($images)) {
        $living_room = json_decode($images->living_room);
    }
    ?>
    <div class="row">
        <label for="type" class="col-xs-3 control-label">Living Room
            <i class="fa fa-question-circle text-info helper" data-container="body"
               data-toggle="popover" data-placement="top" data-content="Living Room Image of the Property"></i>
        </label>
        <div class="col-xs-7">
            <input type="text" class="form-control input-sm image-text" value="<?php
            echo (isset($living_room->text) ? $living_room->text : "");
            ?>"/>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div id="living_room" class="image-list">
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image1" style="background-image: url('<?php
                        echo (isset($living_room->image1) ? $living_room->image1 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image2" style="background-image: url('<?php
                        echo (isset($living_room->image2) ? $living_room->image2 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image3" style="background-image: url('<?php
                        echo (isset($living_room->image3) ? $living_room->image3 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <?php
    if (isset($images)) {
        $family_room = json_decode($images->family_room);
    }
    ?>
    <div class="row">
        <label for="type" class="col-xs-3 control-label">Family Room
            <i class="fa fa-question-circle text-info helper" data-container="body"
               data-toggle="popover" data-placement="top" data-content="Family Room Image of the Property"></i>
        </label>
        <div class="col-xs-7">
            <input type="text" class="form-control input-sm image-text" value="<?php
            echo (isset($family_room->text) ? $family_room->text : "");
            ?>"/>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div id="family_room" class="image-list">
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image1" style="background-image: url('<?php
                        echo (isset($family_room->image1) ? $family_room->image1 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image2" style="background-image: url('<?php
                        echo (isset($family_room->image2) ? $family_room->image2 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image3" style="background-image: url('<?php
                        echo (isset($family_room->image3) ? $family_room->image3 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <?php
    if (isset($images)) {
        $master_bedroom = json_decode($images->master_bedroom);
    }
    ?>
    <div class="row">
        <label for="type" class="col-xs-3 control-label">Master Bedroom
            <i class="fa fa-question-circle text-info helper" data-container="body"
               data-toggle="popover" data-placement="top" data-content="Master Bedroom Image of the Property"></i>
        </label>
        <div class="col-xs-7">
            <input type="text" class="form-control input-sm image-text" value="<?php
            echo (isset($master_bedroom->text) ? $master_bedroom->text : "");
            ?>"/>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div id="master_bedroom" class="image-list">
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image1" style="background-image: url('<?php
                        echo (isset($master_bedroom->image1) ? $master_bedroom->image1 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image2" style="background-image: url('<?php
                        echo (isset($master_bedroom->image2) ? $master_bedroom->image2 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image3" style="background-image: url('<?php
                        echo (isset($master_bedroom->image3) ? $master_bedroom->image3 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <?php
    if (isset($images)) {
        $master_bathroom = json_decode($images->master_bathroom);
    }
    ?>
    <div class="row">
        <label for="type" class="col-xs-3 control-label">Master Bathroom
            <i class="fa fa-question-circle text-info helper" data-container="body"
               data-toggle="popover" data-placement="top" data-content="Master Bathroom Image of the Property"></i>
        </label>
        <div class="col-xs-7">
            <input type="text" class="form-control input-sm image-text" value="<?php
            echo (isset($master_bathroom->text) ? $master_bathroom->text : "");
            ?>"/>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <div id="master_bathroom" class="image-list">
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image1" style="background-image: url('<?php
                        echo (isset($master_bathroom->image1) ? $master_bathroom->image1 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image2" style="background-image: url('<?php
                        echo (isset($master_bathroom->image2) ? $master_bathroom->image2 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
                <div class="show-image">
                    <div class="fileUpload ">
                        <div class="lgt-image image3" style="background-image: url('<?php
                        echo (isset($master_bathroom->image3) ? $master_bathroom->image3 : base_url() . IMG . "img-placeholder.png");
                        ?>')" ></div>
                        <button type="button" class="btn upload-image-btn"><i class="fa fa-upload fa-2x"></i></button>
                        <span></span>
                        <input class="upload" type="file" name="files[]" data-url="<?php echo base_url() . OTHERS . "uploads/php/"; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr />
    <div class="col-xs-12"><button type="button" class="btn btn-primary save-image-btn pull-right btn-sm">Save</button></div>
    <br />
</div>
</form>
</div>
</div>
</div>
<br />
<script>
    $(document).ready(function () {
        $("#propertiesLink").addClass("active");
    });
</script>

<!-- Term Feature Modal -->
<div class="modal fade" id="termFeatureModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Feature Generator</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form-horizontal col-xs-11">
                        <div class="form-group">
                            <label for="term" class="col-xs-3 control-label">Category
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="Select from the drop down box"></i>
                            </label>
                            <div class="col-xs-9">
                                <select type="text" class="form-control" id="featureCategory"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="term" class="col-xs-3 control-label">Feature
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="Select from the drop down box"></i>
                            </label>
                            <div class="col-xs-9">
                                <select type="text" class="form-control" id="featureSelect"></select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" id="generateFeatureBtn">Generate</button>
            </div>
        </div>
    </div>
</div>

<!-- Property Type Modal -->
<div class="modal fade" id="propertyTypeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Property Type</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form-horizontal col-xs-11">
                        <div class="form-group">
                            <label for="term" class="col-xs-3 control-label">Category
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="Select from the drop down box"></i>
                            </label>
                            <div class="col-xs-9">
                                <select type="text" class="form-control" id="propertyCategory"><?php echo $property_categories; ?></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="term" class="col-xs-3 control-label">Type
                                <i class="fa fa-question-circle text-info helper" data-container="body"
                                   data-toggle="popover" data-placement="top" data-content="Select from the drop down box"></i>
                            </label>
                            <div class="col-xs-9">
                                <select type="text" class="form-control" id="propertyCategoryType"></select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" id="generatePropertyTypeBtn">Done</button>
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




