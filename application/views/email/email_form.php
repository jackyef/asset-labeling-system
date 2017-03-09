<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/7/2017
 * Time: 8:03 AM
 */
?>
<!DOCTYPE html>
<head>
    <title> Codeigniter email example </title>
</head>
<body>
<?php
// the action of this form
echo $this->session->flashdata('email_sent');
echo form_open(base_url().'index.php/email/send_email');
?>
<table>
    <tr>
        <td>To</td>
        <td>:</td>
        <td><input type="email" name="email_to" required /></td>
    </tr>
    <tr>
        <td>Cc</td>
        <td>:</td>
        <td><input type="email" name="email_cc" required /></td>
    </tr>
    <tr>
        <td>Bcc</td>
        <td>:</td>
        <td><input type="email" name="email_bcc" required /></td>
    </tr>
    <tr>
        <td>Subject</td>
        <td>:</td>
        <td><input type="text" name="email_subject" size="60" required /></td>
    </tr>
    <tr>
        <td>Content</td>
        <td>:</td>
        <td><textarea type="text" name="email_subject" rows="8" cols="50" required > </textarea></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>
            <input type="submit" value="Send email" />
        </td>
    </tr>
</table>


<?php
echo form_close();
?>
</body>
</html>

