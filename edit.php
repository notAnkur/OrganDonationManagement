<?php
  session_start();
  if(!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
  }

  $id = $_GET['id'];

  $con = mysqli_connect("localhost", "root", "", "dbmsp");

  if(mysqli_connect_errno()) {
    echo "Error connecting to MySQL " . mysqli_connect_error();
  }

  $search_id_sql = mysqli_query($con, "SELECT * FROM donors WHERE id=$id");
  if(mysqli_num_rows($search_id_sql) > 0) {
    $row = mysqli_fetch_assoc($search_id_sql);
    $name = $row['donor_name'];
    $age = $row['age'];
    $gender = $row['gender'];
    $blood_type = $row['blood_type'];
    $previous_history = $row['previous_history'];
    $last_donation_date = $row['last_donation_date'];
    $contact = $row['contact'];
  }

  if(isset($_POST['editBtn'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $blood_type = $_POST['blood_type'];
    $previous_history = $_POST['previous_history'];
    $last_donation_date = $_POST['last_donation_date'];
    $contact = $_POST['contact'];

    //adjust date format
    $newLastDonationDate = date("Y-m-d", strtotime($last_donation_date));

    $edit_sql = "UPDATE donors SET donor_name='$name', age='$age', gender='$gender', blood_type='$blood_type', previous_history='$previous_history', last_donation_date='$newLastDonationDate', contact='$contact' WHERE id='$id'";

    if(mysqli_query($con, $edit_sql)) {
      echo '<script type="text/javascript">';
      echo "alert('Updated record for $name');";
      echo 'window.location.href = "admin.php";';
      echo '</script>';
    } else {
      echo "not done" . mysqli_error($con);
    }

  }

  mysqli_close($con);

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Donation Admin Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-light bg-light">
      <a href="admin.php" class="navbar-brand">Donation Admin</a>
      <form class="form-inline" action="admin.php" method="post">
        <p class="my-2 my-sm-0 mr-4">Logged in as <?= $_SESSION['email'] ?></p>
        <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="logoutBtn">Logout</button>
      </form>
    </nav>

    <div class="container my-5" style="max-width: 500px;">
      <form method="post">
        <h4 style="text-align: center;" class="mb-4">Edit Details</h4><hr>
        <div class="form-group">
          <label for="inputId">ID</label>
          <input name="id" type="text" class="form-control" value=<?= $id ?> id="inputId" aria-describedby="id" readonly>
        </div>
        <div class="form-group">
          <label for="inputName">Name</label>
          <input name="name" type="text" class="form-control" value=<?= $name ?> id="inputName" aria-describedby="nameHelp">
        </div>
        <div class="form-group">
          <label for="inputAge">Age</label>
          <input name="age" type="number" class="form-control" value=<?= $age ?> id="inputAge" aria-describedby="ageHelp">
        </div>
        <div class="form-group">
          <label for="inputGender">Gender</label>
          <input name="gender" type="text" class="form-control" value=<?= $gender ?> id="inputGender" aria-describedby="genderHelp">
        </div>
        <div class="form-group">
          <label for="inputBType">Blood Type</label>
          <input name="blood_type" type="text" class="form-control" value=<?= $blood_type ?> id="inputBType" aria-describedby="bloodtypeHelp">
        </div>
        <div class="form-group">
          <label for="inputPrevHistory">Previous History</label>
          <input name="previous_history" type="text" class="form-control" value=<?= $previous_history ?> id="inputPrevHistory" aria-describedby="previous_history_Help">
        </div>
        <div class="form-group">
          <label for="inputLastDonation">Last Donation Date</label>
          <input name="last_donation_date" type="date" class="form-control" value=<?= $last_donation_date ?> id="inputLastDonation" aria-describedby="LastDonationHelp">
        </div>
        <div class="form-group">
          <label for="inputContact">Contact</label>
          <input name="contact" type="number" class="form-control" value=<?= $contact ?> id="inputContact" aria-describedby="contactHelp">
        </div>
        <button type="submit" class="btn btn-primary" name="editBtn">Edit Donor Details</button>
      </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

  </body>
</html>
