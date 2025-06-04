<?php
// Database connection
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Step 1: Get the selected project_number from POST request
    $projectNumber = $_POST['project_number'] ?? '';

    if (empty($projectNumber)) {
        echo "<tr><td colspan='13'>Project number is missing.</td></tr>";
        exit;
    }

    // Prepare and execute query to fetch machine_name
    $machineQuery = $con->prepare("
        SELECT machine_name 
        FROM project_master
        WHERE project_number = ?
    ");
    $machineQuery->bind_param('s', $projectNumber);
    $machineQuery->execute();
    $machineResult = $machineQuery->get_result();

    if ($machineResult->num_rows > 0) {
        $machineRow = $machineResult->fetch_assoc();
        $machineName = $machineRow['machine_name'];

        // Fetch machine_no based on machine_name
        $machineNoQuery = $con->prepare("
            SELECT machine_no 
            FROM machines
            WHERE machine_name = ?
        ");
        $machineNoQuery->bind_param('s', $machineName);
        $machineNoQuery->execute();
        $machineNoResult = $machineNoQuery->get_result();

        if ($machineNoResult->num_rows > 0) {
            $machineNoRow = $machineNoResult->fetch_assoc();
            $machineNo = $machineNoRow['machine_no'];

            // Fetch BOM data where part_no contains machine_no (KSMxxx format)
            $bomQuery = $con->prepare("
                SELECT * 
                FROM bom
                WHERE part_no LIKE ?
            ");
            $likePattern = "%KSM$machineNo%";
            $bomQuery->bind_param('s', $likePattern);
            $bomQuery->execute();
            $bomResult = $bomQuery->get_result();

            if ($bomResult->num_rows > 0) {
                // Display BOM data
                while ($row = $bomResult->fetch_assoc()) {
                    echo "
                    <tr>
                        <td><input type='checkbox' name='select_part[]' value='{$row['part_no']}'></td>
                        <td><input type='number' name='price_{$row['part_no']}' placeholder='Enter price'></td>
                        <td>{$row['item_no']}</td>
                        <td>{$row['quantity']}</td>
                        <td>{$row['part_no']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['material']}</td>
                        
                        <td>{$row['finish_material_size']}</td>
                        <td>{$row['finish_material_weight']}</td>
                        <td>{$row['remark1']}</td>
                        <td>{$row['remark2']}</td>
                        <td>{$row['remark3']}</td>
                        <td>{$row['remark4']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='13'>No BOM data available for the selected project and machine.</td></tr>";
            }
        } else {
            echo "<tr><td colspan='13'>No machine number found for the selected project.</td></tr>";
        }
    } else {
        echo "<tr><td colspan='13'>No machine found for the selected project.</td></tr>";
    }
}
?>
