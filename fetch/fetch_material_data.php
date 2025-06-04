<?php
// Include the database connection


// Prepare the SQL query to fetch materials data
$sqql = "SELECT material_id, material_name, material_type, section, size, vendor_name, order_date, price, remark_1, remark_2, remark_3, remark_4 FROM materials";

// Execute the query
$ressult = $con->query($sqql);

// Check if there are any results
if ($ressult->num_rows > 0) {
    // Fetch and display each row of data
    while ($row = $ressult->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['material_name'] . '</td>';
        echo '<td>' . $row['material_type'] . '</td>';
        echo '<td>' . $row['section'] . '</td>';
        echo '<td>' . $row['size'] . '</td>';
        echo '<td>' . $row['vendor_name'] . '</td>';
        echo '<td>' . $row['order_date'] . '</td>';
        echo '<td>' . $row['price'] . ' Rs</td>';
        echo '<td>' . $row['remark_1'] . '</td>';
        echo '<td>' . $row['remark_2'] . '</td>';
        echo '<td>' . $row['remark_3'] . '</td>';
        echo '<td>' . $row['remark_4'] . '</td>';
        echo '<td><a href="delete/delete_material.php?material_id=' . $row['material_id'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this material?\')">Delete</a></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="12">No materials found</td></tr>';
}

// Close the database connection

?>
