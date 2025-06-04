<?php
include '../conn.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect form data
    $item_id = $_POST['itemID'];
    $item_name = $_POST['itemName'];
    $vendor_rating = $_POST['vendorRating'];
    $delivery_time = $_POST['deliveryTime'];
    $specifications = $_POST['spec'];
    $vendor_ids = $_POST['vendor_ids'] ?? [];
    $prices = $_POST['price'] ?? [];

    // Insert into `boughtout_items`
    $stmt = $con->prepare("INSERT INTO boughtout_items (item_id, item_name, vendor_rating, delivery_time, specifications) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $item_id, $item_name, $vendor_rating, $delivery_time, $specifications);

    if ($stmt->execute()) {
        // Insert into `item_vendors`
        foreach ($vendor_ids as $vendor_id) {
            if (isset($prices[$vendor_id]) && is_numeric($prices[$vendor_id])) {
                $price = $prices[$vendor_id];
                $vendor_stmt = $con->prepare("INSERT INTO item_vendors (item_id, vendor_id, price) VALUES (?, ?, ?)");
                $vendor_stmt->bind_param("sid", $item_id, $vendor_id, $price);
                $vendor_stmt->execute();
            }
        }
        // Redirect to ../items.php
        header("Location: ../items.php");
        exit(); // Stop further script execution
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
