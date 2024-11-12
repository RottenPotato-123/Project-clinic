<?php
require_once 'db.php';

// Start the session
session_start();

// Check if the client is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Error: You must be logged in to add an appointment.";
    exit;
}

// Get the client's ID and email from the session
$client_id = $_SESSION['user_id'];
$client_email = $_SESSION['email'];

// Get the user type from the session or the GET parameter
$user_type = $_GET['role'] ?? ($_SESSION['userType'] ?? null);

// Add appointment
if (isset($_POST['add_appointment'])) {
    $today = date("Y-m-d"); // Get the current date
    $first_name = $_POST['FirstName'];
    $middle_name = $_POST['MiddleName'];
    $last_name = $_POST['LastName'];
    $age = $_POST['Age'];
    $civilstatus = $_POST['civilstatus'];
    $birth_date = date("Y-m-d", strtotime($_POST['date']));
    $birthplace = $_POST['Birthplace'];
    $service = $_POST['service'];
    $appointment_date = ($_POST['appointment_date']);
    

    // Calculate tomorrow and four days later
    $tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));
    $four_days_later = date('Y-m-d', strtotime($today . ' +4 days'));

    // Check if the appointment date is within the allowed range
    if ($appointment_date < $tomorrow || $appointment_date > $four_days_later) {
        
        echo "<script>
            alert('Error: You can only add appointments from tomorrow and up to four days from now!');
            window.location.href = 'blank.php';
          </script>";
        exit;
    }

    // Check if the appointment limit for the day has been reached (30 per day)
    $sql = "SELECT COUNT(*) AS appointment_count 
            FROM appointments 
            WHERE appointment_date = '$appointment_date'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($row['appointment_count'] >= 30) {
        echo "<script>
            alert('Error: Appointment limit of 30 reached for $appointment_date. Please choose another date.');
            window.location.href = 'blank.php';
          </script>";
        exit;
    }

    // Check if the client already has 2 appointments on the selected date
    $sql = "SELECT COUNT(*) AS client_appointment_count 
            FROM appointments 
            WHERE appointment_date = '$appointment_date' AND client_id = '$client_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($row['client_appointment_count'] >= 2) {
        echo "<script>
            alert('Error: You can only book a maximum of 2 appointments per account on the same day.');
            window.location.href = 'blank.php';
          </script>";
        exit;
    }

    // Get the next queue number
    $sql = "SELECT MAX(queue_number) AS max_queue_number 
            FROM appointments 
            WHERE appointment_date = '$appointment_date'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $queue_number = $row['max_queue_number'] + 1;

    // Insert appointment
    $sql = "INSERT INTO appointments VALUES (
        null, '$client_id', '$first_name', '$middle_name', '$last_name', '$age', 
        '$civilstatus', '$birth_date', '$birthplace', '$service', 
        '$appointment_date', '$queue_number', 'Ongoing'
    )";

    if ($conn->query($sql) === TRUE) {
        try {
            $mail = include $_SERVER['DOCUMENT_ROOT'] . '/Project-clinic/mailer.php';
            $mail = getMailer();
            $mail->setFrom("noreply@example.com");
            $mail->addAddress($client_email, $first_name); // Send email to client

            $mail->Subject = "Appointment Confirmation";
            $mail->Body = "
                <h1>Hello $first_name,</h1>
                <p>Your appointment for <strong>$service</strong> has been scheduled on <strong>$appointment_date</strong>.</p>
                <p>Thank you for choosing our clinic!</p>
            ";

            $mail->send();
            echo "<script>
                alert('Appointment added successfully for $appointment_date!');
                window.location.href = 'blank.php';
              </script>";
        } catch (Exception $e) {
            echo "<script>alert('Error: Email could not be sent. {$mail->ErrorInfo}');</script>";
        }
    } else {
        echo "<script>alert('Error adding appointment: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>
