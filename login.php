<?php
session_start();

require_once 'C:/xampp/htdocs/code/GlobalVariables.php'; // Adjust the path as needed
require_once 'Connection.php';
$loginError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check if email or password is empty
        if (empty($email) || empty($password)) {
            $loginError = "Email and password cannot be empty.";
        } else {
            // Check if user exists
            $sql = "SELECT Id, Email, Password, UserType, FName, Address, Phone FROM user WHERE Email = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($Id, $Email, $Password, $UserType, $FName, $Address, $Phone);
                    $stmt->fetch();

                    // Check password (hashed)
                    if (password_verify($password, $Password)) {
                        // Password is valid, proceed with login
                        echo "Password is valid!";
                        // Set session variables
                        $_SESSION['user_id'] = $Id;
                        $_SESSION['email'] = $Email;
                        $_SESSION['name'] = $FName;
                        $_SESSION['userType'] = $UserType;
                    
                        // Set global variables (if necessary)
                        GlobalVariables::$userId = $Id;
                        GlobalVariables::$name = $FName;
                        GlobalVariables::$location = $Address;
                        GlobalVariables::$phone = $Phone;
                        GlobalVariables::$email = $Email;
                        GlobalVariables::$userType = $UserType;
                    
                        // Determine user type and redirect accordingly
                        if (strcasecmp($UserType, 'Admin') === 0) {
                            // Redirect to admin panel
                            header("Location: admin/blank.php");
                            exit();
                        } elseif (strcasecmp($UserType, 'Client') === 0) {
                            // Redirect to client panel
                            header("Location: client/blank.php");
                            exit();
                        }
                    } else {
                        $loginError = "Invalid password.";
                          }
                } else {
                    $loginError = "No user found with this email.";
                }

                $stmt->close();
            } else {
                $loginError = "Database query failed: " . $mysqli->error;
            }
        }
    }
}

$mysqli->close();
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tailwind Login Template by David Grzyb</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .body-bg {
            background-color: #d721e8;
            background-image: linear-gradient(315deg, #e121e8 0%, #ab5fbe 74%);
        }
    </style>
</head>
<body class="body-bg min-h-screen pt-12 md:pt-20 pb-6 px-2 md:px-0" style="font-family: 'Lato', sans-serif;">
    <header class="max-w-lg mx-auto">
        <a href="#">
            <h1 class="text-4xl font-bold text-white text-center">Startup</h1>
        </a>
    </header>

    <main class="bg-white max-w-lg mx-auto p-8 md:p-12 my-10 rounded-lg shadow-2xl">
        <section>
            <h3 class="font-bold text-2xl">Welcome to Startup</h3>
            <p class="text-gray-600 pt-2">Sign in to your account.</p>
        </section>

        <section class="mt-10">
            <form class="flex flex-col" method="POST" action="">
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="email">Email</label>
                    <input type="text" id="email" name="email" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3">
                </div>
                <div class="mb-6 pt-3 rounded bg-gray-200">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="password">Password</label>
                    <input type="password" id="password" name="password" class="bg-gray-200 rounded w-full text-gray-700 focus:outline-none border-b-4 border-gray-300 focus:border-purple-600 transition duration-500 px-3 pb-3">
                </div>
                <div class="flex justify-end">
                    <a href="forgotpass.php" class="text-sm text-purple-600 hover:text-purple-700 hover:underline mb-6">Forgot your password?</a>
                </div>
                <button class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">Sign In</button>
                <?php if (!empty($loginError)) : ?>
                    <p class="text-red-500 mt-4"><?php echo $loginError; ?></p>
                <?php endif; ?>
            </form>
        </section>
    </main>

    <div class="max-w-lg mx-auto text-center mt-12 mb-6">
        <p class="text-white">Don't have an account? <a href="#" class="font-bold hover:underline" onclick="redirectToRegister()">Sign up</a>.</p>
    </div>

    <footer class="max-w-lg mx-auto flex justify-center text-white">
        <a href="#" class="hover:underline">Contact</a>
        <span class="mx-3">•</span>
        <a href="#" class="hover:underline">Privacy</a>
    </footer>

    <script>
        function redirectToRegister() {
            window.location.href = "register.php";
        }
    </script>
</body>
</html>
