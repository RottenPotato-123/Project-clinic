<?php
$mysqli = require __DIR__ . "/Connection.php";

if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

try {
    // Retrieve and sanitize the token from the request
    $token = $_POST["token"] ?? "";
    if (empty($token)) {
        throw new Exception("Token is missing.");
    }
    $token_hash = hash("sha256", $token);

    // SQL query to find the user by token hash
    $sql = "SELECT * FROM user WHERE reset_token_hash = ?";
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        throw new Exception("Failed to prepare SQL statement: " . $mysqli->error);
    }

    $stmt->bind_param("s", $token_hash);

    if (!$stmt->execute()) {
        throw new Exception("Failed to execute SQL statement: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user === null) {
        throw new Exception("Token not found.");
    }

    if (strtotime($user["reset_token_expires_at"]) <= time()) {
        throw new Exception("Token has expired.");
    }

    // Validate password inputs
    $password = $_POST["password"] ?? "";
    $password_confirmation = $_POST["confirm_password"] ?? "";

    if (strlen($password) < 8) {
        throw new Exception("Password must be at least 8 characters.");
    }

    if (!preg_match("/[a-z]/i", $password)) {
        throw new Exception("Password must contain at least one letter.");
    }

    if (!preg_match("/[0-9]/", $password)) {
        throw new Exception("Password must contain at least one number.");
    }

    if ($password !== $password_confirmation) {
        throw new Exception("Passwords do not match.");
    }

    // Hash the new password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    if (!$password_hash) {
        throw new Exception("Failed to hash the password.");
    }

    // SQL query to update the user's password and clear the reset token
    $sql = "UPDATE user
            SET Password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL
            WHERE Id = ?";

    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        throw new Exception("Failed to prepare SQL statement: " . $mysqli->error);
    }

    $stmt->bind_param("si", $password_hash, $user["Id"]);

    if (!$stmt->execute()) {
        throw new Exception("Failed to execute SQL statement: " . $stmt->error);
    }

    if ($stmt->affected_rows === 0) {
        throw new Exception("No changes were made. Password might already be updated.");
    }

    echo "<script>
            alert('Password updated successfully. You can now log in.');
            window.location.href = 'landingPage.html';
          </script>";

} catch (Exception $e) {
    // Gracefully handle exceptions and show the error message
    echo "<script>
            alert('Error: " . htmlspecialchars($e->getMessage()) . "');
            window.history.back();
          </script>";
}
?>
