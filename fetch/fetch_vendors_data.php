<?php


// Fetch all vendor data from the database
$fetchVendorQuery = "SELECT * FROM vendors";
$resullt = $con->query($fetchVendorQuery);

if ($resullt->num_rows > 0) {
    // Loop through all the fetched rows and display them
    while ($row = $resullt->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['vendor_name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['address']) . '</td>';
        echo '<td>' . htmlspecialchars($row['gst_no']) . '</td>';
        echo '<td>' . htmlspecialchars($row['pan_number']) . '</td>';
        echo '<td>' . htmlspecialchars($row['contact_number']) . '</td>';
        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
        echo '<td>' . htmlspecialchars($row['whatsapp_number']) . '</td>';
        echo '<td>' . htmlspecialchars($row['facilities']) . '</td>';
        echo '<td>' . htmlspecialchars($row['payment_terms']) . '</td>';
        echo '<td>' . htmlspecialchars($row['pricing_rating']) . '</td>';
        echo '<td>' . htmlspecialchars($row['quality_rating']) . '</td>';
        echo '<td>' . htmlspecialchars($row['delivery_rating']) . '</td>';
        echo '<td>' . htmlspecialchars($row['precision_rating']) . '</td>';
        echo '<td><a href="delete/delete_vendor.php?id=' . $row['vendor_id'] . '" class="btn btn-danger">Delete</a></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="14">No vendor data found.</td></tr>';
}


?>
