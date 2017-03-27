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
            <li>Item</li>
        </ol>
    </div>
    <div class="pull-right">
        <a href="<?php echo base_url(); ?>item/new"><button class="btn btn-primary"><span class="fa fa-plus"></span> New Item</button> </a>
    </div>
    <div class="clearfix"></div>

    <div class="pull-right">
        <form action="<?= base_url().'item' ?>" method="POST">
            <div class="col-sm-4">
                <div class="input-group date" data-provide="datepicker-inline ">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span> From:
                    </div>
                    <input type="text" class="form-control datepicker" id="date_start" name="date_start">
                </div>
            </div>

            <div class="col-sm-4">
                <div class="input-group date" data-provide="datepicker-inline ">
                    <div class="input-group-addon">
                        <span class="fa fa-calendar"></span> to:
                    </div>
                    <input type="text" class="form-control datepicker" id="date_end" name="date_end">
                </div>
            </div>

            <div class="col-sm-4">
                <div class="input-group" >
                    <div class="input-group-addon">
                        <span class="fa fa-times"></span> Limit
                    </div>
                    <input type="number" class="form-control" id="limit" name="limit"
                           value="<?= (isset($limit) ? $limit : '100')?>"
                           min="10" step="10">
                </div>
            </div>
            <div class="col-sm-4 form-group">
                    <select class="form-control selectpicker" name="model_id" id="model_id" data-live-search="true">
                        <option value="0">Select model</option>
                        <?php foreach($models as $model){ ?>
                            <option value="<?= $model->id?>"
                                <?= (($model_id == $model->id) ? 'selected' : '') ?>>
                                <?= html_escape($model->item_type_name.' / '.$model->brand_name. ' / '. $model->name) ?>
                                <?= (($model->capacity_size) ? html_escape('('.$model->capacity_size.' '.$model->units.')') : '') ?>
                            </option>
                        <?php } ?>
                    </select>
            </div>

            <div class="col-sm-4 form-group">
                    <select class="form-control selectpicker" name="company_id" id="company_id" data-live-search="true">
                        <option value="0">Select company</option>
                        <?php foreach($companies as $company){ ?>
                            <option value="<?= $company->id?>"
                                <?= (($company_id == $company->id) ? 'selected' : '') ?>>
                                <?= html_escape($company->name) ?>
                            </option>
                        <?php } ?>
                    </select>
            </div>


            <div class="col-sm-4">
                <button class="btn btn-success">Go!</button>
            </div>


        </form>

    </div>
    <div class="clearfix"></div>
    <br/>
    <table class="table table-striped table-responsive data-table">
        <!-- add the data-table class to tell the page to paginate this table -->
        <thead>
        <th> Id </th>
        <th> Item Code </th>
        <th> Item Type / Brand </th>
        <th> Model </th>
        <th style="min-width: 6em"> Purchased on </th>
        <th> Owned by </th>
        <th> Is used? </th>
        <th> Held by </th>
        <th style="min-width: 1em"> Action </th>
        </thead>
        <?php
        foreach($records as $item){
            echo '<tr>';
            echo '<td>'.$item->id.'</td>';
            echo '<td>'.
                '<a href="'.base_url().'item/detail/'.$item->id.'">'.
                str_pad($item->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($item->id, 5, '0', STR_PAD_LEFT).
                '</a>'.
                '</td>';
            echo '<td>'.html_escape($item->item_type_name.', '.$item->brand_name).'</td>';
            echo '<td>'.html_escape($item->model_name).'</td>';
            echo '<td>'.
                    '<i class="fa fa-calendar"></i> '.
//                    date("d M Y", strtotime($item->date_of_purchase)).
                    date("Y-m-d", strtotime($item->date_of_purchase)).
                '</td>';
            echo '<td><a href="'.base_url().'company/detail/'.$item->company_id.'">'.
                html_escape($companies[$item->company_id]->name).
                '</a></td>';
            echo '<td>'.(($item->is_used == 1) ? 'Yes' : 'No' ).'</td>';
            echo '<td>'.
                '<a href="'.base_url().'employee/detail/'.$item->employee_id.'">'.
                html_escape($item->employee_name). '</a>'.
                '<br/> <i class="fa fa-building"></i> '.
                html_escape($companies[$item->employee_company_id]->name).
                '<br/> <i class="fa fa-map-marker"></i> '.
                (($item->location_id != 0) ? html_escape($locations[$item->location_id]->name) : '').
                (($item->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($first_sub_locations[$item->first_sub_location_id]->name) : '').
                (($item->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($second_sub_locations[$item->second_sub_location_id]->name) : '').
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
<script>
    $(document).ready(function() {
        // handles datepicker on pages that uses it
        $('#date_start').datepicker({
            format: 'DD, dd MM yyyy',
            autoclose: true,
            todayHighlight: true,
            todayBtn: true,
            disableTouchKeyboard: true
        });
        $('#date_end').datepicker({
            format: 'DD, dd MM yyyy',
            autoclose: true,
            todayHighlight: true,
            todayBtn: true,
            disableTouchKeyboard: true
        });

        $('#date_start').datepicker('update', '<?= $date_start ?>');
        $('#date_end').datepicker('update', '<?= $date_end ?>');
    });
</script>


