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
            <li>User</li>
        </ol>
    </div>
    <div class="pull-right">
        <a href="<?php echo base_url(); ?>master/user/new"><button class="btn btn-primary"><span class="fa fa-plus"></span> New User</button> </a>
    </div>
    <div class="clearfix"></div>
    <table class="table table-striped table-responsive data-table">
        <!-- add the data-table class to tell the page to paginate this table -->
        <thead>
        <th> Id </th>
        <th> User </th>
        <th> Is admin? </th>
        <th> Action </th>
        </thead>
        <?php
        foreach($records as $user){
            echo '<tr>';
            echo '<td>'.$user->id.'</td>';
            echo '<td>'.$user->username.'</td>';
            echo '<td>'. (($user->is_admin == 1) ? 'Yes' : 'No') . '</td>';
            echo '<td> 
                        <a href="'. base_url(). 'master/user/edit/'.$user->id.'">
                        <button class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</button>
                        </a>
                  </td>';
            echo '</tr>';
        }
        ?>
    </table>

</div>


