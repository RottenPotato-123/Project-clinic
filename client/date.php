<?php
if (isset($_POST['date'])) {
    $selectedDate = $_POST['date'];
    // Process the selected date here
    echo 'You selected: ' . $selectedDate;
    exit;
}
?>