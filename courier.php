<!DOCTYPE html>
<html lang="en">

<head>
    <title>Postan | Courier</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="icon" href="public/images/minilogo.png" type="image/x-icon">
    <script type="text/javascript" src="public/js/courier.js"></script>
    <script type="text/javascript" src="public/js/ajax.js"></script>
    <link rel="stylesheet" href="public/css/courier.css">
    <link rel="stylesheet" href="public/css/chatbot.css">
    <script type="text/javascript" src="public/js/chatbot.js"></script>
</head>

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

$u_name = $_SESSION["u_name"];
$u_id = $_SESSION["u_id"];
$u_email = $_SESSION["u_email"];
$u_type = $_SESSION["u_type"];

if (isset($_GET["update_id"])) {
    $update_id = $_GET["update_id"];
}

if ($u_type != "Customer" && !isset($_GET["update_id"])) {
    header("Location: index.php");
}

$success = $error = "";

if (isset($_POST["place"])) {
    if (($_FILES["image"]["size"] / 1024) < 64) {
        $title = $_POST["title"];
        $description = $_POST["description"];
        $address = $_POST["address"];
        $image = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
        $result = $mysqli->query("INSERT INTO courier(customer_id, title, description, address, image) VALUES ('$u_id', '$title', '$description', '$address', '$image')");
        if ($result) {
            $success = "Courier Placed successfully! " . "<a href='dashboard.php'>Go To Dashboard</a>";
        } else {
            $error = "Some error occured, try again! Make sure that the input is not too long";
        }
    } else {
        $error = "Size of image should be less than 64kb, try again";
    }
}

if (isset($_POST["update"])) {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $address = $_POST["address"];
    $status = $_POST["status"];
    $delboy_id = $_POST["delboy"];

    if ($status != "Delivered") {
        if ($_FILES["image"]["size"] != 0) {
            if (($_FILES["image"]["size"] / 1024) < 64) {
                $image = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
                if ($delboy_id == "NULL") {
                    $result = $mysqli->query("UPDATE courier SET title = '$title', description = '$description', address = '$address', image = '$image', status = '$status' WHERE courier_id = '$update_id'");
                } else {
                    $result = $mysqli->query("UPDATE courier SET title = '$title', description = '$description', address = '$address', image = '$image', status = '$status', delboy_id = '$delboy_id' WHERE courier_id = '$update_id'");
                }
            } else {
                $result = NULL;
                $error = "Size of image should be less than 64kb, try again";
            }
        } else {
            if ($delboy_id == "NULL") {
                $result = $mysqli->query("UPDATE courier SET title = '$title', description = '$description', address = '$address', status = '$status' WHERE courier_id = '$update_id'");
            } else {
                $result = $mysqli->query("UPDATE courier SET title = '$title', description = '$description', address = '$address', status = '$status', delboy_id = '$delboy_id' WHERE courier_id = '$update_id'");
            }
        }
        if ($result) {
            $success = "Courier Details Updated successfully! " . "<a href='dashboard.php'>➡Check Dashboard</a>";
            header("Location: viewcourier.php?view_id=" . $update_id);
        } else {
            $error = "Some error occured, try again! Make sure that the input is not too long and image size is less than 64kb";
        }
    } else {
        if (($_FILES["delimage"]["size"] / 1024) < 64) {
            $title = $_POST["title"];
            $description = $_POST["description"];
            $address = $_POST["address"];
            $status = $_POST["status"];
            $delboy_id = $_POST["delboy"];
            $cost = $_POST["cost"];
            $delimage = addslashes(file_get_contents($_FILES["delimage"]["tmp_name"]));

            if ($_FILES["image"]["size"] != 0) {
                if (($_FILES["image"]["size"] / 1024) < 64) {
                    $image = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
                    if ($delboy_id == "NULL") {
                        $result = $mysqli->query("UPDATE courier SET title = '$title', description = '$description', address = '$address', image = '$image', status = '$status' WHERE courier_id = '$update_id'");
                    } else {
                        $result = $mysqli->query("UPDATE courier SET title = '$title', description = '$description', address = '$address', image = '$image', status = '$status', delboy_id = '$delboy_id' WHERE courier_id = '$update_id'");
                    }
                } else {
                    $result = NULL;
                    $error = "Size of image should be less than 64kb, try again!";
                }
            } else {
                if ($delboy_id == "NULL") {
                    $result = $mysqli->query("UPDATE courier SET title = '$title', description = '$description', address = '$address', status = '$status' WHERE courier_id = '$update_id'");
                } else {
                    $result = $mysqli->query("UPDATE courier SET title = '$title', description = '$description', address = '$address', status = '$status', delboy_id = '$delboy_id' WHERE courier_id = '$update_id'");
                }
            }
            if (!$result) {
                $error = "Some error occured, try again! Make sure that the input is not too long";
            }

            $result2 = $mysqli->query("SELECT * FROM courier WHERE courier_id = '$update_id'");
            $row2 = $result2->fetch_assoc();
            $customer_id = $row2["customer_id"];
            $delboy_id = $row2["delboy_id"];
            $title = $row2["title"];
            $description = $row2["description"];
            $address = $row2["address"];
            $image = base64_encode($row2["image"]);
            $reg_date = $row2["reg_date"];

            $result3 = $mysqli->query("INSERT INTO history(customer_id, delboy_id, title, description, address, image, delimage, cost, reg_date) VALUES ('$customer_id', '$delboy_id', '$title', '$description', '$address', '$image', '$delimage', '$cost', '$reg_date')");
            if ($result3) {
                $result4 = $mysqli->query("DELETE FROM courier WHERE courier_id = '$update_id'");
                $success = "courier updated successfully and inserted in history!";
                header("Location: dashboard.php");
            } else {
                $error = "Some error occured, try again!";
            }
        } else {
            $error = "Size of image should be less than 64kb, try again!";
        }
    }
}

?>

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


    <div class="container mb-5">

        <?php if (isset($_GET["update_id"])) { ?>
            <center class="mt-5 mb-5">
                <h1 id="main_title">Courier <span id="primarycolor">Update</span></h1>
            </center>
        <?php } else { ?>
            <center class="mt-5 mb-5">
                <h1 id="main_title">Courier <span id="primarycolor">Placement</span></h1>
            </center>
        <?php } ?>

        <div class="container border border-warning" id="form_container">

            <?php
            if (isset($_GET["update_id"])) {
                $result = $mysqli->query("SELECT * FROM courier WHERE courier_id = '$update_id'");
                $result2 = $mysqli->query("SELECT * FROM courier INNER JOIN users ON courier.delboy_id = users.id WHERE courier.courier_id = '$update_id'");
                $row = $result->fetch_assoc();
                $row2 = $result2->fetch_assoc();
            }
            ?>

            <form action="" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="title" id="title_label">Title:</label>
                    <?php if (isset($_GET["update_id"])) { ?>
                        <input id="title" type="text" class="form-control" name="title" placeholder="Enter Title" value="<?php echo $row["title"]; ?>" required autocomplete="off">
                    <?php } else { ?>
                        <input type="text" class="form-control" name="title" placeholder="Enter Title" required autocomplete="off">
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label for="description" id="description_label">Description:</label>
                    <?php if (isset($_GET["update_id"])) { ?>
                        <textarea id="description" class="form-control" name="description" placeholder="Enter Description" required autocomplete="off"><?php echo $row["description"]; ?></textarea>
                    <?php } else { ?>
                        <textarea class="form-control" name="description" placeholder="Enter Description(weight & dimensions should be described)" required autocomplete="off"></textarea>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label for="address" id="address_label">Reciever's Address:</label>
                    <?php if (isset($_GET["update_id"])) { ?>
                        <textarea id="address" class="form-control" name="address" placeholder="Enter Address" required autocomplete="off"><?php echo $row["address"]; ?></textarea>
                    <?php } else { ?>
                        <textarea class="form-control" name="address" placeholder="Enter Address" required autocomplete="off"></textarea>
                    <?php } ?>
                </div>

                <div class="row justify-content-between">

                    <div class="col-sm-3">
                        <div class="form-group">
                            <?php if (isset($_GET["update_id"])) { ?>
                                <label for="image" id="image_label">Current Image:</label>
                                <div class="row">
                                    <div class="col-10">
                                        <input type="file" class="form-control-file" id="image" name="image" autocomplete="off">
                                    </div>
                                    <div class="col">
                                        <?php echo "<img id='image_render' src='data:image/jpeg;base64," . base64_encode($row["image"]) . "' class='pb-2 previewimg' alt='Courier image' width = '50px' height = '50px'>"; ?>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <label for="image">Courier Image:</label>
                                <input type="file" class="form-control-file" id="image" name="image" required autocomplete="off">
                            <?php } ?>
                        </div>
                    </div>

                    <?php if (isset($_GET["update_id"]) && $u_type == "Admin") { ?>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="delboy" id="delboy_label">Select Delivery Boy:</label>
                                <select class="form-control" name="delboy" id="delboy" required>

                                    <?php
                                    $result3 = $mysqli->query("SELECT * FROM users WHERE utype = 'Delivery Boy' ORDER BY uname");
                                    $customer_id = $row["customer_id"];
                                    $result4 = $mysqli->query("SELECT * FROM preference WHERE customer_id = '$customer_id'");
                                    $check_array = array();
                                    while ($row4 = $result4->fetch_assoc()) {
                                        $check_array[$row4["delboy_id"]] = $row4["prefer"];
                                    }
                                    if ($row2) {
                                    ?>
                                        <option value="<?php echo $row2["id"] ?>" hidden selected value> <?php echo $row2["uname"] ?> </option>
                                    <?php } else { ?>
                                        <option value="NULL" hidden selected value>Not Assigned</option>
                                        <?php }
                                    echo "<option value='NULL'>Not Assigned</option>";
                                    while ($row3 = $result3->fetch_assoc()) {
                                        $id = $row3["id"];
                                        if ($check_array[$id]) { ?>
                                            <option value="<?php echo $row3['id'] ?>"><?php echo $row3["uname"] . " " . $check_array[$id] ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $row3['id'] ?>"><?php echo $row3["uname"] ?></option>
                                    <?php }
                                    } ?>

                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="delboy" id="delboy_label" hidden>Select Delivery Boy:</label>
                                <select class="form-control" name="delboy" id="delboy" hidden required>

                                    <?php
                                    $result3 = $mysqli->query("SELECT * FROM users WHERE utype = 'Delivery Boy' ORDER BY uname");
                                    $customer_id = $row["customer_id"];
                                    $result4 = $mysqli->query("SELECT * FROM preference WHERE customer_id = '$customer_id'");
                                    $check_array = array();
                                    while ($row4 = $result4->fetch_assoc()) {
                                        $check_array[$row4["delboy_id"]] = $row4["prefer"];
                                    }
                                    if ($row2) {
                                    ?>
                                        <option value="<?php echo $row2["id"] ?>" hidden selected value> <?php echo $row2["uname"] ?> </option>
                                    <?php } else { ?>
                                        <option value="NULL" hidden selected value>Not Assigned</option>
                                        <?php }
                                    echo "<option value='NULL'>Not Assigned</option>";
                                    while ($row3 = $result3->fetch_assoc()) {
                                        $id = $row3["id"];
                                        if ($check_array[$id]) { ?>
                                            <option value="<?php echo $row3['id'] ?>"><?php echo $row3["uname"] . " " . $check_array[$id] ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $row3['id'] ?>"><?php echo $row3["uname"] ?></option>
                                    <?php }
                                    } ?>

                                </select>
                            </div>
                        </div>
                    <?php } ?>


                    <?php if ((isset($_GET['update_id']) && $u_type == "Admin") || $u_type == "Delivery Boy") { ?>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="status">Select Status:</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="<?php echo $row["status"] ?>" hidden selected value> <?php echo $row["status"] ?> </option>
                                    <?php if ($row["status"] == "Processing") {  ?>
                                        <option value="Processing">Processing</option>
                                        <option value="Dispatched">Dispatched</option>
                                        <option value="Delivered">Delivered</option>
                                    <?php } elseif ($row["status"] == "Dispatched") { ?>
                                        <option value="Dispatched">Dispatched</option>
                                        <option value="Delivered">Delivered</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="status" hidden>Select Status:</label>
                                <select class="form-control" name="status" id="status" hidden required>
                                    <option value="<?php echo $row["status"] ?>" hidden selected value> <?php echo $row["status"] ?> </option>
                                    <?php if ($row["status"] == "Processing") {  ?>
                                        <option value="Processing">Processing</option>
                                        <option value="Dispatched">Dispatched</option>
                                        <option value="Delivered">Delivered</option>
                                    <?php } elseif ($row["status"] == "Dispatched") { ?>
                                        <option value="Dispatched">Dispatched</option>
                                        <option value="Delivered">Delivered</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- close line missing due to php tag ignore -->
                </div>

                <?php if ($u_type == "Admin" || $u_type == "Delivery Boy") { ?>
                    <div class="row justify-content-between">

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="delimage" id="delimage_label" hidden>Delivery Proof:</label>
                                <input type="file" class="form-control-file" name="delimage" id="delimage" hidden disabled required autocomplete="off">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="cost" id="cost_label" hidden>Cost:</label>
                                <input type="number" class="form-control" name="cost" id="cost" placeholder="Enter Cost(in ₹)" hidden disabled required autocomplete="off">
                            </div>
                        </div>

                    </div>
                <?php } ?>

                <?php if (isset($_GET["update_id"])) { ?>
                    <center>
                        <button onclick="return confirm('Are you sure you want to update the courier details?')" type="submit" id="updatebtn" class="btn" name="update">Update</button>
                    </center>
                <?php } else { ?>
                    <center>
                        <button onclick="return confirm('Make sure your personal and courier details are proper, Do you want to proceed?')" type="submit" id="placebtn" class="btn" name="place">Place</button>
                    </center>
                <?php } ?>

            </form>

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