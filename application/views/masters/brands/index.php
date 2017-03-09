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
            <li>Brand</li>
        </ol>
    </div>
    <div class="pull-right">
        <a href="<?php echo base_url(); ?>master/brand/new"><button class="btn btn-primary"><span class="fa fa-plus"></span> New Brand</button> </a>
    </div>
    <div class="clearfix"></div>
    <table class="table table-striped table-responsive data-table">
        <!-- add the data-table class to tell the page to paginate this table -->
        <thead>
        <th> Id </th>
        <th> Brand </th>
        <th> Item type </th>
        <th> Action </th>
        </thead>
        <?php
        foreach($records as $brand){
            echo '<tr>';
            echo '<td>'.$brand->id.'</td>';
            echo '<td>'.$brand->name.'</td>';
            echo '<td>'.$brand->item_type_name.'</td>';
            echo '<td> 
                        <a href="'. base_url(). 'master/brand/edit/'.$brand->id.'">
                        <button class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</button>
                        </a>
                  </td>';
            echo '</tr>';
        }
        ?>
    </table>

</div>


