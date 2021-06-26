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
            $id = $_POST['id'];
            $name = $_POST['name'];
            $file_loc = $_FILES['picture']['tmp_name'];
            $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
            
            
            if (is_uploaded_file($file_loc)){
                $old_picture_name = $_POST['old-name'];
                move_uploaded_file($file_loc, 'images/'.$name.'.'.$ext);
                $con->query("UPDATE devices SET name='$name', picture_file_name='$name.$ext' WHERE id='$id'");
                unlink($old_picture_name);
            }else {
                $con->query("UPDATE devices SET name='$name' WHERE id='$id'");
            }

            

            header("Location: devices.php");

        }else if(isset($_GET['id'])){
            $id = $_GET['id'];

            $result = $con->query("SELECT name, picture_file_name FROM devices WHERE id='$id'");
            if($result->num_rows == 1){
                $data = $result->fetch_assoc();

                $name = $data['name'];
                $picture_file_name = $data['picture_file_name'];

            }
        }
      ?> 

    <h1>Update Device</h1>
    <div class="back">
        <a href="devices.php">Back to Devices Dashboard</a>
    </div>
    <form action="update.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value='<?=$id?>'>
        <input type="hidden" name="old-name" value='<?php echo $picture_file_name?>'>
      <div class="form-group">
        <label for="name">Name of Device: </label>
        <input type="text" name="name" id="name" value='<?php echo $name?>'/>
      </div>

      <div>
          <?php 
            if (isset($picture_file_name)){
        ?>
            <h3>Old Image</h3>
          <img src='images/<?php echo $picture_file_name ?>' alt="image here" height=250/>
          <h4>Enter new image if you want to update file</h4>
          <?php }else { ?>

            <h4>Enter image</h4>              
          <?php } ?>


      </div>

      <div class="form-group">
        <label for="picture">Picture: </label>
        <input type="file" name="picture" id="picture" />
      </div>

      <input type="submit" value="Update Device" name="submit" />
    </form>
</body>
</html>
