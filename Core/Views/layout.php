<?php global $userLogged; ?>
<?php global $user; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $this->page["title"] ?></title>

    <!-- Bootstrap -->

    <link href="public/tools/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

    <link href="public/tools/jquery-ui-1.12.0.custom/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <link href="public/tools/jquery-ui-1.12.0.custom/jquery-ui.theme.min.css" rel="stylesheet" type="text/css" />
    <link href="public/tools/jquery-ui-1.12.0.custom/jquery-ui.structure.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome -->
    <link href="public/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="public/assets/css/custom.min.css" rel="stylesheet">

    <!--  Mes CSS -->
    <link href="public/css/register.css" rel="stylesheet">
    <link href="public/css/classesCommunes.css" rel="stylesheet">
    <link href="public/css/style.css" rel="stylesheet">

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
</head>

<body class="nav-sm">
    <div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div id="modal-body" class="modal-content">
                <?php if(!empty($this->includeModal)) {
                        if(is_array($this->includeModal)) {
                            foreach($this->includeModal as $modal) {
                                include($modal);
                            }
                        } else {
                            include($this->includeModal);
                        }
                    }
                    ?>
            </div>
        </div>
    </div>
<div class="container body">
    <div id="main-container" class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="index.php" class="site_title">
                        <img src="public/logo.png" class="max-width-100" />
                    </a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <?php if ($userLogged): ?>
                <div class="profile clearfix">
                    <!-- <div class="profile_pic">
                        <img src="images/img.jpg" alt="..." class="img-circle profile_img">
                    </div> -->
                    <div class="profile_info">
                        <span>Bienvenue, </span>
                        <h2><?php echo $user->getNom() ?></h2>
                    </div>
                </div>
                <?php endif; ?>
                <!-- /menu profile quick info -->

                <br>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section active">
                        <h3>General</h3>
                        <ul class="nav side-menu" style="">
                            <li class="active">
                                <a href="index.php?=client">
                                    <i class="fa fa-home"></i> Clients <span class="fa fa-chevron-down"></span>
                                </a>
                            </li>
                            <li><a><i class="fa fa-edit"></i> Gestion <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="index.php?p=composant">Gestion des composants</a></li>
                                    <li><a href="index.php?p=module">Gestion des modules</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="" data-original-title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="" href="login.html" data-original-title="Logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if ($userLogged): ?>
                        <li>
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <?php echo $user->getNom() ?>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <!-- <li><a href="javascript:;"> Mon profil</a></li> -->
                                <li><a href="index.php?p=user&a=logout"><i class="fa fa-sign-out pull-right"></i> Me déconnecter</a></li>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div id="container" class="">
                <?php echo $content; ?>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                © WoodyWoodCoders 2018 -  Bootstrap Admin Template Gentelella created by <a href="https://colorlib.com">Colorlib</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src="public/tools/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="public/tools/jquery-ui-1.12.0.custom/jquery-ui.min.js" type="text/javascript"></script>
<script src="public/tools/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>

<!-- bootstrap-daterangepicker -->
<!-- Custom Theme Scripts -->
<script src="public/assets/js/custom.min.js"></script>
<script src="public/script/global.js"></script>


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

        <?php if (!empty($this->page["script"])): ?>
        <script type="text/javascript">
            $(function() {
                <?php echo $this->page["script"] ; ?>
            });
        </script>
        <?php endif; ?>
</body>
</html>
