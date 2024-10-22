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
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">New Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="w-full px-4 py-2 border-b-4 border-gray-300 rounded focus:outline-none focus:border-teal-500 transition duration-300"
                        required
                    />
                </div>
                <div class="mb-6">
                    <label for="confirm_password" class="block text-gray-700 text-sm font-semibold mb-2">Confirm Password</label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        class="w-full px-4 py-2 border-b-4 border-gray-300 rounded focus:outline-none focus:border-teal-500 transition duration-300"
                        required
                    />
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
