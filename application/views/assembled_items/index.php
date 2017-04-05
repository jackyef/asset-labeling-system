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
            <li>Assembled Item</li>
        </ol>
    </div>
    <?php if($permission_item_insert == 1): ?>
    <div class="pull-right">
        <a href="<?php echo base_url(); ?>assembled-item/new"><button class="btn btn-primary"><span class="fa fa-plus"></span> New Assembled Item</button> </a>
    </div>
    <?php endif; ?>
    <div class="clearfix"></div>
    <div class="pull-right">
        <form action="<?= base_url().'assembled-item' ?>" method="POST">
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
                <select class="form-control selectpicker" name="brand_id" id="brand_id" data-live-search="true">
                    <option value="0">Select brand</option>
                    <?php foreach($brands as $brand){ ?>
                        <option value="<?= $brand->id?>"
                            <?= (($brand_id == $brand->id) ? 'selected' : '') ?>>
                            <?= html_escape($brand->item_type_name.' / '.$brand->name) ?>
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
                <select class="form-control selectpicker" name="location_id" id="location_id" data-live-search="true">
                    <option value="0,0,0">
                        Choose location
                    </option>
                    <?php foreach($locations as $location){ ?>
                        <option value="<?= $location->id.',0,0' ?>"
                            <?= (($location_id.','.$first_sub_location_id.','.$second_sub_location_id == $location->id.',0,0') ? 'selected' : '') ?>>
                            <?= html_escape($location->name) ?>
                        </option>
                    <?php } ?>

                    <?php foreach($first_sub_locations as $first_sub_location){ ?>
                        <option value="<?= $first_sub_location->location_id.','.$first_sub_location->id.',0' ?>"
                            <?= (($location_id.','.$first_sub_location_id.','.$second_sub_location_id == $first_sub_location->location_id.','.$first_sub_location->id.',0') ? 'selected' : '') ?>>
                            <?= (($first_sub_location->location_id != 0) ? html_escape($locations[$first_sub_location->location_id]->name) : '') ?>/<?= html_escape($first_sub_location->name) ?>
                        </option>
                    <?php } ?>

                    <?php foreach($second_sub_locations as $second_sub_location){ ?>
                        <option value="<?= $first_sub_locations[$second_sub_location->first_sub_location_id]->location_id.','.$second_sub_location->first_sub_location_id.','.$second_sub_location->id ?>"
                            <?= (($location_id.','.$first_sub_location_id.','.$second_sub_location_id == $first_sub_locations[$second_sub_location->first_sub_location_id]->location_id.','.$second_sub_location->first_sub_location_id.','.$second_sub_location->id) ? 'selected' : '') ?>>
                            <?= (($first_sub_locations[$second_sub_location->first_sub_location_id]->location_id != 0) ? html_escape($locations[$first_sub_locations[$second_sub_location->first_sub_location_id]->location_id]->name) : '') ?>/<?= ($second_sub_location->first_sub_location_id != 0) ? html_escape($first_sub_locations[$second_sub_location->first_sub_location_id]->name) : ''?>/<?= html_escape($second_sub_location->name) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-sm-4 col-sm-offset-8">
                <button class="btn btn-success"><i class="fa fa-filter"></i> Filter results</button>
            </div>


        </form>

    </div>
    <div class="clearfix"></div>
    <br/>
    <table class="table table-striped table-responsive data-table-item">
        <!-- add the data-table class to tell the page to paginate this table -->
        <thead>
        <th> Id </th>
        <th> Item Code </th>
        <th> Item Type / Brand </th>
        <th> Product name </th>
        <th style="min-width: 6em"> Purchased on </th>
        <th> Owned by </th>
        <th> Is used? </th>
        <th> Held by </th>
        <th> Item location </th>
        <th style="min-width: 1em"> Action </th>
        </thead>
        <?php
        foreach($records as $item){
            echo '<tr>';
            echo '<td>'.$item->id.'</td>';
            echo '<td>'.
                '<a href="'.base_url().'assembled-item/detail/'.$item->id.'">'.
                str_pad($item->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($item->id, 5, '0', STR_PAD_LEFT).
                '</a>'.
                '</td>';
            echo '<td>'.html_escape($item->item_type_name.', '.$item->brand_name).'</td>';
            echo '<td>'.html_escape($item->product_name).'</td>';
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
                '<i class="fa fa-user"></i> '.
                '<a href="'.base_url().'employee/detail/'.$item->employee_id.'">'.
                html_escape($item->employee_name). '</a>'.
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
                echo '<a href="' . base_url() . 'assembled-item/edit/' . $item->id . '">
                        <button class="btn btn-xs btn-info" ><span class="fa fa-edit"></span> Edit</button>
                  </a>';
            }
            echo '<a href="'. base_url(). 'assembled-item/detail/'.$item->id.'">
                        <button class="btn btn-xs btn-warning" ><span class="fa fa-external-link"></span> View</button>
                  </a>';
            if ($permission_item_mutate) {
                echo '<a href="' . base_url() . 'assembled-item/mutate/' . $item->id . '">
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

        $('.data-table-item').DataTable({
            "order": [[ 4, "desc" ], [0, "desc"]],
            responsive: true,
            colReorder: false,
            dom: 'Bflrtip',
            buttons: [
                {
                    extend: 'print',
                    autoPrint: false,
                    exportOptions: {
                        columns: ':visible',
                        pageSize: 'A4',
                        stripHtml: false
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function (data, column, row) {
                                if (data.indexOf('-<br>') == 0 ){ return '-'; }
                                data = data.replace(/<br\s*\/?>/i, "\r\nof\r\n"); //replace the first linebreak with 'of'
                                data = data.replace(/<br\s*\/?>/i, "\r\nat\r\n"); //replace the second linebreak with 'at'
                                data = data.replace(/\s*<span class="fa fa-arrow-right"><\/span>\s*/ig, ", "); //replace right arrow icons with comma
                                data = data.replace(/\s+/ig, " "); //multiple spaces with 1 space
                                var html = data;
                                var div = document.createElement("div");
                                div.innerHTML = html;
                                var text = div.textContent || div.innerText || "";
                                return text;
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function (data, column, row) {
                                if (data.indexOf('-<br>') == 0 ){ return '-'; }
                                data = data.replace(/<br\s*\/?>/i, "\r\nof\r\n"); //replace the first linebreak with 'of'
                                data = data.replace(/<br\s*\/?>/i, "\r\nat\r\n"); //replace the second linebreak with 'at'
                                data = data.replace(/\s*<span class="fa fa-arrow-right"><\/span>\s*/ig, ", "); //replace right arrow icons with comma
                                var html = data;
                                var div = document.createElement("div");
                                div.innerHTML = html;
                                var text = div.textContent || div.innerText || "";
                                return text;
                            }
                        },

                    },
                    sType: 'html',
                    pageSize: 'A4',
                    orientation: 'landscape'
                },
                'colvis'
            ]
        });


    });
</script>

