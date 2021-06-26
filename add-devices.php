<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php
        session_start();

        if(!isset($_SESSION['id'])) {
            header("Location: login.php" );
        }
    ?>


    <style>
      body {
        text-align: center;
      }

      .form-group {
        display: flex;
        justify-content: space-between;
        width: 25%;
        margin: auto;
        padding-bottom: 18px;
      }

      label,
      input {
        font-size: 18px;
      }
      .back{
          margin-bottom: 25px;
      }

      .back a{
          font-size: 18px;
      }
    </style>
</head>
<body>
      <?php 

        include "common.php";

        if(isset($_POST['submit'])){
            $name = $_POST['name'];
            $file_loc = $_FILES['picture']['tmp_name'];
            $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
            
            
            if (is_uploaded_file($file_loc)){
                move_uploaded_file($file_loc, 'images/'.$name.'.'.$ext);
            }

            $con->query("INSERT INTO devices (name, picture_file_name) VALUES ('$name', '$name.$ext')");

            header("Location: devices.php");
        }
      ?> 

    <h1>Add New Device</h1>
    <div class="back">
        <a href="devices.php">Back to Devices Dashboard</a>
    </div>
    <form action="add-devices.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name">Name of Device: </label>
        <input type="name" name="name" id="name" required />
      </div>

      <div class="form-group">
        <label for="picture">Picture: </label>
        <input type="file" name="picture" id="picture" required />
      </div>

      <input type="submit" value="Add Device" name="submit" />
    </form>
</body>
</html>
