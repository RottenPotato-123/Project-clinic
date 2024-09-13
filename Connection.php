<?php
$servername = "localhost";
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "clinic";

// Create connection using MySQLi
$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error . " (" . $mysqli->connect_errno . ")";
    exit;
}

return $mysqli;
?>