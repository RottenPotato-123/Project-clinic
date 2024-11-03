<?php
session_start();
include 'db.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = htmlspecialchars(trim($_POST['FName']));
    $newEmail = htmlspecialchars(trim($_POST['Email']));
    $phone = htmlspecialchars(trim($_POST['Phone']));
    $userId = $_SESSION['user_id'];
    $currentEmail = $_SESSION['user_email'] ?? '';

    // Check if the email has changed
    if ($newEmail !== $currentEmail) {
        // Generate a unique token
        $token = bin2hex(random_bytes(16));
        $_SESSION['email_token'] = $token;
        $_SESSION['pending_email'] = $newEmail;

        $confirm="http://localhost/Project-clinic/client/verify_email.php?token=$token";
        // Send the verification email with the token link
        $mail = require __DIR__ . "/../mailer.php";

        $mail = getMailer(); // Call the function to get the mailer instance

        $mail->setFrom('noreply@example.com');
        $mail->addAddress($newEmail);
        $mail->Subject = 'Email Verification';
        $mail->Body = 
        <<<END
        Hello,

Click the link to verify your new email

<a href="$confirm">Reset Link</a>


If you did not request a password reset, please ignore this message.

Thank you!
END;

        if ($mail->send()) {
            echo "<script>
                alert('A verification link has been sent to your new email. Please check your email to verify.');
                window.location.href = 'userSetting.php';
            </script>";
            exit;
        } else {
            echo "Error sending verification email: " . $mail->ErrorInfo;
            exit;
        }
    } else {
        // If email hasn't changed, proceed with the profile update
        $query = "UPDATE user SET FName = ?, Email = ?, Phone = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssi', $fname, $newEmail, $phone, $userId);

        if ($stmt->execute()) {
            echo "<script>
                alert('Profile updated successfully!');
                window.location.href = 'userSetting.php';
            </script>";
        } else {
            echo "Error updating profile: " . $conn->error;
        }

        $stmt->close();
    }
}
$conn->close();

?>
