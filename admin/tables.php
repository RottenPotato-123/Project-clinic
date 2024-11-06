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
     
      <!-- Include jQuery library -->
      <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include DataTables library -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script>
  const colors = require('tailwindcss/colors')

module.exports = {
  theme: {
    extend: {
      colors: {
        emerald: colors.emerald,  // Explicitly include the emerald color palette
      },
    },
  },
  content: [
    './src/**/*.{html,js}', // Update paths to include all files where you use Tailwind classes
  ],
}
</script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<!-- Tailwind CSS -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
        .bg-sidebar { background: #2AAA8A; }
        .cta-btn { color: #2AAA8A; }
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
                <h1 class="text-3xl text-black pb-6">Walk in</h1>

                <div class="w-full mt-6">
                    <p class="text-xl pb-3 flex items-center">
                        <i class="fas fa-list mr-3"></i>
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

                <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h1 class="text-3xl text-black pb-6">Online Appointments</h1>

                <div class="w-full mt-6">
                    <p class="text-xl pb-3 flex items-center">
                        <i class="fas fa-list mr-3"></i>
                    </p>
                    <table id="Online" class="display" style="width:100%">
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
                
            </tr>
        </thead>
    </table>
                
            </maisn>
    
            
            <div id="loading" class="hidden fixed top-0 left-0 right-0 bottom-0 flex items-center justify-center bg-gray-600 bg-opacity-50">
  <div class="w-16 h-16 border-4 border-t-4 border-blue-500 border-solid rounded-full animate-spin"></div>
</div>
    <!-- Modal Container -->
    <div id="appointmentModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex justify-center overflow-y-auto z-50 min-h-screen p-4 pt-20">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl max-h-[90vh] overflow-auto">
    <!-- Modal Header -->
    <div class="flex justify-between p-6 text-white rounded-t-lg" style="background-color: #2AAA8A;">
  <h5 class="text-xl font-semibold">Appointment Details</h5>
  <button type="button" id="closeModal" class="text-2xl leading-none hover:text-emerald-300">&times;</button>
</div>

    
    <!-- Modal Body -->
    <div class="p-6 space-y-6">
      <!-- Patient Information -->
      <div class="max-w-2xl mx-auto p-8 bg-white shadow-md border border-gray-300">
        <h2 class="text-lg font-semibold mb-4">Patient Information</h2>
        <div class="mb-4 grid grid-cols-2 gap-4">
          <div class="col-span-1">
            <label class="block font-medium">Patient Name:</label>
            <p id="patientName" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-1">
            <label class="block font-medium">Date:</label>
            <p id="appointmentDate" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-2">
            <label class="block font-medium">Address:</label>
            <p id="address" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-2">
            <label class="block font-medium">Service:</label>
            <p id="service" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-1">
            <label class="block font-medium">Age:</label>
            <p id="age" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-1">
            <label class="block font-medium">Civil Status:</label>
            <p id="civilStatus" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-1">
            <label class="block font-medium">Birthday:</label>
            <p id="birthday" class="border-b border-gray-400 w-full py-1"></p>
          </div>
        </div>

        <!-- OB Report -->
        <h3 class="text-lg font-semibold mt-6 mb-4">OB Report</h3>
        <div class="grid grid-cols-2 gap-4 mb-4">
          <div class="col-span-1">
            <label class="block font-medium">BP (Blood Pressure):</label>
            <p id="bp" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-1">
            <label class="block font-medium">Pulse Rate (PR):</label>
            <p id="pr" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-1">
            <label class="block font-medium">RR (Respiratory Rate):</label>
            <p id="rr" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-1">
            <label class="block font-medium">Temp (Temperature):</label>
            <p id="temp" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-1">
            <label class="block font-medium">FH (Fundal Height):</label>
            <p id="fh" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-1">
            <label class="block font-medium">FHT (Fetal Heart Tone):</label>
            <p id="fht" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-1">
            <label class="block font-medium">IE (Internal Exam):</label>
            <p id="ie" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-1">
            <label class="block font-medium">AOG (Age of Gestation):</label>
            <p id="aog" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-1">
            <label class="block font-medium">LMP (Last Menstrual Period):</label>
            <p id="lmp" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-1">
            <label class="block font-medium">EDC (Expected Date of Confinement):</label>
            <p id="edc" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-1">
            <label class="block font-medium">OB HX (Obstetric History):</label>
            <p id="obHx" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-1">
            <label class="block font-medium">OB Score:</label>
            <p id="obScore" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-1">
            <label class="block font-medium">Admitting Diagnosis:</label>
            <p id="ad" class="border-b border-gray-400 w-full py-1"></p>
          </div>
          <div class="col-span-1">
            <label class="block font-medium">Remarks:</label>
            <p id="remarks" class="border-b border-gray-400 w-full py-1"></p>
          </div>
        </div>

        <h3 class="text-lg font-semibold mt-6 mb-4">Additional Notes</h3>
        <div class="border border-gray-300 h-24 p-4" id="notes"></div>

        <div class="flex justify-between mt-8">
          <div class="text-center">
            <p>Authorized Personnel Signature</p>
            <p class="mt-8 border-t border-gray-400 w-48 mx-auto"></p>
            <p class="mt-2">Date: _______________</p>
          </div>
          <div class="text-center">
            <p>Head of Clinic Signature</p>
            <p class="mt-8 border-t border-gray-400 w-48 mx-auto"></p>
            <p class="mt-2">PACITA R. DULAY</p>
          </div>
        </div>
      </div>

      <!-- Print Button -->
      <div class="flex justify-end mt-6">
        <button type="button" id="printModal" class="px-6 py-2 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none"style="background-color: #2AAA8A;" >
          Print
        </button>
      </div>
    </div>
  </div>
</div>



</div>

    <script>
      
      document.getElementById('printModal').addEventListener('click', function() {
    const printContent = document.getElementById('appointmentModal').innerHTML;
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
        return json.filter(item =>  item.status.trim() === 'Confirmed' &&  item.Service.trim() === 'New Born Care'|| item.Service.trim() === 'New Born Screening'|| item.Service.trim()=== 'Post Partum Care Post Partum' || item.Service.trim() === 'Normal Spontaneous Delivery');
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
        "render": function(data, type, row) {
          return `<button class='btn btn-primary' onclick='viewAppointment(${row.id})'>View</button>`;
        }
      }
    ],
    "processing": true,
    "serverSide": false
  });
  $('#Online').DataTable({
    "ajax": {   
      "url": "function/data.php",
      "dataSrc": function(json) {
        return json.filter(item =>  item.status.trim() === 'Confirmed' &&  item.Service.trim() === 'Counselling'|| item.Service.trim() === 'Family Planning'||item.Service.trim() === 'Ear Piercing'||item.Service.trim() === 'Immunization'||item.Service.trim() === 'Acid Wash');
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
      { "title": "Services", "data": "Service"}
      
    ],
    "processing": true,
    "serverSide": false
  });




});

function viewAppointment(id) {
  // Show loading spinner
  $('#loading').removeClass('hidden');

  $.ajax({
    type: 'POST',
    url: 'function/viewdata.php',
    data: { id: id, display: 'both' },
    dataType: 'json',
    success: function (response) {
      // Hide loading spinner once data is fetched
      $('#loading').addClass('hidden');

      // Check if appointment data exists
      if (response.appointment && Object.keys(response.appointment).length > 0) {
        // Populate the modal fields with appointment data
        $('#patientName').text(`${response.appointment.FirstName} ${response.appointment.MiddleName} ${response.appointment.LastName}`);
        $('#appointmentDate').text(response.appointment.appointment_date);
        $('#address').text(response.result.address);
        $('#service').text(response.appointment.Service);
        $('#age').text(response.appointment.Age);
        $('#civilStatus').text(response.appointment.civil_status);
        $('#birthday').text(response.appointment.birth_date);
        $('#bp').text(response.result.bp);  // This will set the BP value from the result data
        $('#pr').text(response.result.pr);
        $('#rr').text(response.result.rr);
        $('#temp').text(response.result.temp);
        $('#fh').text(response.result.fh);
        $('#fht').text(response.result.fht);
        $('#aog').text(response.result.aog);
        $('#lmp').text(response.result.lmp);
        $('#edc').text(response.result.edc);
        $('#obHx').text(response.result.ob_hx);
        $('#obScore').text(response.result.ob_score);
        $('#remarks').text(response.result.remarks);
        $('#ad').text(response.result.ad);
        // Add more fields as necessary
      }

      // Check if result data exists
      if (response.result && Object.keys(response.result).length > 0) {
       
      }

      // Show the modal
      $('#appointmentModal').removeClass('hidden');
    },
    error: function (xhr, status, error) {
      // Hide loading spinner on error
      $('#loading').addClass('hidden');
      console.log(xhr.responseText); // Log any error response
      alert('Error fetching data.');
    }
  });
}



// Close modal event
$('#closeModal').click(function () {
  $('#appointmentModal').addClass('hidden');
});

// Example trigger to open the modal
$('.open-modal').click(function () {
  const id = $(this).data('id'); // Get the ID from button attribute
  viewAppointment(id); // Open modal with appointment ID
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
