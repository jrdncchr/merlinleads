<div class='row'>
    <div class='col-xs-12'>

        <div class="form-group">
            <div class="col-xs-12">
                <div id="message"></div>
            </div>
        </div>

        <div class="col-xs-4">
            <h5><b>Features</b></h5>
            <div class="row">
                <div class="col-xs-12">
                    <?php if(sizeof($features) > 0) { ?>
                        <select multiple id="features" class="form-control" style="height: 400px;">
                            <?php
                            foreach($features as $feature){
                                ?>
                                <option value="<?php echo $feature->id; ?>"><?php echo $feature->name; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    <?php } ?>
                </div>
            </div>
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-default btn-xs" id="showAddFormBtn"><i class="fa fa-plus"></i></button>
                <button type="button" class="btn btn-default btn-xs" id="deleteFeatureBtn"><i class="fa fa-minus"></i></button>
            </div>
        </div>

        <div id="featureDetailsDiv" class="col-xs-8" style="display: none;">
            <h5  style="font-weight: bold;">Feature Details</h5>
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label for="email" class="col-xs-3 control-label">Name</label>
                    <div class="col-xs-9">
                        <input type="text" class="form-control" id="featureName" placeholder="Number of Properties">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-xs-3 control-label">Description</label>
                    <div class="col-xs-9">
                        <input type="text" class="form-control" id="featureDescription" placeholder="Description">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-xs-3 control-label">Key</label>
                    <div class="col-xs-9">
                        <input type="text" class="form-control" id="featureKey" placeholder="Ex. number_of_property">
                        <p class="text-muted small">Ex. if name is 'Number of Properties', the key must be number_of_properties</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-xs-3 control-label">Default Value</label>
                    <div class="col-xs-9">
                        <input type="text" class="form-control" id="featureDefaultValue" placeholder="Default Value">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-xs-3 control-label">Input Type</label>
                    <div class="col-xs-9">
                        <select id="featureInputType" id="featureInputType" class="form-control">
                            <option value="checkbox" selected>Check Box</option>
                            <option value="number">Number</option>
                        </select>
                        <p class="text-muted small">The input type that shows in packages features.</p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <button id="saveFeatureBtn" type="button" class="btn btn-xs btn-primary pull-right">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#packagesSideLink').addClass('custom-nav-active');
        $('#featuresTopLink').addClass('custom-nav-active');
    });
</script>