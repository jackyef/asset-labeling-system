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
            <li><a href="<?= base_url().'company' ?>">Company</a></li>
            <li>Detail</li>
        </ol>
    </div>
    <div class="clearfix"></div>
        <h3><?= html_escape($record->name) ?></h3>
        <h5>Below are the list of employees that work here: </h5>
    <table class="table table-striped table-responsive data-table">
        <!-- add the data-table class to tell the page to paginate this table -->
        <thead>
        <th> Id </th>
        <th> Employee Name </th>
        <th> Company </th>
        <th> Is working? </th>
        <th> Current Location </th>
        <th style="min-width: 1em"> Action </th>
        </thead>
        <?php
        foreach($employees as $employee){
            echo '<tr>';
            echo '<td>'.$employee->id.'</td>';
            echo '<td><a href="'.base_url().'employee/detail/'.$employee->id.'">'.html_escape($employee->name).'</a></td>';
            echo '<td>'.html_escape($employee->company_name).'</td>';
            echo '<td>'.(($employee->is_working == 1) ? 'Yes' : 'No') .'</td>';
            echo '<td>'.
                (($employee->location_id != 0) ? '<span class="fa fa-map-marker"></span> '.html_escape($locations[$employee->location_id]->name) : '').
                (($employee->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($first_sub_locations[$employee->first_sub_location_id]->name) : '').
                (($employee->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.html_escape($second_sub_locations[$employee->second_sub_location_id]->name) : '').
                '</td>';
            echo '<td> 
                    <a href="'. base_url(). 'employee/edit/'.$employee->id.'">
                    <button class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</button>
                    </a>
              </td>';
            echo '</tr>';
        }
        ?>
    </table>

</div>
</div>


