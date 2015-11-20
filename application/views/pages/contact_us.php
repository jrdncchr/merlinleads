<!-- Begin page content -->
<div class="container">
    <div class='row'>
        <div class='col-xs-8'>
            <img src="<?php echo base_url() . IMG . 'logo.png'; ?>" class="img-responsive">
            <h2>Contact Us</h2>
            <form class="form-horizontal" role="form" action="<?php echo base_url() . "pages/send_email" ?>" method="post">
                <div class="form-group">
                    <div class="col-xs-10">
                        <?php
                        if (isset($_SESSION['message'])) {
                            ?>
                            <div class="alert alert-danger"><i class="fa fa-exclamation"></i> <?php echo $_SESSION['message']; ?></div>
                            <?php
                            session_destroy();
                        }
                        ?>

                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-xs-2 control-label">Email</label>
                    <div class="col-xs-9">
                        <input type="text" class="form-control" name="email" value="<?php if(isset($user)) { echo $user->email; } ?>" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="message" class="col-xs-2 control-label">Message</label>
                    <div class="col-xs-9">
                        <textarea class="form-control" name="message" placeholder="Type your message here"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="secureimage" class="col-xs-2 control-label">Validation</label>
                    <div class="col-xs-9">
                        <img id="captcha" src="<?php echo base_url() . OTHERS . "securimage/securimage_show.php" ?>" alt="CAPTCHA Image" />
                        <input type="text" name="captcha_code" size="10" maxlength="6" />
                        <a href="#" onclick="document.getElementById('captcha').src = '<?php echo base_url() . OTHERS . "securimage/securimage_show.php?" ?>' + Math.random();
                                return false;">[ Different Image ]</a>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="col-xs-2 control-label"></label>
                    <div class="col-xs-9">
                        <button type="submit" class="pull-right btn btn-primary">Send Message</button>
                    </div>
                </div>
            </form>
        </div>
        <div class='col-xs-4'>
            <div class="well">
                Side Content
            </div>
        </div>
    </div>
</div>