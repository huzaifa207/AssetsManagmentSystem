<?php 

    include "common.php";

    session_start();

    if(isset($_GET['uid']) && isset($_GET['did'])){
        $uid = $_GET['uid'];
        $dev_id = $_GET['did'];

        $result = $con->query("UPDATE devices SET received_by='$uid', issued_to=NULL, issued_by=NUll where id='$dev_id'");

        header("Location: devices.php");
    }