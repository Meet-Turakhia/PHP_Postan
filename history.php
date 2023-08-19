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

if (!$_SESSION["u_id"]) {
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/22d43b373b.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="public/js/ajax.js"></script>
    <link rel="icon" href="public/images/minilogo.png" type="image/x-icon">
    <link rel="stylesheet" href="public/css/history.css">
    <link rel="stylesheet" href="public/css/chatbot.css">
    <script type="text/javascript" src="public/js/chatbot.js"></script>
</head>

<title>Postan | History</title>

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

    <div class="container mt-5">

        <div class="row">

            <div class="col-sm">
                <h2 class="d-inline" style="margin-top: 100px;"><kbd style="color: #ffcc00; background-color:black; font-family: Century Gothic; border-radius: 10px;">History</kbd></h2>
            </div>

            <div class="col-sm">
                <?php
                if ($u_type == "Customer") {
                    $count_query = $mysqli->query("SELECT * FROM history WHERE customer_id = '$u_id' ORDER BY reg_date DESC");
                } elseif ($u_type == "Delivery Boy") {
                    $count_query = $mysqli->query("SELECT * FROM history WHERE delboy_id = '$u_id' ORDER BY reg_date DESC");
                } else {
                    $count_query = $mysqli->query("SELECT * FROM history ORDER BY reg_date DESC");
                }
                $count = 0;
                while ($count_array = $count_query->fetch_assoc()) {
                    $count = $count + 1;
                }
                ?>
                <h2 class="d-inline" id="main_title">Orders <span id="primarycolor">Done:</span> <?php echo $count ?> </h2>
            </div>

        </div>

        <?php if ($count == 0) {
            echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
        } ?>


        <div class="row row-cols-1 row-cols-md-2" style="margin-top: 20px;">

            <?php
            if ($u_type == "Customer") {
                $result = $mysqli->query("SELECT *, users.address as user_address, history.address as courier_address FROM history INNER JOIN users ON history.customer_id = users.id WHERE customer_id = '$u_id' ORDER BY upd_date DESC");
                $result2 = $mysqli->query("SELECT uname FROM history INNER JOIN users ON history.delboy_id = users.id WHERE customer_id = '$u_id' ORDER BY upd_date DESC");
            } elseif ($u_type == "Delivery Boy") {
                $result = $mysqli->query("SELECT *, users.address as user_address, history.address as courier_address FROM history INNER JOIN users ON history.customer_id = users.id WHERE delboy_id = '$u_id' ORDER BY upd_date DESC");
                $result2 = $mysqli->query("SELECT uname FROM history INNER JOIN users ON history.delboy_id = users.id WHERE delboy_id = '$u_id' ORDER BY upd_date DESC");
            } else {
                $result = $mysqli->query("SELECT *, users.address as user_address, history.address as courier_address FROM history INNER JOIN users ON history.customer_id = users.id ORDER BY upd_date DESC");
                $result2 = $mysqli->query("SELECT uname FROM history INNER JOIN users ON history.delboy_id = users.id ORDER BY upd_date DESC");
            }
            while ($row = $result->fetch_assoc()) {
                if ($row["delboy_id"] != NULL) {
                    $row2 = $result2->fetch_assoc();
                }
            ?>
                <div class="col mb-4">
                    <div class="card" style="border-radius: 25px;">
                        <a href="viewhistory.php?view_id=<?php echo $row["history_id"] ?>" style="overflow: hidden; position: absolute; top: 10px;right: 10px;" title="View Details"><i class='fas fa-chevron-circle-right' id="ch"></i></a>
                        <?php echo "<img src='data:image/jpeg;base64," . $row["image"] . "' alt='Courier image' style='max-width: 150px; margin-top: 10px; margin-left: 10px; border-radius: 10px;'>"; ?>
                        <div class="card-body">
                            <center>
                                <h5 class="card-title font-weight-bold"> <?php echo $row["title"]; ?> </h5>
                            </center>
                            <h7>Registered: <b> <?php echo $row["reg_date"]; ?> </b></h7>
                            <h7 style="float: right; overflow: hidden;" id="status">Status:<b> Delivered </b></h7>
                            <?php if ($row["reg_date"] != $row["upd_date"]) { ?>
                                <br>
                                <h7>Delivered: <b> <?php echo $row["upd_date"]; ?> </b></h7>
                            <?php } ?>
                            <div class="card-footer text-muted ca" style="max-width: 100%;">
                                <p> Customer Name:<b> <?php echo $row["uname"] ?> <br></b>DeliveryBoy Name:<b>
                                        <?php
                                        if ($row["delboy_id"] != NULL) {
                                            echo $row2["uname"];
                                        } else {
                                            echo "Not Assigned";
                                        } ?>
                                    </b></p>
                                <a>Source: <b><?php echo $row["user_address"]; ?></b> <br>
                                    Destination: <b> <?php echo $row["courier_address"]; ?> </b></a>
                                <?php if (!$row["feedback"] && $u_type == "Customer") { ?>
                                    <small class="feedback_notice">Please give feedback!</small>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

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