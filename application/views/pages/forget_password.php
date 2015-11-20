<!-- Begin page content -->
<div class="container">
    <div class='row'>
        <div class='col-xs-3'></div>
        <div class='col-xs-6'>
            <img src="<?php echo base_url() . IMG . 'merlin-leads-logo.jpg'; ?>" class="img-responsive" />
            <div class="col-xs-1"></div>
            <div class="col-xs-10">
                <h3 class="text-center" style="font-weight: bold;">Forget Password</h3>
                <hr />
                <form class="form-horizontal" role="form" action="<?php echo base_url() . "pages/forget_password_attempt" ?>" method="post">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <?php
                            if (isset($_SESSION['message'])) {
                                ?>
                                <?php echo $_SESSION['message']; ?>
                                <?php
                                unset($_SESSION['message']);
                            }
                            ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username" class="col-xs-3 control-label">Email</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="email" placeholder="Email" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username" class="col-xs-3 control-label"></label>
                        <div class="col-xs-9">
                            <a href="<?php echo base_url() . "pages/login"; ?>"><small>&LeftArrow; Return to Login</small></a>
                            <button type="submit" class="pull-right btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <div class='col-xs-3'></div>
    </div>
</div>