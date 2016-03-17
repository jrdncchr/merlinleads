<style>
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }

    table.dataTable tbody tr.selected {
        background-color: white !important;
        border: none;
        /*background-color: #99e6e6;*/
    }
</style>

<!-- Begin page content -->
<div class="col-xs-12" style="margin-bottom: 50px;">
    <h4 style="text-align: center; font-weight: bold; margin-bottom: 15px;">Properties Overview</h4>
        <hr style="margin: 25px 15px;" />
    <div class="row">
        <div class="col-xs-3">
            <button class="btn btn-success btn-sm btn-block" id="addPropertyBtn"><i class="fa fa-plus"></i> Add Property
            </button>
            <button id="genericPost" class="btn btn-primary btn-sm btn-block" style="display: none;">Generic Post</button>
        </div>
            <div class="col-xs-5 col-offset-xs-1">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="type" class="col-xs-4 control-label">Profile
                            <i class="fa fa-question-circle text-info helper" data-container="body"
                               data-toggle="popover" data-placement="top"
                               data-content="Select a profile that will be used for the properties."></i>
                        </label>

                        <div class="col-xs-8">
                            <select class="form-control" id="profile"><?php echo $profiles; ?></select>
                        </div>
                    </div>
                </form>
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="module" class="col-xs-4 control-label">Module
                            <i class="fa fa-question-circle text-info helper" data-container="body"
                               data-toggle="popover" data-placement="top" data-content="Select a module to be used."></i>
                        </label>

                        <div class="col-xs-8">
                            <select class="form-control" id="module">
                                <?php echo $modules; ?>
                            </select>

                        </div>
                    </div>
                </form>
            </div>
        <div class="col-xs-3 col-xs-offset-1">
            <a class="btn btn-default btn-sm btn-block" target="_blank"
               href="http://support.merlinleads.com/property-input-basic-info/"><i
                    class="fa fa-video-camera"></i> Setting up a Property Guide</a>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12" style="padding-top: 20px;">
            <div id="propertyMessage">
                <?php
                if (isset($_SESSION['message'])) {
                    ?>
                    <div class="alert alert-warning"><i class="fa fa-warning"></i> <?php echo $_SESSION['message']; ?>
                    </div>
                    <?php
                    unset($_SESSION['message']);
                }
                ?>
                <?php
                if (!$profiles || !$subscription) { ?>
                    <div class="alert alert-warning">
                        <?php if (!$profiles) { ?>
                        <i class="fa fa-warning"></i>
                        You don't have any profiles yet, <a href="<?php echo base_url() . 'profiles/add'; ?>">create a profile now</a>. <br />
                        <?php } ?>
                        <?php if (!$subscription) { ?>
                        <i class="fa fa-warning"></i>
                        You don't have any subscription yet, <a href="<?php echo base_url() . 'main/upgrade'; ?>">subscribe now</a>. <br />
                        <?php } ?>
                    </div>
                    <?php
                }
                ?>
            </div>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="properties-tabs">
                <li class="active"><a href="#properties-active" data-toggle="tab">Active</a></li>
                <li><a href="#properties-archive" data-toggle="tab">Archived</a></li>
                <li><a href="#properties-edit" data-toggle="tab">Edit</a></li>
            </ul>

            <div class="tab-content">
                <div id="properties-active" class="tab-pane active">
                    <table class="display table table-striped" cellspacing="0" width="100%" id="properties" style="max-width: none !important;">
                        <thead>
                        <tr>
                            <th width="10%">Actions</th>
                            <th width="18%">Property</th>
<!--                            <th width="10%">Status</th>-->
                            <th width="6%"><img src="<?php echo base_url() . IMG . 'logo/craiglist.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Craigslist"></th>
                            <th width="6%"><img src="<?php echo base_url() . IMG . 'logo/ebay.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Ebay Classified"></th>
                            <th width="6%"><img src="<?php echo base_url() . IMG . 'logo/backpage.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Backpage"></th>
                            <th width="6%"><img src="<?php echo base_url() . IMG . 'logo/youtube.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Youtube"></th>
                            <th width="6%"><img src="<?php echo base_url() . IMG . 'logo/slideshare.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Slideshare"></th>
                            <th width="6%"><img src="<?php echo base_url() . IMG . 'logo/twitter.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Twitter"></th>
                            <th width="6%"><img src="<?php echo base_url() . IMG . 'logo/facebook.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Facebook"></th>
                            <th width="6%"><img src="<?php echo base_url() . IMG . 'logo/googleplus.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Google+"></th>
                            <th width="6%">LinkedIn</th>
                            <th width="6%">Blog</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="6" class="dataTables_empty">Loading data from server</td>
                        </tr>
                        </tbody>
                    </table>
                    <br/>
                </div>
                <div id="properties-archive" class="table-responsive tab-pane">
                    <table cellpadding="0" cellspacing="0" border="0" class="display table table-striped"
                           id="propertiesArchive">
                        <thead>
                        <tr>
                            <th width="10%">Actions</th>
                            <th width="18%">Property</th>
                            <!--                            <th width="10%">Status</th>-->
                            <th width="6%"><img src="<?php echo base_url() . IMG . 'logo/craiglist.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Craigslist"></th>
                            <th width="6%"><img src="<?php echo base_url() . IMG . 'logo/ebay.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Ebay Classified"></th>
                            <th width="6%"><img src="<?php echo base_url() . IMG . 'logo/backpage.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Backpage"></th>
                            <th width="6%"><img src="<?php echo base_url() . IMG . 'logo/youtube.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Youtube"></th>
                            <th width="6%"><img src="<?php echo base_url() . IMG . 'logo/slideshare.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Slideshare"></th>
                            <th width="6%"><img src="<?php echo base_url() . IMG . 'logo/twitter.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Twitter"></th>
                            <th width="6%"><img src="<?php echo base_url() . IMG . 'logo/facebook.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Facebook"></th>
                            <th width="6%"><img src="<?php echo base_url() . IMG . 'logo/googleplus.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Google+"></th>
                            <th width="6%">LinkedIn</th>
                            <th width="6%">Blog</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="6" class="dataTables_empty">Loading data from server</td>
                        </tr>
                        </tbody>
                    </table>
                    <br/>
                </div>
                <div id="properties-edit" class="table-responsive tab-pane">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped"
                           id="propertiesEdit">
                        <thead>
                        <tr>
                            <th width="20%">Actions</th>
                            <th>Property</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="6" class="dataTables_empty">Loading data from server</td>
                        </tr>
                        </tbody>
                    </table>
                    <br/>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#propertiesLink").addClass("active");
        $("#propertyNav").addClass("active");

        setupPropertyDT();
        activatePopovers();
        activateEvents();
    });

    function activatePopovers() {
        $(document).find(".helper").each(function() {
            $(this).popover({
                'trigger': 'hover'
            });
        });
    }

    function setupPropertyDT() {
        var propertiesDt = $("#properties").dataTable({
            "bJQueryUI": true,
            "bProcessing": true,
//            "bFilter": false,
//            "bInfo": false,
//            "sScrollX": "100%",
            "sScrollXInner": <?php echo sizeof($available_modules) > 3 ? "'120%'" : "'100%'"; ?>,
            "bScrollCollapse": true,
//            "bPaginate": false,
            fixedColumns: {
                leftColumns: 2
            },
            "ajax": base_url + "property/getPropertyOverviewDetails",
            "columns": [
                { 'data' : 'poId', 'render': function(data, type, row) {
                    return '\
                    <div class="btn-group btn-block btn-group-vertical">\n\
                                <button class="btn btn-success btn-xs" style="padding: 0px 10px !important;" type="button" onclick="post(' + data + ', \'' + row.status + '\');">Post</button>\n\
                                <button type="button" class="btn btn-primary btn-xs btn-block dropdown-toggle" style="padding: 0px 10px !important;" data-toggle="dropdown">\n\
                                    Actions <span class="caret"></span>\n\
                                </button>\n\
                                <ul class="dropdown-menu" role="menu">\n\
                                    <li><a href="#" onclick="setup(\'edit\',  ' + data + ');"><i class="fa fa-edit"></i> Edit Property</a></li>\n\
                                    <li><a href="#" onclick="archiveProperty(' + data + ');"><i class="fa fa-archive"></i> Archive</a></li>\n\
                                    <li><a href="#" onclick="deleteProperty(' + data + ');"><i class="fa fa-trash-o"></i> Trash</a></li>\n\
                                    <li class="divider"></li>\n\
                                    <li class="dropdown-header">Generate Report</li>\n\
                                    <li><a href="' + base_url + 'property/getPropertyExcelReport/' + data + '/ALL"><i class="fa fa-file-text"></i> ALL</a></li>\n\
                                    <li><a href="' + base_url + 'property/getPropertyExcelReport/' + data + '/7DAYS"><i class="fa fa-file-text"></i> Last 7 Days</a></li>\n\
                                    <li><a href="' + base_url + 'property/getPropertyExcelReport/' + data + '/30DAYS"><i class="fa fa-file-text"></i> Last 30 Days</a></li>\n\
                                </ul>\n\
                            </div>';
                }
                },
                { 'data' : 'propertyName' },
                //{ 'data' : 'status' },
                { 'data' : 'craiglistRegular',
                    'render' : function(data, type, row) {
                        var regBg = "#d9534f";
                        if (row.craiglistRegularHours >= 48) {
                            regBg = "#5cb85c";
                        } else if (row.craiglistRegularHours >= 12) {
                            regBg = "#f0ad4e";
                        }
                        var vidBg = "#d9534f";
                        if (row.craiglistVideoHours >= 48) {
                            vidBg = "#5cb85c";
                        } else if (row.craiglistVideoHours >= 12) {
                            vidBg = "#f0ad4e";
                        }
                        return "<p class='helper p-counter' style='background-color: " + regBg + "' data-container='body' data-toggle='popover' data-placement='top' data-html='true' data-content='Regular: <b>" + row.craiglistRegular + "</b> post(s)'>R: " + row.craiglistRegular + "</p>\n\
                            <p class='helper p-counter' style='background-color: " + vidBg + "' data-container='body' data-toggle='popover' data-placement='top' data-html='true' data-content='Video: <b>" + row.craiglistVideo + "</b> post(s)'>V: " + row.craiglistVideo + "</p>";
                    }
                    <?php echo !in_array("Craiglist", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'ebayRegular',
                    'render' : function(data, type, row) {
                        var regBg = "#d9534f";
                        if (row.ebayRegularHours >= 48) {
                            regBg = "#5cb85c";
                        } else if (row.ebayRegularHours >= 12) {
                            regBg = "#f0ad4e";
                        }
                        var vidBg = "#d9534f";
                        if (row.ebayVideoHours >= 48) {
                            vidBg = "#5cb85c";
                        } else if (row.ebayVideoHours >= 12) {
                            vidBg = "#f0ad4e";
                        }
                        return "<p class='helper p-counter' style='background-color: " + regBg + "' data-container='body' data-toggle='popover' data-placement='top' data-html='true' data-content='Regular: <b>" + row.ebayRegular + "</b> post(s)'>R: " + row.ebayRegular + "</p>\n\
                            <p class='helper p-counter' style='background-color: " + vidBg + "' data-container='body' data-toggle='popover' data-placement='top' data-html='true' data-content='Video: <b>" + row.ebayVideo + "</b> post(s)'>V: " + row.ebayVideo + "</p>";
                    }
                    <?php echo !in_array("Ebay", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'backpageRegular',
                    'render' : function(data, type, row) {
                        var regBg = "#d9534f";
                        if (row.backpageRegularHours >= 48) {
                            regBg = "#5cb85c";
                        } else if (row.backpageRegularHours >= 12) {
                            regBg = "#f0ad4e";
                        }
                        var vidBg = "#d9534f";
                        if (row.backpageVideoHours >= 48) {
                            vidBg = "#5cb85c";
                        } else if (row.backpageVideoHours >= 12) {
                            vidBg = "#f0ad4e";
                        }
                        return "<p class='helper p-counter' style='background-color: " + regBg + "' data-container='body' data-toggle='popover' data-placement='top' data-html='true' data-content='Regular: <b>" + row.backpageRegular + "</b> post(s)'>R: " + row.backpageRegular + "</p>\n\
                            <p class='helper p-counter' style='background-color: " + vidBg + "' data-container='body' data-toggle='popover' data-placement='top' data-html='true' data-content='Video: <b>" + row.backpageVideo + "</b> post(s)'>V: " + row.backpageVideo + "</p>";
                    }
                    <?php echo !in_array("Backpage", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'youtube',
                    'render' : function(data, type, row) {
                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
                    }
                    <?php echo !in_array("Youtube", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'slideshare',
                    'render' : function(data, type, row) {
                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
                    }
                    <?php echo !in_array("Slideshare", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'twitter',
                    'render' : function(data, type, row) {
                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
                    }
                    <?php echo !in_array("Twitter", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'facebook',
                    'render' : function(data, type, row) {
                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
                    }
                    <?php echo !in_array("Facebook", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'googlePlus',
                    'render' : function(data, type, row) {
                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
                    }
                    <?php echo !in_array("Google+", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'linkedIn',
                    'render' : function(data, type, row) {
                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
                    }
                    <?php echo !in_array("LinkedIn", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'blog',
                    'render' : function(data, type, row) {
                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
                    }
                    <?php echo !in_array("Blog", $available_modules) ? ",visible: false" : ""; ?>
                }
            ]
        }).promise().done(function() {
            setTimeout(function() {
                activatePopovers();
            }, 2000);
        });

        //new $.fn.dataTable.FixedColumns( propertiesDt, {
        //    "iLeftColumns": 2,
        //    "iLeftWidth": 800
        //} );

        $("#propertiesArchive").dataTable({
            "bJQueryUI": true,
            "bProcessing": true,
//            "bFilter": false,
            "bInfo": false,
            "ajax": base_url + "property/getPropertyOverviewDetails/Archive",
            "columns": [
                { 'data' : 'poId', 'render': function(data, type, row) {
                    return '\
                    <div class="btn-group btn-block btn-group-vertical">\n\
                                <button type="button" class="btn btn-primary btn-xs btn-block dropdown-toggle" style="padding: 0px 10px !important;" data-toggle="dropdown">\n\
                                    Actions <span class="caret"></span>\n\
                                </button>\n\
                                <ul class="dropdown-menu" role="menu">\n\
                                    <li><a href="#" onclick="activateProperty(' + data + ');"><i class="fa fa-check"></i> Activate Property</a></li>\n\
                                    <li><a href="#" onclick="setup(\'edit\',  ' + data + ');"><i class="fa fa-edit"></i> Edit Property</a></li>\n\
                                    <li><a href="#" onclick="deleteProperty(' + data + ');"><i class="fa fa-trash-o"></i> Trash</a></li>\n\
                                    <li class="divider"></li>\n\
                                    <li class="dropdown-header">Generate Report</li>\n\
                                    <li><a href="' + base_url + 'property/getPropertyExcelReport/' + data + '/ALL"><i class="fa fa-file-text"></i> ALL</a></li>\n\
                                    <li><a href="' + base_url + 'property/getPropertyExcelReport/' + data + '/7DAYS"><i class="fa fa-file-text"></i> Last 7 Days</a></li>\n\
                                    <li><a href="' + base_url + 'property/getPropertyExcelReport/' + data + '/30DAYS"><i class="fa fa-file-text"></i> Last 30 Days</a></li>\n\
                                </ul>\n\
                            </div>';
                }
                },
                { 'data' : 'propertyName' },
                //{ 'data' : 'status' },
                { 'data' : 'craiglistRegular',
                    'render' : function(data, type, row) {
                        var regBg = "#d9534f";
                        if (row.craiglistRegularHours >= 48) {
                            regBg = "#5cb85c";
                        } else if (row.craiglistRegularHours >= 12) {
                            regBg = "#f0ad4e";
                        }
                        var vidBg = "#d9534f";
                        if (row.craiglistVideoHours >= 48) {
                            vidBg = "#5cb85c";
                        } else if (row.craiglistVideoHours >= 12) {
                            vidBg = "#f0ad4e";
                        }
                        return "<p class='helper p-counter' style='background-color: " + regBg + "' data-container='body' data-toggle='popover' data-placement='top' data-html='true' data-content='Regular: <b>" + row.craiglistRegular + "</b> post(s)'>R: " + row.craiglistRegular + "</p>\n\
                            <p class='helper p-counter' style='background-color: " + vidBg + "' data-container='body' data-toggle='popover' data-placement='top' data-html='true' data-content='Video: <b>" + row.craiglistVideo + "</b> post(s)'>V: " + row.craiglistVideo + "</p>";
                    }
                    <?php echo !in_array("Craiglist", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'ebayRegular',
                    'render' : function(data, type, row) {
                        var regBg = "#d9534f";
                        if (row.ebayRegularHours >= 48) {
                            regBg = "#5cb85c";
                        } else if (row.ebayRegularHours >= 12) {
                            regBg = "#f0ad4e";
                        }
                        var vidBg = "#d9534f";
                        if (row.ebayVideoHours >= 48) {
                            vidBg = "#5cb85c";
                        } else if (row.ebayVideoHours >= 12) {
                            vidBg = "#f0ad4e";
                        }
                        return "<p class='helper p-counter' style='background-color: " + regBg + "' data-container='body' data-toggle='popover' data-placement='top' data-html='true' data-content='Regular: <b>" + row.ebayRegular + "</b> post(s)'>R: " + row.ebayRegular + "</p>\n\
                            <p class='helper p-counter' style='background-color: " + vidBg + "' data-container='body' data-toggle='popover' data-placement='top' data-html='true' data-content='Video: <b>" + row.ebayVideo + "</b> post(s)'>V: " + row.ebayVideo + "</p>";
                    }
                    <?php echo !in_array("Ebay", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'backpageRegular',
                    'render' : function(data, type, row) {
                        var regBg = "#d9534f";
                        if (row.backpageRegularHours >= 48) {
                            regBg = "#5cb85c";
                        } else if (row.backpageRegularHours >= 12) {
                            regBg = "#f0ad4e";
                        }
                        var vidBg = "#d9534f";
                        if (row.backpageVideoHours >= 48) {
                            vidBg = "#5cb85c";
                        } else if (row.backpageVideoHours >= 12) {
                            vidBg = "#f0ad4e";
                        }
                        return "<p class='helper p-counter' style='background-color: " + regBg + "' data-container='body' data-toggle='popover' data-placement='top' data-html='true' data-content='Regular: <b>" + row.backpageRegular + "</b> post(s)'>R: " + row.backpageRegular + "</p>\n\
                            <p class='helper p-counter' style='background-color: " + vidBg + "' data-container='body' data-toggle='popover' data-placement='top' data-html='true' data-content='Video: <b>" + row.backpageVideo + "</b> post(s)'>V: " + row.backpageVideo + "</p>";
                    }
                    <?php echo !in_array("Backpage", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'youtube',
                    'render' : function(data, type, row) {
                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
                    }
                    <?php echo !in_array("Youtube", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'slideshare',
                    'render' : function(data, type, row) {
                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
                    }
                    <?php echo !in_array("Slideshare", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'twitter',
                    'render' : function(data, type, row) {
                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
                    }
                    <?php echo !in_array("Twitter", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'facebook',
                    'render' : function(data, type, row) {
                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
                    }
                    <?php echo !in_array("Facebook", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'googlePlus',
                    'render' : function(data, type, row) {
                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
                    }
                    <?php echo !in_array("Google+", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'linkedIn',
                    'render' : function(data, type, row) {
                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
                    }
                    <?php echo !in_array("LinkedIn", $available_modules) ? ",visible: false" : ""; ?>
                },
                { 'data' : 'blog',
                    'render' : function(data, type, row) {
                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
                    }
                    <?php echo !in_array("Blog", $available_modules) ? ",visible: false" : ""; ?>
                }
            ]
        }).promise().done(function() {
            setTimeout(function() {
                activatePopovers();
            }, 2000);
        });

        $("#propertiesEdit").dataTable({
            "bJQueryUI": true,
            "bProcessing": true,
            "ajax": base_url + "property/getPropertyOverviewDetails/Edit",
            "bAutoWidth": false,
            "columns": [
                { 'data' : 'poId', render: function(data, type, row) {
                    return '\
                    <div class="btn-group btn-block btn-group-vertical">\n\
                                <button type="button" class="btn btn-primary btn-xs btn-block dropdown-toggle" style="padding: 0px 10px !important;" data-toggle="dropdown">\n\
                                    Actions <span class="caret"></span>\n\
                                </button>\n\
                                <ul class="dropdown-menu" role="menu">\n\
                                    <li><a href="#" onclick="setup(\'edit\',  ' + data + ');"><i class="fa fa-edit"></i> Edit Property</a></li>\n\
                                    <li><a href="#" onclick="deleteProperty(' + data + ');"><i class="fa fa-trash-o"></i> Trash</a></li>\n\
                                </ul>\n\
                            </div>';
                    }
                },
                { 'data': 'propertyName' }
            ]
        }).promise().done(function() {
            setTimeout(function() {
                activatePopovers();
            }, 2000);
        });

    }


    function setupPropertyTable() {
        $('#properties').dataTable({
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $(nRow).children().each(function(index, td) {
                    if (index === 2) {
                        if ($(td).html() === "Active") {
                            $(td).css({"background-color": "#5cb85c", 'color': 'white'});
                        } else if ($(td).html() === "Inactive") {
                            $(td).css({"background-color": "#d9534f", 'color': 'white'});
                        } else if ($(td).html() === "Edit") {
                            $(td).css({"background-color": "lightgrey", 'color': 'black'});
                        }
                    }
                    if (index > 2 && index < 6) {
                        var regular = "N/A";
                        var video = "N/A";
                        try {
                            var json = JSON.parse($(td).html());
                            if (json.regular) {
                                regular = json.regular;
                            }
                            if (json.video) {
                                video = json.video;
                            }
                            $(td).html("<p class='helper' data-container='body' data-toggle='popover' data-placement='top' data-html='true' data-content='Regular: <b>" + regular + "</b> post(s)'>R: " + regular + "</p>\n\
                                    <p class='helper' data-container='body' data-toggle='popover' data-placement='top' data-html='true' data-content='Video: <b>" + video + "</b> post(s)'>V: " + video + "</p>");
                        } catch (error) {
                        }

                        try {
                            var reg_count = regular.split('/');
                            if (reg_count[0] === reg_count[1]) {
                                $(td).find('p:first').css({'background': '#d9534f'}).addClass('p-counter');
                            } else {
                                var t = json.regular_ldp.split(/[- :]/);
                                var d = new Date(t[0], t[1] - 1, t[2], t[3], t[4], t[5]);
                                var hours = parseInt(getDateDiff(d));
                                if (hours >= 48) {
                                    $(td).find('p:first').css({'background': '#5cb85c'}).addClass('p-counter');
                                } else if (hours >= 12) {
                                    $(td).find('p:first').css({'background': '#f0ad4e'}).addClass('p-counter');
                                } else {
                                    $(td).find('p:first').css({'background': '#d9534f'}).addClass('p-counter');
                                }
                            }
                        } catch (error) {
                        }
                        try {
                            var vid_count = video.split('/');
                            if (vid_count[0] === vid_count[1]) {
                                $(td).find('p:last').css({'background': '#d9534f'}).addClass('p-counter');
                            } else {
                                var t = json.video_ldp.split(/[- :]/);
                                var d = new Date(t[0], t[1] - 1, t[2], t[3], t[4], t[5]);
                                var hours = getDateDiff(d, "hours");
                                if (hours >= 48) {
                                    $(td).find('p:last').css({'background': '#5cb85c'}).addClass('p-counter');
                                } else if (hours >= 12) {
                                    $(td).find('p:last').css({'background': '#f0ad4e'}).addClass('p-counter');
                                } else {
                                    $(td).find('p:last').css({'background': '#d9534f'}).addClass('p-counter');
                                }
                            }

                        } catch (error) {
                        }
                    } else if (index > 5) {
                        var data = $(td).html();
                        $(td).html("<p style='text-align: center'>" + data + "</p>");
                    }
                });
                return nRow;
            },
            "bJQueryUI": true,
            "bProcessing": true,
            "bFilter": false,
            "bInfo": false,
            "bServerSide": true,
            "sAjaxSource": base_url + "property/getOverview",
            "aoColumnDefs": [{
                "aTargets": [0], // Column to target
                "mRender": function(data, type, full) {
                    return '\
                    <div style="z-index: 10000;" class="btn-group btn-block btn-group-vertical">\n\
                                <button class="btn btn-success btn-xs" style="padding: 0px 10px !important;" type="button" onclick="post(' + full[0] + ', \'' + full[2] + '\');">Post</button>\n\
                                <button type="button" class="btn btn-primary btn-xs btn-block dropdown-toggle" style="padding: 0px 10px !important;" data-toggle="dropdown">\n\
                                    Actions <span class="caret"></span>\n\
                                </button>\n\
                                <ul class="dropdown-menu" role="menu">\n\
                                    <li><a href="#" onclick="setup(\'edit\',  ' + full[0] + ');"><i class="fa fa-edit"></i> Edit Property</a></li>\n\
                                    <li><a href="#" onclick="archiveProperty(' + full[0] + ');"><i class="fa fa-archive"></i> Archive</a></li>\n\
                                    <li><a href="#" onclick="deleteProperty(' + full[0] + ');"><i class="fa fa-trash-o"></i> Trash</a></li>\n\
                                    <li class="divider"></li>\n\
                                    <li class="dropdown-header">Generate Report</li>\n\
                                    <li><a href="' + base_url + 'property/getPropertyExcelReport/' + full[0] + '/ALL"><i class="fa fa-file-text"></i> ALL</a></li>\n\
                                    <li><a href="' + base_url + 'property/getPropertyExcelReport/' + full[0] + '/7DAYS"><i class="fa fa-file-text"></i> Last 7 Days</a></li>\n\
                                    <li><a href="' + base_url + 'property/getPropertyExcelReport/' + full[0] + '/30DAYS"><i class="fa fa-file-text"></i> Last 30 Days</a></li>\n\
                                </ul>\n\
                            </div>';
                }
            }]
        }).promise().done(function() {
            setTimeout(function() {
                activatePopovers();
            }, 2000);
        });
        $('#propertiesArchive').dataTable({
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $(nRow).children().each(function(index, td) {
                    if (index === 2) {
                        if ($(td).html() === "Archive") {
                            $(td).css({"background-color": "#F09324", 'color': 'white'});
                        } else if ($(td).html() === "Inactive") {
                            $(td).css({"background-color": "#d9534f", 'color': 'white'});
                        } else if ($(td).html() === "Edit") {
                            $(td).css({"background-color": "lightgrey", 'color': 'black'});
                        }
                    }
                    if (index > 2) {
                        var regular = "N/A";
                        var video = "N/A";
                        try {
                            var json = JSON.parse($(td).html());
                            if (json.regular) {
                                regular = json.regular;
                            }
                            if (json.video) {
                                video = json.video;
                            }
                            $(td).html("<p class='helper' data-container='body' data-toggle='popover' data-placement='top' data-html='true' data-content='Regular: <b>" + regular + "</b> post(s)'>" + regular + "</p>\n\
                                    <p class='helper' data-container='body' data-toggle='popover' data-placement='top' data-html='true' data-content='Video: <b>" + video + "</b> post(s)'>" + video + "</p>");
                        } catch (error) {
                        }

                        try {
                            var reg_count = regular.split('/');
                            if (reg_count[0] === reg_count[1]) {
                                $(td).find('p:first').css({'background': '#d9534f'}).addClass('p-counter');
                            } else {
                                var t = json.regular_ldp.split(/[- :]/);
                                var d = new Date(t[0], t[1] - 1, t[2], t[3], t[4], t[5]);
                                var hours = getDateDiff(d);
                                if (hours >= 48) {
                                    $(td).find('p:first').css({'background': '#5cb85c'}).addClass('p-counter');
                                } else if (hours >= 12) {
                                    $(td).find('p:first').css({'background': '#f0ad4e'}).addClass('p-counter');
                                } else {
                                    $(td).find('p:first').css({'background': '#d9534f'}).addClass('p-counter');
                                }
                            }
                        } catch (error) {
                        }
                        try {
                            var vid_count = video.split('/');
                            if (vid_count[0] === vid_count[1]) {
                                $(td).find('p:last').css({'background': '#d9534f'}).addClass('p-counter');
                            } else {
                                var t = json.video_ldp.split(/[- :]/);
                                var d = new Date(t[0], t[1] - 1, t[2], t[3], t[4], t[5]);
                                var hours = getDateDiff(d, "hours");
                                if (hours >= 48) {
                                    $(td).find('p:last').css({'background': '#5cb85c'}).addClass('p-counter');
                                } else if (hours >= 12) {
                                    $(td).find('p:last').css({'background': '#f0ad4e'}).addClass('p-counter');
                                } else {
                                    $(td).find('p:last').css({'background': '#d9534f'}).addClass('p-counter');
                                }
                            }

                        } catch (error) {
                        }

                    }
                });
                return nRow;
            },
            "bJQueryUI": true,
            "bProcessing": true,
            "bFilter": false,
            "bInfo": false,
            "bServerSide": true,
            "sAjaxSource": base_url + "property/getOverviewArchive",
            "aoColumnDefs": [{
                "aTargets": [0], // Column to target
                "mRender": function(data, type, full) {
                    return '<div class="btn-group">\n\
                                <button type="button" class="btn btn-primary btn-xs dropdown-toggle" style="padding: 0px 10px !important;" data-toggle="dropdown">\n\
                                    Actions <span class="caret"></span>\n\
                                </button>\n\
                                <ul class="dropdown-menu" role="menu">\n\
                                    <li class="dropdown-header">Main Actions</li>\n\
                                    <li><a href="#" onclick="activateProperty(' + full[0] + ');"><i class="fa fa-check"></i> Activate Property</a></li>\n\
                                    <li><a href="#" onclick="setup(\'edit\',  ' + full[0] + ');"><i class="fa fa-edit"></i> Edit Property</a></li>\n\
                                    <li><a href="#" onclick="deleteProperty(' + full[0] + ');"><i class="fa fa-trash-o"></i> Trash</a></li>\n\
                                    <li class="divider"></li>\n\
                                    <li class="dropdown-header">Generate Report</li>\n\
                                    <li><a href="' + base_url + 'property/getPropertyExcelReport/' + full[0] + '/ALL"><i class="fa fa-file-text"></i> ALL</a></li>\n\
                                    <li><a href="' + base_url + 'property/getPropertyExcelReport/' + full[0] + '/7DAYS"><i class="fa fa-file-text"></i> Last 7 Days</a></li>\n\
                                    <li><a href="' + base_url + 'property/getPropertyExcelReport/' + full[0] + '/30DAYS"><i class="fa fa-file-text"></i> Last 30 Days</a></li>\n\
                                </ul>\n\
                            </div>';
                }
            }]
        }).promise().done(function() {
            setTimeout(function() {
                activatePopovers();
            }, 500);
        });
    }

    function activatePopovers() {
        $(document).find(".helper").each(function() {
            $(this).popover({
                'trigger': 'hover'
            });
        });
    }

    function activateEvents() {
        $('#addPropertyBtn').click(function() {
            setup('add', 0);
        });
        var genericModules = ["Blog", "Facebook", "Google Plus"];
        $("#module").change(function() {
            if(genericModules.indexOf($(this).val()) > -1) {
                $("#genericPost").show();
            } else {
                $("#genericPost").hide();
            }
        });
        if(genericModules.indexOf($("#module").val()) > -1) {
            $("#module").trigger("change");
        }

        $("#genericPost").click(function() {
            genericPost();
        });

    }

    function setup(type, id, status) {
        $.ajax({
            url: base_url + 'property/setup',
            data: {module: $('#module').val(), profile: $('#profile').val()},
            type: 'post',
            cache: false,
            success: function(data) {
                if (data === "OK") {
                    if (type === 'add') {
                        window.location = base_url + 'property/add';
                    } else if (type === 'edit') {
                        window.location = base_url + 'property/edit/' + id;
                    } else if (type === 'post') {
                        if (status === "Active") {
                            window.location = base_url + 'property/post/' + id;
                        } else {
                            alert("This property is not yet activated.");
                        }
                    } else if (type === 'module') {
                        if (status === "Active") {
                            window.location = base_url + 'property/module/' + id;
                        } else {
                            alert("This property is not yet activated.");
                        }
                    } else if (type === "status") {
                        window.location = base_url + 'property/status/' + status + '/' + id;
                    }
                } else {
                    $("#propertyMessage").removeClass().addClass('alert alert-danger')
                        .html("<i class='fa fa-exclamation'></i> Please create a profile first. \n\
                            <a href='" + base_url + "profiles/add'>Create new profile now.</a>");
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    function genericPost() {
        var module = $('#module').val();
        $.ajax({
            url: base_url + 'property/setup',
            data: { module: module, profile: $('#profile').val() },
            type: 'post',
            cache: false,
            success: function(data) {
                if (data === "OK") {
                    window.location = base_url + 'generic_post/' + module.toLowerCase().replace(" ", "_");
                } else {
                    $("#propertyMessage").removeClass().addClass('alert alert-danger')
                        .html("<i class='fa fa-exclamation'></i> Please create a profile first. \n\
                            <a href='" + base_url + "profiles/add'>Create new profile now.</a>");
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    function post(id, status) {
        var module = $('#module').val();
        $.ajax({
            url: base_url + 'property/setup',
            data: { module: module, profile: $('#profile').val() },
            type: 'post',
            cache: false,
            success: function(data) {
                if (data === "OK") {
                    if (status === "Active") {
                        var m2 = ['Facebook', 'Blog', 'Google Plus', 'LinkedIn'];
                        if(m2.indexOf(module) > -1) {
                            window.location = base_url + 'post/' + module.toLowerCase().replace(" ", "_") + "/" + id;
                        } else {
                            window.location = base_url + 'property/post/' + id;
                        }
                    } else {
                        alert("This property is not yet activated.");
                    }
                } else {
                    $("#propertyMessage").removeClass().addClass('alert alert-danger')
                        .html("<i class='fa fa-exclamation'></i> Please create a profile first. \n\
                            <a href='" + base_url + "profiles/add'>Create new profile now.</a>");
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    function deleteProperty(id) {
        $("#propertyMessage").html("");
        var verify = confirm('Are you sure to delete this property?');
        if (verify) {
            loading("info", "Deleting property, please wait...");
            $.ajax({
                url: base_url + 'property/delete',
                data: {id: id},
                type: 'post',
                cache: false,
                success: function(data) {
                    if (data === "OK") {
                        var oTable = $('#properties').dataTable();
                        oTable.fnReloadAjax();
                        var archiveTable = $('#propertiesArchive').dataTable();
                        archiveTable.fnReloadAjax();
                        var editTable = $('#propertiesEdit').dataTable();
                        editTable.fnReloadAjax();
                        loading("success", "Deleting property successful!");
                    } else {
                        alert(data);
                    }
                }
            });
        }
    }

    function archiveProperty(id) {
        loading("info", "Archiving property, please wait...");
        $.ajax({
            url: base_url + 'property/archiveProperty',
            data: {id: id},
            type: 'post',
            cache: false,
            success: function(data) {
                if (data === "OK") {
                    var oTable = $('#properties').dataTable();
                    oTable.fnReloadAjax();
                    var archiveTable = $('#propertiesArchive').dataTable();
                    archiveTable.fnReloadAjax();
                    loading("success", "Archiving property successful!");
                } else {
                    loading("danger", data);
                }
            }
        });
    }

    function activateProperty(id) {
        loading("info", "Activating property, please wait...");
        $.ajax({
            url: base_url + 'property/activateProperty',
            data: {id: id},
            type: 'post',
            cache: false,
            success: function(data) {
                if (data === "OK") {
                    $("#propertyMessage").html("");
                    var oTable = $('#properties').dataTable();
                    oTable.fnReloadAjax();
                    var archiveTable = $('#propertiesArchive').dataTable();
                    archiveTable.fnReloadAjax();
                    loading("success", "Activating property successful!");
                } else {
                    $("#propertyMessage").html(data);
                    loading("danger", "Activating property failed!");
                }
            }
        });
    }
</script>

