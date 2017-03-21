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
    <a href="<?= base_url().'master/model'?>"><button class="btn btn-primary"><span class="fa fa-backward"></span> Back to model list</button></a>
    <h2>Edit model</h2>
    <br/>
    <form class="form-horizontal" action="<?php echo base_url(); ?>master/model/edit/submit/<?= $id ?>" method="POST">
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="Ex: MG2570, PGX2901, Viper-DDR3, etc"
                       value="<?= html_escape($record->name) ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Item type - Brand:</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker" name="brand_id" id="brand_id" data-live-search="true">
                    <?php foreach($brands as $brand){ ?>
                        <option value="<?= $brand->id?>" <?= $brand->id == $record->brand_id ? 'selected' : '' ?>>
                            <?= html_escape($brand->item_type_name.' / '.$brand->name) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Capacity/Size:</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="capacity_size" name="capacity_size" placeholder="500, 1000, 17, etc (Optional)"
                       value="<?= html_escape($record->capacity_size) ?>">
            </div>
            <label class="control-label col-sm-1" for="name">Units:</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="units" name="units" placeholder="TB, GB, Inch, GHz, etc (Optional)"
                       value="<?= html_escape($record->units) ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
</div>


