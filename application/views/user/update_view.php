<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/6/2017
 * Time: 3:28 PM
 */
?>

<!DOCTYPE html>
<head>
    <title> Update user data </title>
</head>
<body>
<?php
    // the action of this form
    echo form_open('user/update');
    foreach($users as $user) {
        echo form_label('User ID Number');
        echo form_input(array('id' => 'old_user_id', 'name' => 'old_user_id', 'value' => $old_user_id, 'type'=> 'hidden', ));
        // define the id and the name of the html element
        echo form_input(array('id' => 'user_id', 'name' => 'user_id', 'value' => $user->user_id));
        echo "<br/>";

        echo form_label('Username');
        echo form_input(array('id' => 'username', 'name' => 'username', 'value' => $user->username));
        echo "<br/>";

        echo form_label('Password');
        echo form_input(array('id' => 'password', 'name' => 'password'));
        echo "<br/>";

        echo form_label('E-mail Address');
        echo form_input(array('id' => 'email', 'name' => 'email', 'value' => $user->email));
        echo "<br/>";

        echo form_submit(array('id' => 'submit', 'value' => 'Update user data'));
        break;
    }
    echo form_close();
?>
</body>
</html>
