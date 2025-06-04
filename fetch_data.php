<?php
// Database connection
include 'conn.php';
// Check connection
if ($con->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed']));
}



// Fetch vendors
$vendorsQuery = "SELECT vendor_name FROM vendors";
$vendorsResult = $con->query($vendorsQuery);
$vendors = [];
if ($vendorsResult->num_rows > 0) {
    while ($row = $vendorsResult->fetch_assoc()) {
        $vendors[] = $row['vendor_name'];
    }
}

// Return JSON response
echo json_encode(['materials' => $materials, 'vendors' => $vendors]);
$con->close();
?>
