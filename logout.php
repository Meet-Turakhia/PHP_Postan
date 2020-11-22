<?php

require("backend.php");
session_start();
$u_id = $_SESSION["u_id"];
$result = $mysqli->query("DELETE FROM session WHERE u_id = '$u_id'");
session_destroy();
header("Location: login.php");
