<?php
include 'conn.php'; // Include your database connection

$query = "SELECT * FROM purchase_order ORDER BY created_at DESC";
$result = $con->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Orders</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="content">
    <h1 style="text-align: center;">Purchase Orders</h1>
    <table>
        <thead>
            <tr>
                <th>PO Number</th>
                <th>Generated At</th>

               
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                   
                    <tr>
                        <td><?php echo htmlspecialchars($row['po_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                        
                        
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No Purchase Orders found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</body>
</html>
