<?php
// Include database connection
include '../conn.php';

// Fetch the customer details to edit
if (isset($_GET['id'])) {
    $customerId = $_GET['id'];
    
    // Fetch the customer details from the database
    $sql = "SELECT * FROM customers WHERE customer_id = '$customerId'";
    $result = $con->query($sql);
    
    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
    } else {
        // If no customer is found
        header("Location: index.php"); // Redirect to customer list page
        exit();
    }
}

// Update operation
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

    // Prepare the SQL query to update data
    $sql = "UPDATE customers SET company_name = '$companyName', address = '$address', gst_no = '$gstNo', contact_name = '$contactName', 
            designation = '$designation', email = '$email', whatsapp_number = '$wpNumber', pan_no = '$panNo', 
            payment_terms = '$paymentTerms', custom_payment_terms = '$customPaymentTerms' 
            WHERE customer_id = '$customerId'";

    if ($con->query($sql) === TRUE) {
        // Success message
        $message = "Customer details updated successfully.";

        // Redirect to prevent resubmission
        header("Location: ../index.php");
        exit();
    } else {
        // Error message
        $message = "Error: " . $con->error;
    }
}

// Close the connection
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <!-- Sidebar -->
    <?php include '../sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content">
        <h1>Edit Customer</h1>

        <!-- Display Message -->
        <?php if (isset($message)): ?>
            <div class="alert alert-info">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <!-- Edit Form -->
        <form action="" method="POST">
            <div class="mb-3">
                <label for="companyName" class="form-label">Company Name</label>
                <input type="text" class="form-control" id="companyName" name="companyName" value="<?= $customer['company_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" required><?= $customer['address']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="gstNo" class="form-label">GST No.</label>
                <input type="text" class="form-control" id="gstNo" name="gstNo" value="<?= $customer['gst_no']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="contactName" class="form-label">Contact Name</label>
                <input type="text" class="form-control" id="contactName" name="contactName" value="<?= $customer['contact_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="designation" class="form-label">Designation</label>
                <input class="form-control" type="text" id="designation" name="designation" value="<?= $customer['designation']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email ID</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $customer['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="wpNumber" class="form-label">WhatsApp Number</label>
                <input type="text" class="form-control" id="wpNumber" name="wpNumber" value="<?= $customer['whatsapp_number']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="panNo" class="form-label">PAN No.</label>
                <input type="text" class="form-control" id="panNo" name="panNo" value="<?= $customer['pan_no']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="paymentTerms" class="form-label">Payment Terms</label>
                <select class="form-select" id="paymentTerms" name="paymentTerms" required>
                    <option value="30 Days" <?= ($customer['payment_terms'] == '30 Days') ? 'selected' : ''; ?>>30 Days</option>
                    <option value="60 Days" <?= ($customer['payment_terms'] == '60 Days') ? 'selected' : ''; ?>>60 Days</option>
                    <option value="90 Days" <?= ($customer['payment_terms'] == '90 Days') ? 'selected' : ''; ?>>90 Days</option>
                    <option value="Customized" <?= ($customer['payment_terms'] == 'Customized') ? 'selected' : ''; ?>>Customized</option>
                </select>
            </div>

            <div class="mb-3" id="customPaymentTermsContainer" style="<?= ($customer['payment_terms'] == 'Customized') ? 'display:block;' : 'display:none;'; ?>">
                <label for="customPaymentTerms" class="form-label">Custom Payment Terms</label>
                <input type="text" class="form-control" id="customPaymentTerms" name="customPaymentTerms" value="<?= $customer['custom_payment_terms']; ?>">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
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
