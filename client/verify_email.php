<?php
session_start();
include 'db.php';

if (isset($_GET['token']) && $_GET['token'] === $_SESSION['email_token']) {
    // Tokens match, proceed to update the email
    $newEmail = $_SESSION['pending_email'];
    $userId = $_SESSION['user_id'];

    $query = "UPDATE user SET Email = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $newEmail, $userId);

    if ($stmt->execute()) {
        echo "<script>
            alert('Email updated successfully!');
            window.location.href = 'userSetting.php';
        </script>";
        
        // Update the session with the new email
        $_SESSION['user_email'] = $newEmail;
        unset($_SESSION['email_token'], $_SESSION['pending_email']);
    } else {
        echo "Error updating email: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "<script>
        alert('Invalid or expired token.');
        window.location.href = 'userSetting.php';
    </script>";
}

$conn->close();
?>
