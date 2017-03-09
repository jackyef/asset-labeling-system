<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/6/2017
 * Time: 3:07 PM
 */
?>

<!DOCTYPE html>
<head>
    <title> {title} </title>
    <link rel="stylesheet" href="<?= base_url() ?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>css/sidenav.css">
    <script src="<?= base_url() ?>js/jquery.js"></script>
    <script src="<?= base_url() ?>js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>js/dataTables.bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#user-table').DataTable();
        } );

        /* Set the width of the side navigation to 250px */
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
//            $("#main").css({ 'margin-left': '+=250px' });
        }

        /* Set the width of the side navigation to 0 */
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
//            $("#main").css({ 'margin-left': '-=250px' });
        }

    </script>
</head>
<body>
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="#">About</a>
    <a href="#">Services</a>
    <a href="#">Clients</a>
    <a href="#">Contact</a>
</div>

<div id="main" class="container">
    <div class="row">
        <br/>
        <button class="btn btn-default"onclick="openNav()"><span class="fa fa-bars"></span></button>
        <div class="pull-right">
            <a href="add"> <button class="btn btn-sm btn-success"><span class="fa fa-plus"></span> Add a new user</button></a>
        </div>
        <div class="clearfix"></div>

        <br/>
        <table class="table table-striped table-responsive" id="user-table">
            <thead>
                <th> Id </th>
                <th> Username </th>
                <th> Password (md5 hash) </th>
                <th> Email address </th>
                <th> Action </th>
            </thead>
            {records}
            <tr>
                <td>{user_id}</td>
                <td>{username}</td>
                <td>{password}</td>
                <td>{email}</td>
                <td><a href="edit/{user_id}"><button class="btn btn-xs btn-info"><span class="fa fa-edit"></span> Edit</button></a>
                    <a href="delete/{user_id}"><button class="btn btn-xs btn-danger"><span class="fa fa-close"></span> Delete</button></a></td>
            </tr>
            {/records}
        </table>

    </div>
</div>
</body>
</html>