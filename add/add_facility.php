<?php

include '../conn.php';


// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the facility name from the form
    $facilityName = $con->real_escape_string($_POST['facilityName']);

    // SQL query to insert into facilities table
    $sql = "INSERT INTO facilities (facility_name) VALUES ('$facilityName')";

    if ($con->query($sql) === TRUE) {
        echo "Facility added successfully.";
        header("Location: ../vendor.php"); // Redirect back to the vendor page
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}


?>
