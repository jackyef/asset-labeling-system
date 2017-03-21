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
            <li>First Sub Locations</li>
        </ol>
    </div>
    <div class="pull-right">
        <a href="<?php echo base_url(); ?>master/fsub-location/new"><button class="btn btn-primary"><span class="fa fa-plus"></span> New First Sub Location</button> </a>
    </div>
    <div class="clearfix"></div>
    <table class="table table-striped table-responsive data-table">
        <!-- add the data-table class to tell the page to paginate this table -->
        <thead>
        <th> Id </th>
        <th> Sub Location (Lv. 1)</th>
        <th> Parent Location </th>
        <th style="min-width: 1em"> Action </th>
        </thead>
        <?php
        foreach($records as $first_sub_loc){
            echo '<tr>';
            echo '<td>'.$first_sub_loc->id.'</td>';
            echo '<td>'.html_escape($first_sub_loc->name).'</td>';
            echo '<td>'.html_escape($first_sub_loc->location_name).'</td>';
            echo '<td> 
                        <a href="'. base_url(). 'master/fsub-location/edit/'.$first_sub_loc->id.'">
                        <button class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</button>
                        </a>
                  </td>';
            echo '</tr>';
        }
        ?>
    </table>

</div>
</div>


