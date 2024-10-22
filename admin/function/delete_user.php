<?php
session_start();
include '../db.php'; // Ensure this path is correct

header('Content-Type: application/json'); // Set JSON response type

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id']) && filter_var($_POST['user_id'], FILTER_VALIDATE_INT)) {
        $user_id = intval($_POST['user_id']);

        // Start a transaction to ensure atomicity
        $conn->begin_transaction();

        try {
            // Delete related records from child table(s)
            $relatedStmt = $conn->prepare("DELETE FROM appointments WHERE client_id = ?");
            $relatedStmt->bind_param("i", $user_id);
            $relatedStmt->execute();
            $relatedStmt->close();

            // Now delete the user record
            $userStmt = $conn->prepare("DELETE FROM user WHERE Id = ?");
            $userStmt->bind_param("i", $user_id);
            $userStmt->execute();

            if ($userStmt->affected_rows > 0) {
                // Commit transaction
                $conn->commit();
                echo json_encode([
                    'status' => 'success',
                    'message' => 'User and related data removed successfully.'
                ]);
            } else {
                throw new Exception('User ID not found.');
            }

            $userStmt->close();
        } catch (Exception $e) {
            // Rollback on any failure
            $conn->rollback();
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to delete user: ' . $e->getMessage()
            ]);
        }

        $conn->close();
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid or missing user ID.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}
?>
