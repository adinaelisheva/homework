<?php
  include("common.php"); 
  if (!isset($_GET["id"])) {
    die('id needs to be set');
  }
  $id = $_GET["id"];
  $query = "UPDATE items SET done = NULL WHERE id = '$id';";
  echo($query);
  mysqli_query($con,$query) or die(mysqli_error($con));
  echo "Success";
  
?>