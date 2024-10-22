<?php
session_start();

// Determine the user type
$user_type = $_GET['role'] ?? (isset($_SESSION['userType']) ? $_SESSION['userType'] : null);

if ($user_type !== 'Admin') {
    // Redirect to an unauthorized access page or display an error message
    header('Location: unauthorized_access.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Admin Template</title>
    <meta name="author" content="David Grzyb">
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
                <i class="fas fa-plus mr-3"></i> New Report
            </button>
        </div>
        <nav class="text-white text-base font-semibold pt-3">
                <a href="index.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-tachometer-alt mr-3"></i> Statistics
                </a>
                <a href="blank.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-sticky-note mr-3"></i> Appointments
                </a>
                <a href="tables.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-table mr-3"></i> Tables
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
                <button @click="isOpen = !isOpen" class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
                    <img src="https://source.unsplash.com/uJ8LNVCBjFQ/400x400">
                </button>
                <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
                <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">
                    <a href="#" class="block px-4 py-2 account-link hover:text-white">Account</a>
                    <a href="#" class="block px-4 py-2 account-link hover:text-white">Support</a>
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
                        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                    </a>
                    <a href="blank.php" class="flex items-center active-nav-link text-white py-2 pl-4 nav-item">
                        <i class="fas fa-sticky-note mr-3"></i> Blank Page
                    </a>
                    <a href="tables.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-table mr-3"></i> Tables
                    </a>
                    <a href="forms.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-align-left mr-3"></i> Forms
                    </a>
                    <a href="tabs.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-tablet-alt mr-3"></i> Tabbed Content
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
$sql = "SELECT * FROM user WHERE UserType = 'Client'"; // Adjusted query to filter by user type
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
                            <td>
                            <button class="edit-user-btn" data-id="<?= $user['Id'] ?>" title="Edit User">
    <i class="fas fa-user-edit"></i> <!-- Edit User icon -->
</button>

<button class="edit-password-btn" data-id="<?= $user['Id'] ?>" title="Edit Password">
    <i class="fas fa-lock-open"></i> <!-- Edit Password icon -->
</button>

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
                <input type="text" id="edit-phone" name="phone" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
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
                <label for="edit-password" class="block text-sm font-medium text-gray-700">New Password:</label>
                <input type="password" id="edit-password" name="password" required class="mt-1 block w-full border border-gray-300 rounded-md p-2" />
                <!-- Show Password Button -->
                <button type="button" id="toggle-password" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-600">
                    👁️
                </button>
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



        
        
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function () {
    $('#toggle-password').on('click', function () {
        const passwordInput = $('#edit-password');
        const passwordFieldType = passwordInput.attr('type');

        if (passwordFieldType === 'password') {
            passwordInput.attr('type', 'text'); // Change to text to show password
        } else {
            passwordInput.attr('type', 'password'); // Change back to password
        }
    });
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
            columnDefs: [{ width: "20%", targets: 5 }] // Adjust column width for actions
        });

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
