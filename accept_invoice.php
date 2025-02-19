<?php
$conn = new mysqli("localhost", "root", "", "items_info") or die("Connection failed: " . mysqli_connect_error());

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

        // Function to generate a new unique invoice number
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

        // Step 3: Insert into quotations table
        $quotation_sql = "INSERT INTO quotations (
            invoice_number, quotation_number, quotation_date, client_name, client_address, client_phone, 
            client_city, client_state, client_country, client_pincode, client_gst_no, 
            shipper_location, shipper_company, shipper_address, shipper_city, shipper_state, 
            shipper_country, shipper_pincode, shipper_phone, shipper_gst_no, 
            total_igst, total_sgst, total_cgst, base_value, gross_amount, 
            discount_amount, final_amount, terms_and_conditions
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt_quotation = $conn->prepare($quotation_sql);
        $stmt_quotation->bind_param("ssssssssssssssssssssddddddds", 
            $new_invoice_number, $invoice_data['quotation_number'], $invoice_data['invoice_date'], 
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

        $quotation_id = $conn->insert_id; // Get the inserted quotation ID

        // Step 4: Fetch invoice items and insert into quotation_items and item_leisure tables
        $query_items = "SELECT * FROM invoice_items WHERE invoice_id = ?";
        $stmt_items = $conn->prepare($query_items);
        $stmt_items->bind_param("i", $invoice_id);
        $stmt_items->execute();
        $items_result = $stmt_items->get_result();

        $quotation_item_sql = "INSERT INTO quotation_items (
            invoice_id, item_number, invoice_number, quotation_number, product_name, unit, quantity, rate, 
            gst_percentage, igst, sgst, cgst, amount, value, lot_tracking_id, expiring_date
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_quotation_item = $conn->prepare($quotation_item_sql);

        // Prepare the item_leisure insertion query
        $item_leisure_sql = "INSERT INTO item_leisure (
            product_type, invoice_number, entry_type, product_id, product_name, quantity, location, unit, date, 
            lot_tracking_id, expiring_date
        ) VALUES ('sales', ?,'sales_invoice', ?, ?, ?, ?, ?, CURDATE(), ?, ?)";
        $stmt_item_leisure = $conn->prepare($item_leisure_sql);

        while ($item = $items_result->fetch_assoc()) {
            // Insert into quotation_items
            $stmt_quotation_item->bind_param("isssssddddddddss", 
                $quotation_id, $item['item_number'], $new_invoice_number, $invoice_data['quotation_number'], $item['product_name'], 
                $item['unit'], $item['quantity'], $item['rate'], $item['gst_percentage'], 
                $item['igst'], $item['sgst'], $item['cgst'], $item['amount'], $item['value'], $item['lot_tracking_id'], $item['expiring_date']
            );

            if (!$stmt_quotation_item->execute()) {
                throw new Exception("Error inserting into quotation_items: " . $stmt_quotation_item->error);
            }

            // Calculate negative quantity: multiplication of value and quantity, then negative
            $negative_quantity = -1 * ($item['quantity'] * $item['value']);

            // Fetch the base unit from item_unit_details table where base='1' for this item_number
            $query_base_unit = "SELECT unit FROM item_unit_details WHERE item_number = ? AND base = '1' LIMIT 1";
            $stmt_unit = $conn->prepare($query_base_unit);
            $stmt_unit->bind_param("s", $item['item_number']);
            $stmt_unit->execute();
            $result_unit = $stmt_unit->get_result();
            if ($result_unit->num_rows > 0) {
                $row_unit = $result_unit->fetch_assoc();
                $base_unit = $row_unit['unit'];
			}
            $stmt_unit->close();

            // For location, use the shipper_location from the invoice data
            $location = $invoice_data['shipper_location'];

            // Insert into item_leisure table using the base unit from item_unit_details
            $stmt_item_leisure->bind_param("sssdssds",
			    $new_invoice_number, 
                $item['item_number'],    // product_id
                $item['product_name'],   // product_name
                $negative_quantity,      // quantity (negative)
                $location,               // location
                $base_unit,              // unit (from item_unit_details where base='1')
                $item['lot_tracking_id'],// lot_tracking_id
                $item['expiring_date']   // expiring_date (date format)
            );

            if (!$stmt_item_leisure->execute()) {
                throw new Exception("Error inserting into item_leisure: " . $stmt_item_leisure->error);
            }
        }

        // Commit the transaction if everything is successful
        $conn->commit();
        echo json_encode(["status" => "success", "message" => "Invoice accepted and saved to quotations & item_leisure successfully!"]);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }

    // Close statements and connection
    $stmt_quotation->close();
    $stmt_quotation_item->close();
    $stmt_item_leisure->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "No invoice ID provided"]);
}
?>
