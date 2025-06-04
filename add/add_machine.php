<?php
include '../conn.php';

// Insert data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $machinePhoto = $_FILES['machinePhoto']['name'];
    $machineName = $_POST['machineName'];
    $machineNo = $_POST['machineNo'];
    $remark1 = $_POST['remark1'];
    $remark2 = $_POST['remark2'];
    $remark3 = $_POST['remark3'];
    $remark4 = $_POST['remark4'];

    // Upload photo
    $targetDir = "../img/";
    $targetFile = $targetDir . basename($machinePhoto);
    if (move_uploaded_file($_FILES['machinePhoto']['tmp_name'], $targetFile)) {
        // Prepare SQL
        $sql = "INSERT INTO machines (machine_photo, machine_name, machine_no, remark1, remark2, remark3, remark4) 
                VALUES ('$targetFile', '$machineName', '$machineNo', '$remark1', '$remark2', '$remark3', '$remark4')";

        if ($con->query($sql) === TRUE) {
            header("Location: ../machine.php");
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    } else {
        echo "Error uploading file.";
    }
}

$con->close();
?>
