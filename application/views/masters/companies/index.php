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
            <li>Company</li>
        </ol>
    </div>
    <div class="pull-right">
        <a href="<?php echo base_url(); ?>master/company/new"><button class="btn btn-primary"><span class="fa fa-plus"></span> New Company</button> </a>
    </div>
    <div class="clearfix"></div>
    <table class="table table-striped table-responsive data-table">
        <!-- add the data-table class to tell the page to paginate this table -->
        <thead>
        <th> Id </th>
        <th> Company Name </th>
        <th style="min-width: 1em"> Action </th>
        </thead>
        <?php
        foreach($records as $company){
            echo '<tr>';
            echo '<td>'.$company->id.'</td>';
            echo '<td><a href="'.base_url().'company/detail/'.$company->id.'">'.html_escape($company->name).'</a></td>';
            echo '<td> 
                        <a href="'. base_url(). 'master/company/edit/'.$company->id.'">
                        <button class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</button>
                        </a>
                  </td>';
            echo '</tr>';
        }
        ?>
    </table>

</div>
</div>


