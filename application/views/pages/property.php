<style>
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }

    table.dataTable tbody tr.selected {
        background-color: white !important;
        border: none;
    }
</style>

<!-- Begin page content -->
<div class="col-xs-12" style="margin-bottom: 50px;">
    <h4 style="text-align: center; font-weight: bold;">Properties Overview</h4>
        <hr style="margin: 15px 0;" />
    <div class="row">
        <div class="col-xs-3">
            <button class="btn btn-success btn-sm btn-block" id="addPropertyBtn"><i class="fa fa-plus-circle"></i> Add Property
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
                <li role="presentation" class="pull-right">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="profile_filter"> Show only properties with selected profile
                        </label>
                    </div>
                </li>
            </ul>

            <div class="tab-content">
                <div id="properties-active" class="tab-pane active">
                    <table class="display table table-striped" cellspacing="0" width="100%" id="properties">
                        <thead>
                        <tr>
                            <th width="15%">Actions</th>
                            <th></th>
                            <th width="20%">Property Name</th>
                            <th width="10%"><img src="<?php echo base_url() . IMG . 'logo/craiglist.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Craigslist"></th>
                            <th width="10%"><img src="<?php echo base_url() . IMG . 'logo/ebay.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Ebay Classified"></th>
                            <th width="10%"><img src="<?php echo base_url() . IMG . 'logo/backpage.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Backpage"></th>
                            <th width="10%"><img src="<?php echo base_url() . IMG . 'logo/youtube.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Youtube"></th>
                            <th width="10%"><img src="<?php echo base_url() . IMG . 'logo/slideshare.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Slideshare"></th>
<!--                            <th width="6%"><img src="--><?php //echo base_url() . IMG . 'logo/twitter.png'; ?><!--"-->
<!--                                                class="center-block helper" data-container="body" data-toggle="popover"-->
<!--                                                data-placement="top" data-content="Twitter"></th>-->
<!--                            <th width="6%"><img src="--><?php //echo base_url() . IMG . 'logo/facebook.png'; ?><!--"-->
<!--                                                class="center-block helper" data-container="body" data-toggle="popover"-->
<!--                                                data-placement="top" data-content="Facebook"></th>-->
<!--                            <th width="6%"><img src="--><?php //echo base_url() . IMG . 'logo/googleplus.png'; ?><!--"-->
<!--                                                class="center-block helper" data-container="body" data-toggle="popover"-->
<!--                                                data-placement="top" data-content="Google+"></th>-->
<!--                            <th width="6%">LinkedIn</th>-->
<!--                            <th width="6%">Blog</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="6" class="dataTables_empty">Fetching properties, please wait...</td>
                        </tr>
                        </tbody>
                    </table>
                    <br/>
                </div>
                <div id="properties-archive" class="tab-pane">
                    <table class="display table table-striped" cellspacing="0" width="100%" id="propertiesArchive">
                        <thead>
                        <tr>
                            <th width="15%">Actions</th>
                            <th></th>
                            <th width="20%">Property Name</th>
                            <th width="10%"><img src="<?php echo base_url() . IMG . 'logo/craiglist.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Craigslist"></th>
                            <th width="10%"><img src="<?php echo base_url() . IMG . 'logo/ebay.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Ebay Classified"></th>
                            <th width="10%"><img src="<?php echo base_url() . IMG . 'logo/backpage.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Backpage"></th>
                            <th width="10%"><img src="<?php echo base_url() . IMG . 'logo/youtube.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Youtube"></th>
                            <th width="10%"><img src="<?php echo base_url() . IMG . 'logo/slideshare.png'; ?>"
                                                class="center-block helper" data-container="body" data-toggle="popover"
                                                data-placement="top" data-content="Slideshare"></th>
<!--                            <th width="6%"><img src="--><?php //echo base_url() . IMG . 'logo/twitter.png'; ?><!--"-->
<!--                                                class="center-block helper" data-container="body" data-toggle="popover"-->
<!--                                                data-placement="top" data-content="Twitter"></th>-->
<!--                            <th width="6%"><img src="--><?php //echo base_url() . IMG . 'logo/facebook.png'; ?><!--"-->
<!--                                                class="center-block helper" data-container="body" data-toggle="popover"-->
<!--                                                data-placement="top" data-content="Facebook"></th>-->
<!--                            <th width="6%"><img src="--><?php //echo base_url() . IMG . 'logo/googleplus.png'; ?><!--"-->
<!--                                                class="center-block helper" data-container="body" data-toggle="popover"-->
<!--                                                data-placement="top" data-content="Google+"></th>-->
<!--                            <th width="6%">LinkedIn</th>-->
<!--                            <th width="6%">Blog</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="6" class="dataTables_empty">Fetching properties, please wait...</td>
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
                            <th></th>
                            <th>Property</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="6" class="dataTables_empty">Fetching properties, please wait...</td>
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
/* Custom filtering function which will search data in column four between two values */
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var checked = $('#profile_filter').is(':checked') ? true : false;
            if(checked) {
                var selectedProfile = $('#profile').val().split(',');
                return selectedProfile[0] == data[1];
            }
            return true;

        }
    );

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

    var propertiesDt, archiveDt, editDt;
    function setupPropertyDT() {
        $("#properties").dataTable({
            "bJQueryUI": true,
            "bProcessing": true,
            "aaSorting": [2],
            "bDestroy": true,
            "sScrollXInner": <?php echo sizeof($available_modules) > 3 ? "'120%'" : "'100%'"; ?>,
            "bScrollCollapse": true,
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
                                    <li><a href="' + base_url + 'property/event_notification/' + data + '"><i class="fa fa-bell"></i> Event Notification</a></li>\n\
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
                { 'data' : 'profileId', visible: false },
                { 'data' : 'propertyName' },
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
//                { 'data' : 'twitter',
//                    'render' : function(data, type, row) {
//                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
//                    }
//                    <?php //echo !in_array("Twitter", $available_modules) ? ",visible: false" : ""; ?>
//                },
//                { 'data' : 'facebook',
//                    'render' : function(data, type, row) {
//                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
//                    }
//                    <?php //echo !in_array("Facebook", $available_modules) ? ",visible: false" : ""; ?>
//                },
//                { 'data' : 'googlePlus',
//                    'render' : function(data, type, row) {
//                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
//                    }
//                    <?php //echo !in_array("Google+", $available_modules) ? ",visible: false" : ""; ?>
//                },
//                { 'data' : 'linkedIn',
//                    'render' : function(data, type, row) {
//                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
//                    }
//                    <?php //echo !in_array("LinkedIn", $available_modules) ? ",visible: false" : ""; ?>
//                },
//                { 'data' : 'blog',
//                    'render' : function(data, type, row) {
//                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
//                    }
//                    <?php //echo !in_array("Blog", $available_modules) ? ",visible: false" : ""; ?>
//                }
            ]
        }).promise().done(function() {
            setTimeout(function() {
                activatePopovers();
            }, 2000);
        });

        propertiesDt = $("#properties").DataTable();

        $("#propertiesArchive").dataTable({
            "bJQueryUI": true,
            "bProcessing": true,
            "aaSorting": [2],
            "bDestroy": true,
            "sScrollXInner": <?php echo sizeof($available_modules) > 3 ? "'120%'" : "'100%'"; ?>,
            "bScrollCollapse": true,
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
                { 'data' : 'profileId', visible: false },
                { 'data' : 'propertyName' },
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
//                { 'data' : 'twitter',
//                    'render' : function(data, type, row) {
//                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
//                    }
//                    <?php //echo !in_array("Twitter", $available_modules) ? ",visible: false" : ""; ?>
//                },
//                { 'data' : 'facebook',
//                    'render' : function(data, type, row) {
//                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
//                    }
//                    <?php //echo !in_array("Facebook", $available_modules) ? ",visible: false" : ""; ?>
//                },
//                { 'data' : 'googlePlus',
//                    'render' : function(data, type, row) {
//                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
//                    }
//                    <?php //echo !in_array("Google+", $available_modules) ? ",visible: false" : ""; ?>
//                },
//                { 'data' : 'linkedIn',
//                    'render' : function(data, type, row) {
//                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
//                    }
//                    <?php //echo !in_array("LinkedIn", $available_modules) ? ",visible: false" : ""; ?>
//                },
//                { 'data' : 'blog',
//                    'render' : function(data, type, row) {
//                        return "<p class='helper p-counter' style='background-color: #5cb85c'>" + data + "</p>"
//                    }
//                    <?php //echo !in_array("Blog", $available_modules) ? ",visible: false" : ""; ?>
//                }
            ]
        }).promise().done(function() {
            setTimeout(function() {
                activatePopovers();
            }, 2000);
        });

        archiveDt = $("#propertiesArchive").DataTable();

        $("#propertiesEdit").dataTable({
            "bJQueryUI": true,
            "bProcessing": true,
            "aaSorting": [2],
            "bDestroy": true,
            "sScrollXInner": <?php echo sizeof($available_modules) > 3 ? "'120%'" : "'100%'"; ?>,
            "bScrollCollapse": true,
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
                { 'data' : 'profileId', visible: false },
                { 'data': 'propertyName' }
            ]
        }).promise().done(function() {
            setTimeout(function() {
                activatePopovers();
            }, 2000);
        });

        editDt = $("#propertiesEdit").DataTable();

    }

    function activatePopovers() {
        $(document).find(".helper").each(function() {
            $(this).popover({
                'trigger': 'hover'
            });
        });
    }

    function activateEvents() {
        $('#profile_filter').on('change', function() {
            propertiesDt.draw();
            archiveDt.draw();
            editDt.draw();
        });

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
        $.post(base_url + 'property/event_notification', {action: 'get_event_setting', event_key: 'off_the_market'}, function(res) {
            if (res.active) {
                $('#event_notification_modal').find('.modal-body span').html('Off the Market');
                $('#event_notification_modal').modal({
                    show: true,
                    keyboard: false,
                    backdrop: 'static'
                });
                $('#event_notification_yes').on('click', function() {
                    archiveNow(id, true);
                });
                $('#event_notification_no').on('click', function() {
                    archiveNow(id, false);
                });
            } else {
                archiveNow(id, false);
            }
        }, 'json');
    }

    function archiveNow(id, send) {
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
                    if (send) {
                        sendEventNotification('off_the_market', id);
                    }
                } else {
                    loading("danger", data);
                }
            }
        });
        $('#event_notification_modal').modal('hide');
    }

    function sendEventNotification(event_key, id) {
        loading("info", "Posting...");
        $.ajax({
            url: base_url + 'property/post_event_notification',
            data: {event_key: event_key, property_id: id},
            type: 'post',
            dataType: 'json',
            cache: false,
            success: function(res) {
                if (res.success) {
                    loading("success", "Post succsessful.");
                } else {
                    loading("danger", "Posting failed.");
                }
            }
        });
    }

    function activateProperty(id) {
        $.post(base_url + 'property/event_notification', {action: 'get_event_setting', event_key: 'back_on_the_market'}, function(res) {
            if (res.active) {
                $('#event_notification_modal').find('.modal-body span').html('Back on the Market');
                $('#event_notification_modal').modal({
                    show: true,
                    keyboard: false,
                    backdrop: 'static'
                });
                $('#event_notification_yes').on('click', function() {
                    activatePropertyNow(id, true);
                });
                $('#event_notification_no').on('click', function() {
                    activatePropertyNow(id, false);
                });
            } else {
                activatePropertyNow(id, false);
            }
        }, 'json');
    }

    function activatePropertyNow(id, send) {
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
                    if (send) {
                        sendEventNotification('back_on_the_market', id);
                    }
                } else {
                    $("#propertyMessage").html(data);
                    loading("danger", "Activating property failed!");
                }
            }
        });
        $('#event_notification_modal').modal('hide');
    }
</script>

