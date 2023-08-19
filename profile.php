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

if (!$_SESSION["u_id"]) {
    header("Location: login.php");
}

$link = mysqli_connect("localhost", "root", "", "postan");
if ($link === false) {
    die("Connection failed: " . mysqli_connect_error());
}

$u_name = $_SESSION['u_name'];
$u_id = $_SESSION["u_id"];
$u_email = $_SESSION["u_email"];
$u_type = $_SESSION["u_type"];
$msg = '';
$success = $error = "";

if (isset($_GET["view_id"])) {
    $view_id = $_GET["view_id"];
}

if (isset($_POST['updateinfo'])) {
    $email = $_POST['email'];
    $address = $_POST['address'];
    $pno = $_POST['pno'];
    if (isset($_GET["view_id"])) {
        $info = mysqli_query($link, "UPDATE users SET email='$email',address='$address',pno ='$pno' WHERE id='$view_id'");
    } else {
        $info = mysqli_query($link, "UPDATE users SET email='$email',address='$address',pno ='$pno' WHERE id='$u_id'");
    }
    if (mysqli_error($link) == true) {
        $msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>❌ Updation Failed!</strong> Email id already exist or check the input properly.
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
    </button>
    </div>";
    } else {
        $msg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>✔ Record Updated Successfully!</strong>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button>
        </div>";
    }
}

if (isset($_POST["upload_dp"])) {
    if (($_FILES["dp"]["size"] / 1024) < 64) {
        $dp = addslashes(file_get_contents($_FILES["dp"]["tmp_name"]));
        if (isset($_GET["view_id"])) {
            $result = $mysqli->query("UPDATE users SET dp = '$dp' WHERE id = '$view_id'");
        } else {
            $result = $mysqli->query("UPDATE users SET dp = '$dp' WHERE id = '$u_id'");
        }
        if ($result) {
            $success = "dp updated successfully!";
        } else {
            $error = "some error occured try again!";
        }
    } else {
        $error = "The image size should be less than 64kb!";
    }
}

if (isset($_GET["view_id"])) {
    $record = mysqli_query($link, "SELECT * FROM users WHERE id = '$view_id'");
} else {
    $record = mysqli_query($link, "SELECT * FROM users WHERE id = '$u_id'");
}

foreach ($record as $row) {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src="https://kit.fontawesome.com/22d43b373b.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="public/js/profile.js"></script>
        <script type="text/javascript" src="public/js/ajax.js"></script>
        <link rel="icon" href="public/images/minilogo.png" type="image/x-icon">
        <link rel="stylesheet" href="public/css/profile.css">
        <link rel="stylesheet" href="public/css/chatbot.css">
        <script type="text/javascript" src="public/js/chatbot.js"></script>
    </head>

    <title>Postan | <?php echo $u_name; ?></title>

    <body>

        <!-- navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top" style="background-color: black !important; border-bottom:3px solid #ffcc00;">
            <img src="public/images/logo.PNG" alt="company logo" height="40px"><span><a class="nav-link" href="index.php" style="font-family: Century Gothic; font-size: 25px; color: #ffcc00">Postan<span class="sr-only">(current)</span></a>
            </span>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" id="link" href="index.php">Home</a>
                    </li>

                    <?php if ($u_type == "Customer") { ?>
                        <li class="nav-item">
                            <a class="nav-link" id="link" href="courier.php">Courier</a>
                        </li>
                    <?php } ?>

                    <li class="nav-item">
                        <a class="nav-link" id="link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="link" href="aboutus.php">About Us</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="profile.php" id="link" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class='fas fa-user-circle'></i> <?php echo $u_name; ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: black">
                            <a class="dropdown-item text-light" href="profile.php">Profile page</a>
                            <a class="dropdown-item text-light" href="history.php">History</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-light" href="logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0 dropdown">
                    <input class="form-control mr-sm-2" id="search_text" type="search" placeholder="Search Courier" aria-label="Search">
                    <div class="dropdown-content" id="result"></div>
                </form>
            </div>
        </nav>

        <div class="container">

            <h1 style="margin-top: 30px;"><kbd style="color: #ffcc00; background-color:black; font-family: Century Gothic; border-radius: 10px;">Hello</kbd> <?php echo $row['utype']; ?></h1>

            <div class="container" style="margin-top: 25px; margin-bottom: 50px;">

                <?php if ($success) { ?>
                    <div class="alert alert-success alert-dismissible font-weight-bold fade show mb-3" role="alert">
                        <?php
                        echo $success;
                        ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } elseif ($error) { ?>
                    <div class="alert alert-danger alert-dismissible font-weight-bold fade show mb-3" role="alert">
                        <?php
                        echo $error;
                        ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>

                <?php echo $msg; ?>
                <div class="row no-gutters jumbotron">
                    <div class="col-md-4" style="max-width: 300px; max-height: 300px;">
                        <?php if ($row["dp"]) {
                            echo "<center><img src='data:image/jpeg;base64," . base64_encode($row["dp"]) . "' alt='User dp' id='pic' class='card-img fas fa-user pcard'></center>";
                        } else { ?>
                            <center><img src="public/images/avatar.jpg" id="pic" class='card-img fas fa-user pcard'></img></center>
                        <?php } ?>

                        <?php if ($u_id == $row["id"]) { ?>
                            <a href="#" id="edit" onclick="openForm1()" style="overflow: hidden; position:absolute; bottom: 0px;right: 0px;" title="Upload dp"><i class='material-icons' id="ch">add_circle</i></a>
                        <?php } ?>

                        <div class="form-group form-popup-dp" id="updatedp">
                            <form action="" method="POST" class="form-container-dp" enctype="multipart/form-data">
                                <label for="dp">
                                    <h5 style="border-bottom: 1px solid #ffcc00; color: white;">Profile Picture:</h5>
                                </label><br>
                                <input type="file" name="dp" class="form-control-file" id="dp" required><br>
                                <input type="submit" name="upload_dp" class="btn btn-sm btn-primary" value="Update" id="dpbtn">
                                <input type="button" class="btn btn-sm btn-danger cancel" value="Cancel" onclick="closeForm1()">
                            </form>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card-body">
                            <h1 class="display-4" style="color: black;"><?php echo $row["uname"]; ?></h1>

                            <?php if ($u_id == $row["id"]) { ?>
                                <a href="#" onclick="openForm2()" style="overflow: hidden; position: absolute; top: 10px;right: 0px;" title="Edit"><i class='fa fa-cog' id="ch"></i></a>
                            <?php } ?>

                            <div class="form-group form-popup-info" id="updateinfo">
                                <form action="" method="POST" class="form-container-info">
                                    <label for="exampleFormControlFile1">
                                        <h5 style="border-bottom: 1px solid #ffcc00; color: white;">Edit your Profile Information here.</h5>
                                    </label><br>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" value="<?php echo $row['email']; ?>" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off">
                                        <small id="emailHelp" class="form-text text-muted">Email id will update only if it's unique.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="add" class="change">Address</label>
                                        <textarea class="form-control" id="add" placeholder="Address" name="address" required id="in-between"><?php echo $row['address']; ?></textarea>
                                        <small id="emailHelp" class="form-text text-muted">Address can't contain quotes.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="change">Phone No</label>
                                        <input type="tel" value="<?php echo $row['pno']; ?>" class="form-control" id="tel" placeholder="Phone Number" name="pno" required id="in-between">
                                    </div>
                                    <input type="submit" class="btn btn-sm btn-primary" name="updateinfo" value="Update">
                                    <input type="button" class="btn btn-sm btn-danger cancel" value="Cancel" onclick="closeForm2()">
                                </form>
                            </div>
                            <p class="lead"><?php echo $row['address']; ?></p>
                            <hr class="my-4">
                            <p>Email: <?php echo $row['email']; ?><br>Phone No: <?php echo $row['pno'];
                                                                            } ?></p>
                            <p class="card-text"><small class="text-muted">To view Profile picture Hover over avtar.</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer -->
        <footer class="page-footer font-small" style="background-color: black; border-top: 2px solid #ffcc00;">
            <div class="container">
                <div class="row text-center d-flex justify-content-center pt-5 mb-3">
                    <div class="col-md-2 mb-3">
                        <h6 class="text-uppercase font-weight-bold">
                            <a href="index.php" id="primarycolor">Home</a>
                        </h6>
                    </div>

                    <?php if ($u_type == "Customer") { ?>
                        <div class="col-md-2 mb-3">
                            <h6 class="text-uppercase font-weight-bold">
                                <a href="courier.php" id="primarycolor">Courier</a>
                            </h6>
                        </div>
                    <?php } ?>

                    <div class="col-md-2 mb-3">
                        <h6 class="text-uppercase font-weight-bold">
                            <a href="dashboard.php" id="primarycolor">Dashboard</a>
                        </h6>
                    </div>
                    <div class="col-md-2 mb-3">
                        <h6 class="text-uppercase font-weight-bold">
                            <a href="aboutus.php" id="primarycolor">About Us</a>
                        </h6>
                    </div>
                    <div class="col-md-2 mb-3">
                        <h6 class="text-uppercase font-weight-bold">
                            <a href="profile.php" id="primarycolor">Profile</a>
                        </h6>
                    </div>
                </div>

                <hr class="rgba-white-light bg-light" style="margin: 0 15%;">

                <div class="row d-flex text-center justify-content-center mb-md-0 mb-4">
                    <div class="col-md-8 col-12 mt-5 text-light">
                        <p style="line-height: 1.7rem; text-align: justify;"> Postan is a courier management service used
                            by multiple courier companies, we provide
                            secure and
                            reliable online services, so that company can operate smoothly. Place your courier now! and leave the rest to us.
                            what are you waiting for? we provide the best
                            services
                            and the best prices, let our delivery boy take care of packaging and delivering courier safely!
                        </p>
                    </div>
                </div>

                <hr class="clearfix d-md-none rgba-white-light" style="margin: 10% 15% 5%;">

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-2 flex-center text-center text-light">

                            <a href="" class="text-decoration-none">
                                <i class="fab fa-facebook-f fa-lg  mr-4 text" id="socialicon"> </i>
                            </a>
                            <a href="" class="text-decoration-none">
                                <i class="fab fa-twitter fa-lg mr-4" id="socialicon"> </i>
                            </a>
                            <a href="" class="text-decoration-none">
                                <i class="fab fa-google-plus-g fa-lg mr-4" id="socialicon"> </i>
                            </a>
                            <a href="" class="text-decoration-none">
                                <i class="fab fa-linkedin-in fa-lg mr-4" id="socialicon"> </i>
                            </a>
                            <a href="" class="text-decoration-none">
                                <i class="fab fa-instagram fa-lg mr-4" id="socialicon"> </i>
                            </a>
                            <a href="" class="text-decoration-none">
                                <i class="fab fa-pinterest fa-lg mr-4" id="socialicon"> </i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="footer-copyright text-center py-3 text-light">
                © 2020 Copyright:
                <a href="index.php">Postan.com</a>
            </div>

        </footer>

        <div>
            <a href="#" onclick="openForm()" style="box-shadow: 0px 8px 16px 0px rgba(0,0,0,1); overflow: hidden; position:fixed; bottom: 20px; right: 20px; background-color: black; border-radius: 10px; z-index: 10;" class="animate3" id="cb"><i class='fas fa-user-astronaut p-2 animate3' id="cb"></i></a>
            <div class="form-group form-popup-chatbot" id="chatbot">
                <form name="botform" method="post" class="form-container-chatbot animate">
                    <center><label for="exampleFormControlFile1">
                            <h5 style='font-size:24px; color: #ffcc00;'><i class='fas fa-user-astronaut' style='font-size:25px; color: #ffcc00;'></i> STANBOT</h5><small id="emailHelp" class="form-text text-muted">Encryption by Team Postan</small>
                            <div class='dropdown-divider'></div>
                            <h6 style="color: white;">Hello, how can i help you ?</h6>
                        </label></center>
                    <div class="botmsg animate2">
                        <p style="color:black;" id="bot"></p>
                    </div>
                    <input class="form-control mb-2" type="text" name="mytext" id="u_msg" placeholder="Type a message" onfocus="this.value=''" autocomplete="off" required>
                    <div class="form-inline">
                        <button class="btn btn-success mx-2" id="send" onclick="window.onclick(reply())" onclick="document.botform.mytext.focus();">Send</button></br>
                        <input type="button" class="btn btn-sm btn-danger mb-2" value="Cancel" onclick="closeForm()">
                        <input type="checkbox" oninvalid="this.setCustomValidity('IGNORE THIS')" required>
                    </div>
                </form>
            </div>
        </div>

    </body>

    </html>