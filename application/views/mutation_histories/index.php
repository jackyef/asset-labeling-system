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
    <div class="clearfix"></div>
    <table class="table table-striped table-responsive data-table">
        <!-- add the data-table class to tell the page to paginate this table -->
        <thead>
        <th> Id </th>
        <th> Item Code </th>
        <th> Item Type / Brand </th>
        <th> Model </th>
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
            echo '<td>'.
                '<a href="'.base_url().'item/detail/'.$mutation->item_id.'">'.
                str_pad($mutation->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($mutation->item_id, 5, '0', STR_PAD_LEFT).
                '</a>'.
                '</td>';
            echo '<td>'.$mutation->item_type_name.', '.$mutation->brand_name.'</td>';
            echo '<td>'.$mutation->model_name.'</td>';
            echo '<td>'.
                    '<i class="fa fa-calendar"></i> '.
                    date("d M Y", strtotime($mutation->mutation_date)).
                '</td>';

            if($mutation->prev_employee_id == 0){
                echo '<td> - </td>';
            } else {
                echo '<td>';
                echo '<a href="'.base_url().'employee/detail/'.$mutation->prev_employee_id.'">';
                echo $employees[$mutation->prev_employee_id]->name;
                echo '</a>';
                echo '<br/> <i class="fa fa-building"></i> '.
                    $companies[$employees[$mutation->prev_employee_id]->company_id]->name.
                    '<br/> <i class="fa fa-map-marker"></i> '.
                    (($employees[$mutation->prev_employee_id]->location_id != 0) ? $locations[$employees[$mutation->prev_employee_id]->location_id]->name : '').
                    (($employees[$mutation->prev_employee_id]->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.$first_sub_locations[$employees[$mutation->prev_employee_id]->first_sub_location_id]->name : '').
                    (($employees[$mutation->prev_employee_id]->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.$second_sub_locations[$employees[$mutation->prev_employee_id]->second_sub_location_id]->name : '');
                echo '</td>';
            }

            echo '<td>';
            if($mutation->employee_id == 0){
                echo '-';
            } else {
                echo '<a href="'.base_url().'employee/detail/'.$mutation->employee_id.'">';
                echo $employees[$mutation->employee_id]->name;
                echo '</a>';
                echo '<br/> <i class="fa fa-building"></i> '.
                    $companies[$employees[$mutation->employee_id]->company_id]->name.
                    '<br/> <i class="fa fa-map-marker"></i> '.
                    (($employees[$mutation->employee_id]->location_id != 0) ? $locations[$employees[$mutation->employee_id]->location_id]->name : '').
                    (($employees[$mutation->employee_id]->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.$first_sub_locations[$employees[$mutation->employee_id]->first_sub_location_id]->name : '').
                    (($employees[$mutation->employee_id]->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.$second_sub_locations[$employees[$mutation->employee_id]->second_sub_location_id]->name : '');
            }
            echo '</td>';

            echo '<td>';
            if(strlen($mutation->note) <= 50){
                echo $mutation->note;
            } else {
                // truncate the note if it is greater than 50 characters long
                echo substr($mutation->note, 0, 50). '...';
                echo '<h6><a href="'.base_url().'mutation-history/edit/'.$mutation->id.'#note">see more</a></h6>';
            }
            echo '</td>';

            echo '<td>';
            if ($mutation->mutation_status_id == 0){
                echo 'First assignment';
            } else {
                echo $mutation_statuses[$mutation->mutation_status_id]->name;
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


