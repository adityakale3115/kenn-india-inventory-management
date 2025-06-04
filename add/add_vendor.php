<?php
// Database connection (replace with your actual connection details)
include '../conn.php';

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $vendorName = $_POST['vendorName'];
    $vendorAddress = $_POST['vendorAddress'];
    $vendorGST = $_POST['vendorGST'];
    $vendorContact = $_POST['vendorContact'];
    $vendorEmail = $_POST['vendorEmail'];
    $vendorWhatsapp = $_POST['vendorWhatsapp'];
    $vendorPAN = $_POST['vendorPAN'];
    $facilities = isset($_POST['facilities']) ? implode(',', $_POST['facilities']) : ''; // Join selected facilities
    $pricingRating = $_POST['pricingRating'];
    $qualityRating = $_POST['qualityRating'];
    $deliveryRating = $_POST['deliveryRating'];
    $precisionRating = $_POST['precisionRating'];
    $paymentTerms = mysqli_real_escape_string($con, $_POST['paymentTerms']);
    $customPaymentTerms = isset($_POST['customPaymentTerms']) ? mysqli_real_escape_string($con, $_POST['customPaymentTerms']) : NULL;

    if ($paymentTerms == 'Customized' && !empty($customPaymentTerms)) {
        $paymentTerms = $customPaymentTerms;
    }

    // Check if the PAN number already exists
    $checkPANQuery = "SELECT COUNT(*) FROM vendors WHERE pan_number = ?";
    $stmt = $con->prepare($checkPANQuery);
    $stmt->bind_param("s", $vendorPAN);
    $stmt->execute();
    $stmt->bind_result($panCount);
    $stmt->fetch();
    $stmt->close();

    if ($panCount > 0) {
        echo "The PAN number already exists. Please use a different one.";
    } else {
        // Insert the vendor data into the database
        $insertVendorQuery = "INSERT INTO vendors (vendor_name, address, gst_no, contact_number, email, whatsapp_number, pan_number, facilities, pricing_rating, quality_rating, delivery_rating, precision_rating, payment_terms, custom_payment_terms)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the query
        $stmt = $con->prepare($insertVendorQuery);

        if ($stmt === false) {
            die("Error preparing query: " . $con->error); // Display SQL preparation error
        }

        // Bind parameters
        $stmt->bind_param("ssssssssssssss", $vendorName, $vendorAddress, $vendorGST, $vendorContact, $vendorEmail, $vendorWhatsapp, $vendorPAN, $facilities, $pricingRating, $qualityRating, $deliveryRating, $precisionRating, $paymentTerms, $customPaymentTerms);

        // Execute the query
        if ($stmt->execute()) {
            header("Location: ../vendor.php");
        } else {
            echo "Error: " . $stmt->error; // Display execution error
        }

        $stmt->close();
    }
}


?>
