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
            <li>Operating System</li>
        </ol>
    </div>
    <div class="pull-right">
        <a href="<?php echo base_url(); ?>master/os/new"><button class="btn btn-primary btn"><span class="fa fa-plus"></span> New Operating System</button> </a>
    </div>
    <div class="clearfix"></div>
    <table class="table table-striped table-responsive data-table">
        <!-- add the data-table class to tell the page to paginate this table -->
        <thead>
        <th> Id </th>
        <th> Operating System Name </th>
        <th style="min-width: 1em"> Action </th>
        </thead>
        <?php
        foreach($records as $operating_system){
            echo '<tr>';
            echo '<td>'.$operating_system->id.'</td>';
            echo '<td>'.$operating_system->name.'</td>';
            echo '<td> 
                        <a href="'. base_url(). 'master/os/edit/'.$operating_system->id.'">
                        <button class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</button>
                        </a>
                  </td>';
            echo '</tr>';
        }
        ?>
    </table>

</div>
</div>


