<?php
session_start();

// Include the database connection
include 'db.php';  // Adjust path if necessary

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve form data
    $fname = htmlspecialchars(trim($_POST['FName']));
    $email = htmlspecialchars(trim($_POST['Email']));
    $phone = htmlspecialchars(trim($_POST['Phone']));

    // Prepare an SQL statement to update the user data
    $query = "UPDATE user SET FName = ?, Email = ?, Phone = ? WHERE id = ?";
    $stmt = $conn->prepare($query);

    // Assuming `id` is stored in the session (for the logged-in user)
    $userId = $_SESSION['user_id'];  // Ensure 'user_id' is correctly set

    // Bind parameters and execute the query
    $stmt->bind_param('sssi', $fname, $email, $phone, $userId);

    if ($stmt->execute()) {
        echo "<script>
        alert('Profile update successfully! ');
        window.location.href = 'userSetting.php';
      </script>";
    } else {
        echo "Error updating profile: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
