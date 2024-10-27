<?php
session_start();


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
            $sql = "SELECT Id, Email, Password, UserType, FName, Address, Phone ,Status FROM user WHERE Email = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($Id, $Email, $Password, $UserType, $FName, $Address, $Phone, $Status);
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
                        $_SESSION['status'] = $Status;
                        
                       
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
    <title>login</title>
    <meta name="author" content="mike">
    <meta name="description" content="">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .body-bg {
            background-color: #2AAA8A ;
            
        }
    </style>
</head>
<body class="body-bg min-h-screen pt-12 md:pt-20 pb-6 px-2 md:px-0" style="font-family: 'Lato', sans-serif;">
    <header class="max-w-lg mx-auto">

    </header>

    <main class="bg-white max-w-lg mx-auto p-8 md:p-12 my-10 rounded-lg shadow-2xl">
        <section>
            <h3 class="font-bold text-2xl">Welcome</h3>
            <p class="text-gray-600 pt-2">Sign in to your account.</p>
        </section>

        <section class="mt-10">
            <form class="flex flex-col" method="POST" action="">
                <div class="mb-6 pt-3 rounded ">
                    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter your Email" class=" rounded w-full text-gray-700 border border-gray-300  transition duration-500 px-3 pb-3 pr-10 py-3">
                </div>
                <div class="mb-6 pt-3 rounded  relative">
    <label class="block text-gray-700 text-sm font-bold mb-2 ml-3" for="password">Password</label>
    <div class="relative">
    <input 
        type="password" 
        id="password" 
        name="password" 
        class=" rounded w-full text-gray-700   border border-gray-300  transition duration-500 px-3 pb-3 pr-10 py-3"
        placeholder="Enter your password"
    >
    <button 
        type="button" 
        id="toggle-password" 
        class="absolute inset-y-1 right-0 flex items-center pr-3 text-gray-500"
    >
        <svg id="icon-password" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
    </button>
    </div>
</div>

                <div class="flex justify-end">
                    <a href="forgotpass.php" class="text-sm text-green-600 hover:text-green-700 hover:underline mb-6">Forgot your password?</a>
                </div>
                <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded shadow-lg hover:shadow-xl transition duration-200" type="submit">Log In</button>
                <?php if (!empty($loginError)) : ?>
                    <p class="text-red-500 mt-4"><?php echo $loginError; ?></p>
                <?php endif; ?>
            </form>
        </section>
    </main>

    <div class="max-w-lg mx-auto text-center mt-12 mb-6">
        <p class="text-black">Don't have an account? <a href="#" class="font-bold hover:underline" onclick="redirectToRegister()">Sign up</a>. </p>
        <p class="text-black">Go back to
    <a href="#" class="font-bold hover:underline" onclick="redirectToMain()"> Menu</a>.
    </p>
    </div>
   
    <footer class="max-w-lg mx-auto flex justify-center text-white">
    
    </footer>

    <script>
        document.getElementById('toggle-password').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('icon-password');
        
        // Toggle input type between 'password' and 'text'
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';

        // Swap icon between 'eye' and 'eye-off'
        icon.innerHTML = isPassword 
            ? `<path stroke-linecap="round" stroke-linejoin="round" 
                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.978 9.978 0 012.442-3.487m4.673-.757a3 3 0 014.05 4.05m1.664 1.664A9.953 9.953 0 0112 17c-1.02 0-2.007-.15-2.925-.427m8.15 3.252l-12-12" />`
            : `<path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
               <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
    });
        function redirectToRegister() {
            window.location.href = "register.php";
        }
        function redirectToMain() {
            window.location.href = "landingPage.html";
        }
    </script>
</body>
</html>
