<?php
// Include the connection file
include '../conn.php';

// Check connection
if (!$con) {
    die("Database connection is not initialized.");
}

// Handle deletion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure machine_id is provided
    if (!isset($_POST['machine_id']) || empty($_POST['machine_id'])) {
        die("Machine ID is required.");
    }

    // Sanitize input to ensure it's a valid integer
    $machineId = intval($_POST['machine_id']);

    // Retrieve the photo path from the database
    $sql = "SELECT machine_photo FROM machines WHERE machine_id = ?";
    $stmt = $con->prepare($sql);

    if (!$stmt) {
        die("Prepare statement failed: " . $con->error);
    }

    $stmt->bind_param("i", $machineId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $photoPath = $row['machine_photo'];

        // Delete the record from the database
        $deleteSql = "DELETE FROM machines WHERE machine_id = ?";
        $deleteStmt = $con->prepare($deleteSql);

        if (!$deleteStmt) {
            die("Prepare statement failed: " . $con->error);
        }

        $deleteStmt->bind_param("i", $machineId);

        if ($deleteStmt->execute()) {
            // Check if the image file exists and delete it
            if (!empty($photoPath) && file_exists($photoPath)) {
                unlink($photoPath); // Attempt to delete the image
            }

            // Redirect to machine.php
            header("Location: ../machine.php");
            exit; // Ensure no further code execution
        } else {
            echo "Error deleting machine: " . $deleteStmt->error;
        }

        $deleteStmt->close();
    } else {
        echo "Machine not found.";
    }

    $stmt->close();
    $con->close();
} else {
    echo "Invalid request method.";
}
?>
