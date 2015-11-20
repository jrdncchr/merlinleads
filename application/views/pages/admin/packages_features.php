<div class='row'>
    <div class='col-xs-11'>

        <div class="row">
            <div class="col-xs-12">
                <div id="message">
                    <?php
                    if(isset($_SESSION['message'])) { ?>
                        <div class="alert alert-success text-center">
                            <i class="fa fa-check-circle"></i>
                        <?php echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        ?>
                        </div>
                    <?php } ?>
                </div>
                <button id="showAddEditModalBtn" type="button" class="btn btn-sm btn-success">Add Packages Features</button>
            </div>

        </div>

        <div class="row" style="margin-top: 20px;">
        <?php
        if($packages_features) {
            foreach ($packages_features as $pf) {
                $package_feature = json_decode($pf->features_json);
                ?>
                <div class="col-xs-4 pf">
                    <input type="hidden" class="id" value="<?php echo $pf->id; ?>"/>
                    <input type="hidden" class="name" value="<?php echo $pf->name; ?>"/>
                    <input type="hidden" class="status" value="<?php echo $pf->status; ?>"/>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <?php if ($pf->status == 1) { ?>
                                <th style="color: darkgreen;" class="text-center"><?php echo $pf->name; ?></th>
                            <?php } else { ?>
                                <th style="color: red;" class="text-center"><?php echo $pf->name; ?></th>
                            <?php } ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($features as $f): ?>
                            <tr>
                                <td class="text-center">
                                    <?php
                                    if ($f->input_type == "number") {
                                        echo $f->name . ": <b style='color: darkgreen;'>" . $package_feature->{$f->key} . "</b> <span class='$f->key' style='display: none;'>" . $package_feature->{$f->key} . "</span>";
                                    } else {
                                        if (isset($package_feature->{$f->key})) {
                                            if ($package_feature->{$f->key} == "on") {
                                                echo $f->name . ": <b style='color: darkgreen;'><i class='fa fa-check'></i></b><span class='$f->key' style='display: none;'>on</span>";
                                            } else {
                                                echo $f->name . ": <b style='color: red;'><i class='fa fa-times'></i></b><span class='$f->key' style='display: none;'>off</span>";
                                            }
                                        } else {
                                            echo $f->name . ": <b style='color: red;'><i class='fa fa-times'></i></b><span class='$f->key' style='display: none;'>off</span>";
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary btn-xs btn-block editBtn">Edit</button>
                                <button type="button" class="btn btn-default btn-xs btn-block deleteBtn">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            <?php
            }
        }?>
        </div>
    </div>

</div>

<!-- Add PF Modal -->
<div class="modal fade" id="addEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addModalTitle">Add Package Feature</h4>
            </div>
            <div class="modal-body">
                <form id="addEditForm" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="email" class="col-xs-5 control-label">Status</label>
                        <div class="col-xs-7">
                            <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="0">Disabled</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-xs-5 control-label">Name</label>
                        <div class="col-xs-7">
                            <input type="text" class="form-control required" name="name" id="name" placeholder="Ex. Basic">
                        </div>
                    </div>
                    <?php foreach($features as $f): ?>
                        <div class="form-group">
                            <label for="feature" class="col-xs-5 control-label"><?php echo $f->name; ?></label>
                            <div class="col-xs-7">
                                <?php if($f->input_type == "number") { ?>
                                    <input type="text" id="<?php echo $f->key; ?>" class="form-control required" name="<?php echo $f->key; ?>">
                                <?php } else { ?>
                                    <div class="checkbox">
                                        <label>
                                            <input name="<?php echo $f->key; ?>" id="<?php echo $f->key; ?>" type="checkbox" />
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">Close</button>
                <button id="saveBtn" type="button" class="btn btn-xs btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $('#packagesSideLink').addClass('custom-nav-active');
        $('#packagesFeaturesTopLink').addClass('custom-nav-active');
    });
</script>