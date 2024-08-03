<?php

$serverName = "localhost";
$dbUserName = "root";
$dbPassword = "1234";
$dbName = "visionSolution";

$conn = mysqli_connect($serverName,$dbUserName,$dbPassword,$dbName);

if(!$conn){
    die("Connection Failed : ".mysqli_connect_error());
}