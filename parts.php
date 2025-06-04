<?php
include 'conn.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parts Master</title>
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
        <h1>Parts Master</h1>
        <div class="buttons">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPartModal">Add Part</button>
            <!-- Button to trigger CSV download -->
<button class="btn btn-info" id="downloadCSVBtn">Download CSV</button> <!-- New Button for Uploading Spreadsheet -->
    <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadSpreadsheetModal">Upload Spreadsheet</button> -->

        </div><br>

        <!-- Table for Parts Master -->
        <div class="table-container">
            <table class="table table-bordered" id="parts">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Part Name</th>
                        <th>Drawing Number</th>
                        <th>Description</th>
                        <th>Materials</th>
                        <th>Vendors</th>
                        <th>Surface Finish</th>
                        <th>Hardening</th>
                        <th>Used In Assembly / Machine</th>
                        <th>Assembly Date</th>
                        <th>Part Weight</th>
                        <th>Costing</th>
                        <th>Delivery Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Assuming you have a valid database connection in $con
                    
                    // Query to fetch parts data
                    $sql_parts = "SELECT * FROM parts";
                    $result_parts = $con->query($sql_parts);

                    if ($result_parts->num_rows > 0) {
                        // Loop through each part
                        while ($row = $result_parts->fetch_assoc()) {
                            $partId = $row['part_id'];
                            // Get related materials for this part
                            $sql_materials = "SELECT m.material_name FROM part_materials pm
                                  JOIN materials m ON pm.material_id = m.material_id
                                  WHERE pm.part_id = '$partId'";
                            $result_materials = $con->query($sql_materials);
                            $materials = [];
                            while ($material = $result_materials->fetch_assoc()) {
                                $materials[] = $material['material_name'];
                            }
                            $materials_list = implode(", ", $materials);

                            // Get related vendors for this part
                            $sql_vendors = "SELECT v.vendor_name, pv.price FROM part_vendors pv
                                JOIN vendors v ON pv.vendor_id = v.vendor_id
                                WHERE pv.part_id = '$partId'";
                            $result_vendors = $con->query($sql_vendors);
                            $vendors = [];
                            while ($vendor = $result_vendors->fetch_assoc()) {
                                $vendors[] = $vendor['vendor_name'] . " (Price: " . $vendor['price'] . ")";
                            }
                            $vendors_list = implode("<br>", $vendors);

                            // Display part data in table
                            echo "<tr>";
                            echo "<td>" . $row['part_id'] . "</td>";
                            echo "<td>" . htmlspecialchars($row['part_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['drawing_number']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                            echo "<td>" . $materials_list . "</td>";
                            echo "<td>" . $vendors_list . "</td>";
                            echo "<td>" . htmlspecialchars($row['surface_finish']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['hardening']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['machine']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['assembly_date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['part_weight']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['expected_costing']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['delivery_time']) . "</td>";
                            echo "<td><a href='delete/delete_part.php?part_id=" . $row['part_id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this part?\")'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='13'>No parts found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>

    <!-- Modal for Adding Part -->
    <!-- Modal for Adding Part -->
    <div class="modal fade" id="addPartModal" tabindex="-1" aria-labelledby="addPartModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPartModalLabel">Add New Part</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="add/add_parts.php" method="POST" enctype="multipart/form-data">
                        <!-- Part Name -->
                        <div class="mb-3">
                            <label for="partName" class="form-label">Part Name</label>
                            <input type="text" class="form-control" id="partName" name="partName" required>
                        </div>
                        <!-- Drawing Number -->
                        <div class="mb-3">
                            <label for="drawingNumber" class="form-label">Drawing Number</label>
                            <input type="text" class="form-control" id="drawingNumber" name="drawingNumber" required>
                        </div>
                        <!-- Material of Construction -->
                        <div class="mb-3">
                            <label class="form-label">Material of Construction</label>
                            <div id="material" class="form-check" name="material_ids[]">
                                <?php
                                // Fetch materials from the materials table
                                $sql = "SELECT material_id, material_name FROM materials";
                                $result = $con->query($sql);
                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<div>';
                                        echo '<input class="form-check-input" type="checkbox" id="material' . $row['material_id'] . '" name="material_ids[]" value="' . $row['material_id'] . '">';
                                        echo '<label class="form-check-label" for="material' . $row['material_id'] . '">' . htmlspecialchars($row['material_name']) . '</label>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p>No materials available.</p>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <!-- Remarks -->
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks"></textarea>
                        </div>
                        <!-- Surface Finish (Dropdown) -->
                        <!-- Surface Finish (Customizable Dropdown) -->
<div class="mb-3">
    <label for="surfaceFinish" class="form-label">Surface Finish</label>
    <div class="d-flex flex-wrap gap-2">
        <select class="form-select" id="surfaceFinish" name="surfaceFinish" style="max-width: 300px;">
            <option value="Plated">Plated</option>
            <option value="Painted">Painted</option>
        </select>
        <input type="text" class="form-control" id="customSurfaceFinish" name="customSurfaceFinish" placeholder="Enter Custom Surface Finish" style="max-width: 300px;">
    </div>
    <small class="text-muted">You can select a predefined option or provide a custom value.</small>
</div>

<!-- Hardening (Customizable Dropdown) -->
<div class="mb-3">
    <label for="hardening" class="form-label">Hardening</label>
    <div class="d-flex flex-wrap gap-2">
        <select class="form-select" id="hardening" name="hardening" style="max-width: 300px;">
            <option value="Harden">Harden</option>
            <option value="Toughen">Toughen</option>
        </select>
        <input type="text" class="form-control" id="customHardening" name="customHardening" placeholder="Enter Custom Hardening" style="max-width: 300px;">
    </div>
    <small class="text-muted">You can select a predefined option or provide a custom value.</small>
</div>

                        <!-- Machine -->
                        <div class="mb-3">
                            <label for="machine" class="form-label">Machine</label>
                            <input type="text" class="form-control" id="machine" name="machine" required>
                        </div>
                        <!-- Assembly Date (Past Date) -->
                        <div class="mb-3">
                            <label for="assemblyDate" class="form-label">Assembly Date</label>
                            <input type="date" class="form-control" id="assemblyDate" name="assemblyDate" required>
                        </div>
                        <!-- Part Weight -->
                        <div class="mb-3">
                            <label for="partWeight" class="form-label">Part Weight</label>
                            <input type="text" class="form-control" id="partWeight" name="partWeight" required>
                        </div>
                        <!-- Expected Costing -->
                        <div class="mb-3">
                            <label for="costing" class="form-label">Expected Costing</label>
                            <input type="number" class="form-control" id="costing" name="costing" required>
                        </div>
                        <!-- Operations Required (Multiple Select) -->
                        <div class="mb-3">
                            <label for="operationsRequired" class="form-label">Operations Required</label>
                            <div>
                                <input type="checkbox" id="milling" name="operationsRequired[]" value="Milling">
                                <label for="milling">Milling</label>
                            </div>
                            <div>
                                <input type="checkbox" id="turning" name="operationsRequired[]" value="Turning">
                                <label for="turning">Turning</label>
                            </div>
                            <div>
                                <input type="checkbox" id="grinding" name="operationsRequired[]" value="Grinding">
                                <label for="grinding">Grinding</label>
                            </div>
                        </div>

                        <!-- Vendor -->
                        <div class="mb-3">
                            <label class="form-label">Vendors</label>
                            <div id="vendor" class="form-check" name="vendor_ids[]">
                                <?php
                                // Fetch vendors from the vendors table
                                $sql = "SELECT vendor_id, vendor_name FROM vendors";
                                $result = $con->query($sql);
                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<div class="d-flex align-items-center mb-2">';
                                        echo '<input class="form-check-input me-2" type="checkbox" id="vendor' . $row['vendor_id'] . '" name="vendor_ids[]" value="' . $row['vendor_id'] . '">';
                                        echo '<label class="form-check-label me-3" for="vendor' . $row['vendor_id'] . '">' . htmlspecialchars($row['vendor_name']) . '</label>';
                                        echo '<input type="number" class="form-control" id="price' . $row['vendor_id'] . '" name="price[' . $row['vendor_id'] . ']" placeholder="Enter Price" style="max-width: 150px;">';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p>No Vendor available.</p>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Delivery Time -->
                        <div class="mb-3">
                            <label for="deliveryTime" class="form-label">Delivery Time</label>
                            <input type="text" class="form-control" id="deliveryTime" name="deliveryTime" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Part</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Uploading Spreadsheet -->
<div class="modal fade" id="uploadSpreadsheetModal" tabindex="-1" aria-labelledby="uploadSpreadsheetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadSpreadsheetModalLabel">Upload Spreadsheet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="upload_spreadsheet.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="spreadsheet" class="form-label">Upload Spreadsheet</label>
                        <input type="file" name="spreadsheet" id="spreadsheet" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
<script>
    // Add event listener to the button to ensure the table exists first
    document.addEventListener("DOMContentLoaded", function() {
        // Function to download table data as CSV
        document.getElementById("downloadCSVBtn").addEventListener("click", function() {
            downloadCSV();
        });
    });

    function downloadCSV() {
        var table = document.getElementById("parts");
        
        // Check if the table exists before trying to access its rows
        if (!table) {
            alert("Table not found!");
            return;
        }

        var rows = table.rows;
        var csvContent = "";
        
        // Loop through each row of the table
        for (var i = 0; i < rows.length; i++) {
            var cols = rows[i].cells;
            var rowData = [];
            
            // Loop through each cell in the row
            for (var j = 0; j < cols.length; j++) {
                rowData.push(cols[j].innerText); // Add cell data to rowData
            }
            
            // Join the row data with commas and add a new line
            csvContent += rowData.join(",") + "\n";
        }

        // Create a hidden link to download the CSV file
        var hiddenElement = document.createElement('a');
        hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csvContent); // Create the URI for the CSV
        hiddenElement.target = '_blank';
        hiddenElement.download = 'parts_master.csv'; // Name the downloaded file
        hiddenElement.click(); // Trigger the download
    }
</script>

    <!-- <script>
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                const response = await fetch('fetch_data.php'); // Adjust the path as needed
                const data = await response.json();

                const materialSelect = document.getElementById('material');
                const vendorSelect = document.getElementById('vendor');

                // Populate Material of Construction dropdown
                data.materials.forEach(material => {
                    const option = document.createElement('option');
                    option.value = material;
                    option.textContent = material;
                    materialSelect.appendChild(option);
                });

                // Populate Vendor dropdown
                data.vendors.forEach(vendor => {
                    const option = document.createElement('option');
                    option.value = vendor;
                    option.textContent = vendor;
                    vendorSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        });
    </script> -->

</body>

</html>