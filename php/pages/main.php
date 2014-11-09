<?php
/*
 * Copyright 2014 rintintin.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>GameBook</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="<?php echo ROOT_DIR; ?>style/bootstrap.css">
        
        <!-- Add custom CSS here -->
        <link rel="stylesheet" href="<?php echo ROOT_DIR; ?>style/style_admin.css">
        <link rel="stylesheet" href="<?php echo ROOT_DIR; ?>style/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo ROOT_DIR; ?>style/signin.css">
    </head>

    <body>
        <div id="wrapper">
            <!-- Navigation -->
            <nav id="#header" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?php echo ROOT_DIR; ?>">
                            <img src="<?php echo ROOT_DIR; ?>images/fav.png" width="15"/> GameBook</a>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right navbar-user text-center profile" id="user" style="display: none;">
                            <li class="dropdown user-dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Иван Пешев <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="profile.html"><i class="fa fa-user"></i> Профил</a></li>
                                    <li><a href="#"><i class="fa fa-power-off"></i> Излез</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right text-center">
                            <li>
                                <a href="<?php echo ROOT_DIR; ?>?page=players">Players</a>
                            </li>
                            <li>
                                <a href="<?php echo ROOT_DIR; ?>?page=games">Games</a>
                            </li>
                            <li>
                                <a href="<?php echo ROOT_DIR; ?>?page=clubs">Clubs</a>
                            </li>
                            <li>
                                <a href="<?php echo ROOT_DIR; ?>?page=home">Login/Sign Up</a>
                            </li>
                        </ul>

                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container -->
            </nav>
        </div>

        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12 text-center"><br><br>
                    <a href="index.html"><img src="<?php echo ROOT_DIR; ?>images/logo_medium.png" class="logo" /></a><br>
                    <!--<h1><small>Добре дошли в GameBook.</small></h1>-->
                    <!-- <div class="alert alert-info alert-dismissable">
                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                         Hi, my name is alert. You can close me any time you want.
                    <!--Свободни места: <a class="alert-link" href="http://tablesorter.com/docs/"> 12</a><br>Резервирани места: <a class="alert-link" href="http://tablesorter.com/docs/"> 12</a>-->
                    <!--</div>-->
                </div>
            </div><!-- /.row -->
            <br><br>
            <?php
            select_page($page);
            ?>

        </div><!-- /#page-wrapper --><br><br><br><br>
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p class="copyright text-muted small">Email за контакти: <a href="mailto:tttodorov@uni-sofia.bg">games@uni-sofia.bg</a></p>
                        <p class="copyright text-muted small">Copyright &copy; GameBook 2014. All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- JavaScript -->
        <script src="js/jquery-1.10.2.js"></script>
        <script src="js/bootstrap.js"></script>

        <!-- Page Specific Plugins -->
        <script src="js/tablesorter/jquery.tablesorter.js"></script>
        <script src="js/tablesorter/tables.js"></script>

    </body>
</html>