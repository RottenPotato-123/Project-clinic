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
     
      <!-- Include jQuery library -->
      <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    
    <!-- Include DataTables library -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<!-- Tailwind CSS -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

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

    <aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
        <div class="p-6">
            <a href="index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
            <button class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                <i class="fas fa-plus mr-3"></i> New Report
            </button>
        </div>
        <nav class="text-white text-base font-semibold pt-3">
                <a href="index.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                    <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                </a>
                <a href="blank.php" class="flex items-center active-nav-link text-white py-4 pl-6 nav-item">
                    <i class="fas fa-sticky-note mr-3"></i> Blank Page
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
      

        <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h1 class="text-3xl text-black pb-6">Tables</h1>

                <div class="w-full mt-6">
                    <p class="text-xl pb-3 flex items-center">
                        <i class="fas fa-list mr-3"></i>Counselling
                    </p>
                    <table id="appointments" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Age</th>
                <th>Civil Status</th>
                <th>Birth Date</th>
                <th>Birth Place</th>
                <th>appointment_date</th>
                <th>Status</th>
                <th>Services</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
                </div>

                <div class="w-full mt-12">
                    <p class="text-xl pb-3 flex items-center">
                        <i class="fas fa-list mr-3"></i> Table Example
                    </p>
                    <div class="bg-white overflow-auto">
                        <table class="text-left w-full border-collapse"> <!--Border collapse doesn't work on this site yet but it's available in newer tailwind versions -->
                            <thead>
                                <tr>
                                    <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Name</th>
                                    <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Last Name</th>
                                    <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Phone</th>
                                    <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-grey-lighter">
                                    <td class="py-4 px-6 border-b border-grey-light">Lian</td>
                                    <td class="py-4 px-6 border-b border-grey-light">Smith</td>
                                    <td class="py-4 px-6 border-b border-grey-light">622322662</td>
                                    <td class="py-4 px-6 border-b border-grey-light">jonsmith@mail.com</td>
                                </tr>
                                <tr class="hover:bg-grey-lighter">
                                    <td class="py-4 px-6 border-b border-grey-light">Lian</td>
                                    <td class="py-4 px-6 border-b border-grey-light">Smith</td>
                                    <td class="py-4 px-6 border-b border-grey-light">622322662</td>
                                    <td class="py-4 px-6 border-b border-grey-light">jonsmith@mail.com</td>
                                </tr>
                                <tr class="hover:bg-grey-lighter">
                                    <td class="py-4 px-6 border-b border-grey-light">Lian</td>
                                    <td class="py-4 px-6 border-b border-grey-light">Smith</td>
                                    <td class="py-4 px-6 border-b border-grey-light">622322662</td>
                                    <td class="py-4 px-6 border-b border-grey-light">jonsmith@mail.com</td>
                                </tr>
                                <tr class="hover:bg-grey-lighter">
                                    <td class="py-4 px-6 border-b border-grey-light">Lian</td>
                                    <td class="py-4 px-6 border-b border-grey-light">Smith</td>
                                    <td class="py-4 px-6 border-b border-grey-light">622322662</td>
                                    <td class="py-4 px-6 border-b border-grey-light">jonsmith@mail.com</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="pt-3 text-gray-600">
                        Source: <a class="underline" href="https://tailwindcomponents.com/component/table">https://tailwindcomponents.com/component/table</a>
                    </p>
                </div>

                <div class="w-full mt-12">
                    <p class="text-xl pb-3 flex items-center">
                        <i class="fas fa-list mr-3"></i> Table Example
                    </p>
                    
                    </div>
                    <p class="pt-3 text-gray-600">
                        Source: <a class="underline" href="https://tailwindcomponents.com/component/table-responsive-with-filters">https://tailwindcomponents.com/component/table-responsive-with-filters</a>
                    </p>
                </div>
            </main>
    
            <footer class="w-full bg-white text-right p-4">
                Built by <a target="_blank" href="https://davidgrzyb.com" class="underline">David Grzyb</a>.
            </footer>

            <div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
<!-- Button to trigger the modal -->
<button class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded" onclick="viewAppointment(1)">View Appointment</button>

<!-- Modal -->
<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body max-h-96 overflow-y-auto"> <!-- Add max height and overflow -->
        <h4>Appointment Information:</h4>
        <table id="appointment-details" class="min-w-full border-collapse border border-gray-300">
          <thead>
            <tr class="bg-gray-100">
              <th class="border border-gray-300 p-2">Field</th>
              <th class="border border-gray-300 p-2">Details</th>
            </tr>
          </thead>
          <tbody>
            <!-- Appointment data will be inserted here -->
          </tbody>
        </table>

        <h4 class="font-semibold mt-4">Result:</h4>
        <table id="result-details" class="min-w-full border-collapse border border-gray-300">
          <thead>
            <tr class="bg-gray-100">
              <th class="border border-gray-300 p-2">Field</th>
              <th class="border border-gray-300 p-2">Result</th>
            </tr>
          </thead>
          <tbody>
            <!-- Result data will be inserted here -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


        </div>
        
    </div>
    <!-- Add this modal window HTML element to your page -->
<!-- Add this modal window HTML element to your page -->

    <script>
$(document).ready(function() {
  $('#appointments').DataTable({
    "ajax": {
      "url": "function/data.php",
      "dataSrc": function(json) {
        return json.filter(item => item.status.toLowerCase() === 'confirmed' && item.Service.toLowerCase() === 'counselling');
      }
    },
    "columns": [
      { "title": "ID", "data": "id" },
      { "title": "Full Name", "data": "FullName" },
      { "title": "Age", "data": "Age" },
      { "title": "Civil Status", "data": "civil_status" },
      { "title": "Birth Date", "data": "birth_date" },
      { "title": "Birth Place", "data": "birth_place" },
      { "title": "Appointment Date", "data": "appointment_date" },
      { "title": "Status", "data": "status", "visible": false },
      { "title": "Services", "data": "Service", "visible": false },
      {
        "title": "View",
        "data": null,
        "defaultContent": "<button class='btn btn-primary'>View</button>"
      }
    ],
    "columnDefs": [
      {
        "targets": 9, // assuming the "View" column is the 9th column (0-indexed)
        "render": function(data, type, row) {
          return `<button class='btn btn-primary' onclick='viewAppointment(${row.id})'>View</button>`;
        }
      }
    ],
    "responsive": {
      "details": {
        "display": $.fn.dataTable.Responsive.display.modal({
          "header": function(row) {
            var data = row.data();
            return `Appointment Details for ${data.FullName}`;
          }
        }),
        "renderer": function(api, rowIdx, columns) {
          var data = api.row(rowIdx).data();
          var html = "<table class='min-w-full border-collapse border border-gray-300'>";
          html += "<tr class='bg-gray-100'><th class='border border-gray-300 p-2'>Full Name:</th><td class='border border-gray-300 p-2'>" + data.FullName + "</td></tr>";
          html += "<tr><th class='border border-gray-300 p-2'>Age:</th><td class='border border-gray-300 p-2'>" + data.Age + "</td></tr>";
          html += "<tr><th class='border border-gray-300 p-2'>Civil Status:</th><td class='border border-gray-300 p-2'>" + data.civil_status + "</td></tr>";
          html += "<tr><th class='border border-gray-300 p-2'>Birth Date:</th><td class='border border-gray-300 p-2'>" + data.birth_date + "</td></tr>";
          html += "<tr><th class='border border-gray-300 p-2'>Birth Place:</th><td class='border border-gray-300 p-2'>" + data.birth_place + "</td></tr>";
          html += "<tr><th class='border border-gray-300 p-2'>Appointment Date:</th><td class='border border-gray-300 p-2'>" + data.appointment_date + "</td></tr>";
          html += "<tr><th class='border border-gray-300 p-2'>Status:</th><td class='border border-gray-300 p-2'>" + data.status + "</td></tr>";
          html += "<tr><th class='border border-gray-300 p-2'>Services:</th><td class='border border-gray-300 p-2'>" + data.Service + "</td></tr>";
          html += "</table>";
          return html;
        }
      }
    },
    "processing": true,
    "serverSide": false
  });
});

function viewAppointment(id) {
  console.log("View appointment with ID:", id);
  
  // Get the appointment details from the database result table and appointment table
  $.ajax({
    type: "POST",
    url: "function/viewdata.php", // Path to your PHP file that retrieves appointment details
    data: { id: id },
    dataType: "json",
    success: function(data) {
      // Populate the modal window with appointment details
      var appointmentTable = $("#appointment-details tbody");
      var resultTable = $("#result-details tbody"); // Add a new table for result data
      
      appointmentTable.html(""); // Clear the appointment table
      resultTable.html(""); // Clear the result table
      
      $.each(data.appointment, function(key, value) {
        appointmentTable.append(`<tr><th class="border border-gray-300 p-2">${key}:</th><td class="border border-gray-300 p-2">${value}</td></tr>`);
      });
      
      $.each(data.result, function(key, value) {
        resultTable.append(`<tr><th class="border border-gray-300 p-2">${key}:</th><td class="border border-gray-300 p-2">${value}</td></tr>`);
      });
      
      // Show the modal window
      $("#appointmentModal").modal("show");
    },
    error: function(xhr, status, error) {
      console.error("AJAX Error:", error);
      // Handle errors (optional)
    }
  });
}

function closeModal() {
  $("#appointmentModal").modal("hide");
}

    </script>


    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
</body>
</html>
