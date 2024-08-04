<?php
// get_usernames.php

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["branch"])) {
    $selectedBranch = $_GET["branch"];
    
    $usernameQuery = "SELECT username FROM `user` WHERE branch = '$selectedBranch'";
    $usernameResult = $conn->query($usernameQuery);

    $usernames = [];

    while ($row = $usernameResult->fetch_assoc()) {
        $usernames[] = $row['username'];
    }

    echo json_encode($usernames);
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid request"]);
}

$conn->close();
?>
