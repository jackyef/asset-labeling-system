<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:51 AM
 */
?>

<div class="row">
    <a href="<?= base_url().'master/employee'?>"><button class="btn btn-primary"><span class="fa fa-backward"></span> Back to employee list</button></a>
    <h2>Add a new employee</h2>
    <br/>
    <form class="form-horizontal" action="<?php echo base_url(); ?>master/employee/new/submit" method="POST">
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="Ex: John Doe, Budiman, Cristiano Ronaldo, etc" required>
            </div>
        </div>


        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Company:</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker" name="company_id" id="company_id" data-live-search="true">
                    <?php foreach($companies as $company){ ?>
                        <option value="<?= $company->id?>"><?= $company->name ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label><input type="checkbox" id="is_working" name="is_working"> Is currently working?</label>
                </div>
            </div>
        </div>

        <hr class="separator">
        <h3>Current employee location (optional)</h3>
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Location:</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker" name="location_id" id="location_id" data-live-search="true">
                    <option value="0,0,0">
                        Not specified
                    </option>
                    <?php foreach($locations as $location){ ?>
                        <option value="<?= $location->id.',0,0' ?>">
                            <?= $location->name ?>
                        </option>
                    <?php } ?>

                    <?php foreach($first_sub_locations as $first_sub_location){ ?>
                        <option value="<?= $first_sub_location->location_id.','.$first_sub_location->id.',0' ?>">
                            <?= (($first_sub_location->location_id != 0) ? $locations[$first_sub_location->location_id]->name : '') ?>/<?= $first_sub_location->name ?>
                        </option>
                    <?php } ?>

                    <?php foreach($second_sub_locations as $second_sub_location){ ?>
                        <option value="<?= $first_sub_locations[$second_sub_location->first_sub_location_id]->location_id.','.$second_sub_location->first_sub_location_id.','.$second_sub_location->id ?>">
                            <?= (($first_sub_locations[$second_sub_location->first_sub_location_id]->location_id != 0) ? $locations[$first_sub_locations[$second_sub_location->first_sub_location_id]->location_id]->name : '') ?>/<?= ($second_sub_location->first_sub_location_id != 0) ? $first_sub_locations[$second_sub_location->first_sub_location_id]->name : ''?>/<?= $second_sub_location->name ?>
                        </option>
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



