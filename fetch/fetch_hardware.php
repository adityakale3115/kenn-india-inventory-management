<?php
// Assuming you have already established the connection with the database
include('conn.php'); 

// Fetch all hardware items along with their vendor details
$ssssql = "SELECT hi.item_id, hi.item_name, hi.vendor_rating, hi.delivery_time, hi.specifications, iv.vendor_id, iv.price, v.vendor_name
        FROM hardware_items hi
        LEFT JOIN item_hardware_vendors iv ON hi.item_id = iv.item_id
        LEFT JOIN vendors v ON iv.vendor_id = v.vendor_id";
$reeesult = $con->query($ssssql);

if ($reeesult->num_rows > 0) {
    // Initialize an array to hold all rows for each hardware item
    $hardwareItems = [];

    // Loop through the query result and group vendors for each hardware item
    while ($rroow = $reeesult->fetch_assoc()) {
        $itemId = $rroow['item_id'];

        // Check if the item already exists in the array
        if (!isset($hardwareItems[$itemId])) {
            // If it doesn't exist, initialize the item
            $hardwareItems[$itemId] = [
                'item_id' => $rroow['item_id'],
                'item_name' => $rroow['item_name'],
                'vendor_rating' => $rroow['vendor_rating'],
                'delivery_time' => $rroow['delivery_time'],
                'specifications' => $rroow['specifications'],
                'vendors' => [] // Initialize vendors as an empty array
            ];
        }

        // Add the vendor and price to the vendors array for the current item
        $hardwareItems[$itemId]['vendors'][] = $rroow['vendor_name'] . " - " . $rroow['price'];
    }

    // Display the hardware items and their vendor information
    echo '<table class="table table-bordered">';
    echo '<thead><tr><th>Item ID</th><th>Item Name</th><th>Vendor Info</th><th>Vendor Rating</th><th>Delivery Time</th><th>Specifications</th></tr></thead>';
    echo '<tbody>';

    // Loop through each hardware item and display it
    foreach ($hardwareItems as $item) {
        // Join vendor info with <br> for line breaks
        $vendorInfo = implode('<br>', $item['vendors']);

        echo '<tr>';
        echo '<td>' . htmlspecialchars($item['item_id']) . '</td>';
        echo '<td>' . htmlspecialchars($item['item_name']) . '</td>';
        echo '<td>' . $vendorInfo . '</td>';
        echo '<td>' . htmlspecialchars($item['vendor_rating']) . '</td>';
        echo '<td>' . htmlspecialchars($item['delivery_time']) . '</td>';
        echo '<td>' . htmlspecialchars($item['specifications']) . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p>No hardware items found.</p>';
}
?>
