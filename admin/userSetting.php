<?php
session_start();
include 'db.php';
// Determine the user type
$user_type = $_GET['role'] ?? $_SESSION['userType'] ?? null; 
$status = $_GET['stats'] ?? $_SESSION['status'] ?? null;

// Function to check if user is a client and status is active
if ($user_type !== 'Admin' || $status !== 'active') {
    // Redirect to an unauthorized access page or display an error message
    header('Location: ../login.php');
    exit; // Ensure no further code is executed
}

if (!isset($_SESSION['user_id'])) {
    // Redirect to login if session is not set
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; // Get user ID from session

// Fetch the data from the database
$sql = "SELECT FName, Email, Address, Phone, Password FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user data is available
$user = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Tailwind CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
        .bg-sidebar { background: #3d68ff; }
        .cta-btn { color: #3d68ff; }
        .upgrade-btn { background: #1947ee; }
        .upgrade-btn:hover { background: #0038fd; }
        .active-nav-link { background: #1947ee; }
        .nav-item:hover { background: #1947ee; }
        .account-link:hover { background: #3d68ff; }
    </style>
</head>
<body class="bg-gray-100 font-family-karla flex">

        <!-- Blank page content for clients -->
        <aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
            <div class="p-6">
                <a href="index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
                <button class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                    <i ></i> Chit's Clinic
                </button>
            </div>
            <nav class="text-white text-base font-semibold pt-3">
                <a href="index.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-chart-line  mr-3"></i> Dashboard
                </a>
                <a href="blank.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-sticky-note mr-3"></i>Appointments
                </a>
                <a href="forms.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-align-left mr-3"></i> Users
                </a>
               
               
               
                <a href="tables.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-calendar mr-3"></i> Calendar
                </a>
            </nav>
           
        </aside>

        <div class="relative w-full flex flex-col h-screen overflow-y-hidden">
            <!-- Desktop Header -->
            <header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
                <div class="w-1/2"></div>
                <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
                <button @click="isOpen = !isOpen" class="relative z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none bg-gray-300 flex items-center justify-center text-white font-bold text-xl">
    <?php 
    // Assuming 'FName' holds the full name
    $full_name = htmlspecialchars($user['FName']); 
    
    // Initialize the initials variable
    $initials = "?"; // Fallback if no name is available

    // Check if full name is set and not empty
    if (!empty($full_name)) {
        // Get the first letter of the first name
        $first_name = strtok($full_name, ' '); // Get the first part of the full name
        $initials = strtoupper(substr($first_name, 0, 1)); // First name initial
    }
    ?>
    <span class="text-center" style="font-size: 1.5rem;"><?= $initials; ?></span>
</button>







                    <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
                    <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">
                        <a href="userSetting.php" class="block px-4 py-2 account-link hover:text-white">Account</a>
                        
                        <a href="logout.php" class="block px-4 py-2 account-link hover:text-white">Sign Out</a>
                    </div>
                </div>
            </header>

            <!-- Mobile Header & Nav -->
            <header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
                <div class="flex items-center justify-between">
                    <a href="index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
                    <button @click="isOpen = !isOpen" class="relative z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
    <div class="flex items-center justify-center w-full h-full bg-gray-300 text-white font-bold text-lg">
        <?php 
        // Get the first letter of the full name
        $full_name = htmlspecialchars($user['FName']); // Assuming 'FName' holds the full name
        echo strtoupper(substr($full_name, 0, 1)); 
        ?>
    </div>
</button>

                </div>
                <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
                    <a href="index.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                    </a>
                    <a href="blank.php" class="flex items-center active-nav-link text-white py-2 pl-4 nav-item">
                        <i class="fas fa-sticky-note mr-3"></i> Appointments
                    </a>
                   
                    <a href="calendar.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-calendar mr-3"></i> Calendar
                    </a>
                    <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-cogs mr-3"></i> Support
                    </a>
                    <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-user mr-3"></i> My Account
                    </a>
                    <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-sign-out-alt mr-3"></i> Sign Out
                    </a>
                    
                </nav>
            </header>

            <div class="w-full h-screen flex items-center justify-center bg-gray-50">
        <div class="w-full max-w-lg p-6 bg-white shadow-lg rounded-lg">
            <form action="update.php" method="POST">

                <!-- First Name -->
                <div class="mb-4">
                    <label for="FName" class="block text-sm font-medium text-indigo-900">Full name</label>
                    <input type="text" id="FName" name="FName" 
                        class="w-full p-2.5 mt-1 border rounded-lg bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        value="<?php echo htmlspecialchars($user['FName']); ?>" required>
                </div>

                <!-- Last Name -->
                

                <!-- Email -->
                <div class="mb-4">
                    <label for="Email" class="block text-sm font-medium text-indigo-900">Email</label>
                    <input type="email" id="Email" name="Email" 
                        class="w-full p-2.5 mt-1 border rounded-lg bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        value="<?php echo htmlspecialchars($user['Email']); ?>" required>
                </div>

                <!-- Phone Number -->
                <div class="mb-4">
                    <label for="Phone" class="block text-sm font-medium text-indigo-900">Phone Number</label>
                    <input type="number" id="Phone" name="Phone" 
                        class="w-full p-2.5 mt-1 border rounded-lg bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        value="<?php echo htmlspecialchars($user['Phone']); ?>" required>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                        class="px-5 py-2.5 text-white bg-indigo-700 hover:bg-indigo-800 rounded-lg focus:ring-4 focus:outline-none focus:ring-indigo-300">
                        Save
                    </button>
                    
                </div>
                </form>
                <form action="change_password.php"id="passwordForm" method="POST">

                <!-- Password Section -->
                <div class="mb-6">
                    <h2 class="text-lg font-medium text-indigo-900 mb-4">Change Password</h2>

                    <!-- Current Password -->
                    <div class="mb-4">
                        <label for="current_password" class="block text-sm font-medium text-indigo-900">Current Password</label>
                        <input type="password" id="current_password" name="current_password"
                            class="w-full p-2.5 mt-1 border rounded-lg bg-indigo-50 focus:ring-2 focus:ring-indigo-400"
                            placeholder="Enter your current password" required>
                    </div>

                    <!-- New Password -->
                    <div class="mb-4">
                        <label for="new_password" class="block text-sm font-medium text-indigo-900">New Password</label>
                        <input type="password" id="new_password" name="new_password"
                            class="w-full p-2.5 mt-1 border rounded-lg bg-indigo-50 focus:ring-2 focus:ring-indigo-400"
                            placeholder="Enter a new password" required>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="mb-4">
                        <label for="confirm_password" class="block text-sm font-medium text-indigo-900">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password"
                            class="w-full p-2.5 mt-1 border rounded-lg bg-indigo-50 focus:ring-2 focus:ring-indigo-400"
                            placeholder="Re-enter new password" required>
                    </div>

                    <!-- Update Password Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-5 py-2.5 text-white bg-indigo-700 hover:bg-indigo-800 rounded-lg focus:ring-4 focus:ring-indigo-300">
                            Update Password
                        </button>
                    </div>
                </div>
                </form>

        </div>
    </div>

            </div>

        <!-- AlpineJS -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <!-- Font Awesome -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
   
        <script>
            function validatePasswords(password, passwordConfirmation, event) {
    // Check password length
    if (password.length < 6 ) {
        alert("Password must be 6 characters.");
        event.preventDefault(); // Prevent form submission
        return false;
    }

    // Validate if passwords match
    if (password !== passwordConfirmation) {
        alert("Passwords do not match.");
        event.preventDefault(); // Prevent form submission
        return false;
    }

    // All checks passed
    return true;
}
document.getElementById('passwordForm').addEventListener('submit', function(event) {
    const password = document.getElementById('new_password').value;
    const passwordConfirmation = document.getElementById('confirm_password').value;

    // Call the validation function
    if (!validatePasswords(password, passwordConfirmation, event)) {
        console.log("Password validation failed."); // For debugging purposes
    }
});

        </script>
</body>


</html>
