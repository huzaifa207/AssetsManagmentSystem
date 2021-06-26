<?php 

    include "common.php";

    $id = $_REQUEST['id'];

    function get_name($id){
        global $con;

        $result_set = $con->query("select name from employees where id=".$id);
        if($result_set->num_rows == 1) 
            return json_encode($result_set->fetch_assoc());
        else return null;
    }