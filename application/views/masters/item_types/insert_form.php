<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:51 AM
 */
?>

<div class="row">
    <a href="<?= base_url().'master/item-type'?>"><button class="btn btn-primary"><span class="fa fa-backward"></span> Back to item type list</button></a>
    <h2>Add a new item type</h2>
    <br/>
    <form class="form-horizontal" action="<?php echo base_url(); ?>master/item-type/new/submit" method="POST">
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="Ex: HDD, Desktop, Printer, etc" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label><input type="checkbox" id="is_assembled" name="is_assembled"> Is an assembled item?</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>



