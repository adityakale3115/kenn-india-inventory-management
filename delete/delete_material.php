<?php
// Include database connection
include '../conn.php';

// Check if material_id is provided
if (isset($_GET['material_id'])) {
    // Get the material_id from the query string
    $material_id = $_GET['material_id'];

    // Prepare the DELETE query
    $sql = "DELETE FROM materials WHERE material_id = ?";

    // Prepare statement
    if ($stmt = $con->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("i", $material_id);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to the materials page after deletion
            header("Location: ../material.php?success=1");
        } else {
            echo "Error deleting record: " . $con->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing the query: " . $con->error;
    }
} else {
    echo "Material ID not provided!";
}

// Close the database connection
$con->close();
?>
