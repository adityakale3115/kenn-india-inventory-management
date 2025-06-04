<?php
// Include the database connection
include '../conn.php';

// Get POST data and sanitize inputs
$partName = $con->real_escape_string($_POST['partName']);
$drawingNumber = $con->real_escape_string($_POST['drawingNumber']);
$description = $con->real_escape_string($_POST['description']);
$materialIds = $_POST['material_ids'] ?? []; // Array of selected material IDs
$vendorIds = $_POST['vendor_ids'] ?? []; // Array of selected vendor IDs
$prices = $_POST['price'] ?? []; // Prices corresponding to each vendor
$surfaceFinish = !empty($_POST['customSurfaceFinish']) ? $con->real_escape_string($_POST['customSurfaceFinish']) : $con->real_escape_string($_POST['surfaceFinish']);
$hardening = !empty($_POST['customHardening']) ? $con->real_escape_string($_POST['customHardening']) : $con->real_escape_string($_POST['hardening']);
$machine = $con->real_escape_string($_POST['machine']);
$assemblyDate = $con->real_escape_string($_POST['assemblyDate']);
$partWeight = $con->real_escape_string($_POST['partWeight']);
$costing = $con->real_escape_string($_POST['costing']);
$deliveryTime = $con->real_escape_string($_POST['deliveryTime']);

// Start a transaction
$con->begin_transaction();

try {
    // Insert part data into parts table
    $stmt = $con->prepare("
        INSERT INTO parts 
        (part_name, drawing_number, description, surface_finish, hardening, machine, assembly_date, part_weight, expected_costing, delivery_time) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "ssssssssss", 
        $partName, 
        $drawingNumber, 
        $description, 
        $surfaceFinish, 
        $hardening, 
        $machine, 
        $assemblyDate, 
        $partWeight, 
        $costing, 
        $deliveryTime
    );
    $stmt->execute();

    // Get the ID of the newly inserted part
    $partId = $con->insert_id;

    // Insert data into part_materials table
    if (!empty($materialIds)) {
        $stmtMaterial = $con->prepare("INSERT INTO part_materials (part_id, material_id) VALUES (?, ?)");
        foreach ($materialIds as $materialId) {
            $stmtMaterial->bind_param("ii", $partId, $materialId);
            $stmtMaterial->execute();
        }
        $stmtMaterial->close();
    }

    // Insert data into part_vendors table
    if (!empty($vendorIds)) {
        $stmtVendor = $con->prepare("INSERT INTO part_vendors (part_id, vendor_id, price) VALUES (?, ?, ?)");
        foreach ($vendorIds as $vendorId) {
            $price = $prices[$vendorId] ?? 0; // Default to 0 if price is missing
            $stmtVendor->bind_param("iid", $partId, $vendorId, $price);
            $stmtVendor->execute();
        }
        $stmtVendor->close();
    }

    // Commit the transaction
    $con->commit();

    // Redirect to parts.php after successful insertion
    header("Location: ../parts.php");
    exit; // Stop script execution
} catch (Exception $e) {
    // Rollback the transaction in case of error
    $con->rollback();

    // Log the error (or echo for debugging)
    error_log("Error: " . $e->getMessage());
    echo "Error occurred: " . $e->getMessage();
}

// Close the connection
$con->close();
?>
