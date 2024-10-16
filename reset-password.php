<?php
if (!isset($_GET["token"])) {
    die("Token is required.");
}

$token = $_GET["token"];
$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/Connection.php";

// Query to find the user by token hash
$sql = "SELECT * FROM user WHERE reset_token_hash = ?";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("Failed to prepare statement: " . $mysqli->error);
}

$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("Token not found.");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Token has expired.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Your Password</h2>
    <form action="process-reset-password.php" method="POST">
        <input type="hidden" name="email" value="<?= htmlspecialchars($user['Email']) ?>">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
