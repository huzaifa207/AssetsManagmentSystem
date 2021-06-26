<?php 

    include "common.php";

    $e_id = $_GET['e_id'];
    $d_id = $_GET['d_id'];
    $u_id = $_GET['u_id'];
    
    
    $result = $con->query("SELECT devices_limit FROM employees WHERE id='$e_id'");
    $result = $result->fetch_assoc();
    $limit = $result['devices_limit'];
    
    $result = $con->query("SELECT COUNT(*) AS devices_count FROM devices WHERE issued_to='$e_id'");
    $result = $result->fetch_assoc();
    $devices = $result['devices_count'];
    


    if(isset($e_id) && isset($d_id) && isset($u_id)){
        if ($devices < $limit){
            $con->query("UPDATE devices SET issued_to='$e_id', issued_by='$u_id', received_by=NULL WHERE id='$d_id'");
            header("Location: devices.php" );
        }else{
            header("Location: devices.php?msg=err");
            
        }
    }
