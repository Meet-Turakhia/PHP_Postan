<?php
require("backend.php");
session_start();
$output = "";
echo $output;
$user_input = $_POST["search"];

if ($_SESSION["u_type"] == "Customer") {
    $customer_id = $_SESSION['u_id'];
    $result = $mysqli->query("SELECT history.title, history.history_id AS id, history.feedback AS render FROM history WHERE ((title LIKE '%{$user_input}%' OR history_id LIKE '%{$user_input}%') AND customer_id = '$customer_id') UNION SELECT courier.title, courier.courier_id AS id, courier.identify AS render FROM courier WHERE ((title LIKE '%{$user_input}%' OR courier_id LIKE '%{$user_input}%') AND customer_id = '$customer_id') LIMIT 5");
}

if ($_SESSION["u_type"] == "Delivery Boy") {
    $delboy_id = $_SESSION['u_id'];
    $result = $mysqli->query("SELECT history.title, history.history_id AS id, history.feedback AS render FROM history WHERE ((title LIKE '%{$user_input}%' OR history_id LIKE '%{$user_input}%') AND delboy_id = '$delboy_id') UNION SELECT courier.title, courier.courier_id AS id, courier.identify AS render FROM courier WHERE ((title LIKE '%{$user_input}%' OR courier_id LIKE '%{$user_input}%') AND delboy_id = '$delboy_id') LIMIT 5");
}

if ($_SESSION["u_type"] == "Admin") {
    $delboy_id = $_SESSION['u_id'];
    $result = $mysqli->query("SELECT history.title, history.history_id AS id, history.feedback AS render FROM history WHERE (title LIKE '%{$user_input}%' OR history_id LIKE '%{$user_input}%') UNION SELECT courier.title, courier.courier_id AS id, courier.identify AS render FROM courier WHERE (title LIKE '%{$user_input}%' OR courier_id LIKE '%{$user_input}%') LIMIT 5");
}

if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_array()) {
        $courier_id = $row['id'];
        if ($row["render"] == "postan000000") {
            $output .= "<a href='viewcourier.php?view_id={$courier_id}' title='view'><p>" . $row["title"] . " cid: " . $row["id"] . "</p></a>";
        } else {
            $output .= "<a href='viewhistory.php?view_id={$courier_id}' title='view'><p>" . $row["title"] . " hid: " . $row["id"] . "</p></a>";
        }
    }
    echo $output;
} else {
    echo "<div style='color: #ffffff; text-align: center; padding: 5% 0% 5% 0%;'>Results Not Found</div>";
}
