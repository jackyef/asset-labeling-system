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
                    <?= $record->name ?>
                </h3>
                <div class="col-md-5">
                    <div class="panel panel-primary" style="border-color: #229955;">
                        <div class="panel-heading" style="background-color: #229955;">
                            <h3 class="panel-title" style="color: white;">Basic information</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Name</strong></div>
                                <div class="col-sm-8">
                                    <?= $record->name ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Works at</strong></div>
                                <div class="col-sm-8">
                                    <span class="fa fa-building"></span>
                                    <a href="<?= base_url().'company/detail/'.$record->company_id ?>">
                                        <?= $companies[$record->company_id]->name ?>
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
                                        (($record->location_id != 0) ? $locations[$record->location_id]->name : '').
                                        (($record->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.$first_sub_locations[$record->first_sub_location_id]->name : '').
                                        (($record->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.$second_sub_locations[$record->second_sub_location_id]->name : '')
                                    ?>

                                </div>
                            </div>
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
                        </div>
                    </div>
                </div>
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
                    echo '<td>'.$item->item_type_name.', '.$item->brand_name.'</td>';
                    echo '<td>'.$item->model_name.'</td>';
                    echo '<td>'.
                        '<i class="fa fa-calendar"></i> '.
                        date("d M Y", strtotime($item->date_of_purchase)).
                        '</td>';
                    echo '<td><a href="'.base_url().'company/detail/'.$item->company_id.'">'.
                        $companies[$item->company_id]->name.
                        '</a></td>';
                    echo '<td>'.(($item->is_used == 1) ? 'Yes' : 'No' ).'</td>';
                    echo '<td>'.$item->employee_name.
                        '<br/> <i class="fa fa-building"></i> '.
                        $companies[$item->employee_company_id]->name.
                        '<br/> <i class="fa fa-map-marker"></i> '.
                        (($item->location_id != 0) ? $locations[$item->location_id]->name : '').
                        (($item->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.$first_sub_locations[$item->first_sub_location_id]->name : '').
                        (($item->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.$second_sub_locations[$item->second_sub_location_id]->name : '').
                        '</td>';
                    echo '<td> 
                    <a href="'. base_url(). 'item/edit/'.$item->id.'">
                    <button class="btn btn-xs btn-info" ><span class="fa fa-edit"></span> Edit</button>
                    </a>
                    <a href="'. base_url(). 'item/detail/'.$item->id.'">
                    <button class="btn btn-xs btn-warning" ><span class="fa fa-external-link"></span> View</button>
                    </a>
                    <a href="'. base_url(). 'item/mutate/'.$item->id.'">
                    <button class="btn btn-xs btn-primary" ><span class="fa fa-refresh"></span> Mutate</button>
                    </a>
              </td>';
                    echo '</tr>';
                }
                ?>
            </table>

        </div>
    </div>
</div>


