<?php
session_start();
include 'db.php'; // Include your database connection file

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ID from the POST data
    $id = $_POST['id'];
    $response = ['success' => false];

    // Prepare and execute the deletion query
    $stmt = $conn->prepare("DELETE FROM appointments WHERE Id = ?");
    
    // Check if the statement was prepared successfully
    if ($stmt) {
        $stmt->bind_param('i', $id); // 'i' indicates the type is integer

        // Execute the statement
        if ($stmt->execute()) {
            $response['success'] = true; // Deletion successful
        } else {
            // Log the error and set the message
            error_log("SQL Error: " . $stmt->error); // Log the error
            $response['message'] = 'Failed to delete appointment. Error: ' . $stmt->error; // Error message
        }

        // Close the statement
        $stmt->close();
    } else {
        // Log the preparation error
        error_log("Statement Preparation Error: " . $conn->error);
        $response['message'] = 'Failed to prepare statement. Error: ' . $conn->error;
    }

    // Return JSON response
    echo json_encode($response);
} else {
    // Handle non-POST requests
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

// Close the database connection
$conn->close();
?>