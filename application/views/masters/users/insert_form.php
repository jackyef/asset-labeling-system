<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:51 AM
 */
?>

<div class="row">
    <div class="col-sm-12">
    <a href="<?= base_url().'master/user'?>"><button class="btn btn-primary"><span class="fa fa-backward"></span> Back to user list</button></a>
    <h2>Add a new user</h2>
    <br/>
    <form class="form-horizontal" action="<?php echo base_url(); ?>master/user/new/submit" method="POST">
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="username" name="username" placeholder="Type username here"
                       <?php if(isset($username)): ?>
                            value="<?= $username ?>"
                       <?php endif; ?>
                       required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Password:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" placeholder="Type password here. Don't worry, it won't be saved as a plaintext." required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="is_admin" name="is_admin"
                            <?php if(isset($is_admin)): ?>
                            <?php if($is_admin == 1): ?>
                                checked
                            <?php endif; ?>
                            <?php endif; ?>
                        > Assign this user as an admin?
                    </label>
                    <h5 class="alert alert-warning">
                        All admins can access all the "Masters" section of the system. This means that they can make changes to the masters data. <br/>
                        <strong>Make sure you can trust your admins!</strong>
                    </h5>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Permissions for this user:</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker"
                        multiple="multiple" name="permission_ids[]" id="permission_ids[]" data-live-search="true">
                    <?php foreach($permissions as $permission){ ?>
                        <option
                                value="<?= $permission->id ?>"
                                <?= ((in_array($permission->id, $permission_ids)) ? 'selected' : '' )?>>
                            <?= $permission->permission_name ?>
                        </option>
                    <?php } ?>
                </select>
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
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
</div>



