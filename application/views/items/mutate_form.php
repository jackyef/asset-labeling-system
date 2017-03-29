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
        <div class="pull-left">
            <ol class="breadcrumb">
                <li><a href="<?= base_url()?>">Home</a></li>
                <li><a href="<?= base_url().'item' ?>">Item</a></li>
                <li>Mutate</li>
            </ol>
        </div>
        <div class="clearfix"></div>
    <h3>Mutate item (code:
        <a href="<?= base_url().'item/detail/'.$record->id ?>">
        <?= str_pad($record->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($record->id, 5, '0', STR_PAD_LEFT) ?></a>)
    </h3>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Basic information</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Item Type</strong></div>
                                <div class="col-sm-8">
                                    <?= html_escape($record->item_type_name) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Brand</strong></div>
                                <div class="col-sm-8">
                                    <?= html_escape($record->brand_name) ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4"><strong>Model</strong></div>
                                <div class="col-sm-8">
                                    <?= html_escape($record->model_name) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Capacity/Size</strong></div>
                                <div class="col-sm-8">
                                    <?php if ($record->model_capacity_size == ''): ?>
                                        N/A
                                    <?php else: ?>
                                        <?= html_escape($record->model_capacity_size.' '.$record->model_units) ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Operating System</strong></div>
                                <div class="col-sm-8">
                                    <?php if ($record->operating_system_id == 0): ?>
                                        N/A
                                    <?php else: ?>
                                        <?= html_escape($operating_systems[$record->operating_system_id]->name) ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Current Location</strong></div>
                                <div class="col-sm-8">
                                    <?= (($record->location_id != 0) ? '<i class="fa fa-map-marker"></i> '.html_escape($locations[$record->location_id]->name) : '') ?>
                                    <?= (($record->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($first_sub_locations[$record->first_sub_location_id]->name) : '') ?>
                                    <?= (($record->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($second_sub_locations[$record->second_sub_location_id]->name) : '') ?>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary" style="border-color: #229955;">
                        <div class="panel-heading" style="background-color: #229955;">
                            <h3 class="panel-title" style="color: white;">Current holder</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Name</strong></div>
                                <div class="col-sm-8">
                                    <a href="<?= base_url().'employee/detail/'.$record->employee_id ?>">
                                        <?= html_escape($record->employee_name) ?>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Works at</strong></div>
                                <div class="col-sm-8">
                                    <span class="fa fa-building"></span>
                                    <a href="<?= base_url().'company/detail/'.$record->employee_company_id ?>">
                                        <?= html_escape($companies[$record->employee_company_id]->name) ?>
                                    </a>
                                </div>
                            </div>

                            <div class="divider">&nbsp;</div>

                            <div class="form-group">
                                <div class="col-sm-4"><strong>Item status</strong></div>
                                <div class="col-sm-8">
                                    <?php if($record->is_used == 1):?>
                                        <span class="label label-info"> Occupied</span>
                                    <?php else: ?>
                                        <span class="label label-warning"> Vacant</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="divider">&nbsp;</div>


                            <div class="form-group">
                                <div class="col-sm-4"><strong>Location </strong></div>
                                <div class="col-sm-8">
                                    <span class="fa fa-map-marker"></span>
                                    <?php echo
                                        (($employees[$record->employee_id]->location_id != 0) ? html_escape($locations[$employees[$record->employee_id]->location_id]->name) : '').
                                        (($employees[$record->employee_id]->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($first_sub_locations[$employees[$record->employee_id]->first_sub_location_id]->name) : '').
                                        (($employees[$record->employee_id]->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($second_sub_locations[$employees[$record->employee_id]->second_sub_location_id]->name) : '')
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-primary" style="border-color: #d9534f;">
                <div class="panel-heading" style="background-color: #d9534f; border-color: #d9534f;">
                    <h3 class="panel-title" style="color: white;">Mutation</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="<?php echo base_url(); ?>item/mutate/submit/<?= $record->id ?>" method="POST">
                        <div class="form-group">
                            <label class="col-sm-12" for="date_of_purchase">Mutation date:</label>
                            <div class="col-sm-12">
                                <div class="input-group date" data-provide="datepicker-inline ">
                                    <input type="text" class="form-control datepicker" id="mutation_date" name="mutation_date" />
                                    <div class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12" for="employee_id">Mutate to:</label>
                            <input type="hidden" name="prev_employee_id" id="prev_employee_id" value="<?= $record->employee_id ?>"/>
                            <div class="col-sm-12">
                                <select class="form-control selectpicker" name="employee_id" id="employee_id" data-live-search="true">
                                    <?php foreach($employees as $employee){ ?>
                                        <option value="<?= $employee->id?>"
                                        <?= (($employee->id == $record->employee_id) ? 'selected' : '') ?>>
                                            <?= html_escape($employee->name) ?>
                                            (<?= html_escape($employee->company_name) ?>)
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="hidden" name="prev_location_id" id="prev_location_id" value="<?= $record->location_id ?>"/>
                                <input type="hidden" name="prev_first_sub_location_id" id="prev_first_sub_location_id" value="<?= $record->first_sub_location_id ?>"/>
                                <input type="hidden" name="prev_second_sub_location_id" id="prev_second_sub_location_id" value="<?= $record->second_sub_location_id ?>"/>
                                <select class="form-control selectpicker" name="location_id" id="location_id" data-live-search="true">
                                    <option value="0,0,0">
                                        Not specified
                                    </option>
                                    <?php foreach($locations as $location){ ?>
                                        <option value="<?= $location->id.',0,0' ?>"
                                            <?= (($record->location_id.','.$record->first_sub_location_id.','.$record->second_sub_location_id == $location->id.',0,0') ? 'selected' : '') ?>>
                                            <?= html_escape($location->name) ?>
                                        </option>
                                    <?php } ?>

                                    <?php foreach($first_sub_locations as $first_sub_location){ ?>
                                        <option value="<?= $first_sub_location->location_id.','.$first_sub_location->id.',0' ?>"
                                            <?= (($record->location_id.','.$record->first_sub_location_id.','.$record->second_sub_location_id == $first_sub_location->location_id.','.$first_sub_location->id.',0') ? 'selected' : '') ?>>
                                            <?= (($first_sub_location->location_id != 0) ? html_escape($locations[$first_sub_location->location_id]->name) : '') ?>/<?= html_escape($first_sub_location->name) ?>
                                        </option>
                                    <?php } ?>

                                    <?php foreach($second_sub_locations as $second_sub_location){ ?>
                                        <option value="<?= $first_sub_locations[$second_sub_location->first_sub_location_id]->location_id.','.$second_sub_location->first_sub_location_id.','.$second_sub_location->id ?>"
                                            <?= (($record->location_id.','.$record->first_sub_location_id.','.$record->second_sub_location_id == $first_sub_locations[$second_sub_location->first_sub_location_id]->location_id.','.$second_sub_location->first_sub_location_id.','.$second_sub_location->id) ? 'selected' : '') ?>>
                                            <?= (($first_sub_locations[$second_sub_location->first_sub_location_id]->location_id != 0) ? html_escape($locations[$first_sub_locations[$second_sub_location->first_sub_location_id]->location_id]->name) : '') ?>/<?= ($second_sub_location->first_sub_location_id != 0) ? html_escape($first_sub_locations[$second_sub_location->first_sub_location_id]->name) : ''?>/<?= html_escape($second_sub_location->name) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12" for="employee_id">Mutation status:</label>
                            <div class="col-sm-12">
                                <select class="form-control selectpicker" name="mutation_status_id" id="mutation_status_id" data-live-search="true">
                                    <?php foreach($mutation_statuses as $ms){ ?>
                                        <option value="<?= $ms->id?>">
                                            <?= html_escape($ms->name) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12" for="note">Note:</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" rows="4" id="note" name="note" placeholder="Ex: Sesuai dengan Surat no. XX, etc"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary form-control">
                                        <span class="fa fa-refresh"></span>
                                        Mutate
                                    </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


</div>
</div>
<script type="text/javascript">
    // update the date pickers to take the record's value
    $(document).ready(function(){
        $('#mutation_date').datepicker({
            format: 'DD, dd MM yyyy',
            autoclose: true,
            todayHighlight: true,
            todayBtn: true,
            disableTouchKeyboard: true
        });

        $('#mutation_date').datepicker('update', new Date());

    });

</script>

