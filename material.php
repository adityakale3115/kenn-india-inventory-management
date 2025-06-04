<!DOCTYPE html>
<html lang="en">
<?php
include 'conn.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material Master</title>
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
        <h1>Material Master</h1>
        <div class="buttons">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMaterialModal">Add
                Material</button>
        </div><br>

        <!-- Table for content -->
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>

                        <th scope="col">Material Name</th>
                        <th scope="col">Material Type</th>
                        <th scope="col">Section</th>
                        <th scope="col">Size</th>
                        <th scope="col">Vendor</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Price</th>
                        <th scope="col">Remark 1</th>
                        <th scope="col">Remark 2</th>
                        <th scope="col">Remark 3</th>
                        <th scope="col">Remark 4</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include 'fetch/fetch_material_data.php'; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Adding Material -->
    <div class="modal fade" id="addMaterialModal" tabindex="-1" aria-labelledby="addMaterialModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMaterialModalLabel">Add New Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="add/add_material.php" method="POST" enctype="multipart/form-data">

                        <!-- Material Name -->
                        <div class="mb-3">
                            <label for="materialName" class="form-label">Material Name</label>
                            <input type="text" class="form-control" id="materialName" name="materialName" required>
                        </div>
                        <!-- Material Type -->
                        <div class="mb-3">
                            <label for="materialType" class="form-label">Material Type</label>
                            <select class="form-select" id="materialType" name="materialType"
                                onchange="toggleCustomMaterialType()" required>
                                <option value="SS">SS</option>
                                <option value="Mild Steel - Black">Mild Steel - Black</option>
                                <option value="Mild Steel - Bright">Mild Steel - Bright</option>
                                <option value="Brass">Brass</option>
                                <option value="Nylon">Nylon</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Custom Material Type Input -->
                        <div class="mb-3" id="customMaterialTypeContainer" style="display: none;">
                            <label for="customMaterialType" class="form-label">Custom Material Type</label>
                            <input type="text" class="form-control" id="customMaterialType" name="customMaterialType"
                                placeholder="Enter custom material type">
                        </div>
                        
                        <!-- Section -->
                        <div class="mb-3">
                            <label for="section" class="form-label">Section</label>
                            <select class="form-select" id="section" name="section" onchange="toggleCustomSection()"
                                required>
                                <option value="Round Section">Round Section</option>
                                <option value="Rect Pipe Section">Rect Pipe Section</option>
                                <option value="Round Pipe Section">Round Pipe Section</option>
                                <option value="Plate">Plate</option>
                                <option value="Sheet Metal">Sheet Metal</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- Custom Section Input -->
                        <div class="mb-3" id="customSectionContainer" style="display: none;">
                            <label for="customSection" class="form-label">Custom Section</label>
                            <input type="text" class="form-control" id="customSection" name="customSection"
                                placeholder="Enter custom section">
                        </div>

                        <!-- Size -->
                        <div class="mb-3">
                            <label for="size" class="form-label">Size</label>
                            <input type="text" class="form-control" id="size" name="size" placeholder="e.g., 100x200"
                                required>
                        </div>
                        <!-- Vendor -->
                        <div class="mb-3">
                            <label for="vendor" class="form-label">Vendor</label>
                            <select class="form-select" id="vendor" name="vendor" required>
                                <?php
                                // Connect to the database
                                

                                // Check connection
                                if ($con->connect_error) {
                                    die("Connection failed: " . $con->connect_error);
                                }

                                // Fetch vendor names from the vendors table
                                $sql = "SELECT vendor_name FROM vendors";
                                $result = $con->query($sql);

                                // Check if there are any vendors
                                if ($result->num_rows > 0) {
                                    // Output each vendor name as an option
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['vendor_name'] . '">' . $row['vendor_name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No vendors available</option>';
                                }

                                // Close the database connection
                                
                                ?>
                            </select>
                        </div>

                        <!-- Order Date -->
                        <div class="mb-3">
                            <label for="orderDate" class="form-label">Order Date</label>
                            <input type="date" class="form-control" id="orderDate" name="orderDate" required>
                        </div>
                        <!-- Price -->
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price"
                                placeholder="Enter price in Rs." required>
                        </div>
                        <!-- Remarks -->
                        <div class="mb-3">
                            <label for="remark1" class="form-label">Remark 1</label>
                            <input type="text" class="form-control" id="remark1" name="remark1" placeholder="Remark 1">
                        </div>
                        <div class="mb-3">
                            <label for="remark2" class="form-label">Remark 2</label>
                            <input type="text" class="form-control" id="remark2" name="remark2" placeholder="Remark 2">
                        </div>
                        <div class="mb-3">
                            <label for="remark3" class="form-label">Remark 3</label>
                            <input type="text" class="form-control" id="remark3" name="remark3" placeholder="Remark 3">
                        </div>
                        <div class="mb-3">
                            <label for="remark4" class="form-label">Remark 4</label>
                            <input type="text" class="form-control" id="remark4" name="remark4" placeholder="Remark 4">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Material</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function toggleCustomSection() {
            const sectionSelect = document.getElementById('section');
            const customSectionContainer = document.getElementById('customSectionContainer');
            const customSectionInput = document.getElementById('customSection');

            // Show the custom section input if "Other" is selected
            if (sectionSelect.value === 'Other') {
                customSectionContainer.style.display = 'block';
            } else {
                customSectionContainer.style.display = 'none';
                customSectionInput.value = '';  // Clear the custom section input if not "Other"
            }
        }

        function toggleCustomMaterialType() {
    const materialTypeSelect = document.getElementById('materialType');
    const customMaterialTypeContainer = document.getElementById('customMaterialTypeContainer');
    const customMaterialTypeInput = document.getElementById('customMaterialType');

    // Show the custom material type input if "Other" is selected
    if (materialTypeSelect.value === 'Other') {
        customMaterialTypeContainer.style.display = 'block';
    } else {
        customMaterialTypeContainer.style.display = 'none';
        customMaterialTypeInput.value = '';  // Clear the custom material type input if not "Other"
    }
}

    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>