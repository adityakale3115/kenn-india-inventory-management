<?php
include 'conn.php'; // Include database connection

// Fetch all items with their vendors
$sqlll = "SELECT 
            b.item_id,
            b.item_name,
            b.vendor_rating,
            b.delivery_time,
            b.specifications,
            GROUP_CONCAT(CONCAT(v.vendor_name, ' - ', iv.price) SEPARATOR '<br> ') AS vendor_data
        FROM boughtout_items b
        LEFT JOIN item_vendors iv ON b.item_id = iv.item_id
        LEFT JOIN vendors v ON iv.vendor_id = v.vendor_id
        GROUP BY b.item_id";

$resssult = $con->query($sqlll);

if ($resssult->num_rows > 0) {
    echo '<table class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Item ID</th>';
    echo '<th>Item Name</th>';
    echo '<th>Vendor & His Pricing</th>';
    echo '<th>Vendor Rating</th>';
    echo '<th>Delivery Time</th>';
    echo '<th>Specifications</th>';
    echo '<th>Delete</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Display each row
    while ($rooww = $resssult->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($rooww['item_id']) . '</td>';
        echo '<td>' . htmlspecialchars($rooww['item_name']) . '</td>';
        echo '<td>' . nl2br($rooww['vendor_data']) . '</td>'; // Apply nl2br to ensure line breaks
        echo '<td>' . htmlspecialchars($rooww['vendor_rating']) . '</td>';
        echo '<td>' . htmlspecialchars($rooww['delivery_time']) . '</td>';
        echo '<td>' . htmlspecialchars($rooww['specifications']) . '</td>';
        echo '<td><button class="btn btn-danger">Delete</button></td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p>No items found.</p>';
}
?>
