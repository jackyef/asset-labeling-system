<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:26 AM
 */
?>

<div class="row">
    <div class="col-sm-12">
        <div class="pull-left">
            <ol class="breadcrumb">
                <li><a href="<?= base_url()?>">Home</a></li>
                <li><a href="<?= base_url().'employee' ?>">Employee</a></li>
                <li>Detail</li>
            </ol>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-sm-12">
                <h3>Employee:
                    <?= html_escape($record->name) ?>
                </h3>
                <div class="col-md-5">
                    <div class="panel panel-primary" >
                        <div class="panel-heading" >
                            <h3 class="panel-title" >Basic information</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Name</strong></div>
                                <div class="col-sm-8">
                                    <?= html_escape($record->name) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Works at</strong></div>
                                <div class="col-sm-8">
                                    <span class="fa fa-building"></span>
                                    <a href="<?= base_url().'company/detail/'.$record->company_id ?>">
                                        <?= html_escape($companies[$record->company_id]->name) ?>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Status</strong></div>
                                <div class="col-sm-8">
                                    <?php if($record->is_working == 1): ?>
                                        <span class="label label-success">Active</span>
                                    <?php else: ?>
                                        <span class="label label-warning">Non-active</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="divider">&nbsp;</div>


                            <div class="form-group">
                                <div class="col-sm-4"><strong>Location </strong></div>
                                <div class="col-sm-8">
                                    <span class="fa fa-map-marker"></span>
                                    <?php echo
                                        (($record->location_id != 0) ? html_escape($locations[$record->location_id]->name) : '').
                                        (($record->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($first_sub_locations[$record->first_sub_location_id]->name) : '').
                                        (($record->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($second_sub_locations[$record->second_sub_location_id]->name) : '')
                                    ?>

                                </div>
                            </div>
                            <?php if($permission_employee_edit == 1): ?>
                            <div class="divider">&nbsp;</div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <a href="<?= base_url().'employee/edit/'.$record->id ?>">
                                        <button class="btn btn-primary form-control">
                                            <span class="fa fa-edit"></span>
                                            Edit employee information
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if($permission_item_mutate == 1): ?>
                <div class="col-md-7">
                    <div class="panel panel-danger" style="border-color: #d9534f;">
                        <div class="panel-heading" style="background-color: #d9534f;">
                            <h3 class="panel-title" style="color: white;">
                                Mutate multiple employee's items
                                <a data-toggle="collapse" href="#collapse1"><i class="pull-right fa fa-chevron-down"></i></a>
                                <div class="clearfix"></div>
                            </h3>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse">
                            <div class="panel-body">
                            <form class="form-horizontal" action="<?php echo base_url(); ?>employee/mutate-multiple/<?= $record->id ?>" method="POST">

                                <div class="form-group">
                                    <label class="col-sm-12" for="item_ids[]">Select items:</label>
                                    <div class="col-sm-12">
                                        <select class="form-control selectpicker"
                                                multiple="multiple" name="item_ids[]" id="item_ids[]" data-live-search="true" required>
                                            <?php foreach($items as $item){ ?>
                                                <option
                                                        value="<?= $item->id.','.$item->assembled ?>">
                                                    <?= str_pad($item->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($item->id, 5, '0', STR_PAD_LEFT).' - '.
                                                    html_escape($item->item_type_name.', '. $item->brand_name.', '.$item->model_name.' ('.$item->employee_name.')') ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
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
                                    <input type="hidden" name="prev_employee_id" id="prev_employee_id" value="<?= $record->id ?>"/>
                                    <div class="col-sm-12">
                                        <select class="form-control selectpicker" name="employee_id" id="employee_id" data-live-search="true">
                                            <?php foreach($employees as $employee){ ?>
                                                <option value="<?= $employee->id?>"
                                                    <?= (($employee->id == $record->id) ? 'selected' : '') ?>>
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
                <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h3>Item(s) information</h3>
            <hr />
            <table class="table table-striped table-responsive data-table">
                <!-- add the data-table class to tell the page to paginate this table -->
                <thead>
                <th> Id </th>
                <th> Item Code </th>
                <th> Item Type / Brand </th>
                <th> Model Name</th>
                <th style="min-width: 6em"> Purchased on </th>
                <th> Owned by </th>
                <th> Is used? </th>
                <th> Held by </th>
                <th> Item location </th>
                <th style="min-width: 1em"> Action </th>
                </thead>
                <?php
                foreach($items as $item){
                    echo '<tr>';
                    echo '<td>'.$item->id.'</td>';
                    $link = 'item';
                    if(isset($item->assembled) AND $item->assembled == 1){
                        $link = 'assembled-item';
                    };
                    echo '<td>'.
                        '<a href="'.base_url().$link.'/detail/'.$item->id.'">'.
                        str_pad($item->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($item->id, 5, '0', STR_PAD_LEFT).
                        '</a>'.
                        '</td>';
                    echo '<td>'.html_escape($item->item_type_name.', '.$item->brand_name).'</td>';
                    echo '<td>'.html_escape($item->model_name).'</td>';
                    echo '<td>'.
                        '<i class="fa fa-calendar"></i> '.
                        date("d M Y", strtotime($item->date_of_purchase)).
                        '</td>';
                    echo '<td><a href="'.base_url().'company/detail/'.$item->company_id.'">'.
                        html_escape($companies[$item->company_id]->name).
                        '</a></td>';
                    echo '<td>'.(($item->is_used == 1) ? 'Yes' : 'No' ).'</td>';
                    echo '<td>'.
                        '<i class="fa fa-user"></i> '.
                        html_escape($item->employee_name).
                        '<br/> <i class="fa fa-building"></i> '.
                        html_escape($companies[$item->employee_company_id]->name).
                        '</td>';
                    echo '<td>'.
                        (($item->location_id != 0) ? '<i class="fa fa-map-marker"></i> '.html_escape($locations[$item->location_id]->name) : '').
                        (($item->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($first_sub_locations[$item->first_sub_location_id]->name) : '').
                        (($item->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($second_sub_locations[$item->second_sub_location_id]->name) : '').
                        '</td>';
                    echo '<td>';
                    if ($permission_item_edit) {
                        echo '<a href="' . base_url() . $link.'/edit/' . $item->id . '">
                        <button class="btn btn-xs btn-info" ><span class="fa fa-edit"></span> Edit</button>
                         </a>';
                    }
                    echo '<a href="'. base_url(). $link.'/detail/'.$item->id.'">
                        <button class="btn btn-xs btn-warning" ><span class="fa fa-external-link"></span> View</button>
                         </a>';
                    if ($permission_item_mutate) {
                        echo '<a href="' . base_url() . $link.'/mutate/' . $item->id . '">
                        <button class="btn btn-xs btn-primary" ><span class="fa fa-refresh"></span> Mutate</button>
                        </a>';
                    }
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </table>

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


