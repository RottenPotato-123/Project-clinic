<?php
// Connect to the database
require_once 'db.php';

function insertData($conn) {
    // Check if the request is a POST request
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Debug: Check if appointment_id is passed
       
        
        // Ensure appointment_id exists and is valid
        if (isset($_POST["appointment_id"]) && !empty($_POST["appointment_id"])) {
            $appointment_id = (int)$_POST["appointment_id"]; // Cast to int for safety
        } else {
            echo "Appointment ID is required";
            exit;
        }
        
        // Retrieve other form data from the POST request
        $BP = $_POST["BP"];
        $PR = $_POST["PR"];
        $RR = $_POST["RR"];
        $TEMP = $_POST["TEMP"];
        $FH = $_POST["FH"];
        $FHT = $_POST["FHT"];
        $IE = $_POST["IE"];
        $AOG = $_POST["AOG"];
        $LMP = $_POST["LMP"];
        $EDC = $_POST["EDC"];
        $OB_HX = $_POST["OB_HX"];
        $OB_SCORE = $_POST["OB_SCORE"];
        $ADMITTING = $_POST["ADMITTING"];
        $ADDRESS = $_POST["ADDRESS"];
        $REMARKS = $_POST["REMARKS"];

        // Validate user input
        if (empty($BP) || empty($PR) || empty($RR) || empty($TEMP) || empty($FH) || empty($FHT) || empty($IE) || empty($AOG) || empty($LMP) || empty($EDC) || empty($OB_HX) || empty($OB_SCORE) || empty($ADMITTING) || empty($ADDRESS) || empty($REMARKS)) {
            echo "Please fill in all fields";
            exit;
        } else {
            // Insert the data into the result table, including the foreign key appointment_id
            $sql = "INSERT INTO result (id, bp, pr, rr, temp, fh, fht, ie, aog, lmp, edc, ob_hx, ob_score, ad, address, remarks)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Prepare the statement
            $stmt = mysqli_prepare($conn, $sql);
            
            if ($stmt === false) {
                echo "Error preparing statement: " . mysqli_error($conn);
                exit;
            }
            
            // Bind the parameters
            mysqli_stmt_bind_param($stmt, "isssssssssssssss", $appointment_id, $BP, $PR, $RR, $TEMP, $FH, $FHT, $IE, $AOG, $LMP, $EDC, $OB_HX, $OB_SCORE, $ADMITTING, $ADDRESS, $REMARKS);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "New record created successfully";

                // Update the status of the appointment to "confirmed"
                $update_sql = "UPDATE appointments SET status = 'Confirmed' WHERE id = ?";
                $update_stmt = mysqli_prepare($conn, $update_sql);
                mysqli_stmt_bind_param($update_stmt, "i", $appointment_id);
                
                // Execute the update statement
                if (mysqli_stmt_execute($update_stmt)) {
                    echo "<script>
    alert('Record added successfully for !');
    window.location.href = 'blank.php';
  </script>";
                } else {
                    echo "Error updating appointment status: " . mysqli_stmt_error($update_stmt);
                }
                
                // Close the update statement
                mysqli_stmt_close($update_stmt);

            } else {
                echo "Error: " . mysqli_stmt_error($stmt);
            }
            
            // Close the statement
            mysqli_stmt_close($stmt);
        }
    }
}

// Call the function and pass the $conn variable
insertData($conn);
?>
