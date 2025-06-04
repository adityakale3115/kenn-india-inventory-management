<?php include 'conn.php';

$facilitiesQuery = "SELECT facility_id, facility_name FROM facilities";
$result = $con->query($facilitiesQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Master</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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
    <?php include 'sidebar.php'

        ?>

    <!-- Main Content -->
    <div class="content">
        <h1>Vendor Master</h1>
        <div class="buttons">
            <!-- Add Vendor Button that triggers the modal -->
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#vendorModal">
                Add Vendor
            </button><!-- Button to trigger the Add Facilities modal -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFacilityModal">Add
                Facilities</button>

        </div><br>

        <!-- Filters for Vendors -->
        <div class="filters">
            <h5>Filter Vendors</h5>
            <form class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Facilities</label><br>
                    <?php
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo '<input type="checkbox" id="facility' . $row['facility_id'] . '" name="facilities[]" value="' . $row['facility_name'] . '">';
                            echo '<label for="facility' . $row['facility_id'] . '"> ' . $row['facility_name'] . '</label><br>';
                        }
                    } else {
                        echo "No facilities available.";
                    }
                    ?>
                </div>
                <div class="col-md-4">
                    <label for="filterRatingType" class="form-label">Filter by Ratings</label>
                    <select id="filterRatingType" class="form-select">
                        <option value="pricing">Pricing</option>
                        <option value="quality">Quality</option>
                        <option value="delivery">Delivery Time</option>
                        <option value="precision">Precision</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filterRatingValue" class="form-label">Minimum Rating</label>
                    <input type="number" id="filterRatingValue" class="form-control" min="1" max="5"
                        placeholder="Enter rating (1-5)">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>
        </div>
        <br>

        <!-- Table for Vendor List -->
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Vendor Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">GST No.</th>
                        <th scope="col">PAN Number</th> <!-- New Column for PAN Number -->
                        <th scope="col">Contact</th>
                        <th scope="col">Email</th>
                        <th scope="col">WhatsApp</th>

                        <th scope="col">Facilities</th>
                        <th scope="col">Payment Terms</th>
                        <th scope="col">Pricing Ratings</th>
                        <th scope="col">Quality Ratings</th>
                        <th scope="col">Delivery Ratings</th>
                        <th scope="col">Precision Ratings</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                   <?php include 'fetch/fetch_vendors_data.php'; ?>
                </tbody>

            </table>
        </div>
    </div>

    <!-- Modal for Adding Vendor -->
    <div class="modal fade" id="vendorModal" tabindex="-1" aria-labelledby="vendorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorModalLabel">Add Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for adding vendor -->
                    <form action="add/add_vendor.php" method="POST">
                        <div class="mb-3">
                            <label for="vendorName" class="form-label">Vendor Name</label>
                            <input type="text" class="form-control" id="vendorName" name="vendorName" required>
                        </div>
                        <div class="mb-3">
                            <label for="vendorAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="vendorAddress" name="vendorAddress" required>
                        </div>
                        <div class="mb-3">
                            <label for="vendorGST" class="form-label">GST No.</label>
                            <input type="text" class="form-control" id="vendorGST" name="vendorGST" required>
                        </div>
                        <div class="mb-3">
                            <label for="vendorContact" class="form-label">Contact</label>
                            <input type="text" class="form-control" id="vendorContact" name="vendorContact" required>
                        </div>
                        <div class="mb-3">
                            <label for="vendorEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="vendorEmail" name="vendorEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="vendorWhatsapp" class="form-label">WhatsApp</label>
                            <input type="text" class="form-control" id="vendorWhatsapp" name="vendorWhatsapp" required>
                        </div>
                        <div class="mb-3">
                            <label for="vendorPAN" class="form-label">PAN Number</label>
                            <input type="text" class="form-control" id="vendorPAN" name="vendorPAN" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Facilities</label><br>
                            <?php
                            $facilitiesQueryy = "SELECT facility_id, facility_name FROM facilities";
                            $resultt = $con->query($facilitiesQueryy);
                            if ($resultt && $resultt->num_rows > 0) {
                                while ($row = $resultt->fetch_assoc()) {
                                    echo '<input type="checkbox" id="facility' . $row['facility_id'] . '" name="facilities[]" value="' . $row['facility_name'] . '">';
                                    echo '<label for="facility' . $row['facility_id'] . '"> ' . $row['facility_name'] . '</label><br>';
                                }
                            } else {
                                echo "No facilities available or query failed.";
                            }
                            ?>
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

                        <div class="mb-3">
                            <label for="pricingRating" class="form-label">Pricing Ratings</label>
                            <input type="number" class="form-control" id="pricingRating" name="pricingRating" min="1"
                                max="5" required>
                        </div>
                        <div class="mb-3">
                            <label for="qualityRating" class="form-label">Quality Ratings</label>
                            <input type="number" class="form-control" id="qualityRating" name="qualityRating" min="1"
                                max="5" required>
                        </div>
                        <div class="mb-3">
                            <label for="deliveryRating" class="form-label">Delivery Time Ratings</label>
                            <input type="number" class="form-control" id="deliveryRating" name="deliveryRating" min="1"
                                max="5" required>
                        </div>
                        <div class="mb-3">
                            <label for="precisionRating" class="form-label">Precision Ratings</label>
                            <input type="number" class="form-control" id="precisionRating" name="precisionRating"
                                min="1" max="5" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Vendor</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal for Adding Facilities -->
    <div class="modal fade" id="addFacilityModal" tabindex="-1" aria-labelledby="addFacilityModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFacilityModalLabel">Add New Facility</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for adding facility -->
                    <form action="add/add_facility.php" method="POST">
                        <div class="mb-3">
                            <label for="facilityName" class="form-label">Facility Name</label>
                            <input type="text" class="form-control" id="facilityName" name="facilityName"
                                placeholder="Enter facility name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Facility</button>
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