<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:51 AM
 */
?>

<div class="row">
    <a href="<?= base_url().'master/brand'?>"><button class="btn btn-primary"><span class="fa fa-backward"></span> Back to brand list</button></a>
    <h2>Edit brand</h2>
    <br/>
    <form class="form-horizontal" action="<?php echo base_url(); ?>master/brand/edit/submit/<?= $id ?>" method="POST">
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="Ex: Samsung, Asus, etc"
                       value="<?= $record->name ?>"required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Item type:</label>
            <div class="col-sm-10">
                <select class="form-control" name="item_type_id" id="item_type_id">
                    <?php foreach($item_types as $item_type){ ?>
                        <option value="<?= $item_type->id?>"
                        <?= $item_type->id == $record->item_type_id ? 'selected' : '' ?>><?= $item_type->name ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>

