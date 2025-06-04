<?php
// Include database connection
include '../conn.php';

// Check if the 'id' is passed in the URL
if (isset($_GET['id'])) {
    // Sanitize and get the customer_id
    $customer_id = mysqli_real_escape_string($con, $_GET['id']);

    // Prepare the DELETE SQL query
    $sql = "DELETE FROM customers WHERE customer_id = '$customer_id'";

    // Execute the query
    if ($con->query($sql) === TRUE) {
        // Redirect back to the main page after deletion
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Close the database connection
$con->close();
?>
