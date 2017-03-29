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
                <li>Mutation History</li>
            </ol>
        </div>

        <div class="pull-right">

            <div class="alert alert-info hidden-xs">
                <i class="fa fa-info-circle"></i> Tips: Use shift+click to order by multiple columns!
            </div>
            <form action="<?= base_url().'mutation-history' ?>" method="POST">
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
        <th> Model Name </th>
        <th style="min-width: 6em"> Mutated on </th>
        <th> From </th>
        <th> To </th>
        <th style="min-width: 9em"> Note </th>
        <th> Status </th>
        <th style="min-width: 1em"> Action </th>
        </thead>
        <?php
        foreach($records as $mutation){
            echo '<tr>';
            echo '<td>'.$mutation->id.'</td>';
            $link = 'item';
            if(isset($mutation->assembled) AND $mutation->assembled == 1){
                $link = 'assembled-item';
            };
            echo '<td>'.
                '<a href="'.base_url().$link.'/detail/'.$mutation->item_id.'">'.
                str_pad($mutation->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($mutation->item_id, 5, '0', STR_PAD_LEFT).
                '</a>'.
                '</td>';
            echo '<td>'.html_escape($mutation->item_type_name.', '.$mutation->brand_name).'</td>';
            echo '<td>'.html_escape($mutation->model_name).'</td>';
            echo '<td>'.
                    '<i class="fa fa-calendar"></i> '.
//                    date("d M Y", strtotime($mutation->mutation_date)).
                    date("Y-m-d", strtotime($mutation->mutation_date)).
                '</td>';

            echo '<td>';
            if($mutation->prev_employee_id == 0){
                echo '-';
            } else {
                echo '<i class="fa fa-user"></i> ';
                echo '<a href="'.base_url().'employee/detail/'.$mutation->prev_employee_id.'">';
                echo html_escape($employees[$mutation->prev_employee_id]->name);
                echo '</a>';
                echo '<br/> <i class="fa fa-building"></i> '.
                    html_escape($companies[$employees[$mutation->prev_employee_id]->company_id]->name);
//                    '<br/> <i class="fa fa-map-marker"></i> '.
//                    (($employees[$mutation->prev_employee_id]->location_id != 0) ? html_escape($locations[$employees[$mutation->prev_employee_id]->location_id]->name) : '').
//                    (($employees[$mutation->prev_employee_id]->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($first_sub_locations[$employees[$mutation->prev_employee_id]->first_sub_location_id]->name) : '').
//                    (($employees[$mutation->prev_employee_id]->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($second_sub_locations[$employees[$mutation->prev_employee_id]->second_sub_location_id]->name) : '');
            }
            echo '<br/>'.
                (($mutation->prev_location_id != 0) ? '<i class="fa fa-map-marker"></i> '.html_escape($locations[$mutation->prev_location_id]->name) : '').
                (($mutation->prev_first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($first_sub_locations[$mutation->prev_first_sub_location_id]->name) : '').
                (($mutation->prev_second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($second_sub_locations[$mutation->prev_second_sub_location_id]->name) : '');

            echo '</td>';

            echo '<td>';
            if($mutation->employee_id == 0){
                echo '-';
            } else {
                echo '<i class="fa fa-user"></i> ';
                echo '<a href="'.base_url().'employee/detail/'.$mutation->employee_id.'">';
                echo html_escape($employees[$mutation->employee_id]->name);
                echo '</a>';
                echo '<br/> <i class="fa fa-building"></i> '.
                    html_escape($companies[$employees[$mutation->employee_id]->company_id]->name);
//                    '<br/> <i class="fa fa-map-marker"></i> '.
//                    (($employees[$mutation->employee_id]->location_id != 0) ? html_escape($locations[$employees[$mutation->employee_id]->location_id]->name) : '').
//                    (($employees[$mutation->employee_id]->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($first_sub_locations[$employees[$mutation->employee_id]->first_sub_location_id]->name) : '').
//                    (($employees[$mutation->employee_id]->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($second_sub_locations[$employees[$mutation->employee_id]->second_sub_location_id]->name) : '');
            }
            // echo the item target location
            echo '<br/>'.
                (($mutation->location_id != 0) ? '<i class="fa fa-map-marker"></i> '.html_escape($locations[$mutation->location_id]->name) : '').
                (($mutation->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($first_sub_locations[$mutation->first_sub_location_id]->name) : '').
                (($mutation->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($second_sub_locations[$mutation->second_sub_location_id]->name) : '');
          
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

<script type="text/javascript">
    $(document).ready(function(){

        $('.data-table-mutation').DataTable({
            "order": [[ 4, "desc" ], [0, "desc"]],
//            "processing": true,
//            "serverSide": true,
//            "ajax":{
//                url: "<?php //echo base_url() . 'mutation_history/fetch_mutation_history'; ?>//",
//                type: "POST"
//            },
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

//        var startDate = $('#date_start').datepicker('getDate');
//        var endDate = $('#date_end').datepicker('getDate');

        // Add event listeners to the two range filtering inputs
//        var table = $('.data-table-mutation').DataTable();
//        $('#date_start').datepicker().on('changeDate', function () {
//            table.draw();
//        });
//        $('#date_end').datepicker().on('changeDate', function () {
//            table.draw();
//        } );
//
//
//        // push new parameter for filtering purposes
//        $.fn.dataTableExt.afnFiltering.push(
//            function( oSettings, aData, iDataIndex ) {
//
//                var iFini = new Date($('#date_start').datepicker('getDate')).toLocaleString();
//                var iFfin = new Date($('#date_end').datepicker('getDate')).toLocaleString();
//                var iStartDateCol = 4;
//                var iEndDateCol = 4;
//
//                iFini = iFini.split(',');
//                iFini = iFini[0].split('/');
//                iFfin = iFfin.split(',');
//                iFfin = iFfin[0].split('/'); // now IFini and IFfin are array of month, day, year
//
//                if(iFini[0].length == 1){
//                    // pads single digit month
//                    iFini[0] = '0' + iFini[0].toString();
//                }
//                if(iFini[1].length == 1){
//                    // pads single digit date
//                    iFini[1] = '0' + iFini[1].toString();
//                }
//                if(iFfin[0].length == 1){
//                    // pads single digit month
//                    iFfin[0] = '0' + iFfin[0].toString();
//                }
//                if(iFfin[1].length == 1){
//                    // pads single digit date
//                    iFfin[1] = '0' + iFfin[1].toString();
//                }
//
//                iFini=iFini[2] +'-'+ iFini[0] +'-'+iFini[1];
//                iFfin=iFfin[2] +'-'+ iFfin[0] +'-'+iFfin[1];
//
//                var rowDate = aData[iStartDateCol].substring(1); //remove the leading space in the first index we put on the column
//
//                // 1970-01-01 means the datepickers are blank, so don't do any filtering
//                if ( iFini === "1970-01-01" && iFfin === "1970-01-01" )
//                {
//                    return true;
//                }
//                else if ( iFini <= rowDate && iFfin === "1970-01-01")
//                {
//                    return true;
//                }
//                else if ( iFfin >= rowDate && iFini === "1970-01-01")
//                {
//                    return true;
//                }
//                else if (iFini <= rowDate && iFfin >= rowDate)
//                {
//                    return true;
//                }
//                return false;
//            }
//        );
//
    });

</script>