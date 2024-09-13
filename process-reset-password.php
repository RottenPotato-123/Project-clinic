<?php

$token = $_POST["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/Connection.php";

if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

$sql = "SELECT * FROM user
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("Failed to prepare SQL statement: (" . $mysqli->errno . ") " . $mysqli->error);
}

$stmt->bind_param("s", $token_hash);

if (!$stmt->execute()) {
    die("Failed to execute SQL statement: (" . $stmt->errno . ") " . $stmt->error);
}

$result = $stmt->get_result();

if (!$result) {
    die("Failed to retrieve result: (" . $stmt->errno . ") " . $stmt->error);
}

$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

if (!$password_hash) {
    die("Failed to hash password");
}

echo "Password hash: $password_hash\n"; // Debug logging

$sql = "UPDATE user
        SET Password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE Id = ?";

$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("Failed to prepare SQL statement: (" . $mysqli->errno . ") " . $mysqli->error);
}

$stmt->bind_param("ss", $password_hash, $user["Id"]);

if (!$stmt->execute()) {
    die("Failed to execute SQL statement: (" . $stmt->errno . ") " . $stmt->error);
}

if ($stmt->affected_rows === 0) {
    die("Failed to update password: (" . $mysqli->errno . ") " . $mysqli->error);
}

echo "Password updated. You can now login.";