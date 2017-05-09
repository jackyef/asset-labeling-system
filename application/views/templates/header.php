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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
    <title> {title} </title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url()?>favicon.png"/>

    <link rel="stylesheet" href="<?= base_url() ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>css/bootstrap-select.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>css/bootstrap-datepicker3.standalone.min.css">
<!--    <link rel="stylesheet" href="--><?//= base_url() ?><!--css/dataTables.min.css">-->
    <link rel="stylesheet" href="<?= base_url() ?>css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>css/dataTables-ext2.min.css">
<!--    <link rel="stylesheet" href="--><?//= base_url() ?><!--css/jquery.dataTables.css">-->
    <link rel="stylesheet" href="<?= base_url() ?>css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>css/sidenav.css">
    <!-- Material Design fonts -->
<!--    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">-->
<!--    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">-->
<!--    <link rel="stylesheet" href="--><?//= base_url() ?><!--css/bootstrap-material-design.min.css">-->
<!--    <link rel="stylesheet" href="--><?//= base_url() ?><!--css/material-kit.css">-->
<!--    <link rel="stylesheet" href="--><?//= base_url() ?><!--css/ripples.min.css">-->
    <link rel="stylesheet" href="<?= base_url() ?>css/print.css">
    <script src="<?= base_url() ?>js/jquery.js"></script>
    <script src="<?= base_url() ?>js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>js/bootstrap-select.js"></script>
    <script src="<?= base_url() ?>js/bootstrap-datepicker.min.js"></script>
<!--    <script src="--><?//= base_url() ?><!--js/dataTables.min.js"></script>-->
    <script src="<?= base_url() ?>js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>js/dataTables.bootstrap.min.js"></script>
    <script src="<?= base_url() ?>js/dataTables-ext2.min.js"></script>
<!--    <script src="--><?//= base_url() ?><!--js/material.min.js"></script>-->
<!--    <script src="--><?//= base_url() ?><!--js/material-kit.js"></script>-->
<!--    <script src="--><?//= base_url() ?><!--js/nouislider.min.js"></script>-->
<!--    <script src="--><?//= base_url() ?><!--js/ripples.min.js"></script>-->

    <script>
        $(document).ready(function() {
//            $('.page-loading').fadeOut(1500);
//            $.material.init();
            setTimeout(function(){
                $('.page-fade').fadeIn(800);


                $('.data-table').DataTable({
                    responsive: true,
//                fixedHeader: true,
//                scrollX: true,
//                scrollY: "300px",
                    colReorder: true
//                dom: 'Blfrtip',
//                buttons: ['print', 'colvis']
                });
            }, 0);



        } );
    </script>
    <style type="text/css">
        .page-loading {
            display: none;
            position: relative;
            width: 100%;
            min-height: 100%;
            margin: 0 auto;
            z-index: 99999;
            font-size: 3em;
            text-align: center;
            vertical-align: middle;
            padding-top: 10%;
            bottom: 0;
            left: 0;
            right: 0;
        }
    </style>
    <noscript>
        <!-- shows page content if javascript is disabled -->
        <style type="text/css">
            .page-fade{
                display: block;
            }
            .page-loading{
                display: none;
            }
        </style>
    </noscript>
</head>
<body style="overflow-x: hidden">
<?//= json_encode($is_logged_in) ?>
<?//= json_encode($session_is_admin) ?>
<?//= json_encode($session_user_id) ?>
<?//= json_encode($session_username) ?>

<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container" >
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" style="padding-top: .35em; margin-top: 0em; margin-bottom: 0em" href="<?= base_url()?>">
<!--                <span class="fa-stack fa-sm" >-->
<!--                      <i class="fa fa-square-o fa-stack-2x"></i>-->
<!--                      <i class="fa fa-tag fa-stack-1x"></i>-->
<!--                      <i class="fa fa-laptop fa-stack-1x"></i>-->
<!--                </span>-->
                <span class="fa fa-sm fa-laptop fa-2x"></span>
                <span class="fa fa-sm fa-tag" ></span>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav" style="margin-top: 0em; margin-bottom: 0em">
                <!-- this Masters dropdown is admin-only -->
                <?php if ($is_logged_in == 1): ?>
                <?php if ($permission_master == 1 || $permission_user_management == 1): ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Masters <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <?php if ($permission_master == 1): ?>
                        <li><a href="<?= base_url()?>master/supplier">Supplier</a></li>
                        <li><a href="<?= base_url()?>master/company">Company</a></li>
                        <li><a href="<?= base_url()?>master/employee">Employee</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?= base_url()?>master/location">Location</a></li>
                        <li><a href="<?= base_url()?>master/fsub-location">1st Sub-location</a></li>
                        <li><a href="<?= base_url()?>master/ssub-location">2nd Sub-location</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?= base_url()?>master/item-type">Item type</a></li>
                        <li><a href="<?= base_url()?>master/brand">Brand</a></li>
                        <li><a href="<?= base_url()?>master/model">Model</a></li>
                        <li><a href="<?= base_url()?>master/mutation-status">Mutation Status</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?= base_url()?>master/os">Operating System</a></li>
                        <li role="separator" class="divider"></li>
                    <?php endif; ?>
                    <?php if ($permission_user_management == 1): ?>
                        <li><a href="<?= base_url()?>master/user">User</a></li>
                    <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- The ones below can be accessed by any users as long as they're logged in-->
                <li><a href="<?= base_url().'item'?>">Item</a></li>
                <li><a href="<?= base_url().'assembled-item'?>">Assembled Item</a></li>
                <li><a href="<?= base_url().'mutation-history'?>">Mutation History</a></li>
                <li><a href="<?= base_url().'company'?>">Company</a></li>
                <li><a href="<?= base_url().'employee'?>">Employee</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Barcode <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= base_url()?>barcode">Read barcode</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?= base_url()?>barcode/print">Generate labels</a></li>
                    </ul>
                </li>
                <?php else: ?>
                <!-- If not admin, and not logged in, then only show Home, Help, About, etc. -->
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li><a href="<?= base_url().'help' ?>">Help</a></li>
                <li><a href="<?= base_url().'about' ?>">About</a></li>
                <?php endif; ?>
            </ul>


            <!-- this is the right part of the nav-bar -->
            <ul class="nav navbar-nav navbar-right" style="margin-top: 0em; margin-bottom: 0em">
                <?php if ($is_logged_in == 1): ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hi, {session_username}! <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= base_url().'home/chpass/'.$session_user_id ?>"><span class="fa fa-pencil"></span> Change password</a></li>
                        <li><a href="<?= base_url().'logout' ?>"><span class="fa fa-sign-out"></span> Logout</a></li>
                    </ul>
                </li>
                <?php else: ?>
                <li class="">
                    <a href="#" class="" role="button" aria-haspopup="true" aria-expanded="false"><span class="fa fa-warning"></span> You are currently not logged in.</a>
                    <ul class="dropdown-menu">
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="page-loading"><span class="fa fa-circle-o-notch fa-5x fa-spin"></span></div>
<div class="container page-fade" style="display: block;">
    <!-- This is a placeholder to show site_wite_msg from any controller, just pass the value as a flashdata -->
    <?php if(isset($site_wide_msg)): ?>
        <div class="col-sm-12">
            <div class="alert alert-<?= $site_wide_msg_type?>">
                <p><?= $site_wide_msg ?><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- javascript warning -->
    <noscript>
        <div class="col-sm-12">
            <div class="noscriptmsg alert alert-danger">
                <span class="fa fa-warning"></span> Uh oh!
                We noticed that either you disabled Javascript on your browser,
                or your browser simply doesn't support Javascript. This web
                will <strong>NOT</strong> work well without Javascript. Please
                enable Javascript on your browser, or switch to a browser that
                supports it.
            </div>
        </div>
    </noscript>