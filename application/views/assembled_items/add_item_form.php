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
                <li><a href="<?= base_url().'assembled-item' ?>">Assembled Item</a></li>
                <li>Add item to assembled item</li>
            </ol>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-sm-12">
                <h3>Item
                    Code:
                    <a href="<?= base_url().'assembled-item/detail/'.$record->id ?>">
                    <?= (str_pad($record->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($record->id, 5, '0', STR_PAD_LEFT)) ?></a>
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
                                <div class="col-sm-4"><strong>Product Name</strong></div>
                                <div class="col-sm-8">
                                    <?= html_escape($record->product_name) ?>
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
                                <div class="col-sm-4"><strong>Held by</strong></div>
                                <div class="col-sm-8">
                                    <span class="fa fa-user"></span>
                                    <a href="<?= base_url().'employee/detail/'.$record->employee_id ?>">
                                        <?= html_escape($record->employee_name) ?>
                                    </a>
                                    <br/>
                                    <span class="fa fa-building"></span>
                                    <a href="<?= base_url().'company/detail/'.$employees[$record->employee_id]->company_id ?>">
                                        <?= html_escape($employees[$record->employee_id]->company_name) ?>
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
                                <div class="col-sm-4">
                                    <strong>Contains</strong></div>
                                <div class="col-sm-8">
                                    <table>
                                    <?php if(sizeof($items) == 0){ ?>
                                        <tr>
                                            <td> This assembled item contains no items.</td>
                                        </tr>
                                    <?php }?>
                                    <?php foreach($items as $item): ?>
                                        <tr>
                                        <td><?= html_escape($item->item_type_name.', '.$item->brand_name.', '.$item->model_name)?>
                                        <?php if($item->model_units != ''): ?>
                                            (<?= html_escape($item->model_capacity_size.' '.$item->model_units) ?>)
                                        <?php endif; ?>
                                        (<a href="<?= base_url().'item/detail/'.$item->id?>"><?= (str_pad($item->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($item->id, 5, '0', STR_PAD_LEFT)) ?></a>)
                                        </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </table>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="panel panel-primary" style="border-color: #229955;">
                        <div class="panel-heading" style="background-color: #229955;">
                            <h3 class="panel-title" style="color: white;">Add item</h3>
                        </div>
                        <div class="panel-body">
                            <form action="<?= base_url().'assembled-item/add/submit/'.$record->id ?>" method="post">
                                <div class="form-group">
                                    <div class="col-sm-12"><strong>Choose item:</strong></div>

                                </div>
                                <input type="hidden" value="<?= $record->employee_id ?>" name="employee_id" id="employee_id"/> <!-- mutate to holder of this assembled item -->
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <select class="form-control selectpicker" name="item_id_prev_employee_id" id="item_id_prev_employee_id" data-live-search="true">
                                            <?php foreach($items_to_add as $item_to_add){ ?>
                                                <option value="<?= $item_to_add->id.','.$item_to_add->employee_id?>">
                                                    <?= html_escape($item_to_add->item_type_name) ?> / <?= html_escape($item_to_add->brand_name) ?> / <?= html_escape($item_to_add->model_name) ?>
                                                    (<?= (str_pad($item_to_add->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($item_to_add->id, 5, '0', STR_PAD_LEFT)) ?>)
                                                    <?= html_escape($item_to_add->employee_name) ?>
                                                    <br/>
                                                    <?= html_escape($companies[$item_to_add->employee_company_id]->name) ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="divider">&nbsp;</div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                            <button class="btn btn-primary form-control">
                                                <span class="fa fa-arrow-left"></span>
                                                Add to this assembled item
                                            </button>
                                    </div>
                                </div>

                                <div class="divider">&nbsp;</div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="alert alert-danger">
                                            <span class="fa fa-warning"></span>
                                            This will automatically mutate the selected item to the holder of this assembled item!
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
