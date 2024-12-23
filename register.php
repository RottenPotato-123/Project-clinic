<?php
require_once 'Connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordConfirmation = $_POST["password_confirmation"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $phoneNumber = $_POST['phone_number'];
    $userType = "Client"; 
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $status = 'inactive';
    $confirmationCode = bin2hex(random_bytes(16));

    if (empty($email) || empty($password) || empty($passwordConfirmation) || empty($name) || empty($address) || empty($phoneNumber) || empty($userType)) {
        echo "Please fill in all fields.";
        exit;
    }

    if ($password !== $passwordConfirmation) {
        echo "Passwords do not match.";
        exit;
    }

   

   

    if (strlen($phoneNumber) != 11) {
        echo "Invalid phone number. Please enter an 11-digit number.";
        exit;
    }

    $query = "INSERT INTO user (Email, Password, Fname, Address, Phone, UserType, Status, ConfirmationCode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssssssss", $email, $hashedPassword, $name, $address, $phoneNumber, $userType, $status, $confirmationCode);
    $stmt->execute();

    if ($stmt->affected_rows == 1) {
        // Send confirmation email using PHPMailer
       
        try {
            // Server settings
          

            $mail = include $_SERVER['DOCUMENT_ROOT'] . '/Project-clinic/mailer.php';
            $mail = getMailer();
            $mail->setFrom('no-reply@yourdomain.com', 'Your Website Name'); // Your sender email and name
            $mail->addAddress($email); // Add a recipient

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Confirmation';
            $mail->Body    = 'Please click the link below to confirm your email:<br>' .
                             '<a href="http://localhost/Project-clinic/confirmation.php?code=' . $confirmationCode . '">Confirm Email</a>';

            $mail->send();
            echo "<script>alert('Registration successful! A confirmation email has been sent to your email address.'); window.location.href = 'login.php';</script>";
        } catch (Exception $e) {
            echo "Error sending confirmation email: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error saving user data";
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .body-bg {
            background-color: #2AAA8A;
        }
    </style>
    <title>Sign up</title>
</head>
<body>
    <div>
        <div class="body-bg min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <img class="mx-auto h-10 w-auto" src="https://www.svgrepo.com/show/301692/login.svg" alt="Workflow">
                <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">Create a new account</h2>
                <p class="mt-4 text-lg text-center text-sm leading-5 text-white max-w">
                    Or
                    <a href="#" class="login-button underline font-medium text-white-600 hover:text-white-500 focus:outline-none focus:underline transition ease-in-out duration-150" onclick="redirectToLogin()">
                        login to your account
                    </a>
                </p>
                <p class="mt-4 text-lg text-center text-sm leading-5 text-white max-w">

                <a href="#" class="font-bold hover:underline" onclick="redirectToMain()">Back to menu</a>
                </p>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                    <form id="user-form" method="POST" action="#">
                        <div>
                            <label for="name" class="block text-sm font-medium leading-5 text-gray-700">Full Name</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input id="name" name="name" placeholder="John Doe" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="email" class="block text-sm font-medium leading-5 text-gray-700">Email address</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input id="email" name="email" placeholder="user@example.com" type="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="address" class="block text-sm font-medium leading-5 text-gray-700">Address</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input id="address" name="address" placeholder="123 Main St, Anytown, USA" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="phone_number" class="block text-sm font-medium leading-5 text-gray-700">Phone Number</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input id="phone_number" name="phone_number" placeholder="09xxxxxxxxx" type="tel" required maxlength="11" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                        </div>

                        <div class="mb-6 pt-3 rounded  relative">
    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="password">Password</label>
    <div class="relative">
        <input 
            type="password" 
            id="password" 
            name="password" 
            class=" rounded w-full text-gray-700   border border-gray-300   transition duration-500 px-3 pb-3 pr-10 py-2"
            placeholder="Enter your password"
        >
        <button 
            type="button" 
            id="toggle-password" 
            class="absolute inset-y-1 right-0 flex items-center pr-3 text-gray-500"
            onclick="togglePasswordVisibility('password', 'icon-password')"
        >
        <svg id="icon-password" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
        </button>
    </div>
</div>

<div class="mb-6 pt-3 rounded  relative">
    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="password_confirmation">Confirm Password</label>
    <div class="relative">
        <input 
            type="password" 
            id="password_confirmation" 
            name="password_confirmation" 
            class=" rounded w-full text-gray-700   border border-gray-300  transition duration-500 px-3 pb-3 pr-10 py-2"
            placeholder="Confirm your password"
        >
        <button 
            type="button" 
            id="toggle-confirm-password" 
            class="absolute inset-y-1 right-0 flex items-center pr-3 text-gray-500"
            onclick="togglePasswordVisibility('password_confirmation', 'icon-confirm-password')"
        >
        <svg id="icon-confirm-password" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
        </button>
    </div>
</div>

                        <div class="mt-6">
                            <span class="block w-full rounded-md shadow-sm">
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                    Create account
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
         function togglePasswordVisibility(passwordFieldId, iconId) {
        const passwordField = document.getElementById(passwordFieldId);
        const icon = document.getElementById(iconId);

        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.innerHTML =  `<path stroke-linecap="round" stroke-linejoin="round" 
                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.978 9.978 0 012.442-3.487m4.673-.757a3 3 0 014.05 4.05m1.664 1.664A9.953 9.953 0 0112 17c-1.02 0-2.007-.15-2.925-.427m8.15 3.252l-12-12" />`        ; // Eye icon
        } else {
            passwordField.type = "password";
            icon.innerHTML = '<path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />'; // Original icon
        }
    }
        document.getElementById('user-form').addEventListener('submit', function (event) {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            // Validate password length
            if (password.length < 6 ) {
                alert("Password must be between 6 and 8 characters.");
                event.preventDefault(); // Prevent form submission
                return;
            }

            // Validate if passwords match
            if (password !== passwordConfirmation) {
                alert("Passwords do not match.");
                event.preventDefault(); // Prevent form submission
                return;
            }
        });

        function redirectToLogin() {
            window.location.href = "login.php"; 
        }
        function redirectToMain() {
            window.location.href = "landingPage.html";
        }
        document.getElementById('email').addEventListener('blur', function() {
        const email = this.value;
        checkEmailAndPhone(email, document.getElementById('phone_number').value);
    });

    document.getElementById('phone_number').addEventListener('blur', function() {
        const phoneNumber = this.value;
        checkEmailAndPhone(document.getElementById('email').value, phoneNumber);
    });

    function checkEmailAndPhone(email, phoneNumber) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'validate.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.email) {
                    alert(response.email);
                }
                if (response.phone) {
                    alert(response.phone);
                }
            }
        };
        xhr.send('email=' + encodeURIComponent(email) + '&phone_number=' + encodeURIComponent(phoneNumber));
    }
    </script>
</body>
</html>
