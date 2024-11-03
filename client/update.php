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

    // Fetch current data from the database to check for changes
    $query = "SELECT FName, Email, Phone FROM user WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->bind_result($currentFName, $currentEmail, $currentPhone);
    $stmt->fetch();
    $stmt->close();

    // Check if any of the data has changed
    if (trim($fname) === trim($currentFName) && trim($newEmail) === trim($currentEmail) && trim($phone) === trim($currentPhone)) {
        echo "<script>
            alert('No changes detected in profile. Data not saved.');
            window.location.href = 'userSetting.php';
        </script>";
        exit;
    }

    // Check if the email has changed
    if ($newEmail !== $currentEmail) {
        // Generate a unique token
        $token = bin2hex(random_bytes(16));
        $_SESSION['email_token'] = $token;
        $_SESSION['pending_email'] = $newEmail;

        $confirm = "http://localhost/Project-clinic/client/verify_email.php?token=$token";
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

<a href="$confirm">Changes email</a>

If you did not request a email change, please ignore this message.

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
        $query = "UPDATE user SET FName = ?, Phone = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssi', $fname, $phone, $userId);

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
