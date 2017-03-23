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
                <li>Generate barcode labels</li>
            </ol>
        </div>
        <div class="clearfix"></div>
    <h2>Generate barcode labels</h2>
    <br/>
    <form class="form-horizontal" action="<?php echo base_url(); ?>barcode/print/submit" target="_blank" method="POST">
        <div class="form-group">
            <div class="alert alert-warning">
                <span class="fa fa-info-circle"></span> This page generate barcodes specifically designed for Honeywell PC42T printer.
            </div>
            <label class="control-label col-sm-2" for="name">Choose item codes to print:</label>
            <div class="col-sm-10">
                <select class="form-control selectpicker"
                        multiple="multiple" name="item_codes[]" id="item_codes[]" data-live-search="true">
                    <?php foreach($items as $item){ ?>
                        <option
                        value="<?= str_pad($item->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($item->id, 5, '0', STR_PAD_LEFT) ?>">
                            <?= str_pad($item->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($item->id, 5, '0', STR_PAD_LEFT).' - '.
                             html_escape($item->item_type_name.', '. $item->brand_name.', '.$item->model_name.' ('.$item->employee_name.')') ?></option>
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
</div>



