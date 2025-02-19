<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "items_info";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Generate unique quotation number
function generateUniqueQuotationNumber($conn) {
    $query = "SELECT MAX(CAST(SUBSTRING(invoice_number, 4) AS UNSIGNED)) AS last_invoice_number FROM quotations";
    $result = $conn->query($query);
    
    $last_invoice_number = 0;
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_invoice_number = $row['last_invoice_number'] ? $row['last_invoice_number'] : 0;
    }

    return "INV" . str_pad($last_invoice_number + 1, 4, "0", STR_PAD_LEFT);
}

// Generate a new quotation number
$new_invoice_number = generateUniqueQuotationNumber($conn);

$conn->begin_transaction();

try {
    $quotation_date = date('Y-m-d');

    // Step 1: Insert into quotations table
    $quotation_sql = "INSERT INTO quotations (
        invoice_number, quotation_date, client_name, client_address, client_phone, 
        client_city, client_state, client_country, client_pincode, client_gst_no, 
        shipper_location, shipper_company, shipper_address, shipper_city, shipper_state, 
        shipper_country, shipper_pincode, shipper_phone, shipper_gst_no, 
        total_igst, total_sgst, total_cgst, base_value, gross_amount, 
        discount_amount, final_amount, terms_and_conditions
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Debugging: Ensure all $_POST fields are set
    if (empty($_POST['client_name']) || empty($_POST['client_address']) || empty($_POST['client_phone']) || empty($_POST['product_name'])) {
        throw new Exception("Missing required fields in POST data.");
    }

    $stmt_invoice = $conn->prepare($quotation_sql);
    $stmt_invoice->bind_param("sssssssssssssssssssddddddds", 
        $new_invoice_number, $quotation_date, 
        $_POST['client_name'], $_POST['client_address'], $_POST['client_phone'], 
        $_POST['client_city'], $_POST['client_state'], $_POST['client_country'], $_POST['client_pincode'], $_POST['client_gst_no'], 
        $_POST['shipper_location'], $_POST['shipper_company'], $_POST['shipper_address'], $_POST['shipper_city'], $_POST['shipper_state'], 
        $_POST['shipper_country'], $_POST['shipper_pincode'], $_POST['shipper_phone'], $_POST['shipper_gst_no'], 
        $_POST['total_igst'], $_POST['total_sgst'], $_POST['total_cgst'], $_POST['base_value'], $_POST['gross_amount'], 
        $_POST['discount_amount'], $_POST['final_amount'], $_POST['terms_and_conditions']
    );

    if (!$stmt_invoice->execute()) {
        throw new Exception("Error inserting invoice: " . $stmt_invoice->error);
    }
    $invoice_id = $conn->insert_id; // Get the newly created invoice ID
    
 


    // Step 2: Insert product details into quotation_items table
    $quotation_item_sql = "INSERT INTO quotation_items (
        invoice_id, item_number, invoice_number, product_name, unit, quantity, rate, gst_percentage, 
        igst, sgst, cgst, amount, value, lot_tracking_id, expiring_date
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt_product = $conn->prepare($quotation_item_sql);

    // Step 3: Insert data into item_leisure table
    $item_leisure_sql = "INSERT INTO item_leisure (
        product_type, invoice_number, entry_type, product_id, product_name, quantity, location, 
        unit, lot_tracking_id, expiring_date, date
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt_leisure = $conn->prepare($item_leisure_sql);

    // Check if product details are set in POST data
    if (empty($_POST['product_name']) || !is_array($_POST['product_name'])) {
        throw new Exception("No product details provided.");
    }

    foreach ($_POST['product_name'] as $index => $product_name) {
        // Ensure all required product fields are set
        if (empty($_POST['unit_cleaned'][$index]) || empty($_POST['quantity'][$index]) || empty($_POST['rate'][$index])) {
            throw new Exception("Missing product details for product at index " . $index);
        }
    
        // Store values in variables
        $item_number = $_POST['item_number'][$index];
        $unit_cleaned = $_POST['unit_cleaned'][$index];
        $quantity = $_POST['quantity'][$index];
        $rate = $_POST['rate'][$index];
        $gst = $_POST['gst'][$index];
        $igst = $_POST['igst'][$index];
        $sgst = $_POST['sgst'][$index];
        $cgst = $_POST['cgst'][$index];
        $amount = $_POST['amount'][$index];
        $value = $_POST['value'][$index];
        $lot_tracking_id = $_POST['lot_tracking_id'][$index];
        $expiring_date = $_POST['expiring_date'][$index];
    
        // Bind parameters for quotation_items
        $stmt_product->bind_param("issssddddddssss", 
            $invoice_id, $item_number, $new_invoice_number, $product_name, 
            $unit_cleaned, $quantity, $rate, 
            $gst, $igst, $sgst, $cgst, 
            $amount, $value, $lot_tracking_id, $expiring_date
        );
    
        if (!$stmt_product->execute()) {
            throw new Exception("Error inserting product: " . $stmt_product->error);
        }
    
        // Store values for item_leisure
        $product_type = "inventory";
        $entry_type = "in";
        $product_id = $item_number;
        $location = $_POST['shipper_location']; // Assuming shipper_location is the location
        $date = $quotation_date;
         // Calculate negative quantity
         $negative_quantity = -1 * ($quantity * $value);
         // Fetch the base unit from item_unit_details table where base=1 for this item_number
$query_base_unit = "SELECT unit FROM item_unit_details WHERE item_number = ? AND base = '1' LIMIT 1";
$stmt_unit = $conn->prepare($query_base_unit);
$stmt_unit->bind_param("s", $item_number);
$stmt_unit->execute();
$result_unit = $stmt_unit->get_result();
if ($result_unit->num_rows > 0) {
    $row_unit = $result_unit->fetch_assoc();
    $base_unit = $row_unit['unit'];
} else {
    $base_unit = "piece"; // default if not found
}
$stmt_unit->close();

    
        // Bind parameters for item_leisure
        $stmt_leisure->bind_param("sssssisssss", 
            $product_type, $new_invoice_number, $entry_type, $product_id, $product_name, 
            $negative_quantity , $location, $base_unit, 
            $lot_tracking_id, $expiring_date, $date
        );
    
        if (!$stmt_leisure->execute()) {
            throw new Exception("Error inserting into item_leisure: " . $stmt_leisure->error);
        }
    }
    

    // Commit the transaction
    $conn->commit();

    echo "<script>
            alert('Invoice and Item Leisure saved successfully!');
            window.location.href='invoice.php';
          </script>";

} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

// Close statements only if they were initialized
if (isset($stmt_invoice)) $stmt_invoice->close();
if (isset($stmt_product)) $stmt_product->close();
if (isset($stmt_leisure)) $stmt_leisure->close();
$conn->close();
?>
