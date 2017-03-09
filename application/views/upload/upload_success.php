<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/6/2017
 * Time: 10:03 PM
 */
?>
<html>

   <head>
      <title>Upload Form</title>
   </head>

   <body>
      <h3>Your file was successfully uploaded!</h3>

      <ul>

          <?php foreach ($upload_data as $key => $value){?>
            <li><?php echo $key;?>: <?php echo $value;?></li>
          <?php }; ?>
      </ul>

<p><?php echo anchor('upload', 'Upload Another File!'); ?></p>
</body>

</html>