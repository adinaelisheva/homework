<?php
  include("common.php"); 
  if (!isset($_GET["name"])) {
    die("No name set");
  }
  $name = mysqli_real_escape_string($con, $_GET["name"]);

  if (!isset($_GET["subject"])) {
    die("No subject set");
  }
  $subject = mysqli_real_escape_string($con, $_GET["subject"]);

  $hasDueDate = isset($_GET["due"]);
  $isDaily = $hasDueDate ? 0 : 1;
  $dueDate = mysqli_real_escape_string($con, $_GET["due"]);

  if ($hasDueDate) {
    $query = "INSERT INTO items (name, subject, due) VALUES ('$name','$subject', '$dueDate');";
  } else {
    $query = "INSERT INTO items (name, subject, daily) VALUES ('$name','$subject', 1);";
  }
  echo($query);
  mysqli_query($con,$query) or die(mysqli_error($con));
  echo "Success";
  
?>