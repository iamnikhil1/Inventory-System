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
    $query = "SELECT MAX(CAST(SUBSTRING(quotation_number, 4) AS UNSIGNED)) AS last_quotation_number FROM invoices";
    $result = $conn->query($query);
    
    $last_quotation_number = 0;
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_quotation_number = $row['last_quotation_number'] ? $row['last_quotation_number'] : 0;
    }

    return "QUO" . str_pad($last_quotation_number + 1, 4, "0", STR_PAD_LEFT);
}

// Generate a new quotation number
$new_quotation_number = generateUniqueQuotationNumber($conn);

$conn->begin_transaction();

try {
    $quotation_date = date('Y-m-d');

    // Step 1: Insert into invoices table
    $invoice_sql = "INSERT INTO invoices (
        quotation_number, invoice_date, client_name, client_address, client_phone, 
        client_city, client_state, client_country, client_pincode, client_gst_no, 
        shipper_location, shipper_company, shipper_address, shipper_city, shipper_state, 
        shipper_country, shipper_pincode, shipper_phone, shipper_gst_no, 
        total_cgst, total_sgst, total_igst, base_value, gross_amount, 
        discount_amount, terms_and_conditions, final_amount
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt_invoice = $conn->prepare($invoice_sql);
    $stmt_invoice->bind_param("sssssssssssssssssssssssssss", 
        $new_quotation_number, $quotation_date, 
        $_POST['client_name'], $_POST['client_address'], $_POST['client_phone'], 
        $_POST['client_city'], $_POST['client_state'], $_POST['client_country'], $_POST['client_pincode'], $_POST['client_gst_no'], 
        $_POST['shipper_location'], $_POST['shipper_company'], $_POST['shipper_address'], $_POST['shipper_city'], $_POST['shipper_state'], 
        $_POST['shipper_country'], $_POST['shipper_pincode'], $_POST['shipper_phone'], $_POST['shipper_gst_no'], 
        $_POST['total_cgst'], $_POST['total_sgst'], $_POST['total_igst'], $_POST['base_value'], $_POST['gross_amount'], 
        $_POST['discount_amount'], $_POST['terms_and_conditions'], $_POST['final_amount']
    );

    if (!$stmt_invoice->execute()) {
        throw new Exception("Error inserting invoice: " . $stmt_invoice->error);
    }
    $invoice_id = $conn->insert_id; // Get the newly created invoice ID

    // Step 2: Insert product details into invoice_items table
    $product_sql = "INSERT INTO invoice_items (
        invoice_id, item_number, quotation_number, product_name, unit, quantity, rate, value, gst_percentage, igst, sgst, cgst, amount, lot_tracking_id, expiring_date
    ) VALUES (?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_product = $conn->prepare($product_sql);

    foreach ($_POST['product_name'] as $index => $product_name) {
        $stmt_product->bind_param("issssdddddddsss", 
            $invoice_id,$_POST['item_number'][$index], $new_quotation_number, $product_name, 
            $_POST['unit_cleaned'][$index], $_POST['quantity'][$index], $_POST['rate'][$index],$_POST['value'][$index],
            $_POST['gst'][$index], $_POST['igst'][$index], $_POST['sgst'][$index], $_POST['cgst'][$index], $_POST['amount'][$index], $_POST['lot_tracking_id'][$index], $_POST['expiring_date'][$index]
        );
        $stmt_product->execute();
    }

    $conn->commit();

    echo "<script>
            alert('Invoice saved successfully!');
            window.location.href='quotation.php';
          </script>";

} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

// Close statements only if they were initialized
if (isset($stmt_invoice)) $stmt_invoice->close();
if (isset($stmt_product)) $stmt_product->close();
$conn->close();
?>
