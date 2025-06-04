<?php
include 'conn.php'; // This file should create the $con connection

// Check database connection
if (!$con) {
    die("Connection error: " . mysqli_connect_error());
}

// Check if the total_quantity column exists
$colCheck = mysqli_query($con, "SHOW COLUMNS FROM bom LIKE 'total_quantity'");
if (mysqli_num_rows($colCheck) == 0) {
    die("Column 'total_quantity' does not exist in table 'bom'. Please add it using: ALTER TABLE bom ADD COLUMN total_quantity INT DEFAULT 0;");
}

// 1. Fetch all items ordered by item_no ASC
$query = "SELECT id, item_no, hierarchy_level FROM bom ORDER BY item_no ASC";
$result = mysqli_query($con, $query);
if (!$result) {
    die("Error fetching items: " . mysqli_error($con));
}

$items = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Convert item_no to an integer for proper numeric comparison
    $row['item_no'] = intval($row['item_no']);
    $items[] = $row;
}

// 2. Initialize totalQuantities array (keyed by id)
$totalQuantities = [];
foreach ($items as $item) {
    $totalQuantities[$item['id']] = 0;
}

// 3. Calculate total_quantity for each parent by counting direct children
// A child is defined as having a numerically greater item_no AND a higher hierarchy_level.
foreach ($items as $parent) {
    foreach ($items as $child) {
        if (
            $child['item_no'] > $parent['item_no'] &&
            $child['hierarchy_level'] > $parent['hierarchy_level']
        ) {
            $totalQuantities[$parent['id']]++;
        }
    }
}

// Debug: output the computed total quantities
echo "<pre>Computed total_quantities:\n" . print_r($totalQuantities, true) . "</pre>";

// 4. Update each record in the database with the computed total_quantity
foreach ($totalQuantities as $id => $qty) {
    $updateQuery = "UPDATE bom SET total_quantity = $qty WHERE id = $id";
    if (!mysqli_query($con, $updateQuery)) {
        echo "Error updating id $id: " . mysqli_error($con) . "<br>";
    } else {
        echo "Updated id $id with total_quantity = $qty<br>";
    }
}

echo "<br>Total Quantity Updated Successfully!";
?>
