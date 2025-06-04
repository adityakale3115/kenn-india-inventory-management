<?php
// Include the database connection file
include 'conn.php'; 

// Query to fetch data from the BOM table
$query = "SELECT id, item_no, quantity, part_no, hierarchy_level, description, material, 
       finish_material_size, finish_material_weight, 
       remark1, remark2, remark3, remark4, total_quantity
FROM bom"; // Sort by hierarchy level

$result = mysqli_query($con, $query);

$data = []; // Store data for processing
$totalCount = []; // Store total quantity per parent

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

// Calculate direct subparts count
foreach ($data as $row) {
    foreach ($data as $subRow) {
        if ($subRow['hierarchy_level'] == $row['hierarchy_level'] + 1) {
            // Count how many times this row appears as a parent
            if (!isset($totalCount[$row['id']])) {
                $totalCount[$row['id']] = 0;
            }
            $totalCount[$row['id']]++;
        }
    }
}

// Display table
foreach ($data as $row) {
    $indentation = str_repeat('&nbsp;&nbsp;', $row['hierarchy_level'] * 2);
    $highlightClass = ($row['item_no'] > 0) ? "highlight" : "";

    echo "<tr class='$highlightClass'>";
    echo "<td>" . $row['item_no'] . "</td>";
    echo "<td>" . $row['quantity'] . "</td>";
    echo "<td style='text-align: left;'>" . $indentation . $row['part_no'] . "</td>";
    echo "<td>" . $row['hierarchy_level'] . "</td>";
    echo "<td>" . $row['total_quantity'] . "</td>";
    echo "<td>" . $row['description'] . "</td>";
    echo "<td>" . $row['material'] . "</td>";
    echo "<td>" . $row['finish_material_size'] . "</td>";
    echo "<td>" . $row['finish_material_weight'] . "</td>";

    echo "<td>" . $row['remark1'] . "</td>";
    echo "<td>" . $row['remark2'] . "</td>";
    echo "<td>" . $row['remark3'] . "</td>";
    echo "<td>" . $row['remark4'] . "</td>";

    // Display calculated total_quantity (direct subpart count)
    $totalQuantity = isset($totalCount[$row['id']]) ? $totalCount[$row['id']] : 0;
    echo "<td>" . $totalQuantity . "</td>";

    echo "<td>
            <a href='edit/edit_bom.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Edit</a>
          </td>";
    echo "<td>
            <a href='delete/delete_bom.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this item?\")'>Delete</a>
          </td>";
    echo "</tr>";
}

// Add error reporting for debugging
if (!$result) {
    echo "Error: " . mysqli_error($con);
}
?>
