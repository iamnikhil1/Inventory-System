<?php
$conn = new mysqli("localhost", "root", "", "items_info");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['invoice_number'])) {
    $invoice_number = $_GET['invoice_number'];

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Step 1: Update invoice status to 'rejected'
        $query = "UPDATE quotations SET status = 'rejected' WHERE invoice_number = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $invoice_number);

        if ($stmt->execute()) {
            // Step 2: Flip the sign of quantity in item_leisure for the same invoice_number
            $query = "UPDATE item_leisure SET quantity = IF(quantity < 0, -quantity, quantity) WHERE invoice_number = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $invoice_number);
            if ($stmt->execute()) {
                $conn->commit();
                echo json_encode(["status" => "success", "message" => "Invoice rejected successfully"]);
            } else {
                throw new Exception("Error flipping quantity sign in item_leisure: " . $stmt->error);
            }
        } else {
            throw new Exception("Error updating invoice status: " . $stmt->error);
        }
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invoice number is missing"]);
}
?>
