<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:26 AM
 */
?>

<div class="row">
    <div class="pull-left">
        <ol class="breadcrumb">
            <li><a href="<?= base_url()?>">Home</a></li>
            <li>Masters</li>
            <li>Mutation Status</li>
        </ol>
    </div>
    <div class="pull-right">
        <a href="<?php echo base_url(); ?>master/mutation-status/new"><button class="btn btn-primary"><span class="fa fa-plus"></span> New Mutation Status</button> </a>
    </div>
    <div class="clearfix"></div>
    <table class="table table-striped table-responsive data-table">
        <!-- add the data-table class to tell the page to paginate this table -->
        <thead>
        <th> Id </th>
        <th> Mutation Status </th>
        <th> Action </th>
        </thead>
        <?php
        foreach($records as $mutation_status){
            echo '<tr>';
            echo '<td>'.$mutation_status->id.'</td>';
            echo '<td>'.$mutation_status->name.'</td>';
            echo '<td> 
                        <a href="'. base_url(). 'master/mutation-status/edit/'.$mutation_status->id.'">
                        <button class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</button>
                        </a>
                  </td>';
            echo '</tr>';
        }
        ?>
    </table>

</div>


