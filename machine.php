<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Machine Master</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
    .highlight {
        background-color: #f2d7d5; /* Light red background */
        color: #000; /* Black text */
    }
    .table-container {
            overflow-x: auto;
            white-space: nowrap;
        }
</style>

</head>

<body>

    <!-- Sidebar -->
    <?php include 'sidebar.php' ?>

    <!-- Main Content -->
    <div class="content">
        <h1>Machine Master</h1>
        <div class="buttons">
            <!-- Add Machine Button -->
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMachineModal">Add
                Machine</button>
                
        </div><br>

        <!-- Machine Table -->
        <!-- Machine Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Machine ID</th>
                    <th scope="col">Machine Photo</th>
                    <th scope="col">Machine Name</th>
                    <th scope="col">Machine No</th>
                    <th scope="col">Remark 1</th>
                    <th scope="col">Remark 2</th>
                    <th scope="col">Remark 3</th>
                    <th scope="col">Remark 4</th>
                    <th scope="col">Delete</th>

                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection
                include 'conn.php';
                // Check connection
                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                }

                // Fetch machines from database
                $sql = "SELECT * FROM machines";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['machine_id']}</td>
                            <td><img src='img/{$row['machine_photo']}' style='height:150px;' alt=''></td>
                            <td>{$row['machine_name']}</td>
                            <td>{$row['machine_no']}</td>
                            <td>{$row['remark1']}</td>
                            <td>{$row['remark2']}</td>
                            <td>{$row['remark3']}</td>
                            <td>{$row['remark4']}</td>
                            <td>
                    <form action='delete/delete_machine.php' method='POST' style='display: inline;'>
                        <input type='hidden' name='machine_id' value='{$row['machine_id']}'>
                        <button type='submit' class='btn btn-danger'>Delete</button>
                    </form>
                </td> 
                
                </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No machines found.</td></tr>";
                }

                $con->close();
                ?>
            </tbody>
        </table>

        <h1>Bill Of Material</h1>
        <div class="buttons">
    <form action="upload/upload_bom_csv.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="bom_csv" accept=".csv" required>
        <button type="submit" class="btn btn-primary">Upload CSV</button>
    </form>
</div><br>
        <div class="buttons">
            <!-- Add Bill Of Material Button -->
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBOMModal">Add Bill Of
                Material</button>
        </div><br>

        <!-- Bill of Material Table -->
         <div class="table-container">
        <table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Item No</th>
            <th scope="col">Quantity</th> 
            <th scope="col">Part No</th>
            <th scope="col">Hierarchy Level</th>
            <th scope="col">Total Quantity</th>
            <th scope="col">Description</th>
            <th scope="col">Material</th>
            <th scope="col">Finish Material Size</th>
            <th scope="col">Finish Material Weight</th>
            <th scope="col">Remark 1</th>
            <th scope="col">Remark 2</th>
            <th scope="col">Remark 3</th>
            <th scope="col">Remark 4</th>
            
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
            
        </tr>
    </thead>
    <tbody>
        <?php
        // Include PHP script to fetch data
        include 'fetch/fetch_bom_data.php';
        ?>
    </tbody>
</table>
</div>

    </div>

    <!-- Modal for Adding Machine -->
    <div class="modal fade" id="addMachineModal" tabindex="-1" aria-labelledby="addMachineModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMachineModalLabel">Add New Machine</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for adding machine -->
                    <form action="add/add_machine.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="machinePhoto" class="form-label">Upload Photo</label>
                            <input type="file" class="form-control" id="machinePhoto" name="machinePhoto" required>
                        </div>
                        <div class="mb-3">
                            <label for="machineName" class="form-label">Machine Name</label>
                            <input type="text" class="form-control" id="machineName" name="machineName" required>
                        </div>
                        <div class="mb-3">
                            <label for="machineNo" class="form-label">Machine Number</label>
                            <input type="text" class="form-control" id="machineNo" name="machineNo" required>
                        </div>
                        <div class="mb-3">
                            <label for="remark1" class="form-label">Remark 1</label>
                            <input type="text" class="form-control" id="remark1" name="remark1">
                        </div>
                        <div class="mb-3">
                            <label for="remark2" class="form-label">Remark 2</label>
                            <input type="text" class="form-control" id="remark2" name="remark2">
                        </div>
                        <div class="mb-3">
                            <label for="remark3" class="form-label">Remark 3</label>
                            <input type="text" class="form-control" id="remark3" name="remark3">
                        </div>
                        <div class="mb-3">
                            <label for="remark4" class="form-label">Remark 4</label>
                            <input type="text" class="form-control" id="remark4" name="remark4">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Machine</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Bill of Material -->
    <!-- Modal for Adding Bill of Material -->
    <div class="modal fade" id="addBOMModal" tabindex="-1" aria-labelledby="addBOMModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBOMModalLabel">Add Bill Of Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for adding Bill of Material -->
                    <form action="add/add_bom.php" method="POST">
                        
                        <div class="mb-3">
                            <label for="itemNo" class="form-label">Item No</label>
                            <input type="text" class="form-control" id="itemNo" name="item_no" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="partNo" class="form-label">Part No</label>
                            <input type="text" class="form-control" id="partNo" name="part_no" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="moc" class="form-label">Material of Construction (MOC)</label>
                            <input type="text" class="form-control" id="moc" name="moc" required>
                        </div>
                        <div class="mb-3">
                            <label for="finishSize" class="form-label">Finish Material Size</label>
                            <input type="text" class="form-control" id="finishSize" name="finish_material_size"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="finishWeight" class="form-label">Finish Material Weight</label>
                            <input type="text" class="form-control" id="finishWeight" name="finish_material_weight"
                                required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="remark1" class="form-label">Remark 1</label>
                            <input type="text" class="form-control" id="remark1" name="remark_1">
                        </div>
                        <div class="mb-3">
                            <label for="remark2" class="form-label">Remark 2</label>
                            <input type="text" class="form-control" id="remark2" name="remark_2">
                        </div>
                        <div class="mb-3">
                            <label for="remark3" class="form-label">Remark 3</label>
                            <input type="text" class="form-control" id="remark3" name="remark_3">
                        </div>
                        <div class="mb-3">
                            <label for="remark4" class="form-label">Remark 4</label>
                            <input type="text" class="form-control" id="remark4" name="remark_4">
                        </div>
                        <button type="submit" class="btn btn-primary">Add BOM</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>