<?php
require_once 'Connection.php';

if (isset($_GET['code'])) {
    $confirmationCode = $_GET['code'];

    // Update the user's status to active
    $query = "UPDATE user SET Status = 'active' WHERE ConfirmationCode = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $confirmationCode);
    $stmt->execute();

    if ($stmt->affected_rows == 1) {
        echo "<script>
        alert('Confirmation  successfully! You can login now!');
        window.location.href = 'login.php';
      </script>";
    } else {
        echo "Invalid confirmation code or your email is already confirmed.";
    }
}

$mysqli->close();
?>
