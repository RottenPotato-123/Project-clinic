<?php
session_start();
include 'db.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
  $id = intval($_POST['id']); // Ensure the ID is an integer

  // Prepare the DELETE statement
  $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ?");
  $stmt->bind_param("i", $id); // 'i' denotes the type (integer)

  // Execute the statement and check if the deletion was successful
  if ($stmt->execute()) {
      echo json_encode(['success' => true, 'message' => 'Deleted successfully.']);
  } else {
      echo json_encode(['success' => false, 'message' => 'Failed to delete record.']);
  }

  // Close the statement
  $stmt->close();
} else {
  echo json_encode(['success' => false, 'message' => 'ID not provided.']);
}

// Close the database connection
$conn->close();
?>