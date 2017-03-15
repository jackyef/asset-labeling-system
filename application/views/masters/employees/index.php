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
            <li>Masters</li>
            <li>Employee</li>
        </ol>
    </div>
    <div class="pull-right">
        <a href="<?php echo base_url(); ?>master/employee/new"><button class="btn btn-primary"><span class="fa fa-plus"></span> New Employee</button> </a>
    </div>
    <div class="clearfix"></div>
    <table class="table table-striped table-responsive data-table">
        <!-- add the data-table class to tell the page to paginate this table -->
        <thead>
        <th> Id </th>
        <th> Employee Name </th>
        <th> Company </th>
        <th> Is working? </th>
        <th> Current Location </th>
        <th> Action </th>
        </thead>
        <?php
        foreach($records as $employee){
            echo '<tr>';
            echo '<td>'.$employee->id.'</td>';
            echo '<td>'.$employee->name.'</td>';
            echo '<td>'.$employee->company_name.'</td>';
            echo '<td>'.(($employee->is_working == 1) ? 'Yes' : 'No') .'</td>';
            echo '<td>'.
                (($employee->location_id != 0) ? $locations[$employee->location_id]->name : '').
                (($employee->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.$first_sub_locations[$employee->first_sub_location_id]->name : '').
                (($employee->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.$second_sub_locations[$employee->second_sub_location_id]->name : '').
                '</td>';
            echo '<td> 
                        <a href="'. base_url(). 'master/employee/edit/'.$employee->id.'">
                        <button class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</button>
                        </a>
                  </td>';
            echo '</tr>';
        }
        ?>
    </table>

</div>
</div>


