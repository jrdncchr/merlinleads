<!-- Begin page content -->
<div class="col-xs-11">
    <h1>Store</h1>
    <hr />
        <center>
        <?php if($message == "Success") { ?>
            <h3>Thank you!</h3>
            <p>You are now subscribed on <?php echo "<b>$packageName</b>" ?>!</p>
            <a href="<?php echo base_url() . 'property'; ?>"><i class="fa fa-arrow-left"></i> Return to Properties</a>
        <?php } else { ?>
            <p class="text-error"><?php echo $message; ?></p>
        <?php } ?>
        </center>
    <p></p>
</div>

<script>
    $('#storeLink').addClass('active');
    $('#storeNav').addClass('active');
</script>
