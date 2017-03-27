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
                <li>Detail</li>
            </ol>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-sm-12">
                <h3>Item
                    Code:
                    <?= (str_pad($record->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($record->id, 5, '0', STR_PAD_LEFT)) ?>
                    <?php
                        $item_codes = array();
                        array_push($item_codes, (str_pad($record->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($record->id, 5, '0', STR_PAD_LEFT)));
                    ?>
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
                                        <?php
                                            array_push($item_codes, (str_pad($item->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($item->id, 5, '0', STR_PAD_LEFT)));
                                        ?>
                                        <tr>
                                        <td><?= html_escape($item->item_type_name.', '.$item->brand_name.', '.$item->model_name)?>
                                        <?php if($item->model_units != ''): ?>
                                            (<?= html_escape($item->model_capacity_size.' '.$item->model_units) ?>)
                                        <?php endif; ?>
                                        (<a href="<?= base_url().'item/detail/'.$item->id?>"><?= (str_pad($item->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($item->id, 5, '0', STR_PAD_LEFT)) ?></a>)
                                        </td>
                                        <td valign="middle">
                                            <form method="POST" action="<?= base_url().'assembled-item/remove/'.$id.'/'.$item->id ?>">
                                                <button class="btn btn-xs btn-danger">
                                                        <input type="hidden" name="employee_id" id="employee_id" value="<?= $item->employee_id?>" />
                                                        <span class="fa fa-times"></span> Remove</button>
                                            </form>
                                        </td>
                                        </tr>
                                    <?php endforeach; ?>
                                        <tr>
                                            <td>
                                                <a href="<?= base_url().'assembled-item/add/'.$id ?>">
                                                    <button class="btn btn-sm btn-success">
                                                        <span class="fa fa-plus"></span> Add item</button></a>
                                            </td>
                                        </tr>
                                    </table>
                                    </ul>
                                </div>
                            </div>

                            <div class="divider">&nbsp;</div>

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <a href="<?= base_url().'assembled-item/edit/'.$record->id ?>">
                                        <button class="btn btn-primary form-control">
                                            <span class="fa fa-edit"></span>
                                            Edit item information
                                        </button>
                                    </a>
                                </div>

                                <div class="col-sm-6">
                                    <form action="<?= base_url().'barcode/print/submit' ?>" method="post">
                                        <?php foreach ($item_codes as $item_code): ?>
                                            <input type="hidden" name="item_codes[]" value="<?= $item_code ?>"/>
                                        <?php endforeach; ?>
                                        <button class="btn btn-primary form-control"><span class="fa fa-barcode"></span> Get barcodes for these items</button>
                                    </form>
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
                                    <a href="<?= base_url().'assembled-item/mutate/'.$record->id ?>">
                                        <button class="btn btn-primary form-control">
                                            <span class="fa fa-refresh"></span>
                                            Mutate to another employee
                                        </button>
                                    </a>
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
                                        <a href="<?= base_url().'assembled-item/delete/'.$record->id ?>">
                                            <button class="btn btn-danger form-control"
                                                    onclick="return confirm('CAUTION! This WILL delete ALL the items inside of it, along with' +
                                                     ' all of their mutation records as well! ' +
                                             'This process is irreversible! ' +
                                             'Click \'Cancel\' if you don\'t want to do this!')">
                                                <span class="fa fa-trash"></span>
                                                Delete this item
                                            </button></a>
                                        <div class="alert alert-warning">
                                            NOTE: If you only want to remove the items inside, so that you can put the items inside of another assembled item, don't use this!
                                            <br/>
                                            For that purpose, you can simply <strong>REMOVE</strong> (not delete) the item.
                                        </div>
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
            <div class="pull-right">
                <form action="<?= base_url().'assembled-item/detail/'.$record->id ?>" method="POST">
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

                    <div class="col-sm-3">
                        <div class="input-group" >
                            <div class="input-group-addon">
                                <span class="fa fa-times"></span> Limit
                            </div>
                            <input type="number" class="form-control" id="limit" name="limit"
                                   value="<?= (isset($limit) ? $limit : '100')?>"
                                   min="10" step="10">
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-success">Go!</button>
                    </div>
                </form>

            </div>
            <div class="clearfix"></div>
            <br/>
            <table class="table table-striped table-responsive data-table-mutation">
                <!-- add the data-table class to tell the page to paginate this table -->
                <thead>
                <th> Id </th>
                <th> Item Code </th>
                <th> Item Type / Brand </th>
                <th> Product name </th>
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
                        '<a href="'.base_url().'assembled-item/detail/'.$mutation->item_id.'">'.
                        str_pad($mutation->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($mutation->item_id, 5, '0', STR_PAD_LEFT).
                        '</a>'.
                        '</td>';
                    echo '<td>'.html_escape($mutation->item_type_name.', '.$mutation->brand_name).'</td>';
                    echo '<td>'.html_escape($mutation->product_name).'</td>';
                    echo '<td>'.
                        '<i class="fa fa-calendar"></i> '.
                        date("Y-m-d", strtotime($mutation->mutation_date)).
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
        //            if(strlen($mutation->note) <= 50){
                            echo html_escape($mutation->note);
        //            } else {
        //                // truncate the note if it is greater than 50 characters long
        //                echo '<span class="first50">'.
        //                    html_escape(substr($mutation->note, 0, 49)). '...'.
        //                     '</span>';
        //                echo '<h6><a href="'.base_url().'mutation-history/edit/'.$mutation->id.'#note">see more</a></h6>';
        //            }
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


            $('.data-table-mutation').DataTable({
                "order": [[ 4, "desc" ]],
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
                            pageSize: 'A4'

                        },
                        sType: 'html'
                    },
                    'colvis'
                ]
            });


        });

    </script>
