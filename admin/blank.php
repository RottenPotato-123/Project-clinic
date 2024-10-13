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
        .upgrade-btn:hover { background: #fcfcfc; }
        .active-nav-link { background: #50C878; }
        .nav-item:hover { background: #50C878; }
        .account-link:hover { background: #2AAA8A; }
    </style>
</head>
<body class="bg-gray-100 font-family-karla flex">

    <aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
        <div class="p-6">
            <a href="index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
            <button class="w-full bg-white cta-tn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                <i class="fas fa-plus mr-3"></i> New Report
            </button>
        </div>
        <nav class="text-white text-base font-semibold pt-3">
                <a href="index.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                </a>
                <a href="blank.php" class="flex items-center active-nav-link text-white py-4 pl-6 nav-item">
                    <i class="fas fa-sticky-note mr-3"></i> Appointments
                </a>
                <a href="tables.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-table mr-3"></i> Tables
                </a>
                <a href="forms.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-align-left mr-3"></i> Forms
                </a>
                <a href="tabs.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-tablet-alt mr-3"></i> Tabbed Content
                </a>
                <a href="calendar.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-calendar mr-3"></i> Calendar
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
       <td><?= ($appointment['Service'])  ?></td>
      <td><?= $appointment['appointment_date'] ?></td>
      <td><?= $appointment['queue_number'] ?></td>
      <td><?= $appointment['status'] ?></td>
      <td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<!-- Initialize the DataTable using jQuery -->

            </main>
    
            <div class="fixed top-0 left-0 w-full h-full bg-gray-200 bg-opacity-50 hidden" id="modal-overlay">
  <!-- Modal Content -->
  <div class="bg-white rounded shadow-md w-1/2 h-2/2 p-4 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
    <!-- Header -->
    <h2 class="text-3xl font-bold text-gray-800   mb-4">New Appointment</h2>
    <!-- Form -->
    <form action="add_appointment.php" method="post">
      <!-- Input Fields -->
      <input type="hidden" id="appointment_date" name="appointment_date" />

      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">First Name:</label>
        <input type="text" id="FirstName" name="FirstName" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">Middle Name:</label>
        <input type="text" id="MiddleName" name="MiddleName" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">Last Name:</label>
        <input type="text" id="LastName" name="LastName" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">Age:</label>
        <input type="text" id="Age" name="Age" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <div class="mb-4">
        <label for="title" class="block mb-2 text-gray-700">Address:</label>
        <input type="text" id="Address" name="Address" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
      </div>
      <!-- Select Field -->
      <div class="mb-4">
        <label for="service" class="block mb-2 text-gray-700">Service:</label>
        <select id="service" name="service" class="w-full p-2 pl-1 text-sm text-gray-700 border border-gray-300 rounded">
          <option value="Counselling">Counselling</option>
          <option value="Family Planning">Family Planning</option>
          <option value="Ear Piercing">Ear Piercing</option>
          <option value="Immunization">Immunization</option>
          <option value="Acid Wash">Acid Wash</option>
        </select>
      </div>
      <!-- Submit Button -->
      <button type="submit" name="add_appointment" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"onclick="addAppointment()">Book Appointment</button>
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
<div id="confirmModal" class="modal hidden">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>Are you sure you want to delete this item?</p>
        <button id="confirmDelete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Confirm</button>
        <button class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded cancel">Cancel</button>
    </div>
</div>



    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    
   
    <script>
    
   $(document).ready(function() {
    
    // Initialize DataTables with responsive support
    $('#appointments-table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,  // Enable responsive behavior
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/English.json"
      },
      "createdRow": function(row, data, dataIndex) {
    $(row).attr('data-id', data.Id); // Set the data-id attribute on the tr element
  },
    "columnDefs": [
  { "width": "20%", "targets": 6 },  // Adjust column width for action buttons
  {
    "targets": 7,
  "render": function(data, type, row) {
    console.log('Row:', row); // Log the row for debugging
    console.log('Row ID:', row[0]); // Log the ID (first element of the row)
    return `
      <button 
          class="confirm-button bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" 
        data-toggle="modal" 
        data-target="modal-overlay2" 
         data-id="${row[0]}"
         onclick="document.getElementById('modal-overlay2').classList.toggle('hidden')" 
        type="button">
        Confirm
      </button>&nbsp;
    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded delete-btn" 
      data-id="${row[0]}" 
      type="button">
      Delete
  </button>
 `;
}

  },
]
      
    });
    var table = $('#appointments-table').DataTable();
  // Add an event listener to the confirm button
  $('#appointments-table').on('click', '.confirm-button', function() {
    var id = $(this).attr('data-id'); // Retrieve the appointment ID
    console.log('Button data-id:', id); // Log the ID to confirm it's correct

    // Update the input field in the modal with the appointment ID
    $('#modal-overlay2 input[name="appointment_id"]').val(id);

    // Show the modal
    $('#modal-overlay2').removeClass('hidden');
});


function confirmClick(id) {
    alert('Confirming appointment with ID: ' + id);
    // Additional confirmation logic
}
$.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            const status = data[6]; // Assuming the status is in the 7th column (index 6)
            console.log('Row data:', data); // Log the entire row data for debugging
            console.log('Status:', status); // Log the status to see its value
            return status && status.trim().toLowerCase() === "pending"; // Filter condition
        }
    );

    // Draw the table to apply the filter
    table.draw();


   // Handle row deletion
   $(document).on('click', '.delete-btn', function() {
            const appointmentId = $(this).data('id');

        var rowId = $(this).data('id'); // Get the ID from the button
        var row = $(this).closest('tr'); // Get the closest row
        $('#confirmDelete').data('id', rowId); // Set the ID in the confirm button
        $('#confirmModal').removeClass('hidden'); // Show the confirmation modal

        // Confirm deletion on confirm button click
        $('#confirmDelete').off('click').on('click', function() {
            $.ajax({
                url: 'funtion.php', // Update with your actual PHP file
                type: 'POST',
                data: { id: rowId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        table.row(row).remove().draw(); // Remove the row from DataTable
                        alert('Data deleted successfully!'); // Notify the user
                    } else {
                        alert('Failed to delete data: ' + (response.message || 'Unknown error.'));
                    }
                    $('#confirmModal').addClass('hidden'); // Hide the modal
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX request failed:', textStatus, errorThrown);
                    console.error('Response Text:', jqXHR.responseText);
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

  });
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

 </script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</body>
</html>
