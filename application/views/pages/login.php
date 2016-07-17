<!-- Begin page content -->
<div class="container">
    <div class='row'>
        <div class='col-xs-3'></div>
        <div class='col-xs-6'>
            <img src="<?php echo base_url() . IMG . 'merlin-leads-logo.jpg'; ?>" class="img-responsive" />
            <div class="col-xs-1"></div>
            <div class="col-xs-10">
                <h3 class="text-center" style="font-weight: bold;">Login</h3>
                <hr />
                <form class="form-horizontal" role="form" action="<?php echo base_url() . "pages/login_attempt" ?>" method="post">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <?php echo $this->session->flashdata('message'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-xs-3 control-label">Email</label>
                        <div class="col-xs-9">
                            <input type="email" class="form-control" name="loginEmail" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-xs-3 control-label">Password</label>
                        <div class="col-xs-9">
                            <input type="password" class="form-control" name="loginPassword" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username" class="col-xs-3 control-label"></label>
                        <div class="col-xs-5">
                            <p><a href="<?php echo base_url() . "registration"; ?>"><small>Not yet registered?</small></a></p>
                            <p><a href="<?php echo base_url() . "pages/forget_password"; ?>"><small>Forget password?</small></a></p>
                        </div>
                        <div class="col-xs-4">
                            <button type="submit" class="pull-right btn btn-primary">Login</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <div class='col-xs-3'></div>
    </div>
</div>