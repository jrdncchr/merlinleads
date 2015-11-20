<div class='row'>
    <div class='col-xs-12'>
        <div class="form-group">
            <div class="col-xs-12">
                <div id="storeMessage"></div>
            </div>
        </div>

      <div class="col-xs-4">
            <h5 for="text"><b>Packages</b></h5>
            <select multiple id="packages" class="form-control" style="min-height: 200px;">
                <?php
                for ($i = 0; $i < sizeof($packages); $i++) {
                    ?>
                    <option value="<?php echo $packages[$i]->id; ?>"><?php echo $packages[$i]->name; ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div id="packageInformationDiv" style='display: none;' class="col-xs-8">
            <h5><b>Package Information</b></h5>

            <form class="form-horizontal">
                <div class="form-group">
                    <label for="type" class="col-xs-3 control-label">Stripe Plan Id</label>
                    <div class="col-xs-8">
                        <input type="text" id="stripePlanId" class="form-control required" readonly="true" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="type" class="col-xs-3 control-label">Name</label>

                    <div class="col-xs-8">
                        <input type="text" id="packageName" class="form-control required" readonly="true"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="type" class="col-xs-3 control-label">Package Feature</label>

                    <div class="col-xs-8">
                        <select id="packageFeature" class="form-control required">
                            <?php foreach($packages_features as $pf): ?>
                                <option value="<?php echo $pf->id ?>"><?php echo $pf->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="type" class="col-xs-3 control-label">Status</label>

                    <div class="col-xs-8">
                        <select id="packageStatus" class="form-control required">
                            <option value='Active'>Active</option>
                            <option value='Inactive'>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="type" class="col-xs-3 control-label">Show</label>
                    <div class="col-xs-8">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="show"> Check to show in the Upgrade page
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-11">
                        <button type="button" class="btn btn-primary btn-sm pull-right" id="packageUpdateBtn">Update</div>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $('#packagesSideLink').addClass('custom-nav-active');
        $('#packagesTopLink').addClass('custom-nav-active');
    });
</script>