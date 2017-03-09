<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/6/2017
 * Time: 9:31 PM
 */
?>

<!DOCTYPE html>
<head>
    <title> Upload </title>
</head>
<body>
<h1>Example of uploading file</h1>

<?php echo $error; ?>
<?php echo form_open_multipart(base_url().'index.php/upload/do_uploading'); ?>

<form action="" method="">
    <input type="file" name="uploaded_file" size="30"/>
    <input type="submit" value="Upload!" />
</form>

<?php echo form_close() ?>
</body>
</html>