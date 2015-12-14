<!-- Begin page content -->
<div class="col-xs-12">
    <h4 style="text-align: center; font-weight: bold;">Profiles</h4>
    <hr style="margin: 10px 300px;"/>
    <p><a href="<?php echo base_url() . 'property' ?>">&Leftarrow; Return to Properties</a></p>
    <div class="col-xs-3">
        <a class="btn btn-success btn-sm btn-block" href="<?php echo base_url() . 'profiles/add/aab' ?>"><i
            class="fa fa-plus"></i> Add a Profile</a>
        </div>
        <div class="col-xs-3 col-xs-offset-6">
            <a class="btn btn-default btn-sm btn-block" target="_blank"
            href="http://support.merlinleads.com/profile-setup/"><i
            class="fa fa-video-camera"></i> Setting up a Profile Guide</a>

        </div>
        <div class="col-xs-12">
            <div id="profileMessage" style="margin-top: 10px;">
                <?php
                if (isset($_SESSION['message'])) {
                    ?>
                    <div class="alert alert-warning"><i class="fa fa-warning"></i> <?php echo $_SESSION['message']; ?>
                    </div>
                    <?php
                    unset($_SESSION['message']);
                }
                ?>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="table-responsive">
                <table cellpadding="0" cellspacing="0" border="0" class="display table table-striped" id="profiles">
                    <thead>
                        <tr>
                            <th width="10%">Actions</th>
                            <th width="45%">Profile Name</th>
                            <th width="30%">Type</th>
                            <th width="15%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="dataTables_empty">Loading data from server</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#profilesLink").addClass("active");
        });
    </script>