<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/15/2017
 * Time: 1:26 PM
 */
?>
<div class="row">
    <div class="col-sm-12">
        <div class="pull-left">
            <ol class="breadcrumb">
                <li><a href="<?= base_url()?>">Home</a></li>
                <li>Change Password</li>
            </ol>
        </div>
        <div class="clearfix"></div>
        <h2>Change your password</h2>

        <br/>
        <form class="form-horizontal" action="<?php echo base_url(); ?>home/chpass/<?= $id ?>" method="POST">
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Current password:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Type your current password here"
                           required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">New password:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Type your new password here"
                           required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <!-- show errors message if there are errors -->
                    <?php if(isset($errors)): ?>
                        <div class="alert alert-danger">
                            <h4>Error(s) occured:</h4>
                            <ul >
                                <?php foreach($errors as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <!-- show success message if there is one-->
                    <?php if(isset($msg)): ?>
                        <div class="alert alert-success">
                            <h5><span class="fa fa-info-circle"></span> <?= $msg ?></h5>
                        </div>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>


