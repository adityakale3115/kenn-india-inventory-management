<?php
// Include database connection
include '../conn.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values
    $materialName = $_POST['materialName'];
    $materialType = $_POST['materialType'];  // Get selected material type
    $customMaterialType = isset($_POST['customMaterialType']) ? $_POST['customMaterialType'] : null; // Check for custom material type
    $section = $_POST['section'];  // Get selected section
    $customSection = isset($_POST['customSection']) ? $_POST['customSection'] : null; // Check for custom section
    $size = $_POST['size'];
    $vendor = $_POST['vendor'];
    $orderDate = $_POST['orderDate'];
    $price = $_POST['price'];
    $remark1 = $_POST['remark1'];
    $remark2 = $_POST['remark2'];
    $remark3 = $_POST['remark3'];
    $remark4 = $_POST['remark4'];

    // If "Other" is selected, use the custom material type value
    if ($materialType == 'Other' && !empty($customMaterialType)) {
        $materialType = $customMaterialType;
    }

    // If "Other" is selected, use the custom section value
    if ($section == 'Other' && !empty($customSection)) {
        $section = $customSection;
    }

    // Prepare SQL query
    $sql = "INSERT INTO materials (material_name, material_type, section, size, vendor_name, order_date, price, remark_1, remark_2, remark_3, remark_4)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    if ($stmt = $con->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("sssssssssss", $materialName, $materialType, $section, $size, $vendor, $orderDate, $price, $remark1, $remark2, $remark3, $remark4);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to material.php after successful insert
            header("Location: ../material.php");
            exit();  // Stop script execution after the redirect
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $con->error;
    }

    // Close the connection
    $con->close();
}
?>
