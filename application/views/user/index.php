<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/6/2017
 * Time: 3:07 PM
 */
?>


<a href="<?php echo base_url(); ?>index.php/user/new"> Add a new user </a>
<br/><br/>
<table border = "0">
    <tr>
        <th> Id </th>
        <th> Username </th>
        <th> Password (md5 hash) </th>
        <th> Email address </th>
        <th> Action </th>
    </tr>
    <?php
        foreach($users as $user){
            echo '<tr>';
            echo '<td>'.$user->user_id.'</td>';
            echo '<td>'.$user->username.'</td>';
            echo '<td>'.$user->password.'</td>';
            echo '<td>'.$user->email.'</td>';
            echo '<td> 
                        <a href="'. base_url(). 'index.php/user/edit/'.$user->user_id.'">Edit</a>
                        |
                        <a href="'. base_url(). 'index.php/user/delete/'.$user->user_id.'">Delete</a>
                  </td>';
            echo '</tr>';
        }
    ?>
</table>

