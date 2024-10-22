<?php
// Start the session
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to the landing page
header("Location: ../landingPage.html");
exit();
?>