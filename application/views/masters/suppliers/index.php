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
            <li>Supplier</li>
        </ol>
    </div>
    <div class="pull-right">
        <a href="<?php echo base_url(); ?>master/supplier/new"><button class="btn btn-primary"><span class="fa fa-plus"></span> New Supplier</button> </a>
    </div>
    <div class="clearfix"></div>
    <table class="table table-striped table-responsive data-table">
        <!-- add the data-table class to tell the page to paginate this table -->
        <thead>
        <th> Id </th>
        <th> Supplier Name </th>
        <th style="min-width: 1em"> Action </th>
        </thead>
        <?php
        foreach($records as $supplier){
            echo '<tr>';
            echo '<td>'.$supplier->id.'</td>';
            echo '<td>'.html_escape($supplier->name).'</td>';
            echo '<td> 
                        <a href="'. base_url(). 'master/supplier/edit/'.$supplier->id.'">
                        <button class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</button>
                        </a>
                  </td>';
            echo '</tr>';
        }
        ?>
    </table>

</div>
</div>


