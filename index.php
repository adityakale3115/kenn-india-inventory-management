<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        section {
            padding: 1rem;
        }

        form {
            text-align: center;
            margin-top: 2rem;
        }

        label {
            font-weight: bold;
            font-size: 1.5rem;
            font-family: "Bebas Neue", sans-serif;
        }

        select,
        table {
            margin: 1rem auto;
            border: 1px solid #ccc;
            border-collapse: collapse;
            width: 90%;
            text-align: left;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background-color: #f4f4f4;
        }

        .container {
            margin-top: 1rem;
            border-top: 2px solid black;
            border-bottom: 2px solid black;
            overflow-x: auto;
            white-space: nowrap;
        }

        button {
            border-radius: 200px;
        }

        .vendor-checkboxes {
            margin: 1rem;
        }

        .vendor-checkboxes input {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <?php 
    // Include sidebar
    if (!@include('sidebar.php')) {
        echo "<p>Error loading sidebar.</p>";
    }
    ?>
    <div class="content">
        <div class="content-header">
            <h1>Welcome to Kenn India</h1>
            <p>Manage Machines, Vendors, and payroll efficiently.</p>
        </div>

        <div class="cards">
            <div class="card">
                <h3>Total Machines</h3>
                <p>150</p>
            </div>
            <div class="card">
                <h3>Total Vendors</h3>
                <p>120</p>
            </div>
            <div class="card">
                <h3>Total Projects</h3>
                <p>30</p>
            </div>
        </div>

        <!-- Dropdown for Project Selection -->
        <form>
            <label for="project">Select Project:</label>
            <select id="project" name="project">
                <option value="">--Select Project--</option>
                <?php
                // Database connection
                include 'conn.php';
                $result = $con->query("SELECT project_number FROM project_master");
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row['project_number']) . '">' . htmlspecialchars($row['project_number']) . '</option>';
                    }
                } else {
                    echo '<option value="">No Projects Available</option>';
                }
                ?>
            </select>
        </form>

        <!-- Vendor Selection Section -->
        <div class="vendor-checkboxes">
            <label>Select Vendor(s):</label><br>
            <?php
            $vendorQuery = "SELECT vendor_name FROM vendors";
            $vendorResult = $con->query($vendorQuery);
            if ($vendorResult && $vendorResult->num_rows > 0) {
                while ($vendorRow = $vendorResult->fetch_assoc()) {
                    echo '<input type="checkbox" name="vendor[]" value="' . htmlspecialchars($vendorRow['vendor_name']) . '">' . htmlspecialchars($vendorRow['vendor_name']) . '<br>';
                }
            } else {
                echo '<p>No vendors available.</p>';
            }
            ?>
        </div>

        <!-- BOM Table -->
        <div class="container">
            <table>
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Price</th>
                        <th>Item No</th>
                        <th>Quantity</th>
                        <th>Part No</th>
                        <th>Description</th>
                        <th>Material</th>
                        <th>Finish Material Size</th>
                        <th>Finish Material Weight</th>
                        <th>Remark 1</th>
                        <th>Remark 2</th>
                        <th>Remark 3</th>
                        <th>Remark 4</th>
                    </tr>
                </thead>
                <tbody id="bomTable">
                    <!-- Data will be dynamically added here -->
                </tbody>
            </table>
        </div>

        <!-- Generate PO Button -->
        <button id="generatePOButton">Generate PO</button>
    </div>

    <script>
        $(document).ready(function () {
            // Fetch BOM data based on project selection
            $('#project').change(function () {
                const projectNumber = $(this).val();
                if (projectNumber) {
                    $.ajax({
                        url: 'fetch_bom.php',
                        type: 'POST',
                        data: { project_number: projectNumber },
                        success: function (data) {
                            if (data) {
                                $('#bomTable').html(data);
                            } else {
                                $('#bomTable').html('<tr><td colspan="12">No data available for the selected project.</td></tr>');
                            }
                        },
                        error: function () {
                            $('#bomTable').html('<tr><td colspan="12">Error fetching BOM data. Please try again later.</td></tr>');
                        }
                    });
                } else {
                    $('#bomTable').html('');
                }
            });

            // Handle "Generate PO" button click
            $('#generatePOButton').click(function () {
                const selectedParts = [];
                $('input[name="select_part[]"]:checked').each(function () {
                    selectedParts.push($(this).val());
                });

                const selectedVendors = $('input[name="vendor[]"]:checked').map(function () {
                    return $(this).val();
                }).get();

                const prices = {};
                $('input[name^="price"]').each(function () {
                    prices[$(this).attr('name')] = $(this).val();
                });

                if (selectedParts.length === 0 || selectedVendors.length === 0) {
                    alert('Please select at least one part and one vendor.');
                    return;
                }

                // Send data to generate PO PDF
                $.ajax({
                    url: 'generate_po.php',
                    type: 'POST',
                    data: {
                        selectedParts: selectedParts,
                        selectedVendors: selectedVendors,
                        prices: prices
                    },
                    success: function (response) {
                        try {
                            const res = JSON.parse(response);
                            if (res.success) {
                                window.open(res.fileUrl, '_blank'); // Opens the generated PO document
                            } else {
                                alert('Error: ' + res.message);
                            }
                        } catch (e) {
                            alert('Unexpected error occurred.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error: ', error);
                        alert('Failed to generate PO. Please try again.');
                    }
                });
            });
        });
    </script>
</body>

</html>
