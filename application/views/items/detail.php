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
                <li><a href="<?= base_url().'item' ?>">Item</a></li>
                <li>Detail</li>
            </ol>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-sm-12">
                <h3>Item
                    Code:
                    <?= (str_pad($record->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($record->id, 5, '0', STR_PAD_LEFT)) ?>
                </h3>
                <div class="col-md-7">
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

                            <div class="divider">&nbsp;</div>

                            <div class="form-group">
                                <div class="col-sm-4"><strong>Purchased on</strong></div>
                                <div class="col-sm-8">
                                    <span class="fa fa-calendar"></span>
                                    <?= (date("l, d F Y", strtotime($record->date_of_purchase))) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Warranty expires on</strong></div>
                                <div class="col-sm-8">
                                    <?php if($record->date_of_purchase == $record->warranty_expiry_date): ?>
                                        No warranty for this item
                                    <?php else: ?>
                                        <span class="fa fa-calendar"></span>
                                        <?= (date("l, d F Y", strtotime($record->warranty_expiry_date))) ?>
                                        <?php if(date('Y-m-d',now()) > $record->warranty_expiry_date): ?>
                                            <span class="label label-danger">Expired!</span>
                                        <?php else: ?>
                                            <span class="label label-success">Active</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4"><strong>Supplier</strong></div>
                                <div class="col-sm-8">
                                    <?= html_escape($record->supplier_name) ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4"><strong>Owned by</strong></div>
                                <div class="col-sm-8">
                                    <span class="fa fa-building"></span>
                                    <a href="<?= base_url().'company/detail/'.$record->company_id ?>">
                                        <?= html_escape($record->company_name) ?>
                                    </a>
                                </div>
                            </div>


                            <div class="divider">&nbsp;</div>

                            <div class="form-group">
                                <div class="col-sm-4">
                                    <span class="fa fa-sticky-note"></span> <strong>Note</strong></div>
                                <div class="col-sm-8">
                                    <?= nl2br(html_escape($record->note)) ?>
                                </div>
                            </div>

                            <div class="divider">&nbsp;</div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <a href="<?= base_url().'item/edit/'.$record->id ?>">
                                        <button class="btn btn-primary form-control">
                                            <span class="fa fa-edit"></span>
                                            Edit item information
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="panel panel-primary" style="border-color: #229955;">
                        <div class="panel-heading" style="background-color: #229955;">
                            <h3 class="panel-title" style="color: white;">Holder information</h3>
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
                            <div class="divider">&nbsp;</div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?php if($record->assembled_item_id == 0): ?>
                                        <a href="<?= base_url().'item/mutate/'.$record->id ?>">
                                            <button class="btn btn-primary form-control">
                                                <span class="fa fa-refresh"></span>
                                                Mutate to another employee
                                            </button>
                                        </a>
                                    <?php else: ?>
                                            <div class="alert alert-danger">
                                                <span class="fa fa-times"></span>
                                                You can't mutate this item because it is a part of an assembled item.
                                                Mutate the parent item instead.
                                            </div>
                                        <a href="<?= base_url().'assembled-item/detail/'.$record->assembled_item_id ?>">
                                            <button class="btn btn-primary form-control">
                                                <span class="fa fa-arrow-right"></span>
                                                Go to the parent item
                                            </button>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($session_is_admin == 1): ?>
                    <div class="panel panel-danger" >
                        <div class="panel-heading"><span class="fa fa-info-circle"></span> Admin's area</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <a href="<?= base_url().'item/delete/'.$record->id ?>">
                                        <button class="btn btn-danger form-control"
                                            onclick="return confirm('CAUTION! This WILL delete ALL mutation records of this item as well! ' +
                                             'This process is irreversible! ' +
                                             'Click \'Cancel\' if you don\'t want to do this!')">
                                            <span class="fa fa-trash"></span>
                                            Delete this item
                                        </button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h3>Mutation History</h3>
            <hr />
            <table class="table table-striped table-responsive data-table-mutation">
                <!-- add the data-table class to tell the page to paginate this table -->
                <thead>
                <th> Id </th>
                <th> Item Code </th>
                <th> Item Type / Brand </th>
                <th> Model </th>
                <th style="min-width: 6em"> Mutated on </th>
                <th> From </th>
                <th> To </th>
                <th style="min-width: 9em"> Note </th>
                <th> Status </th>
                <th style="min-width: 1em"> Action </th>
                </thead>
                <?php
                foreach($mutations as $mutation){
                    echo '<tr>';
                    echo '<td>'.$mutation->id.'</td>';
                    echo '<td>'.
                        '<a href="'.base_url().'item/detail/'.$mutation->item_id.'">'.
                        str_pad($mutation->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($mutation->item_id, 5, '0', STR_PAD_LEFT).
                        '</a>'.
                        '</td>';
                    echo '<td>'.html_escape($mutation->item_type_name.', '.$mutation->brand_name).'</td>';
                    echo '<td>'.html_escape($mutation->model_name).'</td>';
                    echo '<td>'.
                        '<i class="fa fa-calendar"></i> '.
                        date("d M Y", strtotime($mutation->mutation_date)).
                        '</td>';

                    if($mutation->prev_employee_id == 0){
                        echo '<td> - </td>';
                    } else {
                        echo '<td>';
                        echo '<a href="'.base_url().'employee/detail/'.$mutation->prev_employee_id.'">';
                        echo html_escape($employees[$mutation->prev_employee_id]->name);
                        echo '</a>';
                        echo '<br/> <i class="fa fa-building"></i> '.
                            html_escape($companies[$employees[$mutation->prev_employee_id]->company_id]->name).
                            '<br/> <i class="fa fa-map-marker"></i> '.
                            (($employees[$mutation->prev_employee_id]->location_id != 0) ? html_escape($locations[$employees[$mutation->prev_employee_id]->location_id]->name) : '').
                            (($employees[$mutation->prev_employee_id]->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($first_sub_locations[$employees[$mutation->prev_employee_id]->first_sub_location_id]->name) : '').
                            (($employees[$mutation->prev_employee_id]->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($second_sub_locations[$employees[$mutation->prev_employee_id]->second_sub_location_id]->name) : '');
                        echo '</td>';
                    }

                    echo '<td>';
                    if($mutation->employee_id == 0){
                        echo '-';
                    } else {
                        echo '<a href="'.base_url().'employee/detail/'.$mutation->employee_id.'">';
                        echo html_escape($employees[$mutation->employee_id]->name);
                        echo '</a>';
                        echo '<br/> <i class="fa fa-building"></i> '.
                            html_escape($companies[$employees[$mutation->employee_id]->company_id]->name).
                            '<br/> <i class="fa fa-map-marker"></i> '.
                            (($employees[$mutation->employee_id]->location_id != 0) ? html_escape($locations[$employees[$mutation->employee_id]->location_id]->name) : '').
                            (($employees[$mutation->employee_id]->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($first_sub_locations[$employees[$mutation->employee_id]->first_sub_location_id]->name) : '').
                            (($employees[$mutation->employee_id]->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($second_sub_locations[$employees[$mutation->employee_id]->second_sub_location_id]->name) : '');
                    }
                    echo '</td>';

                    echo '<td>';
                    if(strlen($mutation->note) <= 50){
                        echo html_escape($mutation->note);
                    } else {
                        // truncate the note if it is greater than 50 characters long
                        echo html_escape(substr($mutation->note, 0, 50)). '...';
                        echo '<h6><a href="'.base_url().'mutation-history/edit/'.$mutation->id.'#note">see more</a></h6>';
                    }
                    echo '</td>';

                    echo '<td>';
                    if ($mutation->mutation_status_id == 0){
                        echo 'N/A';
                    } else {
                        echo html_escape($mutation_statuses[$mutation->mutation_status_id]->name);
                    }
                    echo '</td>';
                    echo '<td> 
                        <a href="'. base_url(). 'mutation-history/edit/'.$mutation->id.'">
                        <button class="btn btn-xs btn-info" ><span class="fa fa-edit"></span> Edit</button>
                        </a>
                  </td>';
                    echo '</tr>';
                }
                ?>
            </table>

        </div>
    </div>
</div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.data-table-mutation').DataTable({
                "order": [[ 0, "desc" ]],
                responsive: true,
                colReorder: true
            });
        });

    </script>
