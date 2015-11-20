

<script src="<?php echo base_url() . JS . "bootstrap.min.js"; ?>"></script>
<script src="<?php echo base_url() . JS . "bootstrap-switch.min.js"; ?>"></script>
<script src="<?php echo base_url() . JS . "jquery-ui-timepicker-addon.js"; ?>"></script>
<script src="<?php echo base_url() . JS . "toastr.min.js"; ?>"></script>
<script src="<?php echo base_url() . JS . "jquery.fileupload.js"; ?>"></script>
<script src="<?php echo base_url() . JS . "jquery.iframe-transport.js"; ?>"></script>
<script src="<?php echo base_url() . JS . "vendor/jquery.ui.widget.js"; ?>"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="<?php echo base_url() . JS . "ajaxfileupload.js"; ?>"></script>

<script src="<?php echo base_url() . JS . "all.js"; ?>"></script>
<script src="<?php echo base_url() . JS . "validation.js"; ?>"></script>
<script src="<?php echo base_url() . JS . "global.js"; ?>"></script>

<?php foreach ($js as $j): ?>
    <script src="<?php echo base_url() . JS . $j ?>"></script>
<?php endforeach; ?>

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
    //Google Analytics Code Here
</script>