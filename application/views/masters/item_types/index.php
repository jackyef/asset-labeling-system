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
            <li>Item Type</li>
        </ol>
    </div>
    <div class="pull-right">
        <a href="<?php echo base_url(); ?>master/item-type/new"><button class="btn btn-primary"><span class="fa fa-plus"></span> New Item Type</button> </a>
    </div>
    <div class="clearfix"></div>
    <table class="table table-striped table-responsive data-table">
        <!-- add the data-table class to tell the page to paginate this table -->
        <thead>
        <th> Id </th>
        <th> Item Type </th>
        <th> Is an assembled item? </th>
        <th style="min-width: 1em"> Action </th>
        </thead>
        <?php
        foreach($records as $item_type){
            echo '<tr>';
            echo '<td>'.$item_type->id.'</td>';
            echo '<td>'.$item_type->name.'</td>';
            echo '<td>'. (($item_type->is_assembled == 1) ? 'Yes' : 'No') . '</td>';
            echo '<td> 
                        <a href="'. base_url(). 'master/item-type/edit/'.$item_type->id.'">
                        <button class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</button>
                        </a>
                  </td>';
            echo '</tr>';
        }
        ?>
    </table>

</div>
</div>


