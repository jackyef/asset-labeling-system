<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:51 AM
 */
?>

<div class="row">
    <a href="<?= base_url().'master/os'?>"><button class="btn btn-primary"><span class="fa fa-backward"></span> Back to operating system list</button></a>
    <h2>Edit operating system</h2>
    <br/>
    <form class="form-horizontal" action="<?php echo base_url(); ?>master/os/edit/submit/<?= $record->id ?>" method="POST">
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="Ex: Windows 7, iOS, Android, Linux Ubuntu 16, etc"
                       value="<?= $record->name ?>" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>



