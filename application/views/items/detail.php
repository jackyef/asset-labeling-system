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
                                <div class="col-sm-4"><strong>Model</strong></div>
                                <div class="col-sm-8">
                                    <?= $record->model_name ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Capacity/Size</strong></div>
                                <div class="col-sm-8">
                                    <?php if ($record->model_capacity_size == ''): ?>
                                    N/A
                                    <?php else: ?>
                                    <?= $record->model_capacity_size.' '.$record->model_units ?>
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
                                    <?= $record->supplier_name ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4"><strong>Owned by</strong></div>
                                <div class="col-sm-8">
                                    <span class="fa fa-building"></span>
                                    <a href="<?= base_url().'company/detail/'.$record->company_id ?>">
                                        <?= $record->company_name ?>
                                    </a>
                                </div>
                            </div>


                            <div class="divider">&nbsp;</div>

                            <div class="form-group">
                                <div class="col-sm-4">
                                    <span class="fa fa-sticky-note"></span> <strong>Note</strong></div>
                                <div class="col-sm-8">
                                    <?= $record->note ?>
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
                                        <?= $record->employee_name ?>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4"><strong>Works at</strong></div>
                                <div class="col-sm-8">
                                    <span class="fa fa-building"></span>
                                    <a href="<?= base_url().'company/detail/'.$record->employee_company_id ?>">
                                        <?= $companies[$record->employee_company_id]->name ?>
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
                                        (($employees[$record->employee_id]->location_id != 0) ? $locations[$employees[$record->employee_id]->location_id]->name : '').
                                        (($employees[$record->employee_id]->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.$first_sub_locations[$employees[$record->employee_id]->first_sub_location_id]->name : '').
                                        (($employees[$record->employee_id]->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.$second_sub_locations[$employees[$record->employee_id]->second_sub_location_id]->name : '')
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h3>Mutation History</h3>
            <hr />
            <!-- TODO: put mutation history here -->
            TODO: mutation history here<br/>
            TODO: mutation history here<br/>
            TODO: mutation history here<br/>
            TODO: mutation history here<br/>

        </div>
    </div>
</div>


