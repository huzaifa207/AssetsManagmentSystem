<?php
include_once "common.php";
$devices = get_all_records("devices");

echo json_encode($devices);