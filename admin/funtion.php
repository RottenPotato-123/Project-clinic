<?php
require_once 'db.php';

$id = $_POST['id'];

// Delete record from database
$sql = "DELETE FROM appointments WHERE id = '$id'";
if (mysqli_query($conn, $sql)) {
  echo 'success';
} else {
  echo 'Error deleting record: ' . mysqli_error($conn);
}
$conn->close();
?>