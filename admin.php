<?php
  session_start();
  if(!isset($_SESSION['email'])) {
    echo "Not authorized to access this page";
    exit;
  }

  $con = mysqli_connect("localhost", "root", "", "dbmsp");

  if(isset($_POST['logoutBtn'])) {
    session_destroy();
    header("Location: index.php");
  }

  if(isset($_GET['searchBtn'])) {
    $searchText = $_GET['searchbar'];
    $searchText = stripcslashes($searchText);
    $searchText = mysqli_real_escape_string($con, $searchText);
    header("Location: admin.php?name=$searchText");
  }

  $name_filter = "";
  if(!isset($_GET['name'])) $name_filter = "";
  else $name_filter = $_GET['name'];

  if(isset($_POST['addDonorBtn'])) {
    $name = $_POST['add_name'];
    $age = $_POST['add_age'];
    $gender = $_POST['add_gender'];
    $blood_type = $_POST['add_blood_type'];
    $previous_history = $_POST['add_previous_history'];
    $last_donation_date = $_POST['add_last_donation_date'];
    $contact = $_POST['add_contact'];

    $newLastDonationDate = date("Y-m-d", strtotime($last_donation_date));
    $add_donor_sql = "INSERT INTO donors VALUES(0, '$name', '$age', '$gender', '$blood_type', '$previous_history', '$newLastDonationDate', '$contact')";
    if(mysqli_query($con, $add_donor_sql)) {
      // echo("<script>alert('$name added to donors list');</script>");
      echo '<script type="text/javascript">';
      echo "alert('$name added to Donors list');";
      echo 'window.location.href = "admin.php";';
      echo '</script>';
    }
  }


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

    <div class="form-inline d-flex justify-content-center mt-5">
      <form action="admin.php" method="get">
        <input class="form-control mr-sm-2" type="search" name="searchbar" placeholder="Search by name" aria-label="Search">
        <button class="btn btn-outline-info mr-1" type="submit" name="searchBtn">Search Donor</button>
      </form>
      <a class="btn btn-outline-warning" type="submit" href="admin.php?name=">Clear Filter</a>
    </div>
    <div class="form-inline d-flex justify-content-center mt-2">
      <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModalLong">
        Add New Donor
      </button>
    </div>

    <div class="mt-4 px-2">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">Name</th>
            <th scope="col">Age</th>
            <th scope="col">Gender</th>
            <th scope="col">BloodType</th>
            <th scope="col">PreviousHistory</th>
            <th scope="col">Last Donation</th>
            <th scope="col">Contact</th>
            <th scope="col">Manage</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $all_sql = mysqli_query($con, "SELECT * FROM donors WHERE donor_name LIKE '%$name_filter%'");

            if(mysqli_num_rows($all_sql) > 0) {
              while($row = mysqli_fetch_assoc($all_sql)) {
                echo "
                <tr>
                  <th scope='row'>".$row["id"]."</th>
                  <td>".$row["donor_name"]."</td>
                  <td>".$row["age"]."</td>
                  <td>".$row["gender"]."</td>
                  <td>".$row["blood_type"]."</td>
                  <td>".$row["previous_history"]."</td>
                  <td>".$row["last_donation_date"]."</td>
                  <td>".$row["contact"]."</td>
                  <td>
                    <a class='btn btn-warning btn-sm' href=\"edit.php?id=".$row['id']."\">
                    <svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-pencil-square' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                      <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                      <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
                    </svg>
                    </a>
                    <a class='btn btn-danger btn-sm' href=\"delete.php?id=".$row['id']."\">
                    <svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-trash-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                      <path fill-rule='evenodd' d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z'/>
                    </svg>
                    </a>
                  </td>
                </tr>
                ";
              }
            } else {
              echo "<th scope='row' style='color: red;'>No data available</th>";
            }
          ?>
        </tbody>
      </table>

      <!-- Add Donor modal -->
      <!-- Modal -->
      <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post">
                <h4 style="text-align: center;" class="mb-4">Edit Details</h4><hr>
                <div class="form-group">
                  <label for="inputId">ID</label>
                  <input name="add_id" type="text" class="form-control" id="inputId" value="ID will be Auto Incremented" aria-describedby="id" readonly>
                </div>
                <div class="form-group">
                  <label for="inputName">Name</label>
                  <input name="add_name" type="text" class="form-control" id="inputName" aria-describedby="nameHelp">
                </div>
                <div class="form-group">
                  <label for="inputAge">Age</label>
                  <input name="add_age" type="number" class="form-control" id="inputAge" aria-describedby="ageHelp">
                </div>
                <div class="form-group">
                  <label for="inputGender">Gender</label>
                  <input name="add_gender" type="text" class="form-control" id="inputGender" aria-describedby="genderHelp">
                </div>
                <div class="form-group">
                  <label for="inputBType">Blood Type</label>
                  <input name="add_blood_type" type="text" class="form-control" id="inputBType" aria-describedby="bloodtypeHelp">
                </div>
                <div class="form-group">
                  <label for="inputPrevHistory">Previous History</label>
                  <input name="add_previous_history" type="text" class="form-control" id="inputPrevHistory" aria-describedby="previous_history_Help">
                </div>
                <div class="form-group">
                  <label for="inputLastDonation">Last Donation Date</label>
                  <input name="add_last_donation_date" type="date" class="form-control" id="inputLastDonation" aria-describedby="LastDonationHelp">
                </div>
                <div class="form-group">
                  <label for="inputContact">Contact</label>
                  <input name="add_contact" type="number" class="form-control" id="inputContact" aria-describedby="contactHelp">
                </div>
                <button type="submit" name="addDonorBtn" class="btn btn-primary">Add donor</button>
              </form>
            </div>
          </div>
        </div>
      </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

  </body>
</html>
