<?php
$conn = mysqli_connect("localhost", "root", "", "items_info") or die("Connection failed: " . mysqli_connect_error());

if (isset($_GET['id'])) {
    $invoice_id = $_GET['id'];

    // Begin a transaction to ensure data consistency
    $conn->begin_transaction();

    try {
        // Step 1: Update the invoice status to 'accepted'
        $query = "UPDATE invoices SET status = 'accepted' WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $invoice_id);
        if (!$stmt->execute()) {
            throw new Exception("Error updating invoice status: " . $stmt->error);
        }

        // Step 2: Fetch the invoice data
        $query_invoice = "SELECT * FROM invoices WHERE id = ?";
        $stmt = $conn->prepare($query_invoice);
        $stmt->bind_param("i", $invoice_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result || $result->num_rows == 0) {
            throw new Exception("Invoice not found");
        }
        $invoice_data = $result->fetch_assoc();

        // Function to generate a new unique invoice number (e.g., INV0001)
        function generateUniqueInvoiceNumber($conn) {
            $query = "SELECT MAX(CAST(SUBSTRING(invoice_number, 4) AS UNSIGNED)) AS last_invoice_number FROM quotations";
            $result = $conn->query($query);
            
            $last_invoice_number = 0;
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $last_invoice_number = $row['last_invoice_number'] ? $row['last_invoice_number'] : 0;
            }

            return "INV" . str_pad($last_invoice_number + 1, 4, "0", STR_PAD_LEFT);
        }

        $new_invoice_number = generateUniqueInvoiceNumber($conn);
        $quotation_date = date('Y-m-d');

        // Step 3: Insert into quotations table
        $quotation_sql = "INSERT INTO quotations (
            invoice_number, quotation_number,quotation_date, client_name, client_address, client_phone, 
            client_city, client_state, client_country, client_pincode, client_gst_no, 
            shipper_location, shipper_company, shipper_address, shipper_city, shipper_state, 
            shipper_country, shipper_pincode, shipper_phone, shipper_gst_no, 
            total_igst, total_sgst, total_cgst, base_value, gross_amount, 
            discount_amount, final_amount, terms_and_conditions
        ) VALUES (?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt_quotation = $conn->prepare($quotation_sql);
        $stmt_quotation->bind_param("sssssssssssssssssssssddddds", 
            $new_invoice_number, $invoice_data['quotation_number'], $quotation_date, 
            $invoice_data['client_name'], $invoice_data['client_address'], $invoice_data['client_phone'], 
            $invoice_data['client_city'], $invoice_data['client_state'], $invoice_data['client_country'], 
            $invoice_data['client_pincode'], $invoice_data['client_gst_no'], 
            $invoice_data['shipper_location'], $invoice_data['shipper_company'], $invoice_data['shipper_address'], 
            $invoice_data['shipper_city'], $invoice_data['shipper_state'], $invoice_data['shipper_country'], 
            $invoice_data['shipper_pincode'], $invoice_data['shipper_phone'], $invoice_data['shipper_gst_no'], 
            $invoice_data['total_igst'], $invoice_data['total_sgst'], $invoice_data['total_cgst'], 
            $invoice_data['base_value'], $invoice_data['gross_amount'], $invoice_data['discount_amount'], 
            $invoice_data['final_amount'], $invoice_data['terms_and_conditions']
        );

        if (!$stmt_quotation->execute()) {
            throw new Exception("Error inserting into quotations: " . $stmt_quotation->error);
        }

    // Get the inserted quotation ID

        // Step 4: Fetch invoice items and insert into quotation_items table
        $query_items = "SELECT * FROM invoice_items WHERE invoice_id = ?";
        $stmt_items = $conn->prepare($query_items);
        $stmt_items->bind_param("i", $invoice_id);
        $stmt_items->execute();
        $items_result = $stmt_items->get_result();

        $quotation_item_sql = "INSERT INTO quotation_items (
            invoice_id, invoice_number, product_name, unit, quantity, rate, gst_percentage, igst, sgst, cgst, amount
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt_quotation_item = $conn->prepare($quotation_item_sql);

        while ($item = $items_result->fetch_assoc()) {
            $stmt_quotation_item->bind_param("isssdddddds", 
            $item['invoice_id'], $new_invoice_number, $item['product_name'], 
                $item['unit'], $item['quantity'], $item['rate'], $item['gst_percentage'], 
                $item['igst'], $item['sgst'], $item['cgst'], $item['amount']
            );

            if (!$stmt_quotation_item->execute()) {
                throw new Exception("Error inserting into quotation_items: " . $stmt_quotation_item->error);
            }
        }

        // Commit the transaction if everything is successful
        $conn->commit();
        echo "<script>
                alert('Invoice accepted and saved to quotations successfully!');
                window.location.href='quotation.php';
              </script>";

    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    // Close statements and connection
    if (isset($stmt_quotation)) $stmt_quotation->close();
    if (isset($stmt_quotation_item)) $stmt_quotation_item->close();
    $conn->close();
}
?>
