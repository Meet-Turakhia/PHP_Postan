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
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script type="text/javascript" src="public/js/ajax.js"></script>
    <script type="text/javascript" src="public/js/aboutus.js"></script>
    <link rel="stylesheet" href="public/css/aboutus.css">
    <link rel="icon" href="public/images/minilogo.png" type="image/x-icon">
    <link rel="stylesheet" href="public/css/chatbot.css">
    <script type="text/javascript" src="public/js/chatbot.js"></script>
    <title>Postan | About Us</title>
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

    <!-- Team -->
    <section id="team" class="pb-5">
        <div class="container">
            <center>
                <h5 class="h1 heading mt-5 mb-5">Meet The Team</h5>
            </center>
            <div class="row">
                <!-- Team member -->
                <div class="col-sm">
                    <div class="image-flip">
                        <div class="mainflip flip-0">
                            <div class="frontside">
                                <div class="card shadow-lg">
                                    <div class="card-body text-center">
                                        <img src="public/images/pexels-photo-574069.webp" class="background-image">
                                        <p><img class=" img-fluid img-circle image logo" src="public/images/meet.jpg" alt="card image"></p>
                                        <h2 class="card-title">Meet Turakhia</h2>
                                        <h4 class="card-text">Web Developer</h4>
                                        <img src="public/images/logo-removebg-preview.png" class="mt-2" style="width: auto; height: 50px">
                                    </div>
                                </div>
                            </div>
                            <div class="backside">
                                <div class="card shadow-lg">
                                    <div class="card-body text-center mt-4">
                                        <h2 class="card-title">Meet Turakhia</h2>
                                        <hr>
                                        <h5 style="text-align:justify" class="aboutme">I am an undergrad student pursuing my BE in Computer Engineering from Mumbai University.
                                            I love programming and even if I don't know the solution to a problem right away I always enjoy my journey finding it.</h5>
                                        <hr>
                                        <h4 class="card-title">Social Links</h4>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a href="">
                                                    <i class="social_icons fab fa-facebook socials facebook mt-2"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="">
                                                    <i class="social_icons fab fa-twitter socials twitter mt-2"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="">
                                                    <i class="social_icons fab fa-instagram socials instagram mt-2"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="">
                                                    <i class="social_icons fab fa-linkedin socials linkedin mt-2"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./Team member -->
                <!-- Team member -->
                <div class="col-sm">
                    <div class="image-flip">
                        <div class="mainflip flip-0">
                            <div class="frontside">
                                <div class="card shadow-lg">
                                    <div class="card-body text-center">
                                        <img src="public/images/pexels-photo-574069.webp" class="background-image">
                                        <p><img class=" img-fluid img-circle image logo" src="public/images/parth.jpg" alt="card image" title="Parth Chudasama">
                                        </p>
                                        <h3 class="card-title">Parth Chudasama</h3>
                                        <h4 class="card-text">Web Developer</h4>
                                        <img src="public/images/logo-removebg-preview.png" class="mt-2" style="width: auto; height: 50px">
                                    </div>
                                </div>
                            </div>
                            <div class="backside">
                                <div class="card shadow-lg">
                                    <div class="card-body text-center mt-4">
                                        <h3 class="card-title">Parth Chudasama</h3>
                                        <hr>
                                        <h5 style="text-align:justify" class="aboutme">"Half Backed Engineer" as I've Completed Diploma in Computer Engineering from Shri Bhagubhai
                                            Mafatlal Polytechnic also known SVKM's SBMP, Vile-Parle Mumbai. Currently pursuing Degree in
                                            Computer Engineering from Mumbai University.</h5>
                                        <hr>
                                        <h4 class="card-title">Social Links</h4>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a href="">
                                                    <i class="social_icons fab fa-facebook socials facebook mt-2"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="">
                                                    <i class="social_icons fab fa-twitter socials twitter mt-2"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="">
                                                    <i class="social_icons fab fa-instagram socials instagram mt-2"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="">
                                                    <i class="social_icons fab fa-linkedin socials linkedin mt-2"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./Team member -->
            <!-- Team member -->
            <div class="row">
                <div class="col-sm">
                    <div class="image-flip">
                        <div class="mainflip flip-0">
                            <div class="frontside">
                                <div class="card shadow-lg">
                                    <div class="card-body text-center">
                                        <img src="public/images/pexels-photo-574069.webp" class="background-image">
                                        <p><img class=" img-fluid img-circle image logo" src="public/images/priyal.jpeg" alt="card image" title="Priyal Vyas">
                                        </p>
                                        <h2 class="card-title">Priyal Vyas</h2>
                                        <h4 class="card-text">Web Developer</h4>
                                        <img src="public/images/logo-removebg-preview.png" class="mt-2" style="width: auto; height: 50px">
                                    </div>
                                </div>
                            </div>
                            <div class="backside">
                                <div class="card shadow-lg">
                                    <div class="card-body text-center mt-4">
                                        <h2 class="card-title">Priyal Vyas</h2>
                                        <hr>
                                        <h5 style="text-align:justify" class="aboutme">
                                            An enthusiastic learner who loves to explore new technologies related to web development.
                                            Apart from web development, i am learning machine learning, also i am interested to known about fundamental subjects of computer science.
                                        </h5>
                                        <hr>
                                        <h4 class="card-title">Social Links</h4>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a href="">
                                                    <i class="social_icons fab fa-facebook socials facebook mt-2"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="">
                                                    <i class="social_icons fab fa-twitter socials twitter mt-2"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="">
                                                    <i class="social_icons fab fa-instagram socials instagram mt-2"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="">
                                                    <i class="social_icons fab fa-linkedin socials linkedin mt-2"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./Team member -->
                <!-- Team member -->
                <div class="col-sm">
                    <div class="image-flip">
                        <div class="mainflip flip-0">
                            <div class="frontside">
                                <div class="card shadow-lg">
                                    <div class="card-body text-center">
                                        <img src="public/images/pexels-photo-574069.webp" class="background-image">
                                        <p><img class=" img-fluid img-circle image logo" src="public/images/sayalee.jpeg" alt="card image">
                                        </p>
                                        <h2 class="card-title">Sayalee Patil</h2>
                                        <h4 class="card-text">Web Developer</h4>
                                        <img src="public/images/logo-removebg-preview.png" class="mt-2" style="width: auto; height: 50px">
                                    </div>
                                </div>
                            </div>
                            <div class="backside">
                                <div class="card shadow-lg">
                                    <div class="card-body text-center mt-4">
                                        <h2 class="card-title">Sayalee Patil</h2>
                                        <hr>
                                        <h5 style="text-align:justify" class="aboutme">I am at an intermediate level in web development and trying to acquaint new technologies coming.
                                            Apart from that I have learnt java, python,machine learning and deep learning.I am carrying on the process of learning.
                                        </h5>
                                        <hr>
                                        <h4 class="card-title">Social Links</h4>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a href="">
                                                    <i class="social_icons fab fa-facebook socials facebook mt-2"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="">
                                                    <i class="social_icons fab fa-twitter socials twitter mt-2"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="">
                                                    <i class="social_icons fab fa-instagram socials instagram mt-2"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="">
                                                    <i class="social_icons fab fa-linkedin socials linkedin mt-2"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team -->
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