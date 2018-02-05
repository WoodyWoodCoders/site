<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title><?php echo $this->page["title"] ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />

        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css" />
        <link href="public/tools/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <link href="public/tools/jquery-ui-1.12.0.custom/jquery-ui.min.css" rel="stylesheet" type="text/css" />
        <link href="public/tools/jquery-ui-1.12.0.custom/jquery-ui.theme.min.css" rel="stylesheet" type="text/css" />
        <link href="public/tools/jquery-ui-1.12.0.custom/jquery-ui.structure.min.css" rel="stylesheet" type="text/css" />
        <link href="public/css/classesCommunes.css" rel="stylesheet" type="text/css" />

        <link href="<?= $this->layoutPath; ?>visitors/style.css" rel="stylesheet" type="text/css" />

        <?php
            if(!empty($this->includeCSS)) :
                foreach($this->includeCSS as $include) :
                    $http = substr($include, 0, 7);
                    echo '<link rel="stylesheet" href="' . ($http === "https:/" || $http === "http://"
                                                            ? ""
                                                            : GLOBAL_PATH ) . $include . '">';
                endforeach;
            endif;
        ?>
        <!-- <link rel="shortcut icon" href="favicon.ico" /> </head> -->
    <!-- END HEAD -->
</head>
    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <?php echo $content; ?>
        </div>
        <!--[if lt IE 9]>
<script src="public/plugins/respond.min.js"></script>
<script src="public/plugins/excanvas.min.js"></script>
<script src="public/plugins/ie8.fix.min.js"></script>
<![endif]-->
        <script src="public/tools/jquery-2.2.4.min.js" type="text/javascript"></script>
        <script src="public/tools/jquery-ui-1.12.0.custom/jquery-ui.min.js" type="text/javascript"></script>
        <script src="public/tools/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>

        <?php
            if(!empty($this->includeJS)) :
                foreach($this->includeJS as $include) :
                    $http = substr($include, 0, 7);
                    echo "\n        <script src='" . ($http === "https:/" || $http === "http://"
                                                    ? ""
                                                    : GLOBAL_PATH ) . $include . "' type='text/javascript'></script>";
                endforeach;
            endif;
        ?>

</body>



</html>
