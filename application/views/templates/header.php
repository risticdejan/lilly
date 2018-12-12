<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Lilly</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo site_url('resources/css/bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo site_url('resources/css/bootstrap-theme.min.css');?>" rel="stylesheet">
    <link href="<?php echo site_url('resources/css/style.css');?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="main-loader">
    <div class="fx-box">
        <div class="loader-fx"></div>
    </div>
</div>
<div class="container">
    <div class="header">
    <!-- Static navbar -->
        <nav class="navbar navbar-default">
        <div>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Lilly</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li <?php echo set_active('home');?>>
                        <a href="<?php echo site_url('home');?>">
                            <i class="fa fa-home" aria-hidden="true"></i> Početna
                        </a>
                    </li>
                    <?php if( check_login() ) : ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administracija <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li <?php echo set_active('admin');?> >
                                <a href="<?php echo site_url('admin');?>" style="white-space: nowrap;">
                                    <i class="fa fa-home" aria-hidden="true"></i> Prodajna mesta
                                </a>
                            </li>
                            <li <?php echo set_active('admin/image');?> >
                                <a href="<?php echo site_url('admin/image');?>" style="white-space: nowrap;">
                                    <i class="fa fa-home" aria-hidden="true"></i> Uploud slika
                                </a>
                            </li>
                            <li <?php echo set_active('barcode');?>>
                                <a href="<?php echo site_url('barcode');?>" style="white-space: nowrap;">
                                    <i class="fa fa-home" aria-hidden="true"></i> Bar kodovi
                                </a>
                            </li>
                        </ul>
                    </li>

                    <?php endif;?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if( ! check_login() ) : ?>
                    <li <?php echo set_active('login');?>>
                        <a href="<?php echo site_url('login');?>">
                            <i class="fa fa-sign-in" aria-hidden="true"></i> login
                        </a>
                    </li>
                    <li <?php echo set_active('register');?>>
                        <a href="<?php echo site_url('register');?>">
                            <i class="fa fa-sign-in" aria-hidden="true"></i> Registracija
                        </a>
                    </li>

                    <?php else : ?>
                        <li>
                            <a href="<?php echo site_url('logout');?>" id="logout">
                                <i class="fa fa-sign-out" aria-hidden="true"></i> logout
                            </a>
                        </li>
                    <?php endif;?>
                </ul>
            </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>
    </div>

    <?php if(isset($_SESSION['message'])) : ?>
        <div class="alert alert-<?= $_SESSION['message_class'];?> text-center">
        <p>
            <?= $_SESSION['message'];?>
        </p>
    </div>
    <?php endif;?>

