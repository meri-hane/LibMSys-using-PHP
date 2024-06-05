<?php
$dbName = "crud";
$dbHost = "localhost";
$dbUser = "mj";
$dbPass = "mjdbroot";
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if (!$conn) {
    die("Something went wrong");
}
?>