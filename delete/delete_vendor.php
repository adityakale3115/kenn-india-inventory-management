<?php
// Database connection (replace with your actual connection details)
include '../conn.php';

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if the vendor ID is provided
if (isset($_GET['id'])) {
    // Get the vendor ID from the URL
    $vendorId = $_GET['id'];

    // Prepare the delete query
    $deleteVendorQuery = "DELETE FROM vendors WHERE vendor_id = ?";

    // Prepare the statement
    if ($stmt = $con->prepare($deleteVendorQuery)) {
        // Bind the vendor ID parameter
        $stmt->bind_param("i", $vendorId);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect back to the vendor list page after successful deletion
            header("Location: ../vendor.php?message=Vendor deleted successfully");
            exit;
        } else {
            // Display error message if query execution fails
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing query: " . $con->error;
    }
} else {
    echo "Vendor ID not provided.";
}

// Close the connection
$con->close();
?>
