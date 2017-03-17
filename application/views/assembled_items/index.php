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
            <li>Assembled Item</li>
        </ol>
    </div>
    <div class="pull-right">
        <a href="<?php echo base_url(); ?>assembled-item/new"><button class="btn btn-primary"><span class="fa fa-plus"></span> New Assembled Item</button> </a>
    </div>
    <div class="clearfix"></div>
    <table class="table table-striped table-responsive data-table">
        <!-- add the data-table class to tell the page to paginate this table -->
        <thead>
        <th> Id </th>
        <th> Item Code </th>
        <th> Item Type / Brand </th>
        <th> Product name </th>
        <th style="min-width: 6em"> Purchased on </th>
        <th> Owned by </th>
        <th> Is used? </th>
        <th> Held by </th>
        <th style="min-width: 1em"> Action </th>
        </thead>
        <?php
        foreach($records as $item){
            echo '<tr>';
            echo '<td>'.$item->id.'</td>';
            echo '<td>'.
                '<a href="'.base_url().'assembled-item/detail/'.$item->id.'">'.
                str_pad($item->item_type_id, 2, '0', STR_PAD_LEFT).''.str_pad($item->id, 5, '0', STR_PAD_LEFT).
                '</a>'.
                '</td>';
            echo '<td>'.$item->item_type_name.', '.$item->brand_name.'</td>';
            echo '<td>'.$item->product_name.'</td>';
            echo '<td>'.
                    '<i class="fa fa-calendar"></i> '.
                    date("d M Y", strtotime($item->date_of_purchase)).
                '</td>';
            echo '<td><a href="'.base_url().'company/detail/'.$item->company_id.'">'.
                $companies[$item->company_id]->name.
                '</a></td>';
            echo '<td>'.(($item->is_used == 1) ? 'Yes' : 'No' ).'</td>';
            echo '<td>'.
                '<a href="'.base_url().'employee/detail/'.$item->employee_id.'">'.
                $item->employee_name. '</a>'.
                '<br/> <i class="fa fa-building"></i> '.
                $companies[$item->employee_company_id]->name.
                '<br/> <i class="fa fa-map-marker"></i> '.
                (($item->location_id != 0) ? $locations[$item->location_id]->name : '').
                (($item->first_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.$first_sub_locations[$item->first_sub_location_id]->name : '').
                (($item->second_sub_location_id != 0) ? ' <span class="fa fa-arrow-right"></span> '.$second_sub_locations[$item->second_sub_location_id]->name : '').
                '</td>';
            echo '<td> 
                        <a href="'. base_url(). 'assembled-item/edit/'.$item->id.'">
                        <button class="btn btn-xs btn-info" ><span class="fa fa-edit"></span> Edit</button>
                        </a>
                        <a href="'. base_url(). 'assembled-item/detail/'.$item->id.'">
                        <button class="btn btn-xs btn-warning" ><span class="fa fa-external-link"></span> View</button>
                        </a>
                        <a href="'. base_url(). 'assembled-item/mutate/'.$item->id.'">
                        <button class="btn btn-xs btn-primary" ><span class="fa fa-refresh"></span> Mutate</button>
                        </a>
                  </td>';
            echo '</tr>';
        }
        ?>
    </table>

</div>
</div>


