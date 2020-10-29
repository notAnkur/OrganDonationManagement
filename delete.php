<?php
  session_start();
  if(!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
  }

  $con = mysqli_connect("localhost", "root", "", "dbmsp");
  
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  $id = $_GET['id'];

  $del_sql = mysqli_query($con, "DELETE FROM donors WHERE id='".$id."'");
  mysqli_close($con);
  header("Location: admin.php");

?>
