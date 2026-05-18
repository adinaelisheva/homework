<?php
  include("common.php"); 
  if (!isset($_GET["id"])) {
    die('id needs to be set');
  }
  $id = $_GET["id"];
  $date = time();
  $datestr = date("Y-m-d", $date);

  $query = "UPDATE items SET done = '$datestr' WHERE id = '$id';";
  echo($query);
  mysqli_query($con,$query) or die(mysqli_error($con));
  echo "Success";
  
?>