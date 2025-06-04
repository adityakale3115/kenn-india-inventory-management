<!-- Filters -->
<div class="filters">
    <h5>Filter Vendors</h5>
    <form class="row g-3" method="GET" action="process_filters.php">
        <!-- Facilities Checkboxes -->
        <div class="col-md-4">
            <label class="form-label">Facilities</label><br>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<input type="checkbox" id="facility' . htmlspecialchars($row['facility_id']) . '" 
                           name="facilities[]" 
                           value="' . htmlspecialchars($row['facility_name']) . '">';
                    echo '<label for="facility' . htmlspecialchars($row['facility_id']) . '"> ' . htmlspecialchars($row['facility_name']) . '</label><br>';
                }
            } else {
                echo "<p>No facilities available.</p>";
            }
            ?>
        </div>

        <!-- Rating Type Dropdown -->
        <div class="col-md-4">
            <label for="filterRatingType" class="form-label">Filter by Ratings</label>
            <select id="filterRatingType" class="form-select" name="filterRatingType">
                <option value="pricing">Pricing</option>
                <option value="quality">Quality</option>
                <option value="delivery">Delivery Time</option>
                <option value="precision">Precision</option>
            </select>
        </div>

        <!-- Minimum Rating Dropdown -->
        <div class="col-md-4">
            <label for="filterRatingValue" class="form-label">Minimum Rating</label>
            <select id="filterRatingValue" class="form-select" name="filterRatingValue">
                <option value="" disabled selected>Select a rating</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Apply Filters</button>
        </div>
    </form>
</div>

<?php
// Include database connection
include 'conn.php';

// Initialize variables
$selectedFacilities = isset($_POST['facilities']) ? $_POST['facilities'] : [];
$ratingType = isset($_POST['ratingType']) ? $_POST['ratingType'] : '';
$minRating = isset($_POST['minRating']) ? (int)$_POST['minRating'] : 0;

// Start building the query
$query = "SELECT * FROM vendors WHERE 1=1";

// Add facility filters
if (!empty($selectedFacilities)) {
    $facilityList = implode("','", array_map('mysqli_real_escape_string', array_map('trim', $selectedFacilities)));
    $query .= " AND facility_name IN ('$facilityList')";
}

// Add rating filter
if (!empty($ratingType) && $minRating > 0) {
    $ratingType = mysqli_real_escape_string($con, $ratingType); // Sanitize column name
    $query .= " AND $ratingType >= $minRating";
}

// Debugging: Output the final query (Optional: Use for debugging during development)
error_log("Executing query: $query");

// Execute the query
$result = $con->query($query);

// Check for errors in query execution
if (!$result) {
    die("Query failed: " . $con->error . "<br>SQL: " . $query);
}

// Display results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>" . htmlspecialchars($row['vendor_name']) . "</p>";
    }
} else {
    echo "<p>No vendors match the selected filters.</p>";
}


?>
