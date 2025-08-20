<?php
$serverName = getenv("MYSQLHOST");
$username   = getenv("MYSQLUSER");
$password   = getenv("MYSQLPASSWORD");
$database   = getenv("MYSQLDATABASE");
$port       = getenv("MYSQLPORT");

$conn = new mysqli($serverName, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Koneksi Error: " . $conn->connect_error);
}
?>