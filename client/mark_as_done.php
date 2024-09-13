<?php
// Check if the id parameter is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Connect to the database
    require_once 'db.php';

    // Prepare the SQL query to update the appointment status
    $sql = "UPDATE appointments SET status = 'done' WHERE id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the id parameter
    $stmt->bind_param("i", $id);

    // Execute the query
    if ($stmt->execute() === TRUE) {
        // Update the appointment status in the session
        foreach ($_SESSION['appointments'] as &$appointment) {
            if ($appointment['id'] == $id) {
                $appointment['status'] = 'done';
                break;
            }
        }

        // Redirect back to the appointments page
        header('Location: appointments.php');
        exit;
    } else {
        // Display an error message
        echo "Error updating appointment status: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Display an error message
    echo "Invalid request";
}
?>