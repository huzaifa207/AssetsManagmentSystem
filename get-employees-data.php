<?php
include_once "common.php";
$employees = get_all_records("employees");
for($i=0; $i<count($employees); $i++){
    $devices = array();
    $devices_result_set = $con->query("select id, name from devices where issued_to=" . $employees[$i]['id']);
    while($device = $devices_result_set->fetch_assoc()) {
        $devices[] = array("id"=>$device["id"], "name"=>$device["name"]);        
    }
    $employees[$i]["has_devices"] = $devices;
}
echo json_encode($employees);