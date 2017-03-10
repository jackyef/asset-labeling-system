<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/8/2017
 * Time: 3:53 PM
 */
?>
<!DOCTYPE html>
<head>
    <title> {title} </title>
    <link rel="stylesheet" href="<?= base_url() ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>css/bootstrap-select.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>css/sidenav.css">
    <script src="<?= base_url() ?>js/jquery.js"></script>
    <script src="<?= base_url() ?>js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>js/bootstrap-select.js"></script>
    <script src="<?= base_url() ?>js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>js/dataTables.bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.data-table').DataTable();
        } );
    </script>
</head>
<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Als</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <!-- this Masters dropdown is admin-only -->
                <?php if ($is_admin == 1): ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Masters <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= base_url()?>master/supplier">Supplier <span class="label label-success">done</span></a></li>
                        <li><a href="<?= base_url()?>master/company">Company <span class="label label-success">done</span></a></li>
                        <li><a href="<?= base_url()?>master/employee">Employee</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?= base_url()?>master/location">Location <span class="label label-success">done</span></a></li>
                        <li><a href="<?= base_url()?>master/fsub-location">1st Sub-location <span class="label label-success">done</span></a></li>
                        <li><a href="<?= base_url()?>master/ssub-location">2nd Sub-location <span class="label label-success">done</span></a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?= base_url()?>master/item-type">Item type <span class="label label-success">done</span></a></li>
                        <li><a href="<?= base_url()?>master/brand">Brand <span class="label label-success">done</span></a></li>
                        <li><a href="<?= base_url()?>master/model">Model <span class="label label-success">done</span></a></li>
                        <li><a href="<?= base_url()?>master/mutation-status">Mutation Status <span class="label label-success">done</span></a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?= base_url()?>master/user">User</a></li>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- The ones below can be accessed by any users -->
                <li><a href="#">Item</a></li>
                <li><a href="#">Assembled Item</a></li>
                <li><a href="#">Mutation History</a></li>
                <li><a href="#">Company</a></li>
                <li><a href="#">Employee</a></li>
            </ul>


            <!-- this is the right part of the nav-bar -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hi, {username}! <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= base_url().'user/chpass/'.$user_id ?>"><span class="fa fa-pencil"></span> Change password</a></li>
                        <li><a href="#"><span class="fa fa-sign-out"></span> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="container">