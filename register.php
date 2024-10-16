<?php
require_once 'Connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordConfirmation = $_POST["password_confirmation"]; // Get password confirmation
    $name = $_POST["name"];
    $address = $_POST["address"];
    $phoneNumber = $_POST['phone_number'];
    $userType = "Client"; 
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (empty($email) || empty($password) || empty($passwordConfirmation) || empty($name) || empty($address) || empty($phoneNumber) || empty($userType)) {
        echo "Please fill in all fields.";
        exit;
    }

    // Check if the passwords match
    if ($password !== $passwordConfirmation) {
        echo "Passwords do not match.";
        exit;
    }

    // Check if the email already exists in the database
    $query = "SELECT * FROM user WHERE Email = '$email'";
    $result = mysqli_query($mysqli, $query);
    if (mysqli_num_rows($result) > 0) {
        ?>
        <script>
            alert("Email already exists. Please use a different email address.");
            window.location.href = "register.php"; 
        </script>
        <?php
        exit;
    }

    // Check if the phone number already exists in the database
    $query = "SELECT * FROM user WHERE Phone = '$phoneNumber'";
    $result = mysqli_query($mysqli, $query);
    if (mysqli_num_rows($result) > 0) {
        ?>
        <script>
            alert("Phone number already exists. Please use a different phone number.");
            window.location.href = "register.php"; 
        </script>
        <?php
        exit;
    }

    // Check if the phone number is 11 digits long
    if (strlen($phoneNumber) != 11) {
        echo "Invalid phone number. Please enter an 11-digit number.";
        exit;
    }

    $query = "INSERT INTO user (Email, Password, Fname, Address, Phone, UserType) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssssss", $email, $hashedPassword, $name, $address, $phoneNumber, $userType);
    $stmt->execute();

    if ($stmt->affected_rows == 1) {
        echo "User data saved successfully";
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
    <title>Clinic</title>
</head>
<body>
    <div>
        <div class="body-bg min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <img class="mx-auto h-10 w-auto" src="https://www.svgrepo.com/show/301692/login.svg" alt="Workflow">
                <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">Create a new account</h2>
                <p class="mt-4 text-lg text-center text-sm leading-5 text-white max-w">
                    Or
                    <a href="#" class="login-button underline font-medium text-green-600 hover:text-green-500 focus:outline-none focus:underline transition ease-in-out duration-150" onclick="redirectToLogin()">
                        login to your account
                    </a>
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

                        <div class="mt-6">
                            <label for="password" class="block text-sm font-medium leading-5 text-gray-700">Password</label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input id="password" name="password" type="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="password_confirmation" class="block text-sm font-medium leading-5 text-gray-700">Confirm Password</label>
                            <div class="mt-1 rounded-md shadow-sm">
                                <input id="password_confirmation" name="password_confirmation" type="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                        </div>

                        <div class="mt-6">
                            <span class="block w-full rounded-md shadow-sm">
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
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
    </script>
</body>
</html>
