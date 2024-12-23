<?php
session_start();
require_once 'db.php';
// Determine the user type
$user_type = $_GET['role'] ?? (isset($_SESSION['userType']) ? $_SESSION['userType'] : null);

// Function to check if user is client

if ($user_type !== 'Client') {
    // Redirect to an unauthorized access page or display an error message
    header('Location: ../404.html');
    exit;
}
$user_id = $_SESSION['user_id']; // Ensure you set this when user logs in


// Prepare and execute query to get the first name
$query = "SELECT Fname FROM user WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the first name
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $first_name = $user['Fname']; // Store first name
} else {
    $first_name = 'Guest'; // Fallback in case user not found
}

$_SESSION['name'] = $first_name; // assuming you want to store the name in session

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Tailwind CSS -->
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
  

  
        <!-- Blank page content for clients -->
        <aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
            <div class="p-6">
                <a href="index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Client</a>
                <button class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                    <i ></i> Chit's Clinic
                </button>
            </div>
            <nav class="text-white text-base font-semibold pt-3">
                <a href="index.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-hashtag mr-3"></i> Queuing
                </a>
                <a href="blank.php" class="flex items-center active-nav-link text-white py-4 pl-6 nav-item">
                    <i class="fas fa-sticky-note mr-3"></i> Appointments
                </a>
               
               
               
                <a href="calendar.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-table mr-3"></i> records
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
                        <a href="userSetting.php" class="block px-4 py-2 account-link hover:text-white">Account</a>
                        
                        <a href="logout.php" class="block px-4 py-2 account-link hover:text-white">Sign Out</a>
                    </div>
                </div>
            </header>

            <!-- Mobile Header & Nav -->
            <header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
                <div class="flex items-center justify-between">
                    <a href="index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Client</a>
                    <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
                        <i x-show="!isOpen" class="fas fa-bars"></i>
                        <i x-show="isOpen" class="fas fa-times"></i>
                    </button>
                </div>
                <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
                    <a href="index.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                    </a>
                    <a href="blank.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-table mr-3"></i> Appointments
                    </a>
                   
                    <a href="calendar.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-table mr-3"></i> records
                    </a>
                    
                    <a href="userSetting.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-user mr-3"></i> My Account
                    </a>
                    <a href="logout.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-sign-out-alt mr-3"></i> Sign Out
                    </a>
                    
                </nav>
            </header>

               <?php
// Include the database connection file
require_once 'db.php';

// Get the user_id from the session if needed
// $user_id = $_SESSION['user_id']; // Uncomment if user_id is needed for filtering appointments

$today = date('Y-m-d');

// Query to get all appointments scheduled for today
$query = "SELECT * FROM appointments WHERE DATE(appointment_date) = '$today'";
$result = $conn->query($query);

// Check for SQL errors
if ($result === false) {
    die("SQL error: " . $conn->error);
}

// Store appointments in a session variable for display
$_SESSION['appointments_today'] = [];
$user_id = $_SESSION['user_id']; // Ensure you set this when the user logs in

$sql = "SELECT updated_at FROM appointments WHERE status = 'Confirmed'";
$result = $conn->query($sql);

$time = array();
while ($row = $result->fetch_assoc()) {
    $time[] = $row['updated_at'];
}


// Get appointments for the logged-in user
// Get appointments for the logged-in user
$sql = "SELECT * FROM appointments WHERE client_id = ?"; // Changed Id to user_id
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // Bind the user_id to the query
$stmt->execute();
$result = $stmt->get_result();

// Store the appointments in an array
$appointments = array();
while ($row = $result->fetch_assoc()) {
    $appointment = array(
        'Id' => $row['id'],
        'client_id' => $row['client_id'],
        'FirstName' => $row['FirstName'],
        'LastName' => $row['LastName'],
        'Service' => $row['Service'],
        'appointment_date' => $row['appointment_date'],
        'queue_number' => $row['queue_number'],
        'status' => $row['status']
    );

        $_SESSION['appointments_today'][] = $appointment; // Store each appointment in the session
    }
    $sql = "SELECT * FROM appointments";
    $result = $conn->query($sql);
    
    // Store the appointments in an array
    $appointments = array();
    while ($row = $result->fetch_assoc()) {
        // Get the client's name from the database
        $client_sql = "SELECT FName FROM user WHERE Id = '$row[client_id]'";
        $client_result = $conn->query($client_sql);
        $client_row = $client_result->fetch_assoc();
    
        $appointment = array(
            'Id' => $row['id'],
            'Client_id' => $row['client_id'],
            'FirstName' => $row['FirstName'],
            'LastName' => $row['LastName'],
            'Service' => $row['Service'],
            'appointment_date' => $row['appointment_date'],
            'queue_number' => $row['queue_number'],
            'status' => $row['status'],
            'Time' => $row['updated_at']
        );
    
        $appointments[] = $appointment;
    }
    
    // Store the appointments in the session
    $_SESSION['appointments'] = $appointments;
    $serviceTimes = [
        'Counselling' => 45,         // in minutes
        'Family Planning' => 25,
        'Ear Piercing' => 8,
        'Immunization' => 12,
        'Acid Wash' => 25
    ];
    $totalAppointmentsToday = count($_SESSION['appointments_today']);
    usort($_SESSION['appointments_today'], function ($a, $b) {
        return $a['queue_number'] - $b['queue_number'];
    });
    
    // Initialize the last appointment time to the first `updated_at` if it exists
    $lastAppointmentTime = isset($time[0]) ? new DateTime($time[0]) : null;

// Close the database connection
$conn->close();
?>           <!-- Include the jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include the DataTables library -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>


<main class="w-min flex-grow p-10">
    <h1 class="text-2xl text-black pb-6">ONGOING QUEUE</h1>

    <!-- Adjusted class for table width and responsiveness -->
    <table id="Ongoing_Que" class="display nowrap max-w-xs text-left table-auto min-w-[250x]">
        <thead>
            <tr>
                <th class="p-1 text-2xl">Appointment ID</th>
                <th class="p-1 text-2xl">Queue Number</th>
                <th class="p-1 text-2xl">Service</th>
                <th class="p-1 text-2xl">Status</th>
                
                <th class="p-1 text-2xl"></th> <!-- New column -->
            </tr>
        </thead>
        <tbody>
        <?php
            // Define service and time mappings
            $serviceTimess = [
                'Counselling' => '30m to 1h',
                'Family Planning' => '20m to 30m',
                'Ear Piercing' => '5m to 10m',
                'Immunization' => '10m to 15m',
                'Acid Wash' => '20m to 30m'
            ];

            // Get the current client_id from the session
            $currentClientId = $_SESSION['user_id']; // Adjust according to your session data

            // Loop through appointments
            foreach ($_SESSION['appointments'] as $appointment) {
                // Check if the status is "Confirm" and the client_id matches
                $message = '';
                if ($appointment['status'] === 'Confirmed' && $appointment['Client_id'] == $currentClientId) {
                    $message = 'Your appointment is going to be admitted';
                }
                
                
        ?>  
            <tr data-id="<?= $appointment['Id'] ?>">
                <td class="p-1 text-2x1"><?= $appointment['Id'] ?></td>
                <td class="p-1 text-2x1"><?= $appointment['queue_number'] ?></td>
                <td class="p-1 text-2x1"><?= $appointment['Service'] ?></td>
                <td class="p-1 text-2x1"><?= $appointment['status'] ?></td>
                
                <td class="p-1 text-2x1"><?= $message ?></td> <!-- Display the message -->
            </tr>
        <?php } ?>
        </tbody>
    </table>
</main>


<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
    <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-6">Your Appointments</h1>

        <div class="w-full mt-6">
            <p class="text-xl pb-3 flex items-center">
                <i class="fas fa-list mr-3"></i>
            </p>
            <table id="appointments-table" class="display nowrap w-full text-left table-auto min-w-max">
                <thead>
                    <tr>
                        <th>Appointment ID</th>
                        <th>Client ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Service</th>
                        <th>Appointment Date</th>
                        <th>Estimated Admission Time</th> <!-- New Column -->
                        <th>Queue Number</th>
                        <th>Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($_SESSION['appointments_today'] as $appointment) {
                        // Calculate estimated admission time based on the last appointment's time
                        if ($lastAppointmentTime) {
                            $serviceDuration = isset($serviceTimes[$appointment['Service']]) ? $serviceTimes[$appointment['Service']] : 0;
                            $lastAppointmentTime->modify("+{$serviceDuration} minutes");
                            $estimatedTime = $lastAppointmentTime->format('H:i');
                        } else {
                            $estimatedTime = "N/A";
                        }

                        // Update the last appointment time to the current calculated time
                        $lastAppointmentTime = new DateTime($lastAppointmentTime->format('Y-m-d H:i'));
                    ?>
                    <tr data-id="<?= $appointment['Id'] ?>">
                        <td><?= $appointment['Id'] ?></td>
                        <td><?= $appointment['client_id'] ?></td>
                        <td><?= $appointment['FirstName'] ?></td>
                        <td><?= $appointment['LastName'] ?></td>
                        <td><?= $appointment['Service'] ?></td>
                        <td><?= $appointment['appointment_date'] ?></td>
                        <td><?= $estimatedTime ?></td> <!-- Display Estimated Time -->
                        <td><?= $appointment['queue_number'] ?></td>
                        <td><?= $appointment['status'] ?></td>
                        
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</div>



        <!-- AlpineJS -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <!-- Font Awesome -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
 
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>  
<script>
       
        

    $(document).ready(function () {
    // Initialize Appointments DataTable
    const appointmentsTable = $('#appointments-table').DataTable({
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
        { targets: [1], visible: false } // Hide the first column (Client ID)

        ] // Adjust column width
    });

    // Initialize Ongoing Queue DataTable
    const Ongoing_Que = $('#Ongoing_Que').DataTable({
        paging: false,
        ordering: true,
        info: false,
        autoWidth: false,
        responsive: true,
        
        createdRow: function (row, data) {
            
            $(row).attr('data-id', data.Id); // Set data-id on the tr element
        },
        columnDefs: 
        [
            { targets: 3, visible: false },
            { targets: 0, visible: false }, // Hide the Appointment ID column
            { width: "30%", targets: 4 }] // Adjust column width
    });
    $('#Ongoing_Que_filter').addClass('hidden');

    // Single filter function for both tables
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        let status;
       let clientId;

        // Filter for 'appointments-table' (Assuming status is in the 7th column)
        if (settings.nTable.id === 'appointments-table') {
            const clientIdToFilter = '<?php echo $user_id; ?>';
            status = data[8]?.trim(); // Status in column index 6
            clientId = data[1]?.trim(); // Assuming client ID is in column index 1
            console.log('Client ID:', clientId);
            console.log(' ID:', clientIdToFilter)
           

            console.log('Appointments Row Data:', data);
            console.log('Appointments Status:', status);
            const isStatusMatch = status  === 'Ongoing' ; // Check if status is ongoing or pending

            const shouldDisplayRow = clientId === clientIdToFilter;

console.log('Should Display Row:', shouldDisplayRow); // Log whether the row should be displayed
return shouldDisplayRow && isStatusMatch;
}

        // Filter for 'Ongoing_Que' (Assuming status is in the 5th column)
        if (settings.nTable.id === 'Ongoing_Que') {
            status = data[3]?.trim(); // Status in column index 4
            console.log('Ongoing Queue Row Data:', data);
            console.log('Ongoing Queue Status:', status);
            return status  === 'Confirmed'; // Filter condition
        }

        // Allow all rows for other tables
        return true;
    });

    // Redraw tables when filters are applied
    appointmentsTable.draw();
    Ongoing_Que.draw();
});

</script>

</html>
