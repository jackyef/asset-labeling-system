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
                <li><a href="<?= base_url().'mutation-history' ?>">Mutation History</a></li>
                <li>Edit</li>
            </ol>
        </div>
        <div class="clearfix"></div>
        <h3>Edit mutation
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
                                <div class="col-sm-4"><strong>Item Code</strong></div>
                                <div class="col-sm-8">
                                    <a href="<?= (($assembled == 0) ? base_url().'item/detail/'.$record->item_id : base_url().'assembled-item/detail/'.$record->item_id) ?>">
                                        <?= str_pad($record->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($record->item_id, 5, '0', STR_PAD_LEFT) ?></a>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Item Type</strong></div>
                                <div class="col-sm-8">
                                    <?= $record->item_type_name ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Brand</strong></div>
                                <div class="col-sm-8">
                                    <?= $record->brand_name ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4"><strong><?= ($assembled == 1) ? 'Product Name' : 'Model' ?></strong></div>
                                <div class="col-sm-8">
                                    <?= $record->model_name ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Capacity/Size</strong></div>
                                <div class="col-sm-8">
                                    <?php if(!isset($record->model_capacity_size)): ?>
                                        N/A
                                    <?php else: ?>
                                        <?php if ($record->model_capacity_size == ''): ?>
                                            N/A
                                        <?php else: ?>
                                            <?= $record->model_capacity_size.' '.$record->model_units ?>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Operating System</strong></div>
                                <div class="col-sm-8">
                                    <?php if ($record->operating_system_id == 0): ?>
                                        N/A
                                    <?php else: ?>
                                        <?= $operating_systems[$record->operating_system_id]->name ?>
                                    <?php endif; ?>
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
                    <form class="form-horizontal" action="<?php echo base_url(); ?>mutation-history/edit/submit/<?= $record->id ?>" method="POST">
                        <div class="form-group">
                            <label class="col-sm-12" for="date_of_purchase">Mutation date:</label>
                            <div class="col-sm-12">
                                <div class="input-group date" data-provide="datepicker-inline ">
                                    <input type="hidden" id="mutation_date" name="mutation_date" value="<?= $record->mutation_date?>"/>
                                    <input type="text" class="form-control datepicker" id="mutation_date2" disabled />
                                    <div class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12" for="employee_id">From:</label>
                            <input type="hidden" name="prev_employee_id" id="prev_employee_id" value="<?= $record->employee_id ?>"/>
                            <div class="col-sm-12">
                                <input type="hidden" name="prev_employee_id" id="prev_employee_id" value="<?= $record->prev_employee_id ?>"/>
                                <select class="form-control selectpicker"  data-live-search="true" disabled>
                                    <?php if($record->mutation_status_id == 0): ?>
                                        <option>N/A</option>
                                    <?php else: ?>
                                        <?php foreach($employees as $employee){ ?>
                                            <option value="<?= $employee->id?>"
                                                <?= $record->prev_employee_id == $employee->id ? 'selected' : ''?>>
                                                <?= $employee->name ?>
                                                (<?= $companies[$employee->company_id]->name?>)
                                            </option>
                                        <?php } ?>
                                    <?php endif; ?>
                                </select>
                                <div class="col-sm-12">
                                    <?php if($record->mutation_status_id != 0): ?>
                                        <?= (($employees[$record->prev_employee_id]->location_id != 0) ? '<span class="fa fa-map-marker"></span> '.$locations[$employees[$record->prev_employee_id]->location_id]->name : '') ?>
                                        <?= (($employees[$record->prev_employee_id]->first_sub_location_id != 0) ? '<span class="fa fa-arrow-right"></span> '.$first_sub_locations[$employees[$record->prev_employee_id]->first_sub_location_id]->name : '') ?>
                                        <?= (($employees[$record->prev_employee_id]->second_sub_location_id != 0) ? '<span class="fa fa-arrow-right"></span> '.$second_sub_locations[$employees[$record->prev_employee_id]->second_sub_location_id]->name : '') ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12" for="employee_id">To:</label>
                            <input type="hidden" name="prev_employee_id" id="prev_employee_id" value="<?= $record->employee_id ?>"/>
                            <div class="col-sm-12">
                                <input type="hidden" name="employee_id" id="employee_id" value="<?= $record->employee_id ?>"/>
                                <select class="form-control selectpicker"  data-live-search="true" disabled>
                                    <?php foreach($employees as $employee){ ?>
                                        <option value="<?= $employee->id?>"
                                            <?= $record->employee_id == $employee->id ? 'selected' : ''?>>
                                            <?= $employee->name ?>
                                            (<?= $companies[$employee->company_id]->name?>)
                                        </option>
                                    <?php } ?>
                                </select>
                                <div class="col-sm-12">
                                    <?= (($employees[$record->employee_id]->location_id != 0) ? '<span class="fa fa-map-marker"></span> '.$locations[$employees[$record->employee_id]->location_id]->name : '') ?>
                                    <?= (($employees[$record->employee_id]->first_sub_location_id != 0) ? '<span class="fa fa-arrow-right"></span> '.$first_sub_locations[$employees[$record->employee_id]->first_sub_location_id]->name : '') ?>
                                    <?= (($employees[$record->employee_id]->second_sub_location_id != 0) ? '<span class="fa fa-arrow-right"></span> '.$second_sub_locations[$employees[$record->employee_id]->second_sub_location_id]->name : '') ?>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="assembled" id="assembled" value="<?= $assembled ?>"/>
                        <div class="form-group">
                            <label class="col-sm-12" for="employee_id">Mutation status:</label>
                            <div class="col-sm-12">
                                <select class="form-control selectpicker" name="mutation_status_id" id="mutation_status_id" data-live-search="true">
                                    <?php foreach($mutation_statuses as $ms){ ?>
                                        <option value="<?= $ms->id?>"
                                        <?= $record->mutation_status_id == $ms->id ? 'selected' : ''?>>
                                            <?= $ms->name ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12" for="note">Note:</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" rows="4" id="note" name="note" placeholder="Ex: Sesuai dengan Surat no. XX, etc"><?= $record->note ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary form-control">
                                    <span class="fa fa-save"></span>
                                    Save changes
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
        $('#mutation_date2').datepicker({
            format: 'DD, dd MM yyyy',
            autoclose: true,
            todayHighlight: true,
            todayBtn: true,
            disableTouchKeyboard: true
        });

        $('#mutation_date2').datepicker('update', '<?= (date("d-m-Y", strtotime($record->mutation_date))) ?>');

    });

</script>

