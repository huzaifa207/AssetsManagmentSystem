<?php
    include "common.php";

    if (isset($_POST['submit'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $data = get_user_by_credentials($email, $password);
        
        if($data) {
            session_start();

            $_SESSION['id'] = $data['id'];
            $_SESSION['name'] = $data['full_name'];

            header("Location: index.php");

        }else{
            header("Location: login.html");
        }

    }