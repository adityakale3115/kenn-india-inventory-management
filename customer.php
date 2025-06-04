<?php
// Database connection (Make sure to update with your actual database credentials)
include 'conn.php';

// Insert operation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and collect the form data
    $companyName = mysqli_real_escape_string($con, $_POST['companyName']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $gstNo = mysqli_real_escape_string($con, $_POST['gstNo']);
    $contactName = mysqli_real_escape_string($con, $_POST['contactName']);
    $designation = mysqli_real_escape_string($con, $_POST['designation']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $wpNumber = mysqli_real_escape_string($con, $_POST['wpNumber']);
    $panNo = mysqli_real_escape_string($con, $_POST['panNo']);
    $paymentTerms = mysqli_real_escape_string($con, $_POST['paymentTerms']);
    $customPaymentTerms = isset($_POST['customPaymentTerms']) ? mysqli_real_escape_string($con, $_POST['customPaymentTerms']) : NULL;

    // If the payment terms are customized, use custom payment terms
    if ($paymentTerms == 'Customized' && !empty($customPaymentTerms)) {
        $paymentTerms = $customPaymentTerms;
    }

    // Prepare the SQL query to insert data
    $sql = "INSERT INTO customers (company_name, address, gst_no, contact_name, designation, email, whatsapp_number, pan_no, payment_terms, custom_payment_terms) 
            VALUES ('$companyName', '$address', '$gstNo', '$contactName', '$designation', '$email', '$wpNumber', '$panNo', '$paymentTerms', '$customPaymentTerms')";

    if ($con->query($sql) === TRUE) {
        // Success message
        $message = "New customer added successfully.";

        // Redirect to prevent resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit(); // Always call exit after header redirect
    } else {
        // Error message
        $message = "Error: " . $sql . "<br>" . $con->error;
    }
}

// Fetch all records from the database
$result = $con->query("SELECT * FROM customers");

// Close the connection
$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Master</title>
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
        <h1>Customer Master</h1>

        <!-- Display Message -->
        <?php if (isset($message)): ?>
            <div class="alert alert-info">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <div class="buttons">
            <!-- Add Customer Button that triggers the modal -->
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCustomerModal">Add
                Customer</button>
        </div><br>

        <!-- Table for displaying customer details -->
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Customer ID</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">GST No.</th>
                        <th scope="col">PAN No.</th>
                        <th scope="col">Contact Name</th>
                        <th scope="col">Designation</th>
                        <th scope="col">Email</th>
                        <th scope="col">WhatsApp Number</th>
                        <th scope="col">Payment Terms</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Fetch and display data from the database -->
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['customer_id']; ?></td>
                                <td><?= $row['company_name']; ?></td>
                                <td><?= $row['address']; ?></td>
                                <td><?= $row['gst_no']; ?></td>
                                <td><?= $row['pan_no']; ?></td>
                                <td><?= $row['contact_name']; ?></td>
                                <td><?= $row['designation']; ?></td>
                                <td><?= $row['email']; ?></td>
                                <td><?= $row['whatsapp_number']; ?></td>
                                <td>
                                    <!-- If payment_terms is NULL, display customPaymentTerms instead -->
                                    <?= is_null($row['payment_terms']) || $row['payment_terms'] === '' ? $row['custom_payment_terms'] : $row['payment_terms']; ?>
                                </td>
                                <td>
                                    <!-- Delete Button, passing the customer_id to delete.php -->
                                    <a href="delete/delete-customer.php?id=<?= $row['customer_id']; ?>" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this customer?');">Delete</a>
                                </td>
                                <td>
                                    <!-- Edit Button, passing the customer_id to edit.php -->
                                    <a href="edit/edit-customer.php?id=<?= $row['customer_id']; ?>" class="btn btn-warning"
                                        onclick="return confirm('Are you sure you want to delete this customer?');">Edit</a>
                                </td>
                            </tr>

                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11">No records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Adding Customer -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for adding a customer -->
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="companyName" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="companyName" name="companyName" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="gstNo" class="form-label">GST No.</label>
                            <input type="text" class="form-control" id="gstNo" name="gstNo" required>
                        </div>
                        <div class="mb-3">
                            <label for="contactName" class="form-label">Contact Name</label>
                            <input type="text" class="form-control" id="contactName" name="contactName" required>
                        </div>
                        <div class="mb-3">
                            <label for="designation" class="form-label">Designation</label>
                            <input class="form-control" type="text" id="designation" name="designation" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email ID</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="wpNumber" class="form-label">WhatsApp Number</label>
                            <input type="text" class="form-control" id="wpNumber" name="wpNumber" required>
                        </div>
                        <div class="mb-3">
                            <label for="panNo" class="form-label">PAN No.</label>
                            <input type="text" class="form-control" id="panNo" name="panNo" required>
                        </div>

                        <div class="mb-3">
                            <label for="paymentTerms" class="form-label">Payment Terms</label>
                            <select class="form-select" id="paymentTerms" name="paymentTerms" required>
                                <option value="30 Days">30 Days</option>
                                <option value="60 Days">60 Days</option>
                                <option value="90 Days">90 Days</option>
                                <option value="Customized">Customized</option>
                            </select>
                        </div>

                        <div class="mb-3" id="customPaymentTermsContainer" style="display:none;">
                            <label for="customPaymentTerms" class="form-label">Custom Payment Terms</label>
                            <input type="text" class="form-control" id="customPaymentTerms" name="customPaymentTerms">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Customer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show custom payment terms field if 'Customized' is selected
        document.getElementById('paymentTerms').addEventListener('change', function () {
            if (this.value === 'Customized') {
                document.getElementById('customPaymentTermsContainer').style.display = 'block';
            } else {
                document.getElementById('customPaymentTermsContainer').style.display = 'none';
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
