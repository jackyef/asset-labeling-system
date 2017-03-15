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
    <a href="<?= base_url().'item'?>"><button class="btn btn-primary"><span class="fa fa-backward"></span> Back to item list</button></a>
    <h2>Add a new item</h2>
    <br/>
    <form class="form-horizontal" action="<?php echo base_url(); ?>item/new/submit" method="POST">
        <div class="form-group">
            <label class="control-label col-sm-2" for="date_of_purchase">Purchased at:</label>
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
            <label class="control-label col-sm-2" for="warranty_expiry_date">Warranty expires at:</label>
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
            <label class="control-label col-sm-2" for="model_id">Item type / Brand / Model:</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker" name="model_id" id="model_id" data-live-search="true">
                    <?php foreach($models as $model){ ?>
                        <option value="<?= $model->id?>">
                            <?= $model->item_type_name.' / '.$model->brand_name. ' / '. $model->name ?>
                            <?= (($model->capacity_size) ? '('.$model->capacity_size.' '.$model->units.')' : '') ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="supplier_id">Supplier:</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker" name="supplier_id" id="supplier_id" data-live-search="true">
                    <?php foreach($suppliers as $supplier){ ?>
                        <option value="<?= $supplier->id?>">
                            <?= $supplier->name ?>
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
                        <option value="<?= $company->id?>">
                            <?= $company->name ?>
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
                        <option value="<?= $operating_system->id?>">
                            <?= $operating_system->name ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="employee_id">Holding employee:</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker" name="employee_id" id="employee_id" data-live-search="true">
                    <?php foreach($employees as $employee){ ?>
                        <option value="<?= $employee->id?>">
                            <?= $employee->name ?>
                            (<?= $employee->company_name ?>)
                        </option>
                    <?php } ?>
                </select>
                <div class="checkbox">
                    <label><input type="checkbox" id="is_used" name="is_used"> Is currently being used?</label>
                </div>
                <div class="alert alert-warning">
                    <span class="fa fa-warning"></span> Note:
                    <ul>
                        <li>If you're not assigning this item to be used by an employee yet, assign it to a warehouse employee. (Ex: Gudang IT, Gudang B, etc.)</li>
                        <li>You may have to create this kind of employees beforehand. If no such employees exists, contact your administrator.</li>
                        <li>If you are assigning to a warehouse employee, the item is probably not being currently used.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="note">Note:</label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="4" id="note" name="note" placeholder="Ex: Sesuai dengan Surat no. XX, red-colored Desktop, etc"></textarea>
            </div>
        </div>



        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        // handles datepicker on pages that uses it
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

        $('.datepicker').datepicker('update', new Date());

        // handles warranty_expiry_date can't be earlier than purchase date
        $('#date_of_purchase').datepicker().on('changeDate', function(){
            var selected = $('#date_of_purchase').datepicker('getDate');
            $('#warranty_expiry_date').datepicker('setStartDate', selected);
            $('#warranty_expiry_date').datepicker('update', selected);
        });
    });
</script>