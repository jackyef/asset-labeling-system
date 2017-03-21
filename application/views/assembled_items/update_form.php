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
        <a href="<?= base_url().'assembled-item'?>"><button class="btn btn-primary"><span class="fa fa-backward"></span> Back to assembled item list</button></a>
        <h2>Edit assembled item (code:
            <a href="<?= base_url().'assembled-item/detail/'.$record->id ?>"><?= str_pad($record->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($record->id, 5, '0', STR_PAD_LEFT) ?></a>)
        </h2>
        <br/>
        <form class="form-horizontal" action="<?php echo base_url(); ?>assembled-item/edit/submit/<?= $record->id ?>" method="POST">
            <div class="form-group">
                <label class="control-label col-sm-2" for="date_of_purchase">Purchased on:</label>
                <div class="col-sm-3">
                    <div class="input-group date" data-provide="datepicker-inline ">
                        <input type="text" class="form-control datepicker" id="date_of_purchase" name="date_of_purchase">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="well-sm bg-warning">
                        <span class="fa fa-lightbulb-o">
                        </span>
                        Tips: Use ctrl + <i class="fa fa-arrow-left"></i> / <i class="fa fa-arrow-right"></i>
                        to quickly navigate between years, shift + <i class="fa fa-arrow-left"></i> / <i class="fa fa-arrow-right"></i>
                        between months! Hit enter!
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="warranty_expiry_date">Warranty expires on:</label>
                <div class="col-sm-3">
                    <div class="input-group date" data-provide="datepicker-inline ">
                        <input type="text" class="form-control datepicker" id="warranty_expiry_date" name="warranty_expiry_date">
                        <div class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="well-sm bg-info">
                        <span class="fa fa-info-circle">
                        </span>
                        For items without warranty, just leave this field the same as the purchase date.
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="well-sm bg-warning">
                        <span class="fa fa-info-circle">
                        </span>
                        Changing the dates will <strong>NOT</strong> affect the items inside this assembled item. You have to change
                        each items' purchase date and warranty individually. This is to accomodate items that are purchased separately
                        and then assembled together into an assembled item.
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="brand_id">Item type / Brand:</label>
                <div class="col-sm-10">
                    <select class="form-control selectpicker" name="brand_id" id="brand_id" data-live-search="true">
                        <?php foreach($brands as $brand){ ?>
                            <option value="<?= $brand->id?>"
                            <?= (($brand->id == $record->brand_id) ? 'selected' : '') ?>>
                                <?= html_escape($brand->item_type_name.' / '.$brand->name) ?>
                            </option>
                        <?php } ?>
                    </select>
                    <p class="alert alert-danger">
                        <i class="fa fa-warning"></i>
                        Changing item type (Ex: HDD to Memory) <strong>WILL</strong> change the item code, which will
                        probably cause a lot of problem, for example, if you have printed a barcode of this item.
                        <br/>
                        It's only absolutely safe to do this if there isn't any mutation of this item yet. Proceed at your own risk.
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="model_id">Product name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Ex: PX-8529, Dell Workstation 19, etc"
                           value="<?= html_escape($record->product_name)?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="supplier_id">Supplier:</label>
                <div class="col-sm-10">
                    <select class="form-control selectpicker" name="supplier_id" id="supplier_id" data-live-search="true">
                        <?php foreach($suppliers as $supplier){ ?>
                            <option value="<?= $supplier->id?>"
                                <?= (($supplier->id == $record->supplier_id) ? 'selected' : '') ?>>
                                <?= html_escape($supplier->name) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="company_id">Owned by (Company):</label>
                <div class="col-sm-10">
                    <select class="form-control selectpicker" name="company_id" id="company_id" data-live-search="true">
                        <?php foreach($companies as $company){ ?>
                            <option value="<?= $company->id?>"
                                <?= (($company->id == $record->company_id) ? 'selected' : '') ?>>
                                <?= html_escape($company->name) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="operating_system_id">Operating system:</label>
                <div class="col-sm-10">
                    <select class="form-control selectpicker" name="operating_system_id" id="operating_system_id" data-live-search="true">
                        <option value="0">N/A</option>
                        <?php foreach($operating_systems as $operating_system){ ?>
                            <option value="<?= $operating_system->id?>"
                                <?= (($operating_system->id == $record->operating_system_id) ? 'selected' : '') ?>>
                                <?= html_escape($operating_system->name) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="employee_id">Holding employee:</label>
                <div class="col-sm-10">
                    <select class="form-control selectpicker" name="employee_id" id="employee_id" data-live-search="true" disabled>
                        <?php foreach($employees as $employee){ ?>
                            <option value="<?= $employee->id?>"
                                <?= (($employee->id == $record->employee_id) ? 'selected' : '') ?>>
                                <?= html_escape($employee->name) ?>
                                (<?= html_escape($employee->company_name) ?>)
                            </option>
                        <?php } ?>
                    </select>
                    <div class="checkbox">
                        <label><input type="checkbox" id="is_used" name="is_used"
                                <?= ($record->is_used == 1) ? 'checked' : '' ?>>
                            Is currently being used?</label>
                    </div>
                    <div class="alert alert-warning">
                        <span class="fa fa-warning"></span> Note:
                        <ul>
                            <li>Changing the "is used?" status of this assembled item <strong>WILL</strong> also affect all the items inside this assembled item.</li>
                            <li>If you're not assigning this item to be used by an employee yet, assign it to a warehouse employee. (Ex: Gudang IT, Gudang B, etc.)</li>
                            <li>You may have to create this kind of employees beforehand. If no such employees exists, contact your administrator.</li>
                            <li>If you are assigning to a warehouse employee, the item is probably not currently being used.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="note">Note:</label>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="4" id="note" name="note" placeholder="Ex: Sesuai dengan Surat no. XX, red-colored Desktop, etc"><?= $record->note ?></textarea>
                </div>
            </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save item information</button>
            </div>
        </div>
    </form>
</div>
</div>
<script type="text/javascript">
    // update the date pickers to take the record's value
    $(document).ready(function(){
        $('#warranty_expiry_date').datepicker({
            format: 'DD, dd MM yyyy',
            autoclose: true,
            todayHighlight: true,
            todayBtn: true,
            disableTouchKeyboard: true
        });
        $('#date_of_purchase').datepicker({
            format: 'DD, dd MM yyyy',
            autoclose: true,
            todayHighlight: true,
            todayBtn: true,
            disableTouchKeyboard: true
        });

        $('#date_of_purchase').datepicker('update', '<?= (date("d-m-Y", strtotime($record->date_of_purchase))) ?>');
        $('#warranty_expiry_date').datepicker('setStartDate', '<?= (date("d-m-Y", strtotime($record->warranty_expiry_date))) ?>');
        $('#warranty_expiry_date').datepicker('update', '<?= (date("d-m-Y", strtotime($record->warranty_expiry_date))) ?>');

        // handles warranty_expiry_date can't be earlier than purchase date
        $('#date_of_purchase').datepicker().on('changeDate', function(){
            var selected = $('#date_of_purchase').datepicker('getDate');
            $('#warranty_expiry_date').datepicker('setStartDate', selected);
            $('#warranty_expiry_date').datepicker('update', selected);
        });
    });

</script>

