<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:51 AM
 */
?>

<div class="row">
    <a href="<?= base_url().'master/ssub-location'?>"><button class="btn btn-primary"><span class="fa fa-backward"></span> Back to second sub location list</button></a>
    <h2>Edit second sub location</h2>
    <br/>
    <form class="form-horizontal" action="<?php echo base_url(); ?>master/ssub-location/edit/submit/<?= $id ?>" method="POST">
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="Ex: Section A, Section Z, IT Dept., etc"
                       value="<?= $record->name ?>"required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Parent Location:</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker" name="first_sub_location_id" id="first_sub_location_id" data-live-search="true">
                    <?php foreach($first_sub_locations as $first_sub_location){ ?>
                        <option value="<?= $first_sub_location->id?>"
                        <?= $first_sub_location->id == $record->first_sub_location_id ? 'selected' : '' ?>><?= $first_sub_location->location_name.' / '.$first_sub_location->name ?></option>
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

