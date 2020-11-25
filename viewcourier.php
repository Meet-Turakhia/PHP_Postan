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

$u_name = $_SESSION["u_name"];
$u_id = $_SESSION["u_id"];
$u_email = $_SESSION["u_email"];
$u_type = $_SESSION["u_type"];
$success = $error = "";

if (!$_SESSION["u_id"]) {
    header("Location: login.php");
}

if (!isset($_GET["view_id"])) {
    header("Location: dashboard.php");
}

$view_id = $_GET["view_id"];

if (isset($_POST["delete"])) {
    $result = $mysqli->query("DELETE FROM courier WHERE courier_id = '$view_id'");
    header("Location: dashboard.php");
}

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
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="icon" href="public/images/minilogo.png" type="image/x-icon">
    <script type="text/javascript" src="public/js/viewcourier.js"></script>
    <script type="text/javascript" src="public/js/ajax.js"></script>
    <link rel="stylesheet" href="public/css/viewcourier.css">
</head>

<title>View Courier | cid: <?php echo $view_id; ?></title>

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

    <div class="container">

        <?php
        $result = $mysqli->query("SELECT *, users.address as useraddress, courier.address as courieraddress FROM courier INNER JOIN users ON courier.customer_id = users.id WHERE courier.courier_id = '$view_id' ORDER BY reg_date DESC");
        $result2 = $mysqli->query("SELECT * FROM courier INNER JOIN users ON courier.delboy_id = users.id WHERE courier.courier_id = '$view_id' ORDER BY reg_date DESC");
        $row = $result->fetch_assoc();
        if ($row["delboy_id"] != NULL) {
            $row2 = $result2->fetch_assoc();
        }
        ?>

        <h1 style="margin-top: 30px;" class="ml-4"><kbd style="color: #ffcc00; background-color:black; font-family: Century Gothic; border-radius: 10px;">Courier Id</kbd> <?php echo $row["courier_id"]; ?></h1>

        <div class="container" style="margin-top: 25px; margin-bottom: 50px;">

            <div class="row no-gutters jumbotron">
                <div class="col-md-4 frame">
                    <?php echo "<span class='helper'></span><img class='card-img fas fa-user pcard' src='data:image/jpeg;base64," . base64_encode($row["image"]) . "' style='border-radius: 10px; vertical-align: middle;' alt='Courier image'>"; ?>
                    <!-- <a href="#" id="edit" onclick="openForm()" style="overflow: hidden; position:absolute; bottom: 0px;right: 0px;"><i class='material-icons' id="ch">add_circle</i></a> -->
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <center>
                            <h1 style="color: black; word-wrap: break-word; font-size: 2em;"><?php echo $row["title"]; ?></h1>
                        </center>

                        <?php if (($u_type == "Customer" && $row["status"] == "Processing") || $u_type == "Admin" || $u_type == "Delivery Boy") { ?>
                            <a id="edit" onclick="openForm()" href="#" style="overflow: hidden; position: absolute; top: 10px; right: 0px;" title="Edit"><i class='fa fa-cog' id="ch"></i></a>
                        <?php } ?>

                        <div class="form-group form-popup-dp" id="courier_settings">
                            <form action="" method="POST" class="form-container-dp">
                                <label for="courier_settings">
                                    <h5 style="border-bottom: 1px solid #ffcc00; color: white;">Select Options:</h5>
                                    <small>click outside the model to close</small>
                                </label><br>
                                <a href=" courier.php?update_id=<?php echo $view_id; ?>"><input type="button" name="update" class="btn btn-sm btn-primary" value="Update"></a>
                                <?php if ($u_type != "Delivery Boy") { ?>
                                    <input onclick="return confirm('Are you sure, you want to delete the courier order?')" type="submit" name="delete" class="btn btn-sm btn-danger" value="delete">
                                <?php } ?>
                            </form>
                        </div>
                        <div class="row mt-4 justify-content-between">
                            <div class="col">
                                <p class="lead" style="font-size: 1.05em;"><?php echo $row["reg_date"]; ?></p>
                            </div>
                            <div class="col-2" id="status">
                                <p class="lead" style="font-size: 1.05em;"><?php echo $row["status"]; ?></p>
                            </div>
                        </div>
                        <hr class="my-1">
                        <h6 class="mt-3 mb-3" style="text-align: justify;">Customer: <span class="font-weight-bold"><a href="profile.php?view_id=<?php echo $row["id"] ?>"><?php echo $row["uname"]; ?></a></span></h6>
                        <?php if ($row["delboy_id"] != NULL) { ?>
                            <h6 class="mb-3" style="text-align: justify;">Delivery Boy: <span class="font-weight-bold"><a href="profile.php?view_id=<?php echo $row2["id"] ?>"><?php echo $row2["uname"]; ?></a></span></h6>
                        <?php } else { ?>
                            <h6 class="mb-3" style="text-align: justify;">Delivery Boy: <span class="font-weight-bold">Not Assigned</span></h6>
                        <?php } ?>
                        <h6 class="mb-3" style="text-align: justify;">Description: <span class="font-weight-bold"><?php echo $row["description"]; ?></span></h6>
                        <h6 class="mb-3" style="text-align: justify;">Source: <span class="font-weight-bold"><?php echo $row["useraddress"]; ?></span></h6>
                        <h6 class="mb-3" style="text-align: justify;">Destination: <span class="font-weight-bold"><?php echo $row["courieraddress"]; ?></span></h6>
                        <small style="color: red">
                            <?php if ($row["reg_date"] != $row["upd_date"]) {
                                echo "Details updated on: " . $row["upd_date"];
                            } ?>
                        </small>
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

</body>

</html>