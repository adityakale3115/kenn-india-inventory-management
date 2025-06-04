<?php
// Assuming you have already established the connection with the database
include('../conn.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and get form data
    $itemID = $_POST['hardwareItemID'];
    $itemName = $_POST['hardwareItemName'];
    $vendorRating = $_POST['hardwareVendorRating'];
    $deliveryTime = $_POST['hardwareDeliveryTime'];
    $specifications = isset($_POST['spec']) ? $_POST['spec'] : null;

    // Insert into hardware_items table
    $stmt = $con->prepare("INSERT INTO hardware_items (item_id, item_name, vendor_rating, delivery_time, specifications) 
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $itemID, $itemName, $vendorRating, $deliveryTime, $specifications);
    $stmt->execute();
    $stmt->close();

    // Insert into item_hardware_vendors table
    if (isset($_POST['vendor_ids']) && isset($_POST['price'])) {
        $vendorIds = $_POST['vendor_ids'];
        $prices = $_POST['price'];
        
        foreach ($vendorIds as $vendorId) {
            $price = $prices[$vendorId];

            // Prepare and execute the insert statement for item_hardware_vendors table
            $stmt = $con->prepare("INSERT INTO item_hardware_vendors (item_id, vendor_id, price) 
                                   VALUES (?, ?, ?)");
            $stmt->bind_param("sid", $itemID, $vendorId, $price);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Redirect to ../items.php
    header("Location: ../items.php");
    exit(); // Ensure no further code is executed
}
?>
