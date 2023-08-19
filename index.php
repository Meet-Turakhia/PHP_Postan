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

$cookie_name = "user";
$cookie_value = $_SESSION["u_id"];
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

if (!$_SESSION["u_id"]) {
    header("Location: login.php");
}

$u_name = $_SESSION["u_name"];
$u_id = $_SESSION["u_id"];
$u_email = $_SESSION["u_email"];
$u_type = $_SESSION["u_type"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Postan | Home Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/22d43b373b.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="public/js/ajax.js"></script>
    <link rel="icon" href="public/images/minilogo.png" type="image/x-icon">
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="public/css/chatbot.css">
    <script type="text/javascript" src="public/js/chatbot.js"></script>
</head>

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

    <!-- carousel -->
    <div id="demo" class="carousel slide" data-ride="carousel" data-interval="5000">
        <ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="active"></li>
            <li data-target="#demo" data-slide-to="1"></li>
            <li data-target="#demo" data-slide-to="2"></li>
        </ul>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="public/images/home_carousel/banner1.jpg" alt="home_pickup">
                <div class="carousel-caption">
                    <h3>Home Pickup</h3>
                    <p>Why come to us when we can come to you!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="public/images/home_carousel/banner2.jpg" alt="handle_with_care">
                <div class="carousel-caption">
                    <h3>Handle With Care</h3>
                    <p>We know how much your courier means to you!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="public/images/home_carousel/banner3.jpg" alt="free_packaging">
                <div class="carousel-caption">
                    <h3>Free Packaging</h3>
                    <p>Relax and let us take care of packaging!</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>


    <div class="container mt-5">

        <!-- postan -->
        <h1><span class="shadow-lg badge badge-dark mb-3" style="color: #ffcc00; background-color: black;">Postan</span>
        </h1>

        <div class="row shadow-lg" style="background-color:#e6e6e6; border-top-right-radius: 15px; border-bottom-right-radius: 15px;">
            <div class="col-8" style="background-color: #ffffff;">
                <p style="text-align: justify; font-size: 21px" class="p-3">
                    Postan is a courier management service used
                    by multiple courier companies, we provide
                    secure and
                    reliable online services, so that company can operate smoothly. Simply place your courier by filling
                    out a form, after which our admins will
                    reach you through phone, once the confirmation is done, your courier will be assigned to a delivery
                    boy. You can check the status of your courier in
                    your dashboard. Have any grievances? share your experience with us through the feedback form.
                </p>
            </div>
            <div class="col-4 d-flex" style="background-color:#ffcc00; border-top-right-radius: 15px; border-bottom-right-radius: 15px;">
                <img src="public/images/logo.PNG" alt="postan logo" title="postan logo" class="mx-auto img-fluid align-self-center" style="border-radius: 15px" height="200px">
            </div>
        </div>

        <!-- why postan -->
        <h1>
            <span class="shadow-lg badge badge-dark mt-5 mb-3" style="color: #ffcc00; background-color: black;">Why
                Postan?
            </span>
        </h1>

        <div class="card-deck">

            <div class="card">
                <div class="card-body border border-warning shadow-lg">
                    <center>
                        <img src="public/images/why_postan/unlock.gif" height="50px">
                        <h2 class="card-title mt-2">Secure</h2>
                    </center>
                    <p class="card-text" style="font-size: 20px; text-align: justify;">
                        We give assurity that your
                        courier is safe in the hands of our delivery boy!
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-body border border-warning shadow-lg">
                    <center>
                        <img src="public/images/why_postan/shipped.gif" height="50px">
                        <h2 class="card-title mt-2">Fast</h2>
                    </center>
                    <p class="card-text" style="font-size: 20px; text-align: justify;">
                        We will deliver your courier in
                        the best possible time accross any location!
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-body border border-warning shadow-lg">
                    <center>
                        <img src="public/images/why_postan/handshake.gif" height="50px">
                        <h2 class="card-title mt-2">Reliable</h2>
                    </center>
                    <p class="card-text" style="font-size: 20px; text-align: justify;">
                        You can rely on us to lookafter your courier, we are here for you 24/7!
                    </p>
                </div>
            </div>

        </div>

        <!-- get started -->
        <h1>
            <span class="shadow-lg badge badge-dark mt-5 mb-3" style="color: #ffcc00; background-color: black;">
                Get Started
            </span>
        </h1>

        <div class="row shadow-lg mb-5" style="background-color:#e6e6e6">
            <div class="col-4 d-flex" style="background-color: #ffffff;">
                <img src="public/images/courierboy.png" alt="courier boy" title="courier boy" class="mx-auto img-fluid align-self-center" height="200px">
            </div>
            <div class="col-8" style="background-color: #ffffff;">
                <p style="text-align: justify; font-size: 21px" class="p-3">
                    Place your courier now! and leave the rest to us. what are you waiting for? we provide the best
                    services
                    and the best prices, let our delivery boy take care of packaging and delivering your courier safely!
                </p>

                <?php if ($u_type == "Customer") { ?>
                    <a href="courier.php">
                        <div class="btn btn-lg btn-warning mb-3 ml-2" style="background-color:#ffcc00">Place Now</div>
                    </a>
                <?php } ?>

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