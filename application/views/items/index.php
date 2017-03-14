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
            <li>Item</li>
        </ol>
    </div>
    <div class="pull-right">
        <a href="<?php echo base_url(); ?>item/new"><button class="btn btn-primary"><span class="fa fa-plus"></span> New Item</button> </a>
    </div>
    <div class="clearfix"></div>
    <table class="table table-striped table-responsive data-table">
        <!-- add the data-table class to tell the page to paginate this table -->
        <thead>
        <th> Id </th>
        <th> Item Code </th>
        <th> Item Type / Brand </th>
        <th> Model </th>
        <th> Purchased on </th>
        <th> Owned by </th>
        <th> Is used? </th>
        <th> Held by </th>
        <th> Action </th>
        </thead>
        <?php
        foreach($records as $item){
            echo '<tr>';
            echo '<td>'.$item->id.'</td>';
            echo '<td>'.str_pad($item->item_type_id, 3, '0', STR_PAD_LEFT).'-'.str_pad($item->id, 5, '0', STR_PAD_LEFT).'</td>';
            echo '<td>'.$item->item_type_name.', '.$item->brand_name.'</td>';
            echo '<td>'.$item->model_name.'</td>';
            echo '<td>'.
                    '<i class="fa fa-calendar"></i> '.
                    $item->date_of_purchase.
                '</td>';
            echo '<td>'.$companies[$item->company_id]->name.'</td>';
            echo '<td>'.(($item->is_used == 1) ? 'Yes' : 'No' ).'</td>';
            echo '<td>'.$item->employee_name. ' <br/> <i class="fa fa-map-marker"></i> '.
                (($item->location_id != 0) ? $locations[$item->location_id]->name : '').
                (($item->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.$first_sub_locations[$item->first_sub_location_id]->name : '').
                (($item->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.$second_sub_locations[$item->second_sub_location_id]->name : '').
                '</td>';
            echo '<td> 
                        <a href="'. base_url(). 'item/edit/'.$item->id.'">
                        <button class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</button>
                        </a>
                  </td>';
            echo '</tr>';
        }
        ?>
    </table>

</div>


