<?php
session_start();

// Determine the user type
$user_type = $_GET['role'] ?? $_SESSION['userType'] ?? null; 
$status = $_GET['stats'] ?? $_SESSION['status'] ?? null;

// Function to check if user is a client and status is active
if ($user_type !== 'Admin' || $status !== 'active') {
    // Redirect to an unauthorized access page or display an error message
    header('Location: ../404.html');
    exit; // Ensure no further code is executed
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
  
    <meta name="description" content="">

    <!-- Tailwind -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
              @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
        .bg-sidebar { background: #2AAA8A; }
        .cta-btn { color: #2AAA8A; }
        .upgrade-btn { background: #50C878; }
        .upgrade-btn:hover { background: #ffffff; }
        .active-nav-link { background: #50C878; }
        .nav-item:hover { background: #50C878; }
        .account-link:hover { background: #2AAA8A; }
    </style>
</head>
<body class="bg-gray-100 font-family-karla flex">

    <aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
        <div class="p-6">
            <a href="index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
            <button class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                <i ></i> Chit's Clinic
            </button>
        </div>
        <nav class="text-white text-base font-semibold pt-3">
                <a href="index.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-chart-line  mr-3"></i> Statistics
                </a>
                <a href="blank.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-calendar mr-3"></i> Appointments
                </a>
                <a href="tables.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-table mr-3"></i> Records
                </a>
                <a href="forms.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-align-left mr-3"></i> Users
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
    // Initialize the initials variable
    $initials = "?"; // Fallback if no name is available

    // Check if session variable is set
    if (isset($_SESSION['name'])) {
        // Get the full name from the session
        $full_name = htmlspecialchars($_SESSION['name']); 

        // Get the first letter of the first name
        $first_name = strtok($full_name, ' '); // Get the first part of the full name

        // Check if $first_name is set
        if ($first_name) {
            $initials = strtoupper(substr($first_name, 0, 1)); // First name initial
        }
    }
    echo $initials; // Display the initials in the button
    ?>
</button>
                <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
                <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">
                    <a href="userSetting" class="block px-4 py-2 account-link hover:text-white">Account</a>
                    
                    <a href="logout.php" class="block px-4 py-2 account-link hover:text-white">Sign Out</a>
                </div>
            </div>
        </header>

        <!-- Mobile Header & Nav -->
        <header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
            <div class="flex items-center justify-between">
                <a href="index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
                <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
                    <i x-show="!isOpen" class="fas fa-bars"></i>
                    <i x-show="isOpen" class="fas fa-times"></i>
                </button>
            </div>

            <!-- Dropdown Nav -->
            <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
            <a href="index.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-tachometer-alt mr-3"></i> Statistics
                    </a>
                    <a href="blank.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-sticky-note mr-3"></i> Appointments
                    </a>
                    <a href="tables.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-table mr-3"></i> records
                    </a>
                    <a href="forms.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-align-left mr-3"></i> users
                    </a>
                    
                  
                    
                    <a href="userSetting.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-user mr-3"></i> My Account
                    </a>
                    <a href="logout.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-sign-out-alt mr-3"></i> Sign Out
                    </a>
                   
                </nav>
            <!-- <button class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                <i class="fas fa-plus mr-3"></i> New Report
            </button> -->
        </header>
        <?php
// Include the database connection file
require_once 'db.php';

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get all users of type 'Client' from the database
$sql = "SELECT * FROM user "; // Adjusted query to filter by user type
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Store the user details in an array
$users = array();
while ($row = $result->fetch_assoc()) {
    $user = array(
        'Id' => $row['Id'], // Ensure you're using the correct column name
        'Email' => $row['Email'],
        'Fname' => $row['FName'],
        'Address' => $row['Address'],
        'Phone' => $row['Phone'],
        'Usertype' => $row['UserType'],
    );
    $users[] = $user; // Add each user to the array
}

// Check if users were found
if (empty($users)) {
    echo "No clients found.";
}

// Store the users in the session
$_SESSION['users'] = $users;

// Close the database connection
$conn->close();
?>

<!-- Include the jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include the DataTables library -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>

<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
    <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-6">Client Users</h1>

        <div class="w-full mt-6">
            <table id="user-table" class="display nowrap w-full text-left table-auto min-w-max">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Full name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>UserType</th>
                        <th>Actions</th> <!-- New column for actions -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['users'] as $user) { ?>
                        <tr data-id="<?= $user['Id'] ?>">
                            <td><?= htmlspecialchars($user['Id']) ?></td>
                            <td><?= htmlspecialchars($user['Email']) ?></td>
                            <td><?= htmlspecialchars($user['Fname']) ?></td>
                            <td><?= htmlspecialchars($user['Address']) ?></td>
                            <td><?= htmlspecialchars($user['Phone']) ?></td>
                            <td><?= htmlspecialchars($user['Usertype']) ?></td>
                            <td>
   



<button class="remove-btn" data-id="<?= $user['Id'] ?>" title="Remove">
    <i class="fas fa-trash-alt"></i> <!-- Remove icon -->
</button></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
    <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-6">Admin account</h1>

        <div class="w-full mt-6">
        <button id="openModal" class="w-max bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                <i class="fas fa-plus mr-3"></i> Add New Admin Account 
             </button><button>Add Admin Account</button>
            <table id="admin-table" class="display nowrap w-full text-left table-auto-max-w-max">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Full name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>UserType</th>
                        <th>Actions</th> <!-- New column for actions -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['users'] as $user) { ?>
                        <tr data-id="<?= $user['Id'] ?>">
                            <td><?= htmlspecialchars($user['Id']) ?></td>
                            <td><?= htmlspecialchars($user['Email']) ?></td>
                            <td><?= htmlspecialchars($user['Fname']) ?></td>
                            <td><?= htmlspecialchars($user['Address']) ?></td>
                            <td><?= htmlspecialchars($user['Phone']) ?></td>
                            <td><?= htmlspecialchars($user['Usertype']) ?></td>

                            <td>
                



<button class="remove-btn1" data-id="<?= $user['Id'] ?>" title="Remove">
    <i class="fas fa-trash-alt"></i> <!-- Remove icon -->
</button></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</div>



<!-- Edit User Modal -->
<div id="edit-user-modal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="modal-content bg-white rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">
        <span class="close text-black cursor-pointer absolute top-2 right-2 text-lg">&times;</span>
        <h2 class="text-2xl font-semibold mb-4">Edit User</h2>
        <form id="edit-user-form">
            <input type="hidden" name="user_id" id="edit-user-id" />
            <div class="mb-4">
                <label for="edit-email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" id="edit-email" name="email" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
            </div>
            <div class="mb-4">
                <label for="edit-fname" class="block text-sm font-medium text-gray-700">Full Name:</label>
                <input type="text" id="edit-fname" name="fname" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
            </div>
            <div class="mb-4">
                <label for="edit-address" class="block text-sm font-medium text-gray-700">Address:</label>
                <input type="text" id="edit-address" name="address" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
            </div>
            <div class="mb-4">
                <label for="edit-phone" class="block text-sm font-medium text-gray-700">Phone:</label>
                <input id="edit-phone" name="phone" placeholder="09xxxxxxxxx" type="tel" required maxlength="11" class="mt-1 block w-full p-2 border border-gray-300 rounded" oninput="this.value = this.value.replace(/[^0-9]/g, '')">

            </div>
            <button type="submit" class="mt-4 bg-blue-600 text-white rounded-md p-2 hover:bg-blue-700">Save Changes</button>
            <button type="button" class="close-modal mt-2 bg-gray-400 text-white rounded-md p-2 hover:bg-gray-500">Close</button> <!-- Close button -->
        </form>
    </div>
</div>

<!-- Edit Password Modal -->
<div id="edit-password-modal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="modal-content bg-white rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">
        <span class="close text-black cursor-pointer absolute top-2 right-2 text-lg">&times;</span>
        <h2 class="text-2xl font-semibold mb-4">Edit Password</h2>
        <form id="edit-password-form">
            <input type="hidden" name="user_id" id="edit-password-id" />
            <div class="mb-4 relative">
    <label for="edit-password" class="block text-sm font-medium text-gray-700">
        New Password:
    </label>
    <div class="relative">
        <input 
            type="password" 
            id="edit-password" 
            name="password" 
            required 
            class="mt-1 block w-full border border-gray-300 rounded-md p-2 pr-12" 
        />
        <!-- Toggle Password Button -->
        <button 
            type="button" 
            id="toggle-password" 
            class="absolute inset-y-0 right-0 flex items-center justify-center w-10 h-full text-gray-500"
        >
            <!-- Default Eye Icon -->
            <svg 
                id="eye-icon" 
                xmlns="http://www.w3.org/2000/svg" 
                class="h-6 w-6" 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor" 
                stroke-width="2"
            >
                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path 
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" 
                />
            </svg>
        </button>
    </div>
</div>

            <button type="submit" class="mt-4 bg-blue-600 text-white rounded-md p-2 hover:bg-blue-700">Change Password</button>
            <button type="button" class="close-modal mt-2 bg-gray-400 text-white rounded-md p-2 hover:bg-gray-500">Close</button>
        </form>
    </div>
</div>


<!-- Delete Confirmation Modal -->
<div id="delete-confirmation-modal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="modal-content bg-white rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">
        <span class="close text-black cursor-pointer absolute top-2 right-2 text-lg">&times;</span>
        <h2 class="text-lg font-semibold mb-4">Are you sure you want to delete this user?</h2>
        <div class="flex justify-end">
            <button id="confirm-delete" class="bg-red-600 text-white rounded-md p-2 hover:bg-red-700 mr-2">Confirm</button>
            <button class="close-modal bg-gray-400 text-white rounded-md p-2 hover:bg-gray-500">Cancel</button>
        </div>
    </div>
</div>

<div id="modal" class="fixed inset-0 flex items-center justify-center hidden bg-gray-800 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-96">
            <div class="p-6">
                <h2 class="text-lg font-bold mb-4">User Information</h2>
                <form id="adminForm" action="function/admin_save.php" method="POST">
    <div class="mb-4">
        <label for="fullName" class="block text-sm font-medium text-gray-700">Full Name</label>
        <input type="text" id="fullName" name="fullName" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
    </div>
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
        <input type="email" id="email" name="email" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
    </div>
    <div class="mb-4">
        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
        <input type="text" id="address" name="address" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
    </div>
    <div class="mb-4">
        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
        <input id="phone" name="phone" placeholder="09xxxxxxxxx" type="tel" required maxlength="11" class="mt-1 block w-full p-2 border border-gray-300 rounded" oninput="this.value = this.value.replace(/[^0-9]/g, '')">

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


    <div class="flex justify-end">
        <button type="button" id="closeModal" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 mr-2">Cancel</button>
        <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">Submit</button>
    </div>
</form>

            </div>
            
        </div>

    </div>







        
        
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
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
   const passwordInput = document.getElementById('edit-password');
    const togglePasswordButton = document.getElementById('toggle-password');
    const eyeIcon = document.getElementById('eye-icon');

    togglePasswordButton.addEventListener('click', () => {
        const isPassword = passwordInput.getAttribute('type') === 'password';
        
        // Toggle the input type between password and text
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

        // Swap the icon between 'eye' and 'eye-off'
        eyeIcon.innerHTML = isPassword 
            ? `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.978 9.978 0 012.442-3.487m4.673-.757a3 3 0 014.05 4.05m1.664 1.664A9.953 9.953 0 0112 17c-1.02 0-2.007-.15-2.925-.427m8.15 3.252l-12-12" />`
            : `<path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
               <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
    });
     const openModalButton = document.getElementById('openModal');
        const modal = document.getElementById('modal');
        const closeModalButton = document.getElementById('closeModal');

        // Open modal
        openModalButton.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        // Close modal
        closeModalButton.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
  $(document).ready(function () {
   
        // Initialize User DataTable
        const appointmentsTable = $('#user-table').DataTable({
            paging: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/English.json"
            },
            createdRow: function (row, data) {
                $(row).attr('data-id', data.Id); // Set data-id on the tr element
            },
            columnDefs: [{ width: "20%", targets: 6 },
            { targets: 5, visible: false } 
            ] // Adjust column width for actions
        });

          // Initialize User DataTable
            const admintables = $('#admin-table').DataTable({
                paging: false,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/English.json"
                },
                createdRow: function (row, data) {
                    $(row).attr('data-id', data.Id); // Set data-id on the tr element
                },
                columnDefs: [{ width: "20%", targets: 6 },
                { targets: 5, visible: false } 
                ] // Adjust column width for actions
            });

        $.fn.dataTable.ext.search.push(
          function(settings, data, dataIndex) {
              if (settings.nTable.id === 'user-table') {
                  const status = data[5]; // Assuming status is in the 7th column (index 6)
                  console.log('Appointments Row data:', data);
                  console.log('Appointments Status:', status);
                  return status && status.trim()  === "Client"; // Filter condition
              }
              return true; // Don't filter for other tables
          }
      );
      $.fn.dataTable.ext.search.push(
          function(settings, data, dataIndex) {
              if (settings.nTable.id === 'admin-table') {
                  const status = data[5]; // Assuming status is in the 7th column (index 6)
                  console.log('Appointments Row data:', data);
                  console.log('Appointments Status:', status);
                  return status && status.trim()  === "Admin"; // Filter condition
              }
              return true; // Don't filter for other tables
          }
      );

        // Handle Edit User button click
        $(document).on('click', '.edit-user-btn', function () {
            const userId = $(this).data('id');
            const rowData = appointmentsTable.row($(this).closest('tr')).data();
            
            // Fill the form with user data
            $('#edit-user-id').val(userId);
            $('#edit-email').val(rowData.Email);
            $('#edit-fname').val(rowData.Fname);
            $('#edit-address').val(rowData.Address);
            $('#edit-phone').val(rowData.Phone);
            
            // Show the Edit User modal
            $('#edit-user-modal').removeClass('hidden');
        });

        // Handle Edit Password button click
        $(document).on('click', '.edit-password-btn', function () {
            const userId = $(this).data('id');
            
            // Set the user ID in the password form
            $('#edit-password-id').val(userId);
            
            // Show the Edit Password modal
            $('#edit-password-modal').removeClass('hidden');
        });
        $(document).on('click', '.edit-password-btn1', function () {
            const userId = $(this).data('id');
            
            // Set the user ID in the password form
            $('#edit-password-id').val(userId);
            
            // Show the Edit Password modal
            $('#edit-password-modal').removeClass('hidden');
        });


        // Handle modal close
        $(document).on('click', '.close, .close-modal', function () {
        $(this).closest('.modal').addClass('hidden');
    });
    $(document).on('click', '.edit-user-btn1', function () {
            const userId = $(this).data('id');
            const rowData = admintables.row($(this).closest('tr')).data();
            
            // Fill the form with user data
            $('#edit-user-id').val(userId);
            $('#edit-email').val(rowData.Email);
            $('#edit-fname').val(rowData.Fname);
            $('#edit-address').val(rowData.Address);
            $('#edit-phone').val(rowData.Phone);
            
            // Show the Edit User modal
            $('#edit-user-modal').removeClass('hidden');
        });

        // Handle Edit Password button click
        $(document).on('click', '.edit-password-btn', function () {
            const userId = $(this).data('id');
            
            // Set the user ID in the password form
            $('#edit-password-id').val(userId);
            
            // Show the Edit Password modal
            $('#edit-password-modal').removeClass('hidden');
        });

        // Handle modal close
        $(document).on('click', '.close, .close-modal', function () {
        $(this).closest('.modal').addClass('hidden');
    });
        // Handle Edit User form submission
// Handle Edit User form submission
$('#edit-user-form').on('submit', function (e) {
    e.preventDefault();
    const userId = $('#edit-user-id').val();
    const email = $('#edit-email').val();
    const fname = $('#edit-fname').val();
    const address = $('#edit-address').val();
    const phone = $('#edit-phone').val();

    // Perform AJAX request to update user
    $.ajax({
        url: 'function/edit_user.php',
        method: 'POST',
        data: {
            user_id: userId,
            email: email,
            fname: fname,
            address: address,
            phone: phone
        },
        success: function (response) {
            alert('User updated successfully!');
            window.location.reload(true);

            $('#edit-user-modal').addClass('hidden'); // Hide the modal
        },
        error: function (xhr, status, error) {
            alert('Error updating user: ' + error);
        }
    });
});

        // Handle Edit Password form submission
        $('#edit-password-form').on('submit', function (e) {
            e.preventDefault();
            const userId = $('#edit-password-id').val();
            const password = $('#edit-password').val();

            // Perform AJAX request to update password
            $.ajax({
                url: 'function/edit_password.php', // Your PHP script to handle the password change
                method: 'POST',
                data: {
                    user_id: userId,
                    password: password
                },
                success: function (response) {
                    alert('Password changed successfully!');
                    $('#edit-password-modal').addClass('hidden'); // Hide the modal
                },
                error: function (xhr, status, error) {
                    alert('Error changing password: ' + error);
                }
            });
        });
        let userIdToDelete; // Variable to store the ID of the user to be deleted

        
    // Handle Remove button click to open confirmation modal
    $(document).on('click', '.remove-btn', function () {
        userIdToDelete = $(this).data('id'); // Get the user ID from the clicked button
        $('#delete-confirmation-modal').removeClass('hidden'); // Show the confirmation modal
    });
    $(document).on('click', '.remove-btn1', function () {
        userIdToDelete = $(this).data('id'); // Get the user ID from the clicked button
        $('#delete-confirmation-modal').removeClass('hidden'); // Show the confirmation modal
    });

    // Handle Confirm Delete button click
    $('#confirm-delete').on('click', function () {
        $.ajax({
            url: 'function/delete_user.php', // Your PHP script to handle the deletion
            method: 'POST',
            data: { user_id: userIdToDelete },
            success: function (response) {
                alert('User deleted successfully!');
                window.location.reload(true);

                $('#delete-confirmation-modal').addClass('hidden'); // Hide the confirmation modal
            },
            error: function (xhr, status, error) {
                alert('Error deleting user: ' + error);
            }
        });
    });

    // Handle modal close
    $(document).on('click', '.close, .close-modal', function () {
        $(this).closest('.modal').addClass('hidden'); // Hide the modal
    });
    });
</script>
</body>
</html>
