<?php
include_once "common.php";
$users = get_all_records("users");
echo json_encode($users);