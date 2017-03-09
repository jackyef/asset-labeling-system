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
    <title> Add new user </title>
</head>
<body>
<?php
    // the action of this form
    echo form_open('user/insert');

    echo form_label('User ID Number');
    // define the id and the name of the html element
    echo form_input(array('id'=>'user_id','name'=>'user_id'));
    echo "<br/>";

    echo form_label('Username');
    echo form_input(array('id'=>'username','name'=>'username'));
    echo "<br/>";

    echo form_label('Password');
    echo form_input(array('id'=>'password','name'=>'password'));
    echo "<br/>";

    echo form_label('E-mail Address');
    echo form_input(array('id'=>'email','name'=>'email'));
    echo "<br/>";

    echo form_submit(array('id'=>'submit','value'=>'Add a new user'));
    echo form_close();
?>
</body>
</html>
