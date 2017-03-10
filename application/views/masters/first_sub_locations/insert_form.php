<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:51 AM
 */
?>

<div class="row">
    <a href="<?= base_url().'master/fsub-location'?>"><button class="btn btn-primary"><span class="fa fa-backward"></span> Back to first sub location list</button></a>
    <h2>Add a new first sub location</h2>
    <br/>
    <form class="form-horizontal" action="<?php echo base_url(); ?>master/fsub-location/new/submit" method="POST">
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="Ex: Lantai 1, Gudang, etc" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Parent Location:</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker" name="location_id" id="location_id" data-live-search="true">
                    <?php foreach($locations as $location){ ?>
                        <option value="<?= $location->id?>"><?= $location->name ?></option>
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



