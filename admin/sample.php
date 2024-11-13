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

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

      .font-family-karla {
        font-family: karla;
      }

      .bg-sidebar {
        background: #2AAA8A;
      }

      .cta-btn {
        color: #2AAA8A;
      }

      .upgrade-btn:hover {
        background: #ffffff;
      }

      .active-nav-link {
        background: #50C878;
      }

      .nav-item:hover {
        background: #50C878;
      }

      .account-link:hover {
        background: #2AAA8A;
      }
    </style>
  </head>

  <body class="bg-gray-100 font-family-karla flex">

    <aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
      <div class="p-6">
        <a href="index.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
        <button class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
          <i></i> Chit's Clinic
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


      <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
        <main class="w-full flex-grow p-6">
          <h1 class="text-3xl text-black pb-6">Records</h1>

          <div class="w-full mt-6">
            <p class="text-xl pb-3 flex items-center">
              <i class="fas fa-list mr-3"></i>
            </p>
            <table id="appointments" class="display" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>First Name</th>

                  <th>Action</th>
                </tr>
              </thead>
            </table>
          </div>



          </maisn>



          
            </div>
          </div>


        <!-- Modal Structure with DataTable -->
<div id="appointmentModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center hidden">
  <div class="bg-white p-6 rounded-lg max-w-lg w-full">
    <h2 class="text-2xl font-semibold mb-4">Appointments for <span id="clientFullName"></span></h2>
    <table id="appointmentDetailsTable" class="w-full table-auto text-left">
  <thead>
    <tr>
      <th>ID</th>
      <th>Service</th>
      <th>Appointment Date</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

    <button onclick="closeModal()" class="mt-4 bg-red-500 text-white py-2 px-4 rounded">Close</button>
  </div>
</div>

<div id="appointmentModal1" class="flex items-center justify-center min-h-screen absolute inset-0 bg-gray-800/30 backdrop-blur-md w-full h-full top-0 left-0 bg-gray-200 bg-opacity-50 hidden" id="modal-overlay2">
  <div class="bg-white rounded shadow-md w-4/5 h-4/5 max-w-2xl max-h-screen overflow-hidden flex center flex-col overflow-y-auto">
    <div class="flex justify-between items-center p-4 border-b">
      <h5 class="text-lg font-semibold" id="appointmentModal1Label">Appointment Details</h5>
      <button type="button" id="closeModal" class="text-gray-500 hover:text-gray-700">&times;</button>
    </div>
    <div class="modal-body p-4">
      <h4 class="font-semibold">Appointment Information:</h4>
      <table id="appointment-details" class="min-w-full border-collapse border border-gray-300 mb-4">
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

      <!-- Print Button -->
      <button type="button" id="printModal" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Print</button>
    </div>
  </div>
</div>
        

          <script>
             document.getElementById('printModal').addEventListener('click', function() {
    const printContent = document.getElementById('appointmentModal1').innerHTML;
    const printWindow = window.open('', '', 'height=800,width=800');
    
    printWindow.document.write('<html><head><title>Print Appointment</title>');
    printWindow.document.write('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">'); // Optional: Tailwind CSS
    printWindow.document.write('<style>body { margin: 0; padding: 20px; }</style>'); // Custom print styles
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h5 class="text-lg font-semibold">Appointment Details</h5>'); // Title for printed document
    printWindow.document.write(printContent);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
  });
            
            $(document).ready(function() {
              $('#appointments').DataTable({
                "ajax": {
                  "url": "function/data.php",
                  "dataSrc": function(json) {
                    // Filter confirmed appointments with specific services
                    const filteredData = json.filter(item =>
                      item.status.trim() === 'Done'
                    );

                    // Use a Set to store unique full names
                    const uniqueClients = new Set();
                    return filteredData.filter(item => {
                      if (uniqueClients.has(item.FullName)) {
                        return false; // Skip duplicate full names
                      } else {
                        uniqueClients.add(item.FullName);
                        return true; // Keep unique full names
                      }
                    });
                  }
                },
                "columns": [{
                    "title": "ID",
                    "data": "id"
                  },
                  {
                    "title": "Full Name",
                    "data": "FullName"
                  },
                  {
                    "title": "View",
                    "data": null,
                    "render": function(data, type, row) {
                      return `<button class='btn btn-primary' onclick='viewAppointmentsByFullName("${row.FullName}")'>View</button>`;
                    }
                  }
                ],
                "processing": true,
                "serverSide": false
              });








            });
            // Define this function outside any $(document).ready() or other functions
            function viewAppointmentsByFullName(fullName) {
  $.ajax({
    url: 'function/data.php',
    method: 'GET',
    success: function(data) {
      const appointments = data.filter(item => item.FullName === fullName && item.status.trim() === 'Done');
      $('#clientFullName').text(fullName);

      // Call renderTableRows with the filtered data
      renderTableRows(appointments);

      // Show the modal
      $('#appointmentModal').removeClass('hidden');
    }
  });
}

function renderTableRows(data) {
  // Destroy existing DataTable if it exists
  if ($.fn.DataTable.isDataTable('#appointmentDetailsTable')) {
    $('#appointmentDetailsTable').DataTable().clear().destroy();
  }

  // Generate rows for the HTML table
  const rows = data.map(app => `
    <tr>
      <td>${app.id}</td>
      <td>${app.Service}</td>
      <td>${app.appointment_date}</td>
      <td><button class='btn btn-primary' onclick='viewAppointment(${app.id})'>View</button></td>
    </tr>
  `).join('');

  // Insert rows into the table body
  $('#appointmentDetailsTable tbody').html(rows);

  // Initialize DataTable
  $('#appointmentDetailsTable').DataTable({
    paging: true,
    searching: false,
    ordering: true,
    info: false,
    columns: [
      { title: "ID" },
      { title: "Service" },
      { title: "Appointment Date" },
      { title: "Actions" }
    ]
  });
}

function closeModal() {
  $('#appointmentModal').addClass('hidden');
}
function viewAppointment(id) {
    $.ajax({
      type: 'POST',
      url: 'function/viewdata.php',
      data: { id: id, display: 'both' }, // Fetch both appointment and result
      dataType: 'json',
      success: function (response) {
        // Clear existing data
        $('#appointment-details tbody').empty();
        $('#result-details tbody').empty();

        // Check if appointment data exists
        if (response.appointment) {
          $.each(response.appointment, function (key, value) {
            $('#appointment-details tbody').append(`
              <tr>
                <td class="border border-gray-300 p-2">${key}</td>
                <td class="border border-gray-300 p-2">${value}</td>
              </tr>
            `);
          });
        } else {
          $('#appointment-details tbody').append(`
            <tr>
              <td colspan="2" class="border border-gray-300 p-2 text-center">No appointment data found</td>
            </tr>
          `);
        }

        // Check if result data exists
        if (response.result) {
          $.each(response.result, function (key, value) {
            $('#result-details tbody').append(`
              <tr>
                <td class="border border-gray-300 p-2">${key}</td>
                <td class="border border-gray-300 p-2">${value}</td>
              </tr>
            `);
          });
        } else {
          $('#result-details tbody').append(`
            <tr>
              <td colspan="2" class="border border-gray-300 p-2 text-center">No result data found</td>
            </tr>
          `);
        }

        // Show the modal
        $('#appointmentModal1').removeClass('hidden');
      },
      error: function () {
        alert('Error fetching data.');
      }
    });
  }

  // Close modal event
  $('#closeModal').click(function () {
    $('#appointmentModal1').addClass('hidden');
  });

  // Example trigger to open the modal (replace this with your own logic)
  // Assuming you have a button with class 'open-modal' and data-id attribute
  $('.open-modal').click(function () {
    const id = $(this).data('id'); // Get the ID from button attribute
    openAppointmentModal1(id); // Open modal with appointment ID
  });   

          </script>

          <!-- jQuery -->

          <!-- Bootstrap JS -->
          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

          <!-- AlpineJS -->
          <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
          <!-- Font Awesome -->
          <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
  </body>

  </html>