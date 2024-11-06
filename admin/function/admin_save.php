<?php
session_start(); // Start the session if you need session management
include '../db.php'; // Correct the path to include db.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordConfirmation = $_POST["password_confirmation"];
    $name = $_POST["fullName"];
    $address = $_POST["address"];
    $phoneNumber = $_POST['phone'];
    $userType = "Admin"; 
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $Status = 'active';

    // Validate input
    if (empty($email) || empty($password) || empty($passwordConfirmation) || empty($name) || empty($address) || empty($phoneNumber)) {
        echo "Please fill in all fields.";
        exit;
    }

    // Check if the passwords match
    if ($password !== $passwordConfirmation) {
        echo "Passwords do not match.";
        exit;
    }

    // Check if the phone number is 11 digits long
    if (strlen($phoneNumber) != 11) {
        echo "Invalid phone number. Please enter an 11-digit number.";
        exit;
    }

    // Check if the email already exists in the database
    $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Email already exists. Please use a different email address.";
        exit;
    }
    
    // Check if the phone number already exists in the database
    $stmt = $conn->prepare("SELECT * FROM user WHERE Phone = ?");
    $stmt->bind_param("s", $phoneNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Phone number already exists. Please use a different phone number.";
        exit;
    }

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO user (Email, Password, Fname, Address, Phone, UserType ,Status) VALUES (?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("sssssss", $email, $hashedPassword, $name, $address, $phoneNumber, $userType,$Status);

    if ($stmt->execute()) {
        echo "User data saved successfully. Redirecting...";
        header("Location: ../forms.php"); // Redirect to login page after successful registration
        exit;
    } else {
        echo "Error saving user data: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
