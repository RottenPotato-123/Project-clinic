<?php
if (!isset($_GET["token"])) {
    die("Token is required.");
}

$token = $_GET["token"];
$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/Connection.php";

// Query to find the user by token hash
$sql = "SELECT * FROM user WHERE reset_token_hash = ?";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("Failed to prepare statement: " . $mysqli->error);
}

$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("Token not found.");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Token has expired.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-teal-600 min-h-screen flex items-center justify-center">
    <main class="bg-white border-2 border-white rounded-lg shadow-lg p-8 w-full max-w-md">
        <section>
            <h3 class="text-2xl font-bold text-center mb-6">Reset Password</h3>
        </section>

        <section>
            <form action="process-reset-password.php" method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>"/>
                <div class="mb-6 relative">
    <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">New Password</label>
    <div class="relative">
    <input 
        type="password" 
        id="password" 
        name="password" 
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-500 transition duration-300 pr-10"
        required
    />
    <button 
        type="button" 
        id="toggle-password" 
        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500"
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

<div class="mb-6 relative">
    <label for="confirm_password" class="block text-gray-700 text-sm font-semibold mb-2">Confirm Password</label>
    
    <div class="relative">
        <input 
        type="password" 
        id="confirm_password" 
        name="confirm_password" 
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-teal-500 transition duration-300 pr-10"
        required
    />
    <button 
        type="button" 
        id="toggle-confirm-password" 
        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500"
        onclick="togglePasswordVisibility('confirm_password', 'icon-confirm-password')"
    >
        
        <svg id="icon-confirm-password" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
    </button>
</div>
</div>

                <button 
                    type="submit" 
                    class="w-full bg-teal-500 text-white py-2 rounded hover:bg-teal-600 transition duration-300"
                >
                    Reset Password
                </button>
            </form>
        </section>
    </main>

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
        function validatePassword(password, passwordConfirmation) {
            if (password.length < 8) {
                alert("Password must be at least 8 characters.");
                return false;
            }

            if (!/[a-zA-Z]/.test(password)) {
                alert("Password must contain at least one letter.");
                return false;
            }

            if (!/[0-9]/.test(password)) {
                alert("Password must contain at least one number.");
                return false;
            }

            if (password !== passwordConfirmation) {
                alert("Passwords do not match.");
                return false;
            }

            return true; // All checks passed
        }

        // Attach event listener to the form
        document.querySelector("form").addEventListener("submit", function (e) {
            const password = document.getElementById("password").value;
            const passwordConfirmation = document.getElementById("confirm_password").value;

            if (!validatePassword(password, passwordConfirmation)) {
                e.preventDefault(); // Prevent form submission if validation fails
            }
        });
    </script>
</body>
</html>
