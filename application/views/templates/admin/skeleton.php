<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<?php echo $head ?>
<body>
<div class="wrap">
    <?php echo $nav ?>
    <div id="content" style="margin-top: 60px;">
        <div class="row">
            <?php echo $global; ?>

            <div class="col-xs-2">
                <?php echo $quicklink; ?>
            </div>
            <div class="col-xs-10">
                <?php echo $content ?>
            </div>
        </div>
    </div>
    <div class="push"></div>
</div>
<?php //echo $footer ?>
<?php echo $scripts ?>
</body>
</html>