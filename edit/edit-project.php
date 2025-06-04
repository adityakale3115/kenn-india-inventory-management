<?php
// Database connection
include '../conn.php';

// Fetch the project details for editing
if (isset($_GET['project_number'])) {
    $projectNumber = $_GET['project_number'];
    $sql = "SELECT * FROM project_master WHERE project_number = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $projectNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $project = $result->fetch_assoc();

    if (!$project) {
        echo "<script>alert('Project not found!'); window.location.href = 'index.php';</script>";
    }
}

// Fetch customers to populate the dropdown
$customersSql = "SELECT company_name FROM customers";
$customersResult = $con->query($customersSql);

// Fetch machines to populate the dropdown
$machinesSql = "SELECT machine_name FROM machines";
$machinesResult = $con->query($machinesSql);


// Handle form submission for updating the project
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $projectNumber = $_POST['edit_id'];
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
    

    // Update query
    $updateSql = "UPDATE project_master SET 
                    machine_name = ?, 
                    machine_specification = ?, 
                    customer_name = ?, 
                    order_date = ?, 
                    advanced_amount_received = ?, 
                    advanced_amount_date = ?, 
                    packing_forwarding = ?, 
                    freight = ?, 
                    expected_delivery_date = ? 
                  WHERE project_number = ?";
    $stmt = $con->prepare($updateSql);
    $stmt->bind_param("ssssissssi", $machineName, $key, $customerName, $orderDate, $amountReceived, $amountDate, $packingForwarding, $freight, $deliveryDate, $projectNumber);

    if ($stmt->execute()) {
        echo "<script>alert('Project updated successfully!'); window.location.href = '../project.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <!-- Include Sidebar -->
    <?php include '../sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content">
        <h1>Edit Project</h1>
        <form method="POST">
            <input type="hidden" name="edit_id" value="<?php echo $project['project_number']; ?>">

            <div class="mb-3">
    <label for="machineName" class="form-label">Machine Name</label>
    <select class="form-select" name="machineName" required>
        <option value="">Select Machine</option>
        <?php while ($machine = $machinesResult->fetch_assoc()) { ?>
            <option value="<?php echo $machine['machine_name']; ?>" 
                <?php echo $project['machine_name'] == $machine['machine_name'] ? 'selected' : ''; ?>>
                <?php echo $machine['machine_name']; ?>
            </option>
        <?php } ?>
    </select>
</div>


            <div class="mb-3">
                <label for="key" class="form-label">Key</label>
                <input type="text" class="form-control" name="key" value="<?php echo $project['machine_specification']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="speed" class="form-label">Speed</label>
                <input type="text" class="form-control" name="speed" value="<?php echo $project['machine_specification']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="customerName" class="form-label">Customer Name</label>
                <select class="form-select" name="customerName" required>
                    <option value="">Select Customer</option>
                    <?php while ($customer = $customersResult->fetch_assoc()) { ?>
                        <option value="<?php echo $customer['company_name']; ?>" <?php echo $project['customer_name'] == $customer['company_name'] ? 'selected' : ''; ?>>
                            <?php echo $customer['company_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="orderDate" class="form-label">Order Date</label>
                <input type="date" class="form-control" name="orderDate" value="<?php echo $project['order_date']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="amountReceived" class="form-label">Amount Received</label>
                <input type="number" class="form-control" name="amountReceived" value="<?php echo $project['advanced_amount_received']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="amountDate" class="form-label">Amount Date</label>
                <input type="date" class="form-control" name="amountDate" value="<?php echo $project['advanced_amount_date']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="packingForwarding" class="form-label">Packing & Forwarding</label>
                <input type="text" class="form-control" name="packingForwarding" value="<?php echo $project['packing_forwarding']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="freight" class="form-label">Freight</label>
                <input type="text" class="form-control" name="freight" value="<?php echo $project['freight']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="deliveryDate" class="form-label">Expected Delivery Date</label>
                <input type="date" class="form-control" name="deliveryDate" value="<?php echo $project['expected_delivery_date']; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
