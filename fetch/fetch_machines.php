<?php
// Database connection

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch machine names from the `machines` table
$machine_fetch_query = "SELECT machine_name FROM machines";
$result = $con->query($machine_fetch_query);

if ($result->num_rows > 0) {
    // Output each machine name as an option
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . htmlspecialchars($row['machine_name']) . "'>" . htmlspecialchars($row['machine_name']) . "</option>";
    }
} else {
    echo "<option value=''>No machines available</option>";
}


?>
