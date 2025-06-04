<?php
// Database connection
include 'conn.php';

// Handle form submission for inserting data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['delete_id'])) {
    $machineName = $_POST['machineName'];
    $key = $_POST['key'];
    $speed = $_POST['speed'];
    $customerName = $_POST['customerName'];
    $orderDate = $_POST['orderDate'];
    $amountReceived = $_POST['amountReceived'];
    $amountDate = $_POST['amountDate'];
    $packingForwarding = $_POST['packingForwarding'];
    $freight = $_POST['freight'];
    $deliveryDate = $_POST['deliveryDate'];

    // Prepared statement for inserting data
    $sql = "INSERT INTO project_master (
                machine_name, 
                machine_specification, 
                customer_name, 
                order_date, 
                advanced_amount_received, 
                advanced_amount_date, 
                packing_forwarding, 
                freight, 
                expected_delivery_date
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    $machineSpecification = "Key: $key, Speed: $speed";
    $stmt->bind_param(
        "sssssssss",
        $machineName,
        $machineSpecification,
        $customerName,
        $orderDate,
        $amountReceived,
        $amountDate,
        $packingForwarding,
        $freight,
        $deliveryDate
    );

    if ($stmt->execute()) {
        echo "<script>alert('Project added successfully!'); window.location.href = window.location.href;</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Handle deletion of a project
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];

    // Prepared statement for deletion
    $deleteSql = "DELETE FROM project_master WHERE project_number = ?";
    $stmt = $con->prepare($deleteSql);
    $stmt->bind_param("i", $deleteId);

    if ($stmt->execute()) {
        echo "<script>alert('Project deleted successfully!'); window.location.href = window.location.href;</script>";
    } else {
        echo "<script>alert('Error deleting project: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Master</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .table-container {
            overflow-x: auto;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content">
        <h1>Project Master</h1>
        <div class="buttons">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProjectModal">Add Project</button>
        </div><br>

        <!-- Table for Project Master -->
        <div class="table-container">
            <table class="table table-striped" id="projectTable">
                <thead>
                    <tr>
                        <th scope="col">Project Number</th>
                        <th scope="col">Machine Name</th>
                        <th scope="col">Machine Specification</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Advanced Amount Received</th>
                        <th scope="col">Packing and Forwarding</th>
                        <th scope="col">Freight</th>
                        <th scope="col">Expected Delivery Date</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    // Fetch data
    $sql = "SELECT * FROM project_master";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['project_number']}</td>
                <td>{$row['machine_name']}</td>
                <td>{$row['machine_specification']}</td>
                <td>{$row['customer_name']}</td>
                <td>{$row['order_date']}</td>
                <td>{$row['advanced_amount_received']} Rs on {$row['advanced_amount_date']}</td>
                <td>{$row['packing_forwarding']}</td>
                <td>{$row['freight']}</td>
                <td>{$row['expected_delivery_date']}</td>
                <td>
                    <form method='POST' onsubmit='return confirm(\"Are you sure you want to delete this project?\");'>
                        <input type='hidden' name='delete_id' value='{$row['project_number']}'>
                        <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                    </form><br>
                    <a href='edit/edit-project.php?project_number={$row['project_number']}' class='btn btn-primary btn-sm'>Edit</a>
                               
                </td>
                
            </tr>";
        }
    } else {
        echo "<tr><td colspan='10'>No records found.</td></tr>";
    }
    ?>
</tbody>

            </table>
        </div>
    </div>

    <!-- Modal for Adding Project -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectModalLabel">Add New Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <!-- Machine Name -->
                        <div class="mb-3">
                            <label for="machineName" class="form-label">Machine Name</label>
                            <select class="form-select" id="machineName" name="machineName" required>
                                <?php include 'fetch/fetch_machines.php'; ?>
                            </select>
                        </div>
                        <!-- Machine Specification -->
                        <div class="mb-3">
                            <label for="machineSpecification" class="form-label">Machine Specifications</label>
                            <input type="text" class="form-control" id="key" name="key" placeholder="Key" required>
                            <input type="text" class="form-control" id="speed" name="speed" placeholder="Speed (RPM)" required>
                        </div>
                        <!-- Customer Name -->
                        <div class="mb-3">
                            <label for="customerName" class="form-label">Customer Name</label>
                            <select class="form-select" id="customerName" name="customerName" required>
                                <option value="" disabled selected>Select Customer</option>
                                <?php
                                $customerQuery = "SELECT company_name FROM customers";
                                $customerResult = $con->query($customerQuery);

                                if ($customerResult->num_rows > 0) {
                                    while ($customerRow = $customerResult->fetch_assoc()) {
                                        echo "<option value='" . htmlspecialchars($customerRow['company_name']) . "'>" . htmlspecialchars($customerRow['company_name']) . "</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No customers found</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <!-- Order Date -->
                        <div class="mb-3">
                            <label for="orderDate" class="form-label">Order Date</label>
                            <input type="date" class="form-control" id="orderDate" name="orderDate" required>
                        </div>
                        <!-- Advanced Amount Received -->
                        <div class="mb-3">
                            <label for="amountReceived" class="form-label">Advanced Amount Received</label>
                            <input type="number" class="form-control" id="amountReceived" name="amountReceived" placeholder="Amount" required>
                            <input type="date" class="form-control" id="amountDate" name="amountDate" required>
                        </div>
                        <!-- Packing and Forwarding -->
                        <div class="mb-3">
                            <label for="packingForwarding" class="form-label">Packing and Forwarding</label>
                            <select class="form-select" id="packingForwarding" name="packingForwarding" required>
                                <option value="Extra - 10% Included">Extra - 10% Included</option>
                                <option value="Included - 5%">Included - 5%</option>
                            </select>
                        </div>
                        <!-- Freight -->
                        <div class="mb-3">
                            <label for="freight" class="form-label">Freight</label>
                            <select class="form-select" id="freight" name="freight" required>
                                <option value="Extra (Customer Pays)">Extra (Customer Pays)</option>
                                <option value="Included">Included</option>
                            </select>
                        </div>
                        <!-- Expected Delivery Date -->
                        <div class="mb-3">
                            <label for="deliveryDate" class="form-label">Expected Delivery Date</label>
                            <input type="date" class="form-control" id="deliveryDate" name="deliveryDate" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Project</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
