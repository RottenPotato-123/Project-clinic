<?php

// Connect to the database
require_once 'db.php';

// Function to save form data to database
function saveFormData($conn) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        $sql = "INSERT INTO result (bp, pr, rr, temp, fh, fht, ie, aog, lmp, edc, ob_hx, ob_score, ad, address, remarks)
                VALUES ('$BP', '$PR', '$RR', '$TEMP', '$FH', '$FHT', '$IE', '$AOG', '$LMP', '$EDC', '$OB_HX', '$OB_SCORE', '$ADMITTING', '$ADDRESS', '$REMARKS')";

        if (mysqli_query($conn, $sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

// Call the function
saveFormData($conn);

// Close the database connection
mysqli_close($conn);

?>