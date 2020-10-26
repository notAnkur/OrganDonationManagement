<?php
  session_start();

  if(isset($_POST['loginBtn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $con = mysqli_connect("localhost", "root", "", "dbmsp");

    $email = stripcslashes($email);
    $password = stripcslashes($password);
    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);

    if(mysqli_connect_errno()) {
      echo "db error " . mysqli_connect_error();
      exit;
    }
    $login_sql = mysqli_query($con, "SELECT * FROM login WHERE email='$email' AND password='$password'");
    $login_row = mysqli_fetch_assoc($login_sql);

    if(mysqli_num_rows($login_sql) > 0) {
      if($login_row['email']==$email && $login_row['password']==$password) {
        $_SESSION['email'] = $email;
        header("Location: admin.php");
      } else {
        echo "Login unsuccessful";
        exit;
      }
    }

    mysqli_close($con);

  }
?>

<!DOCTYPE html>

<html>
<title>Blood Donation Management Portal</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" type="text/css" href="styles.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<body>

  <div class="bgimg w3-display-container w3-animate-opacity w3-text-white">
    <div class="w3-display-middle" style="text-align: center;">
      <h1 class="w3-jumbo w3-animate-top">Blood Donation Management Portal</h1><br>
      <hr class="w3-border-grey" style="margin:auto;width:40%"><br>
      <p class="w3-xlarge w3-center" style="margin-bottom: 0;">Built by: Team 6</p>
      <p class="w3-xlarge w3-center" style="margin-top: 0;">Ankur Anant || </p><br>
      <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#exampleModal">Login</button>
    </div>
  </div>

  <!-- Login Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Admin Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="index.php" method="post">
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input name="password" type="password" class="form-control" id="exampleInputPassword1">
          </div>
          <button type="submit" class="btn btn-primary" name="loginBtn">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
