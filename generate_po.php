<?php
require 'vendor/autoload.php';
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// Database connection parameters
$host = 'localhost';
$dbname = 'kennindia';
$user = 'root';
$pass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("Debug: POST request received.");

    // Retrieve data from the POST request
    $selectedParts = isset($_POST['selectedParts']) ? $_POST['selectedParts'] : [];
    $selectedVendors = isset($_POST['selectedVendors']) ? $_POST['selectedVendors'] : [];
    $prices = isset($_POST['prices']) ? $_POST['prices'] : [];

    error_log("Debug: Selected Parts: " . print_r($selectedParts, true));
    error_log("Debug: Selected Vendors: " . print_r($selectedVendors, true));
    error_log("Debug: Prices: " . print_r($prices, true));

    if (empty($selectedParts) || empty($selectedVendors)) {
        error_log("Error: No parts or vendors selected.");
        echo json_encode(['success' => false, 'message' => 'No parts or vendors selected.']);
        exit;
    }

    try {
        // Generate a unique PO number (You can modify the format as needed)
        $poNumber = 'PO-' . strtoupper(uniqid());

        // Create a new Word document
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->addTitle("Purchase Order", 1);

        // Add PO number and vendor information
        $section->addText("PO Number: " . $poNumber, ['bold' => true]);
        $section->addText("Vendors:", ['bold' => true]);
        foreach ($selectedVendors as $vendor) {
            $section->addText("- " . htmlspecialchars($vendor));
        }

        // Add table for selected parts
        $section->addText("\nParts Information:", ['bold' => true]);
        $table = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '999999',
            'cellMargin' => 50,
        ]);
        $table->addRow();
        $table->addCell(2000)->addText('Part Number', ['bold' => true]);
        $table->addCell(3000)->addText('Description', ['bold' => true]);
        $table->addCell(2000)->addText('Quantity', ['bold' => true]);
        $table->addCell(2000)->addText('Price', ['bold' => true]);

        foreach ($selectedParts as $part) {
            $table->addRow();
            $table->addCell(2000)->addText(htmlspecialchars($part));
            $table->addCell(3000)->addText("Description for Part " . htmlspecialchars($part));
            $table->addCell(2000)->addText("1");
            $table->addCell(2000)->addText(htmlspecialchars($prices["price_$part"] ?? '0'));
        }

        // Save the document
        $fileName = "Purchase_Order_" . time() . ".docx";
        $filePath = __DIR__ . "/generated_docs/" . $fileName;

        if (!is_dir(__DIR__ . "/generated_docs")) {
            if (!mkdir(__DIR__ . "/generated_docs", 0777, true)) {
                error_log("Error: Failed to create directory.");
                echo json_encode(['success' => false, 'message' => 'Failed to create directory for generated documents.']);
                exit;
            }
        }

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($filePath);

        // Insert data into the database
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("INSERT INTO purchase_order (po_number, vendors, parts, file_path, created_at) 
                                   VALUES (:po_number, :vendors, :parts, :file_path, NOW())");
            $stmt->execute([
                ':po_number' => $poNumber,
                ':vendors' => json_encode($selectedVendors),
                ':parts' => json_encode($selectedParts),
                ':file_path' => $filePath,
            ]);

            error_log("Debug: Data inserted into the database.");
        } catch (PDOException $e) {
            error_log("Error: Failed to insert data into database - " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Failed to insert data into the database.']);
            exit;
        }

        echo json_encode(['success' => true, 'fileUrl' => "generated_docs/" . $fileName]);
    } catch (Exception $e) {
        error_log("Error: Failed to generate document - " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error generating document.']);
    }
} else {
    error_log("Error: Invalid request method.");
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
