<?php
$dbServername = "localhost";
$dbUsername = "yunda";
$dbPassword = "sayangpapa";
$dbName = "diet";

// Create connection
$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
 ?>
