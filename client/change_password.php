<?php
session_start();  // Start the session

// Include the database connection
include 'db.php';  // Adjust the path if needed

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure user is logged in and user_id is in the session
    if (!isset($_SESSION['user_id'])) {
        echo "Error: User not logged in.";
        exit;
    }

    $userId = $_SESSION['user_id'];

    // Retrieve and sanitize form inputs
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Check if new password matches the confirmation
    if ($new_password !== $confirm_password) {
        echo "Error: New password and confirm password do not match.";
        exit;
    }

    // Fetch the current password hash from the database
    $query = "SELECT Password FROM user WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verify the current password
    if (!password_verify($current_password, $hashed_password)) {
        echo "Error: Current password is incorrect.";
        exit;
    }

    // Hash the new password
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    $update_query = "UPDATE user SET Password = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('si', $new_hashed_password, $userId);

    if ($update_stmt->execute()) {
        echo "<script>
        alert('Appointment added successfully for $appointment_date!');
        window.location.href = 'userSetting.php';
      </script>";
    } else {
        echo "Error updating password: " . $conn->error;
    }

    $update_stmt->close();
    $conn->close();
}
?>
