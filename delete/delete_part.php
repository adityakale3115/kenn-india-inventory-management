<?php
// Assuming you have a valid database connection in $con

include '../conn.php';  // Include the database connection

// Check if part_id is set in the URL
if (isset($_GET['part_id'])) {
    $partId = $_GET['part_id'];

    // Start a transaction to ensure all delete operations happen together
    $con->begin_transaction();

    try {
        // Delete related entries from part_materials table
        $sql_delete_materials = "DELETE FROM part_materials WHERE part_id = '$partId'";
        if (!$con->query($sql_delete_materials)) {
            throw new Exception("Error deleting materials for part_id $partId");
        }

        // Delete related entries from part_vendors table
        $sql_delete_vendors = "DELETE FROM part_vendors WHERE part_id = '$partId'";
        if (!$con->query($sql_delete_vendors)) {
            throw new Exception("Error deleting vendors for part_id $partId");
        }

        // Delete the part from parts table
        $sql_delete_part = "DELETE FROM parts WHERE part_id = '$partId'";
        if (!$con->query($sql_delete_part)) {
            throw new Exception("Error deleting part with part_id $partId");
        }

        // Commit the transaction if all queries are successful
        $con->commit();

        
        exit;
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $con->rollback();
        echo "Error: " . $e->getMessage();
    }
    // Redirect back to the parts listing page
    header("Location: parts.php");
} else {
    echo "Error: part_id not provided.";
}
?>
