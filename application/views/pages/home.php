<!-- Begin page content -->
<div class="container">
    <div class='row'>
        <div class='col-xs-8'>
            <?php
            if (isset($_SESSION['message'])) {
                ?>
                <div class="alert alert-success"><i class="fa fa-check"></i> You have activated your account, you may now login.</div>
                <?php
                unset($_SESSION['message']);
            }
            ?>
            <img src="<?php echo base_url() . IMG . 'logo.png'; ?>" class="img-responsive">
            Main Content
        </div>
        <div class='col-xs-4'>
            <div class="well">
                Side contents
            </div>
        </div>
    </div>
</div>

<script>
    $("#homeNav").addClass('active');
</script>
