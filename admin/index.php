<?php
session_start();

// Determine the user type
$user_type = $_GET['role'] ?? $_SESSION['userType'] ?? null; 
$status = $_GET['stats'] ?? $_SESSION['status'] ?? null;

// Function to check if user is a client and status is active
if ($user_type !== 'Admin' || $status !== 'active') {
    // Redirect to an unauthorized access page or display an error message
    header('Location: ../login.php');
    exit; // Ensure no further code is executed
}
include 'db.php'; // Correct the path to include db.php





$userResult = $conn->query("SELECT COUNT(*) AS user_count FROM user WHERE UserType = 'Client'  AND Status = 'active'");

$appointmentResult = $conn->query("SELECT COUNT(*) AS total_appointments FROM appointments");
$pendingResult = $conn->query("SELECT COUNT(*) AS pending_appointments FROM appointments WHERE status = 'pending'");
$doneResult = $conn->query("SELECT COUNT(*) AS done_appointments FROM appointments WHERE status = 'Confirmed'");

// Store results
$userCount = $userResult->fetch_assoc()['user_count'];
$totalAppointments = $appointmentResult->fetch_assoc()['total_appointments'];
$pendingAppointments = $pendingResult->fetch_assoc()['pending_appointments'];
$doneAppointments = $doneResult->fetch_assoc()['done_appointments'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
                    <i ></i> Chit's Clinic
                </button>
            </div>
            <nav class="text-white text-base font-semibold pt-3">
                <a href="index.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-chart-line mr-3"></i> Statistics
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
                    <a href="userSetting.php" class="block px-4 py-2 account-link hover:text-white">Account</a>
                    
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
                    <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-sign-out-alt mr-3"></i> Sign Out
                    </a>
               
            </nav>
            <!-- <button class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                <i class="fas fa-plus mr-3"></i> New Report
            </button> -->
        </header>

        <div class="w-full overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h1 class="text-5xl text-black pb-6">Dashboard</h1>


       <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 p-4 gap-6">
  <!-- User Count Card -->
  <div class="bg-gradient-to-r from-blue-500 to-blue-700 shadow-lg rounded-xl flex items-center p-5 border-b-4 border-blue-800 transition-transform transform hover:scale-105 text-white">
    <div class="flex justify-center items-center w-16 h-16 bg-white rounded-full shadow-lg transition-transform duration-300 group-hover:rotate-12">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
    </div>
    <div class="text-right flex-1">
      <p class="text-3xl font-semibold"><?php echo $userCount; ?></p>
      <p class="text-lg">Users</p>
    </div>
  </div>

  <!-- Appointments Count Card -->
  <div class="bg-gradient-to-r from-green-500 to-green-700 shadow-lg rounded-xl flex items-center p-5 border-b-4 border-green-800 transition-transform transform hover:scale-105 text-white">
    <div class="flex justify-center items-center w-16 h-16 bg-white rounded-full shadow-lg">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
      </svg>
    </div>
    <div class="text-right flex-1">
      <p class="text-3xl font-semibold"><?php echo $totalAppointments; ?></p>
      <p class="text-lg">Appointments</p>
    </div>
  </div>

  <!-- Pending Appointments Card -->
  <div class="bg-gradient-to-r from-yellow-500 to-yellow-700 shadow-lg rounded-xl flex items-center p-5 border-b-4 border-yellow-800 transition-transform transform hover:scale-105 text-white">
    <div class="flex justify-center items-center w-16 h-16 bg-white rounded-full shadow-lg">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-yellow-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
      </svg>
    </div>
    <div class="text-right flex-1">
      <p class="text-3xl font-semibold"><?php echo $pendingAppointments; ?></p>
      <p class="text-lg">Pending Appointments</p>
    </div>
  </div>

  <!-- Done Appointments Card -->
  <div class="bg-gradient-to-r from-purple-500 to-purple-700 shadow-lg rounded-xl flex items-center p-5 border-b-4 border-purple-800 transition-transform transform hover:scale-105 text-white">
    <div class="flex justify-center items-center w-16 h-16 bg-white rounded-full shadow-lg">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-purple-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </div>
    <div class="text-right flex-1">
      <p class="text-3xl font-semibold"><?php echo $doneAppointments; ?></p>
      <p class="text-lg">Done Appointments</p>
    </div>
  </div>
</div>

    
     
    
                <div id="chartContainer" style="height: 300px; width: 100%;"></div>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>

                
            </main>
    
           
            

        </div>
        
         
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <!-- ChartJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

    <script>
window.onload = function () {
        // Fetch appointment data from the server
        $.ajax({
            url: 'function/fecth.php', // Path to your PHP script
            method: 'GET',
            dataType: 'json',
            success: function(appointments) {
                // Prepare data points for the chart
                var dataPoints = appointments.map(function(appointment) {
                    return { label: appointment.service, y: parseInt(appointment.count) };
                });

                // Construct options for the chart
                var options = {
                    title: {
                        text: "Appointments by Service"              
                    },
                    data: [              
                        {
                            type: "column",
                            dataPoints: dataPoints
                        }
                    ]
                };

                // Render the chart
                $("#chartContainer").CanvasJSChart(options);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data: " + error);
            }
        });
    }
            </script>
</body>
</html>
