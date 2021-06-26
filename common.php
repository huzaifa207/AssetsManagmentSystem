<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DEFAULT_DB_NAME", "ams"); // 'ams' means Assets Management System
$con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD);
if ($con->connect_error) {
    echo ("Could not connect: ERROR NO. " . $con->connect_errno . " : " . $con->connect_error . "<br/>");
    die("Error while connecting to database. Further script processing terminated <br/>");
}
$con->select_db(DEFAULT_DB_NAME);

function get_all_records($table_name){
    global $con;
    $result_set = $con->query("select * from $table_name");
    $all_records = [];
    while ($row = $result_set ->fetch_assoc()) {
        $all_records[] = $row;
    }
    return $all_records;
}

function get_user_by_credentials($email, $password) {
    global $con;
    $result_set = $con->query("select id, full_name from users where email='$email' and password='$password'");
    if($result_set->num_rows == 1) 
        return $result_set->fetch_assoc();
    else return null;
}