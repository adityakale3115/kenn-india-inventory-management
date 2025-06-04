<?php
// Include the database connection file
include '../conn.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $item_no = $_POST['item_no'];
    $quantity = $_POST['quantity'];
    $part_no = $_POST['part_no'];
    $description = $_POST['description'];
    $material = $_POST['material'];
    $finish_material_size = $_POST['finish_material_size'];
    $finish_material_weight = $_POST['finish_material_weight'];
    $remark1 = $_POST['remark1'];
    $remark2 = $_POST['remark2'];
    $remark3 = $_POST['remark3'];
    $remark4 = $_POST['remark4'];

    // Update query
    $updateQuery = "UPDATE bom SET 
        item_no='$item_no',
        quantity='$quantity',
        part_no='$part_no',
        description='$description',
        material='$material',
        finish_material_size='$finish_material_size',
        finish_material_weight='$finish_material_weight',
        remark1='$remark1',
        remark2='$remark2',
        remark3='$remark3',
        remark4='$remark4'
    WHERE id='$id'";

    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('Record updated successfully!'); window.location.href='../machine.php';</script>";
    } else {
        echo "<script>alert('Error updating record: " . mysqli_error($con) . "');</script>";
    }
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Fetch the existing data
    $query = "SELECT * FROM bom WHERE id='$id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
} else {
    echo "<script>alert('Invalid request'); window.location.href='../list/bom_list.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit BOM</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>Edit BOM</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                            <div class="mb-3">
                                <label for="item_no" class="form-label">Item No:</label>
                                <input type="text" id="item_no" name="item_no" class="form-control" value="<?php echo $row['item_no']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity:</label>
                                <input type="text" id="quantity" name="quantity" class="form-control" value="<?php echo $row['quantity']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="part_no" class="form-label">Part No:</label>
                                <input type="text" id="part_no" name="part_no" class="form-control" value="<?php echo $row['part_no']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <input type="text" id="description" name="description" class="form-control" value="<?php echo $row['description']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="material" class="form-label">Material:</label>
                                <input type="text" id="material" name="material" class="form-control" value="<?php echo $row['material']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="finish_material_size" class="form-label">Finish Material Size:</label>
                                <input type="text" id="finish_material_size" name="finish_material_size" class="form-control" value="<?php echo $row['finish_material_size']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="finish_material_weight" class="form-label">Finish Material Weight:</label>
                                <input type="text" id="finish_material_weight" name="finish_material_weight" class="form-control" value="<?php echo $row['finish_material_weight']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="remark1" class="form-label">Remark 1:</label>
                                <input type="text" id="remark1" name="remark1" class="form-control" value="<?php echo $row['remark1']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="remark2" class="form-label">Remark 2:</label>
                                <input type="text" id="remark2" name="remark2" class="form-control" value="<?php echo $row['remark2']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="remark3" class="form-label">Remark 3:</label>
                                <input type="text" id="remark3" name="remark3" class="form-control" value="<?php echo $row['remark3']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="remark4" class="form-label">Remark 4:</label>
                                <input type="text" id="remark4" name="remark4" class="form-control" value="<?php echo $row['remark4']; ?>" required>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success px-5">Update</button>
                                <a href="../machine.php" class="btn btn-secondary px-5">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
