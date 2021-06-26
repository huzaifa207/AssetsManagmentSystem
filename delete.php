<?php
  include "common.php";
  session_start();
  
  $id = $_REQUEST['id'];
  $picture_name = $_REQUEST['picture-name'];

  $con->query("DELETE FROM devices WHERE id='$id'");
  unlink('images/'.$picture_name);
?>