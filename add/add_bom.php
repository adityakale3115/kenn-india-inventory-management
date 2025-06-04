<?php
// Include the database connection file
include '../conn.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $item_no = $_POST['item_no'];
    $quantity = $_POST['quantity'];
    $part_no = $_POST['part_no'];
    $description = $_POST['description'];
    $moc = $_POST['moc'];
    $finish_material_size = $_POST['finish_material_size'];
    $finish_material_weight = $_POST['finish_material_weight'];
    
    $remark_1 = isset($_POST['remark_1']) ? $_POST['remark1'] : null;
    $remark_2 = isset($_POST['remark_2']) ? $_POST['remark2'] : null;
    $remark_3 = isset($_POST['remark_3']) ? $_POST['remark3'] : null;
    $remark_4 = isset($_POST['remark_4']) ? $_POST['remark4'] : null;

    // Prepare the SQL INSERT query
    $query = "INSERT INTO bom (
        item_no, 
        quantity, 
        part_no, 
        description, 
        material, 
        finish_material_size, 
        finish_material_weight, 
        remark1, 
        remark2, 
        remark3, 
        remark4
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind the statement
    $stmt = $con->prepare($query);
    $stmt->bind_param(
        "sisssssssss", // Define the data types for the variables
        $item_no, 
        $quantity, 
        $part_no, 
        $description, 
        $moc, 
        $finish_material_size, 
        $finish_material_weight, 
        $remark_1, 
        $remark_2, 
        $remark_3, 
        $remark_4
    );

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect or display a success message
        echo "<script>alert('Bill of Material added successfully!'); window.location.href='../index.php';</script>";
    } else {
        // Handle errors
        echo "<script>alert('Error: Could not add Bill of Material.'); window.location.href='../index.php';</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $con->close();
} else {
    echo "Invalid request.";
}
?>
