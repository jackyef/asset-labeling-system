<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:26 AM
 */
?>

<div class="row">
    <div class="col-sm-12">
    <div class="pull-left">
        <ol class="breadcrumb">
            <li><a href="<?= base_url()?>">Home</a></li>
        </ol>
    </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-8">
        <div class="panel panel-collapse panel-default" style="border-color: #229955;">
            <div class="panel-heading" style="background-color: #229955">
                <h3 class="panel-title" style="color: white">Information</h3>
            </div>
            <div class="panel-body">
                <h4>Welcome to the new Asset Labeling System!</h4>
                <p class="alert alert-info">
                    This system behaves a little bit differently compared to the previous system.
                    It would help to read about how this system works before you start using it,
                    especially about how it handles asset mutations.
                    You can read about it on the <a class="alert-link" href="<?= base_url().'help'?>">Help page</a>.
                </p>

                <p class="alert alert-warning">
                    If you are in charge of handling asset mutation but don't have an account yet, contact the
                    IT department in your company.
                </p>

            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Login</h3>
            </div>
            <?php if($login_error): ?>
                <p class="alert alert-danger alert-dismissable" ><?= $login_error ?><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            <?php endif; ?>
            <?php if($is_logged_in == 0): ?>

            <div class="panel-body">
                <form class="form-horizontal" action="<?= base_url().'home/login' ?>" method="POST">
                    <div class="form-group">
<!--                        <label class="control-label col-sm-3" for="name">Username</label>-->
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-user" style="min-width: 1.5em"></span>
                                </div>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Type your username here" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
<!--                        <label class="control-label col-sm-3" for="name">Password</label>-->
                        <div class="col-sm-12">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-lock" style="min-width: 1.5em"></span>
                                </div>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Type your password here" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="form-control btn btn-success">Login</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="panel-footer">
                <p class="h6">
                    Don't have an account yet? Contact your IT department.
                </p>
            </div>
            <?php else: ?>
            <div class="panel-body">
                <h4>You are logged in as:</h4>
                <div class="form-group">
                    <div class="col-sm-4" for="name">Username</div>
                    <div class="col-sm-8">
                        <?= $session_username ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-4" for="name">Is admin?</div>
                    <div class="col-sm-8">
                        <?= (($session_is_admin == 1) ? 'Yes' : 'No') ?>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <p class="h6 pull-right">
                    Today is <?= date('l, d F Y') ?>. Work hard!
                </p>
                <div class="clearfix"></div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>


