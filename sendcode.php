<?php

$mysqli = include_once __DIR__ . "/Connection.php";

if (!isset($_POST["email"]) || empty($_POST["email"])) {
    echo "Email address is required.";
    exit;
}

// Validate email input
$email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
if (!$email) {
    echo "Invalid email address.";
    exit;
}

// Generate a secure token
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30); // Token valid for 30 minutes

// SQL to update the user's reset token and expiry
$sql = "UPDATE user SET reset_token_hash = ?, reset_token_expires_at = ? WHERE Email = ?";

// Check if $mysqli is a valid object
if ($mysqli instanceof mysqli) {
    $stmt = $mysqli->prepare($sql);
    
    if (!$stmt) {
        echo "Failed to prepare statement: " . $mysqli->error;
        exit;
    }

    $stmt->bind_param("sss", $token_hash, $expiry, $email);
    $stmt->execute();

    if ($stmt->affected_rows) {
        $reset_url = "http://localhost/Project-clinic/reset-password.php?token=$token";

        // Include your mailer setup
        $mail = require __DIR__ . "../mailer.php";
        $mail = getMailer();
        $mail->setFrom("noreply@example.com");
        $mail->addAddress($email);
        $mail->Subject = "Password Reset";
        $mail->Body = <<<END
        Hello,

We received a request to reset your password. Click the link below to reset it:

<a href="$reset_url">Reset Link</a>

This link will expire in 30 minutes.

If you did not request a password reset, please ignore this message.

Thank you!
END;

        // Attempt to send the email
        try {
            $mail->send();
            echo "<script>
                    alert('Message sent, please check your inbox.');
                    window.location.href = 'landingpage.html';
                  </script>";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>
        alert('No user found with that email address..');
        window.location.href = 'forgotpass.php';
      </script>";
    }
} else {
    echo "Invalid database connection object";
    exit;
}
?>
