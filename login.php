<?php

require("backend.php");
session_start();

if (isset($_COOKIE["user"])) {
  $u_id = $_COOKIE["user"];
  $result = $mysqli->query("SELECT * FROM session WHERE u_id = '$u_id'");
  $row = $result->fetch_assoc();
  if ($row) {
    $result2 = $mysqli->query("SELECT * FROM session INNER JOIN users ON session.u_id = users.id WHERE u_id = '$u_id'");
    $row2 = $result2->fetch_assoc();
    $_SESSION["u_name"] = $row2["uname"];
    $_SESSION["u_id"] = $row2["id"];
    $_SESSION["u_email"] = $row2["email"];
    $_SESSION["u_type"] = $row2["utype"];
  }
}

if (isset($_SESSION["u_id"])) {
  header("Location: index.php");
}

if (isset($_POST['signup'])) {

  $link = mysqli_connect("localhost", "root", "", "postan");
  if ($link === false) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $uname = $email = $pwd = $pwd2 = $pno = $address = $utype = ' ';
  $uname = $_POST['uname'];
  $email = $_POST['email'];
  $pwd = $_POST['pwd'];
  $pwd2 = $_POST['pwd2'];
  $pno = $_POST['pno'];
  $address = $_POST['address'];
  $utype = $_POST['utype'];

  if ($pwd == $pwd2) {
    $pwd = password_hash($pwd, PASSWORD_BCRYPT); //To hash password 
    $sql = mysqli_query($link, "INSERT INTO users (uname, email, pwd, pno, address, utype) VALUES ('$uname', '$email', '$pwd', '$pno', '$address', '$utype')");
    if ($sql == true) {
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
      echo "<strong>You have Registered Successfully! ✔</strong>";
      echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
      echo "<span aria-hidden='true'>&times;</span>";
      echo "</button>";
      echo "</div>";
    } else {
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
      echo "<strong>❌ Registration Failed! </strong>" . $sql . "<br>" . mysqli_error($link);
      echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
      echo "<span aria-hidden='true'>&times;</span>";
      echo "</button>";
      echo "</div>";
    }
  } else {
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
    echo "<strong>❗Passwords are not matching.</strong>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
    echo "<span aria-hidden='true'>&times;</span>";
    echo "</button>";
    echo "</div>";
  }

  mysqli_close($link);
}

if (isset($_POST['signin'])) {

  $link = mysqli_connect("localhost", "root", "", "postan");
  if ($link === false) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $logid = $logpwd = $logtype = ' ';
  $logid = $_POST['logid'];
  $logpwd = $_POST['logpwd'];
  $logtype = $_POST['logtype'];

  $sql = mysqli_query($link, "SELECT * FROM users WHERE email='$logid'");
  if ($sql->num_rows > 0) {
    $data = $sql->fetch_array();
    if (password_verify($logpwd, $data['pwd'])) {
      if ($logtype == $data['utype']) {
        $_SESSION['u_id'] = $data['id'];
        $_SESSION['u_name'] = $data['uname'];
        $_SESSION['u_email'] = $data['email'];
        $_SESSION['u_type'] = $data['utype'];
        $u_id = $data['id'];
        $result = $mysqli->query("INSERT INTO session(u_id) VALUES ($u_id)");
        header("Location: index.php");
      } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
        echo "<strong>🚫 Invalid Login </strong> Make sure you choose valid user type.";
        echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
        echo "<span aria-hidden='true'>&times;</span>";
        echo "</button>";
        echo "</div>";
      }
    } else {
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
      echo "<strong>🚫 Incorrect Password </strong> Login Failed.";
      echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
      echo "<span aria-hidden='true'>&times;</span>";
      echo "</button>";
      echo "</div>";
    }
  } else {
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
    echo "<strong>🚫 Invalid Email </strong> Login Failed.";
    echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
    echo "<span aria-hidden='true'>&times;</span>";
    echo "</button>";
    echo "</div>";
  }

  mysqli_close($link);
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Postan</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="icon" href="public/images/minilogo.png" type="image/x-icon">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/22d43b373b.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="public/js/login.js"></script>
  <link rel="stylesheet" href="public/css/login.css">
</head>

<body style="height: 60vh; background: #000;" class="mt-1 mb-3">
  <!------main container start here---->
  <div class="container-fluid h-100 ">
    <div class="row  h-100 justify-content-center align-items-center">
      <div class="col-sm">
        <br>
        <h1 class="text-center display-4 change">Post<span style="color:white;">an</span></h1>
        <img src="public/images/logo.png" width="100%">
      </div>
      <!------left end---->
      <div class="col-sm ">
        <nav class="navbar navbar-expand-sm text-center">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item register_li">
              <h4 class="nav-link change aa" href="#"><b>Register</b></h4>
            </li>
            <li class="nav-item login_li">
              <h4 class="nav-link change aa" href="#"><b>Login</b></h4>
            </li>
          </ul>
        </nav>
        <!------register start---->

        <div class="container register  text  h-100 mb-3">
          <h2 class="text-center" style="color: #fff;">Register for free!</h2>
          <form action="login.php" method="POST">
            <div class="row justify-content-center align-items-center">
              <div class="col-sm align-self-center">
                <div class="form-group ">
                  <label for="username" class="change">Username</label>
                  <input type="text" class="form-control" id="username" placeholder="Username" name="uname" required id="in-between" pattern="^[A-Z].*$" title="1st letter should be capital" autocomplete="off">
                </div>
              </div>

              <div class="col-sm">
                <div class="form-group">
                  <label for="email" class="change">Email</label>
                  <input type="email" class="form-control" id="email" placeholder="Email" name="email" required id="in-between">
                </div>
              </div>
            </div>
            <div class="row justify-content-center align-items-center">
              <div class="col-sm align-self-center">
                <div class="form-group">
                  <label for="pwd" class="change">Password</label>
                  <div class="wrapper" style="position: relative;">
                    <input type="password" class="form-control" id="pwd" placeholder="Password" name="pwd" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="1 Uppercase 1 Number 1 Symbol & minimum 6 letters required">

                    <i class="fa fa-eye-slash icon pass " id="eye" aria-hidden="true" onclick="toggle()" style=" position: absolute; right: 10px; top:10px; cursor: pointer "></i>
                  </div>
                </div>
              </div>
              <div class="col-sm align-self-center">
                <div class="form-group">
                  <label for="pwd2" class="change">Confirm Password</label>
                  <div class="wrapper" style="position: relative;">
                    <input type="password" class="form-control" id="pwd2" placeholder="Password" name="pwd2" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="1 Uppercase 1 Number 1 Symbol & minimum 6 letters required">

                    <i class="fa fa-eye-slash icon pass " id="eye3" aria-hidden="true" onclick="toggle3()" style=" position: absolute; right: 10px; top:10px; cursor: pointer "></i>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="phone" class="change">Phone No</label>
              <input type="tel" class="form-control" id="tel" placeholder="Phone Number" name="pno" required id="in-between">

            </div>
            <div class="form-group">
              <label for="add" class="change">Address</label>

              <textarea class="form-control" id="add" placeholder="Address" name="address" required title="Address can't contain quotes." id="in-between"></textarea>
            </div>

            <div class="text-center">
              <div class="form-check form-check-inline radio">
                <input class="form-check-input" type="radio" name="utype" id="inlineRadio1" value="Admin" onclick="adminkey()" required>
                <label class="form-check-label" for="inlineRadio1">Admin</label>
              </div>
              <div class="form-check form-check-inline radio">
                <input class="form-check-input" type="radio" name="utype" id="inlineRadio2" value="Delivery Boy" required>
                <label class="form-check-label" for="inlineRadio2">Delivery Boy</label>
              </div>
              <div class="form-check form-check-inline radio">
                <input class="form-check-input" type="radio" name="utype" id="inlineRadio3" value="Customer" required>
                <label class="form-check-label" for="inlineRadio3">Customer</label>
              </div>
            </div>
            <br>

            <button type="submit" class="btn btn-outline-success btn-block" name="signup" id="createAccount" value="Create Account">Submit</button>


          </form>
        </div>


        <!------register end---->

        <!------right end---->

        <!------right login start here---->
        <div class="container login text align-self-center  h-100">
          <h2 class="text-center" style="color:#fff;">Login</h2>
          <form action="#" method="POST">

            <div class="form-group align-self-center">
              <label for="email1" class="change">Email</label>
              <input type="text" class="form-control" id="email1" placeholder="Email" name="logid" required>
            </div>

            <div class="form-group">
              <label for="pwd" class="change">Password</label>
              <div class="wrapper" style="position: relative;">
                <input type="password" class="form-control" id="pwd1" placeholder="Password" name="logpwd" required>
                <i class="fa fa-eye-slash icon pass " id="eye1" aria-hidden="true" onclick="toggle1()" style=" position: absolute; right: 10px; top:10px; cursor: pointer "></i>
              </div>
            </div>

            <div class="text-center">
              <div class="form-check form-check-inline radio">
                <input class="form-check-input" type="radio" name="logtype" id="inlineRadio4" value="Admin" required>
                <label class="form-check-label" for="inlineRadio4">Admin</label>
              </div>
              <div class="form-check form-check-inline radio">
                <input class="form-check-input" type="radio" name="logtype" id="inlineRadio5" value="Delivery Boy" required>
                <label class="form-check-label" for="inlineRadio5">Delivery Boy</label>
              </div>
              <div class="form-check form-check-inline radio">
                <input class="form-check-input" type="radio" name="logtype" id="inlineRadio6" value="Customer" required>
                <label class="form-check-label" for="inlineRadio6">Customer</label>
              </div>
            </div>
            <br>

            <button type="submit" class="btn btn-outline-success btn-block" name="signin">Sign in</button>
            <br>
        </div>
        </form>
      </div>

      <!------left login start here---->
      <!------register end---->
    </div>


  </div>
  <!------main container end here---->

  </div>

</body>

</html>