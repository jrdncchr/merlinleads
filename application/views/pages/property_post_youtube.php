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
                <div class="form-group">
                    <label for="type" class="col-xs-3 control-label">Youtube Link
                        <i class="fa fa-question-circle text-info helper" data-container="body" 
                           data-toggle="popover" data-placement="top" data-content="Youtube Link"></i>
                    </label>
                    <div class='col-xs-9'>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control input-sm" value="" id="link" />
                            <span class="input-group-addon"><li class="fa fa-asterisk"></li></span>
                        </div>
                    </div>

                </div>
                <div id="output">
                    <hr />
                    <div class="form-group">
                        <label for="type" class="col-xs-3 control-label">Title
                            <i class="fa fa-question-circle text-info helper" data-container="body" 
                               data-toggle="popover" data-placement="top" data-content="Title"></i>
                        </label>
                        <div class='col-xs-9'>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control input-sm" value="" id="title" />
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
                                <textarea class="form-control input-sm" style="min-height: 150px;" id="description"></textarea>
                                <a class="input-group-addon clip"><i class='fa fa-clipboard'></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-xs-3 control-label">Keywords
                            <i class="fa fa-question-circle text-info helper" data-container="body" 
                               data-toggle="popover" data-placement="top" data-content="Keyword"></i>
                        </label>
                        <div class="col-xs-9">
                            <div class="input-group input-group-sm">
                                <textarea class="form-control input-sm" id="keyword" style="min-height: 80px;"></textarea>
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
    $(document).ready(function() {
        $("#propertiesLink").addClass("active");
    });
</script>