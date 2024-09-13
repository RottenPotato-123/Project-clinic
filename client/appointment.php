<?php
require_once 'db.php';

// Add appointment
if (isset($_POST['add_appointment'])) {
  $client_id = $_POST['client_id'];
  $appointment_date = $_POST['appointment_date'];
  $service = $_POST['service'];

  // Get the next queue number
  $sql = "SELECT MAX(queue_number) AS max_queue_number FROM appointments WHERE appointment_date = '$appointment_date'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $queue_number = $row['max_queue_number'] + 1;

  $sql = "INSERT INTO appointments (client_id, appointment_date, queue_number, status, service) VALUES ('$client_id', '$appointment_date', '$queue_number', 'pending', '$service')";
  if ($conn->query($sql) === TRUE) {
    echo "Appointment added successfully!";
  } else {
    echo "Error adding appointment: " . $conn->error;
  }
}

// Mark appointment as done
if (isset($_POST['mark_done'])) {
  $appointment_id = $_POST['appointment_id'];

  $sql = "UPDATE appointments SET status = 'complete' WHERE id = '$appointment_id'";
  if ($conn->query($sql) === TRUE) {
    $sql = "INSERT INTO appointment_history (appointment_id, status) VALUES ('$appointment_id', 'complete')";
    if ($conn->query($sql) === TRUE) {
      echo "Appointment marked as done and stored in appointment history!";
    } else {
      echo "Error storing appointment in appointment history: " . $conn->error;
    }
  } else {
    echo "Error updating appointment status: " . $conn->error;
  }
}

// Display pending appointments
echo "<h2>Pending Appointments</h2>";
echo "<table border='1'>";
echo "<tr><th>Client Name</th><th>Appointment Date</th><th>Queue Number</th><th>Status</th><th>Service</th><th>Action</th></tr>";

$sql = "SELECT a.id, a.appointment_date, a.queue_number, a.status, a.service, c.name AS client_name 
        FROM appointments a 
        JOIN clients c ON a.client_id = c.id 
        WHERE a.status = 'pending'
        ORDER BY a.appointment_date ASC, a.queue_number ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['client_name'] . "</td>";
    echo "<td>" . $row['appointment_date'] . "</td>";
    echo "<td>" . $row['queue_number'] . "</td>";
    echo "<td>" . $row['status'] . "</td>";
    echo "<td>" . $row['service'] . "</td>";
    echo "<td><form action='' method='post'><input type='hidden' name='appointment_id' value='" . $row['id'] . "'><input type='submit' name='mark_done' value='Mark as Done'></form></td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='6'>No pending appointments found!</td></tr>";
}

echo "</table>";

// Display completed appointments
echo "<h2>Completed Appointments</h2>";
echo "<table border='1'>";
echo "<tr><th>Client Name</th><th>Appointment Date</th><th>Queue Number</th><th>Status</th><th>Service</th></tr>";

$sql = "SELECT a.id, a.appointment_date, a.queue_number, a.status, a.service, c.name AS client_name 
        FROM appointments a 
        JOIN clients c ON a.client_id = c.id 
        WHERE a.status = 'complete'
        ORDER BY a.appointment_date ASC, a.queue_number ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['client_name'] . "</td>";
    echo "<td>" . $row['appointment_date'] . "</td>";
    echo "<td>" . $row['queue_number'] . "</td>";
    echo "<td>" . $row['status'] . "</td>";
    echo "<td>" . $row['service'] . "</td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='5'>No completed appointments found!</td></tr>";
}

echo "</table>";

$conn->close();
?>