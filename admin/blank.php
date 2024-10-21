<?php
session_start();
include 'db.php';
// Determine the user type
$user_type = $_GET['role'] ?? (isset($_SESSION['userType']) ? $_SESSION['userType'] : null);
if ($user_type !== 'Admin') {
    // Redirect to an unauthorized access page or display an error message
    header('Location: Project-clinic/login.php');
    exit;
  

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chit's Lying-in Clinic</title>
    <link rel="icon" href="/image/logo.png" type="image/png">
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

                <a href="blank.php" class="flex items-center active-nav-link text-white py-4 pl-6 nav-item">
                    <i class="fas fa-calendar mr-3"></i>Appointments
                </a>
 
                <a href="tables.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-table mr-3"></i> Tables
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
                    <a href="blank.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                        <i class="fas fa-sticky-note mr-3"></i> Appointments
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
    
        <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
          
            <main class="w-full flex-grow p-6">
            <div class="text-right">
            <div class="text-right">
  <button class="w-lg bg-gray cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-end justify-end" onclick="document.getElementById('modal-overlay').classList.toggle('hidden')">
  <i class="fas fa-plus mr-3"></i> New Report
</button>

</div>

</div>
                <?php


// Require the database connection file
require_once 'db.php';

//

// Get all appointments from the database
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
        'FirstName' => $row['FirstName'],
        'LastName' => $row['LastName'],
        'Service' => $row['Service'],
        'appointment_date' => $row['appointment_date'],
        'queue_number' => $row['queue_number'],
        'status' => $row['status']
    );

    $appointments[] = $appointment;
}

// Store the appointments in the session
$_SESSION['appointments'] = $appointments;

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
                <h1 class="text-3xl text-black pb-6">On-going Appointments</h1>

                <div class="w-full mt-6">
                    <p class="text-xl pb-3 flex items-center">
                        <i class="fas fa-list mr-3"></i>
                    </p>
<table id="appointments-table" class="display nowrap w-full text-left table-auto min-w-max">
  <thead> 
    <tr>
      <th>Appointment ID</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Service</th>
      <th>Appointment Date</th>
      <th>Queue Number</th>
      <th>Status</th> 
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($_SESSION['appointments'] as $appointment) { ?>
      <tr data-id="<?= $appointment['Id'] ?>">
        <td><?= $appointment['Id'] ?></td>
        <td><?= $appointment['FirstName'] ?></td>
        <td><?= $appointment['LastName'] ?></td>
        <td><?= $appointment['Service'] ?></td>
        <td><?= $appointment['appointment_date'] ?></td>
        <td><?= $appointment['queue_number'] ?></td>
        <td><?= $appointment['status'] ?></td>
        <td>
          <!-- Actions can be added here -->
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>
</main>
</div>
<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h1 class="text-3xl text-black pb-6">New Appointments</h1>

                <div class="w-full mt-6">
                    <p class="text-xl pb-3 flex items-center">
                        <i class="fas fa-list mr-3"></i>
                    </p>
<!-- Second DataTable: Completed Appointments -->
<table id="pending-table" class="display nowrap w-full text-left table-auto min-w-max mt-4">
  <thead>
    <tr>
      <th>Appointment ID</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Service</th>
      <th>Appointment Date</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($_SESSION['appointments'] as $appointment) { ?>
      <tr data-id="<?= $appointment['Id'] ?>">
        <td><?= $appointment['Id'] ?></td>
        <td><?= $appointment['FirstName'] ?></td>
        <td><?= $appointment['LastName'] ?></td>
        <td><?= $appointment['Service'] ?></td>
        <td><?= $appointment['appointment_date'] ?></td>
        <td><?= $appointment['status'] ?></td>
        <td>
          <!-- Actions can be added here -->
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>

</main>
</div>
<!-- Initialize the DataTable using jQuery -->

            </main>
    
            <div class="fixed top-0 left-0 w-full h-full bg-gray-200 bg-opacity-50 hidden" id="modal-overlay">
  <!-- Modal Content -->
  <div class="bg-white rounded shadow-md w-1/2 h-2/2 p-4 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
    <!-- Header -->
    <h2 class="text-3xl font-bold text-gray-800 mb-4">New Appointment</h2>
    <!-- Form -->
    <form action="add_appointment.php" method="post">
      <!-- Input Fields -->
      <input type="hidden" id="appointment_date" name="appointment_date" />

      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">First Name:</label>
        <input type="text" id="FirstName" name="FirstName" class="w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded"required>
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">Middle Name:</label>
        <input type="text" id="MiddleName" name="MiddleName" class="w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">Last Name:</label>
        <input type="text" id="LastName" name="LastName" class="w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded"required>
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">Age:</label>
        <input type="number" id="Age" name="Age" class="w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded"required>
      </div>
      <div class="mb-4">
        <label for="civilstatus" class="block mb-2 text-gray-700">Civil status:</label>
        <select id="civilstatus" name="civilstatus" class="w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded" required>
       
        <option value="Single">Single</option>
        <option value="Married">Married</option>
        <option value="Separated">Separated</option>
        <option value="Widowed">Widowed</option>
        </select>
   </div>

      <div class="mb-4" >

        <label for="title" class="block mb-2 text-gray-700">Birthdate:</label>
        
        <input type="date" id="date" name="date" class="w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded"required>
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">Birthplace:</label>
        <input type="text" id="Birthplace" name="Birthplace" class="w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded" required>
      </div>
      <!-- Select Field -->
      <div class="mb-4">
        <label for="service" class="block mb-2 text-gray-700">Service:</label>
        <select id="service" name="service" class="w-full p-2 pl-10 text-sm text-gray-700 border border-gray-300 rounded" required>
          <option value="Post Partum Care Post Partum">Post Partum Care Post Partum</option>
          <option value="Normal Spontaneous Delivery">Normal Spontaneous Delivery</option>
          <option value="New Born Screening">New Born Screening</option>
          <option value="New Born Care">New Born Care</option>
        <option value="Counselling">Counselling</option>
          <option value="Family Planning">Family Planning</option>
          <option value="Ear Piercing">Ear Piercing</option>
          <option value="Immunization">Immunization</option>
          <option value="Acid Wash">Acid Wash</option>
        </select>
      </div>
      <!-- Submit Button -->
      <button type="submit" name="add_appointment" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Book Appointment</button>
    </form>
    <!-- Close Button -->
    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded absolute top-0 right-0" onclick="document.getElementById('modal-overlay').classList.toggle('hidden')">Close</button>
  </div>
</div>   


<div class="fixed top-0 left-0 w-full h-full bg-gray-200 bg-opacity-50 hidden" id="modal-overlay2">
  <!-- Modal Content -->
  <div class="bg-white rounded shadow-md w-2/2 h-2/2 p-4 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
    <!-- Header -->
    <h2 class="text-3xl font-bold text-gray-800 mb-4">Records</h2>
    <!-- Form -->
    <form action="result.php" method="post">
      <!-- Input Fields -->
      <input type="text" name="appointment_id" value="" readonly> <!-- Updated input field -->

      
      <input type="hidden" id="" name="" />
      <div class="grid grid-cols-4 gap-4">
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">BP:</label>
        <input type="text" id="BP" name="BP" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">PR:</label>
        <input type="text" id="PR" name="PR" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">RR:</label>
        <input type="text" id="RR" name="RR" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">TEMP:</label>
        <input type="text" id="TEMP" name="TEMP" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">FH:</label>
        <input type="text" id="FH" name="FH" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">FHT:</label>
        <input type="text" id="FHT" name="FHT" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">IE:</label>
        <input type="text" id="IE" name="IE" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">AOG:</label>
        <input type="text" id="AOG" name="AOG" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">LMP:</label>
        <input type="text" id="LMP" name="LMP" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">EDC:</label>
        <input type="text" id="EDC" name="EDC" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">OB HX:</label>
        <input type="text" id="OB_HX" name="OB_HX" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">OB SCORE:</label>
        <input type="text" id="OB_SCORE" name="OB_SCORE" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">ADMITTING DIAGNOSE:</label>
        <input type="text" id="ADMITTING" name="ADMITTING" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">ADDRESS:</label>
        <input type="text" id="ADDRESS" name="ADDRESS" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">REMARKS:</label>
        <input type="text" id="REMARKS" name="REMARKS" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
</div>
      
      <!-- Submit Button -->
      <button type="" name="result" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"onclick="(result)">Submit</button>
    </form>
    <!-- Close Button -->
    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded absolute top-0 right-0" onclick="document.getElementById('modal-overlay2').classList.toggle('hidden')">Close</button>
  </div>
</div>   
<!-- Confirmation Modal -->
<div class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden" id="confirmModal">
    <div class="flex items-center justify-center h-full">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
            <h2 class="text-lg font-semibold mb-4">Confirmation</h2>
            <p>Are you sure you want to delete this appointment?</p>
            <div class="mt-4">
                <button id="confirmDelete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Confirm</button>
                <button class="cancel bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded ml-2">Cancel</button>
            </div>
        </div>
    </div>
</div>

      
    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    
   
    <script>
    $(document).ready(function() {
    // Initialize DataTables with responsive support
    const appointmentsTable = $('#appointments-table').DataTable({
    

        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/English.json"
        },
        "createdRow": function(row, data) {
            $(row).attr('data-id', data.Id); // Set the data-id attribute on the tr element
        },
        "columnDefs": [
            { "width": "20%", "targets": 6 }, // Adjust column width for action buttons
            {
                "targets": 7,
                "render": function(data, type, row) {
                    console.log('Row:', row); // Log the row for debugging
                    console.log('Row ID:', row[0]); // Log the ID (first element of the row)
                    console.log('Service:', row[3]); // Log the service (assuming it's in the 4th column)

                    return `
                        <button 
                            class="confirm-button bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" 
                            data-id="${row[0]}"
                            data-service="${row[3]}" 
                            type="button">
                            Mark as done
                        </button>&nbsp;
                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded delete-btn" 
                            data-id="${row[0]}" 
                            type="button">
                            Delete
                        </button>
                    `;
                }
            }
        ]
    });

     const modalServices  = [
      "Post Partum Care Post Partum",
      "Normal Spontaneous Delivery",
      "New Born Screening",
      "New Born Care"
    ];
    const markAsDoneServices  = [
      "Counselling",
      "Family Planning",
      "Ear Piercing",
      "Immunization",
      "Acid Wash"
    ];
    // Event listener for the confirm button
    $('#appointments-table').on('click', '.confirm-button', function() {
        
      var id = $(this).data('id'); // Retrieve the appointment ID
        console.log('Button data-id:', id); // Log the ID to confirm it's correct
        const service = $(this).data('service');  // Get the service
        console .log('Service:', service); // Log the service to confirm it's correct

        // Update the input field in the modal with the appointment ID
       
        if (modalServices.includes(service)) {
        // Open the modal if the service matches the modal-triggering list
        console.log(`Opening modal for Appointment ID: ${id}`);
        $('#modal-overlay2 input[name="appointment_id"]').val(id);
        $('#modal-overlay2').removeClass('hidden');
    } else if (markAsDoneServices.includes(service)) {
        // If the service is in the "Mark as Done" list, proceed directly
        console.log(`Marking Appointment ID: ${id} as done.`);
        markAsDone(id);  // Call the function to mark as done
    } else {
        console.log(`Service "${service}" is not recognized.`);
    }
    });

    // Filter function for ongoing appointments in the appointments table
      $.fn.dataTable.ext.search.push(
          function(settings, data, dataIndex) {
              if (settings.nTable.id === 'appointments-table') {
                  const status = data[6]; // Assuming status is in the 7th column (index 6)
                  console.log('Appointments Row data:', data);
                  console.log('Appointments Status:', status);
                  return status && status.trim().toLowerCase() === "ongoing"; // Filter condition
              }
              return true; // Don't filter for other tables
          }
      );

    // Draw the appointments table to apply the filter
    

    // Handle row deletion
  $(document).on('click', '.delete-btn', function() {
    console.log('Delete button clicked'); // Log a message to the console
    const appointmentId = $(this).data('id'); // Retrieve the appointment ID
    const row = $(this).closest('tr'); // Get the closest row
    console.log('Appointment ID:', appointmentId); // Log the appointment ID
    $('#confirmDelete').data('id', appointmentId); // Set the ID in the confirm button
    console.log('Confirm delete button ID:', $('#confirmDelete').data('id')); // Log the ID of the confirm button
    $('#confirmModal').removeClass('hidden'); // Show the confirmation modal
    console.log('Modal visible:', $('#confirmModal').is(':visible')); // Log whether the modal is visible

    // Confirm deletion on confirm button click
    $('#confirmDelete').off('click').on('click', function() {
        $.ajax({
            url: 'funtion.php', //q Corrected the URL
            type: 'POST',
            data: { id: appointmentId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    appointmentsTable.row(row).remove().draw(); // Remove the row from DataTable
                    window.location.reload(true);

                    
                } else {
                    alert('Failed to delete data: ' + (response.message || 'Unknown error.'));
                }
                $('#confirmModal').addClass('hidden'); // Hide the modal
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX request failed:', textStatus, errorThrown);
                alert('Error occurred while deleting the data. Check console for details.');
                $('#confirmModal').addClass('hidden'); // Hide the modal on error
            }
        });
    });
});

    // Close modal when cancel button is clicked
    $('.cancel, .close').on('click', function() {
        $('#confirmModal').addClass('hidden'); // Hide the modal
    });

    // Initialize DataTable for pending appointments
    const pendingTable = $('#pending-table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "createdRow": function(row, data) {
            $(row).attr('data-id', data.Id); // Set the data-id attribute on the tr element
        },
        "columnDefs": [
            { "width": "20%", "targets": 6 }, // Adjust column width for action buttons
            {
                "targets": 6,
                "render": function(data, type, row) {
                    console.log('Row:', row); // Log the row for debugging
                    return `
                        <button 
                            class="confirm-btn1 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" 
                            data-id="${row[0]}"
                            type="button"
                            onclick="updateStatus(${row[0]})">
                            Confirm
                        </button>&nbsp;
                        <button class="btn bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded delete-btn" 
                            data-id="${row[0]}" 
                            type="button">
                            Delete
                        </button>
                    `;
                }
            }
        ]
        
    });
   


    // Filter function for pending appointments
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            if (settings.nTable.id === 'pending-table') {
                const status = data[5]; // Assuming status is in the 6th column (index 5)
                console.log('Pending Row data:', data); // Log the entire row for debugging
                console.log('Pending Status:', status); // Log the status to see its value
                return status && status.trim().toLowerCase() === "pending"; // Filter condition for pending appointments
            }
            return true; // Don't filter for other tables
        }
    );
appointmentsTable.draw();
    pendingTable.draw();

    
});



function updateStatus(id) {
    // Make an AJAX request to your server-side script
    $.ajax({
        type: "POST",
        url: "function/update_status.php", // Replace with your server-side script URL
        data: { id: id, status: "ongoing" },
        success: function(response) {
            console.log("Status updated successfully!");
            window.location.reload(true);
        },
        error: function(xhr, status  , error) {
            console.log("Error updating status:", error);
        }
    });
}
 


    
  document.getElementById("close-modal").addEventListener("click", () => {
    const modalOverlay = document.getElementById("modal-overlay");
    modalOverlay.classList.add("hidden");
});
document.getElementById("close-modal").addEventListener("click", () => {
    const modalOverlay = document.getElementById("modal-overlay2");
    modalOverlay.classList.add("hidden");
});

function addAppointment() {
        $.ajax({
            type: 'POST',
            url: 'add_appointment.php',
            data: { add_appointment: 1 },
            success: function(response) {
                alert('Appointment added successfully!');
            },
            error: function(xhr, status, error) {
                alert('Error adding appointment: ' + error);
            }
        });
    }
    fetch('/result.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    BP: $('#BP').val(),
    PR: $('#PR').val(),
    RR: $('#RR').val(),
    TEMP: $('#TEMP').val(),
    FH: $('#FH').val(),
    FHT: $('#FHT').val(),
    IE: $('#IE').val(),
    AOG: $('#AOG').val(),
    LMP: $('#LMP').val(),
    EDC: $('#EDC').val(),
    OB_HX: $('# OB_HX').val(),
    OB_SCORE: $('#OB_SCORE').val(),
    ADMITTING: $('#ADMITTING').val(),
    ADDRESS: $('#ADDRESS').val(),
    REMARKS: $('#REMARKS').val(),
    appointment_id: rowId
  })
})
.then(response => response.json())
.then(data => console.log('Retrieved data:', data))
.catch(error => console.log('Error:', error));
$.ajax({
  type: 'POST',
  url: '/result.php',
  data: { appointment_id: rowId },
  success: function(data) {
    console.log('Retrieved data:', data);
  },
  error: function(xhr, status, error) {
    console.log('Error:', error);
  }
});
function markAsDone(id) {
  $.ajax({
        type: "POST",
        url: "function/update.php", // Replace with your server-side script URL
        data: { id: id, status: "Confirmed" },
        success: function(response) {
            console.log("Status updated successfully!");
            window.location.reload(true);
        },
        error: function(xhr, status  , error) {
            console.log("Error updating status:", error);
        }
    });
}

 </script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</body>
</html>
