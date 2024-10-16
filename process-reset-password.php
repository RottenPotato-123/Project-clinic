<?php

$mysqli = require __DIR__ . "/Connection.php";

if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

// Retrieve and sanitize the token
$token = $_POST["token"] ?? "";
$token_hash = hash("sha256", $token);

// SQL query to find the user by token hash
$sql = "SELECT * FROM user WHERE reset_token_hash = ?";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("Failed to prepare SQL statement: (" . $mysqli->errno . ") " . $mysqli->error);
}

$stmt->bind_param("s", $token_hash);

if (!$stmt->execute()) {
    die("Failed to execute SQL statement: (" . $stmt->errno . ") " . $stmt->error);
}

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("Token not found.");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Token has expired.");
}

// Validate password requirements
$password = $_POST["password"] ?? "";
$password_confirmation = $_POST["confirm_password"] ?? "";

if (strlen($password) < 8) {
    die("Password must be at least 8 characters.");
}

if (!preg_match("/[a-z]/i", $password)) {
    die("Password must contain at least one letter.");
}

if (!preg_match("/[0-9]/", $password)) {
    die("Password must contain at least one number.");
}

if ($password !== $password_confirmation) {
    die("Passwords do not match.");
}

// Hash the new password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

if (!$password_hash) {
    die("Failed to hash password.");
}

// Debug log for the password hash (optional, remove in production)
echo "Password hash: $password_hash\n";

// SQL query to update the user's password and clear the reset token
$sql = "UPDATE user
        SET Password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL
        WHERE Id = ?";

$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("Failed to prepare SQL statement: (" . $mysqli->errno . ") " . $mysqli->error);
}

$stmt->bind_param("si", $password_hash, $user["Id"]);

if (!$stmt->execute()) {
    die("Failed to execute SQL statement: (" . $stmt->errno . ") " . $stmt->error);
}

if ($stmt->affected_rows === 0) {
    die("Failed to update password: (" . $mysqli->errno . ") " . $mysqli->error);
}

echo "<script>
        alert('Password updated successfully. You can now login.');
        window.location.href = 'landingPage.html';
      </script>";

?>
