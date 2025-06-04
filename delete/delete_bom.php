<?php
// Include the database connection file
include '../conn.php';

// Check if the `id` is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete query
    $deleteQuery = "DELETE FROM bom WHERE id='$id'";

    if (mysqli_query($con, $deleteQuery)) {
        echo "<script>alert('Record deleted successfully!'); window.location.href='../machine.php';</script>";
    } else {
        echo "<script>alert('Error deleting record: " . mysqli_error($con) . "'); window.location.href='../list/bom_list.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request'); window.location.href='../machine.php';</script>";
}
?>
