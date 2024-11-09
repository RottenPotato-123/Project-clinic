<?php
require_once 'Connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $phoneNumber = $_POST['phone_number'] ?? '';

    $response = [];

    // Check if the email exists
    if (!empty($email)) {
        $query = "SELECT * FROM user WHERE Email = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $response['email'] = 'Email already exists.';
        }
    }

    // Check if the phone number exists
    if (!empty($phoneNumber)) {
        $query = "SELECT * FROM user WHERE Phone = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $phoneNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $response['phone'] = 'Phone number already exists.';
        }
    }

    echo json_encode($response);
}
$mysqli->close();
?>