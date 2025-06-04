<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items Master</title>
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
        <h1>Items Master</h1>
        <div class="buttons">
            <!-- Add Item Button -->
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addItemModal">Add Bought Out
                Item</button>
            <!-- Add Hardware Item Button -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHardwareItemModal">Add Hardware
                Item</button>

        </div><br>

        <!-- Table for Items Master -->
        <div class="table-container">
            <h3>Bought Out Item</h3>
            <table class="table table-striped" id="itemsTable">
               <?php include 'fetch/fetch_boughtout.php'; ?>
            </table>
        </div>

        <!-- Table for Hardware Items -->
        <div class="table-container">
            <h3>Hardware Items</h3>
            <table class="table table-striped" id="hardwareItemsTable">
                <?php include 'fetch/fetch_hardware.php' ?>
            </table>
        </div>
    </div>

    <!-- Modal for Adding Item -->
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemModalLabel">Add New Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="add/add_boughtout.php" method="POST" enctype="multipart/form-data">
                        <!-- Item ID -->
                        <div class="mb-3">
                            <label for="itemID" class="form-label">Item ID</label>
                            <input type="text" class="form-control" id="itemID" name="itemID" required>
                        </div>
                        <!-- Item Name -->
                        <div class="mb-3">
                            <label for="itemName" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="itemName" name="itemName" required>
                        </div>
                        <!-- Purchased From (Dropdown) -->
                        <div class="mb-3">
                            <label class="form-label">Vendors</label>
                            <div id="vendor">
                                <?php
                                include 'conn.php';
                                // Fetch vendors from the vendors table
                                $sql = "SELECT vendor_id, vendor_name FROM vendors";
                                $result = $con->query($sql);
                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<div class="d-flex align-items-center mb-2">';
                                        // Checkbox for vendor selection
                                        echo '<input class="form-check-input me-2" type="checkbox" id="vendor' . $row['vendor_id'] . '" name="vendor_ids[]" value="' . $row['vendor_id'] . '">';
                                        // Vendor name label
                                        echo '<label class="form-check-label me-3" for="vendor' . $row['vendor_id'] . '">' . htmlspecialchars($row['vendor_name']) . '</label>';
                                        // Input field for price corresponding to vendor
                                        echo '<input type="number" class="form-control" id="price' . $row['vendor_id'] . '" name="price[' . $row['vendor_id'] . ']" placeholder="Enter Price" style="max-width: 150px;">';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p>No Vendor available.</p>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Vendor Rating -->
                        <div class="mb-3">
                            <label for="vendorRating" class="form-label">Vendor Rating</label>
                            <input type="number" class="form-control" id="vendorRating" name="vendorRating" required
                                min="1" max="5">
                        </div>
                        <!-- Delivery Time -->
                        <div class="mb-3">
                            <label for="deliveryTime" class="form-label">Delivery Time</label>
                            <input type="text" class="form-control" id="deliveryTime" name="deliveryTime" required>
                        </div>
                        <!-- Specification -->
                        <div class="mb-3">
                            <label for="spec" class="form-label">Specifications</label>
                            <input type="text" class="form-control" id="spec" name="spec">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Hardware Item -->
    <div class="modal fade" id="addHardwareItemModal" tabindex="-1" aria-labelledby="addHardwareItemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addHardwareItemModalLabel">Add New Hardware Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="add/add_hardware.php" method="POST" enctype="multipart/form-data">
                        <!-- Item ID -->
                        <div class="mb-3">
                            <label for="hardwareItemID" class="form-label">Item ID</label>
                            <input type="text" class="form-control" id="hardwareItemID" name="hardwareItemID" required>
                        </div>
                        <!-- Item Name -->
                        <div class="mb-3">
                            <label for="hardwareItemName" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="hardwareItemName" name="hardwareItemName"
                                required>
                        </div>
                        <!-- Purchased From (Dropdown) -->
                        <div class="mb-3">
                            <label class="form-label">Vendors</label>
                            <div id="vendor">
                                <?php

                                // Fetch vendors from the vendors table
                                $sqql = "SELECT vendor_id, vendor_name FROM vendors";
                                $ressult = $con->query($sqql);
                                if ($ressult->num_rows > 0) {
                                    // Output data of each row
                                    while ($roow = $ressult->fetch_assoc()) {
                                        echo '<div class="d-flex align-items-center mb-2">';
                                        // Checkbox for vendor selection
                                        echo '<input class="form-check-input me-2" type="checkbox" id="vendor' . $roow['vendor_id'] . '" name="vendor_ids[]" value="' . $roow['vendor_id'] . '">';
                                        // Vendor name label
                                        echo '<label class="form-check-label me-3" for="vendor' . $roow['vendor_id'] . '">' . htmlspecialchars($roow['vendor_name']) . '</label>';
                                        // Input field for price corresponding to vendor
                                        echo '<input type="number" class="form-control" id="price' . $roow['vendor_id'] . '" name="price[' . $roow['vendor_id'] . ']" placeholder="Enter Price" style="max-width: 150px;">';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p>No Vendor available.</p>';
                                }
                                ?>
                            </div>
                        </div>
                        <!-- Vendor Rating -->
                        <div class="mb-3">
                            <label for="hardwareVendorRating" class="form-label">Vendor Rating</label>
                            <input type="number" class="form-control" id="hardwareVendorRating"
                                name="hardwareVendorRating" required min="1" max="5">
                        </div>
                        <!-- Delivery Time -->
                        <div class="mb-3">
                            <label for="hardwareDeliveryTime" class="form-label">Delivery Time</label>
                            <input type="text" class="form-control" id="hardwareDeliveryTime"
                                name="hardwareDeliveryTime" required>
                        </div>
                        <!-- Specification -->
                        <div class="mb-3">
                            <label for="spec" class="form-label">Specifications</label>
                            <input type="text" class="form-control" id="spec" name="spec">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Hardware Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>