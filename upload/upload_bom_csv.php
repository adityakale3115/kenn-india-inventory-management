<?php
include '../conn.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['bom_csv']) && $_FILES['bom_csv']['error'] === UPLOAD_ERR_OK) {
        // File details
        $fileTmpPath = $_FILES['bom_csv']['tmp_name'];
        $fileName = $_FILES['bom_csv']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Check file extension
        if (strtolower($fileExtension) === 'csv') {
            // Open the file
            if (($handle = fopen($fileTmpPath, 'r')) !== false) {
                // Skip the header row
                fgetcsv($handle);

                // Prepare SQL statement
                $stmt = $con->prepare("INSERT INTO bom (item_no, quantity, part_no, hierarchy_level, description, material, finish_material_size, finish_material_weight, remark1, remark2, remark3, remark4) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                // Loop through the rows
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    // Preserve spaces in part_no
                    $partNo = $data[2]; // Part No column
                    
                    // Calculate the hierarchy level based on leading spaces
                    $trimmedPartNo = ltrim($partNo); // Remove leading spaces
                    $leadingSpaces = strlen($partNo) - strlen($trimmedPartNo); // Count leading spaces
                    $hierarchyLevel = floor($leadingSpaces / 2); // Assume 2 spaces per level

                    // Bind values and execute
                    $stmt->bind_param(
                        "iisissssssss",
                        $data[0], // Item No
                        $data[1], // Quantity
                        $trimmedPartNo, // Trimmed Part No (no leading spaces stored)
                        $hierarchyLevel, // Hierarchy level
                        $data[3], // Description
                        $data[4], // Material
                        $data[5], // Finish Material Size
                        $data[6], // Finish Material Weight
                        $data[7], // Remark 1
                        $data[8], // Remark 2
                        $data[9], // Remark 3
                        $data[10] // Remark 4
                    );
                    $stmt->execute();
                }
                fclose($handle);

                // Redirect after successful upload
                header("Location: ../machine.php");
                exit; // Ensure no further code is executed
            } else {
                echo "Error opening the CSV file.";
            }
        } else {
            echo "Only CSV files are allowed.";
        }
    } else {
        echo "File upload error.";
    }
} else {
    echo "Invalid request.";
}
?>
