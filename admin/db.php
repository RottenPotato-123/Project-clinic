<?php $servername = "localhost";
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "clinic";

// Create connection using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>