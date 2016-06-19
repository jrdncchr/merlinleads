<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title ?></title>
    <meta name="description" content="<?php echo $description ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo base_url() . CSS . 'normalize.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . CSS . 'bootstrap.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . CSS . 'bootstrap-yeti.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . CSS . 'bootstrap-timepicker.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . CSS . 'bootstrap-switch.min.css'; ?>">
<!--    <link rel="stylesheet" href="--><?php //echo base_url() . CSS . 'jquery-ui-1.10.3.custom.min.css'; ?><!--">-->
<!--    <link rel="stylesheet" href="--><?php //echo base_url() . CSS . 'datatables/jquery.dataTables.css'; ?><!--">-->
    <link rel="stylesheet" href="<?php echo base_url() . CSS . 'jquery.dataTables_themeroller.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . CSS . 'toastr.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . CSS . 'style.css'; ?>">

    <?php if($admin): ?>
        <link rel="stylesheet" href="<?php echo base_url() . CSS . 'bootstrap-sidenav.css'; ?>" />
    <?php endif; ?>

    <link rel="stylesheet" href="<?php echo base_url() . FONT . 'css/font-awesome.min.css'; ?>">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="<?php echo base_url() . CSS . 'jquery-ui-bootstrap/jquery-ui-1.10.0.custom.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . CSS . 'jquery-ui-bootstrap/jquery.ui.1.10.0.ie.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . CSS . 'jquery-ui-bootstrap/jquery.ui.1.9.2.ie.css'; ?>">


    <?php foreach ($bower_components['css'] as $bc): ?>
        <link rel="stylesheet" href="<?php echo base_url() . "bower_components/" . $bc; ?>">
    <?php endforeach; ?>

    <?php foreach ($css as $c): ?>
        <link rel="stylesheet" href="<?php echo base_url() . CSS . $c; ?>">
    <?php endforeach; ?>

    <script src="<?php echo base_url() . JS . 'modernizr-2.6.2.min.js'; ?>"></script>
    <script src="<?php echo base_url() . JS . "jquery-1.11.2.min.js"; ?>"></script>
    <script src="<?php echo base_url() . 'bower_components/vue/dist/vue.min.js'; ?>"></script>
<!--    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>-->
    <script src="<?php echo base_url() . JS . "jquery-ui.min.js"; ?>"></script>
    <script src="<?php echo base_url() . JS . "datatables/jquery.dataTables.js"; ?>"></script>
<!--    <script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>-->
    <script src="<?php echo base_url() . JS . "datatables/fnReloadAjax.js"; ?>"></script>
    <script src="<?php echo base_url() . JS . "datatables/dataTables.fixedColumns.min.js"; ?>"></script>

    <script src="<?php echo base_url() . JS . "jquery.zclip.js"; ?>"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->



    <script>
        var base_url = "<?php echo base_url(); ?>";
    </script>
</head>