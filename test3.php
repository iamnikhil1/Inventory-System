<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "items_info";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$invoice_number = $_GET['invoice_number'];
$query = "SELECT * FROM quotations WHERE invoice_number = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $invoice_number);
$stmt->execute();
$result = $stmt->get_result();
$invoice_data = $result->fetch_assoc();

$product_query = "SELECT * FROM quotation_items WHERE invoice_number = ?";
$product_stmt = $conn->prepare($product_query);
$product_stmt->bind_param("s", $invoice_number);
$product_stmt->execute();
$product_result = $product_stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Bill</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="invoice-style.css">
</head>
<body>
    <div class="container">
        <div class="header-section">
            <h1>Invoice Bill</h1>
            <div class="invoice-details">
                <p><strong>Invoice Number:</strong> <?php echo $invoice_data['invoice_number']; ?></p>
                <p><strong>Invoice Date:</strong> <?php echo date('d-m-Y', strtotime($invoice_data['quotation_date'])); ?></p>
            </div>
            <div class="action-buttons">
                <button onclick="window.print();" class="btn btn-print">Print Invoice</button>
            </div>
        </div>

        <div class="client-shipper-section">
            <div class="details-column">
                <h2>Client Details</h2>
                <p><strong>Name:</strong> <?php echo $invoice_data['client_name']; ?></p>
                <p><strong>Address:</strong> <?php echo $invoice_data['client_address']; ?></p>
                <p><strong>Phone:</strong> <?php echo $invoice_data['client_phone']; ?></p>
                <p><strong>City:</strong> <?php echo $invoice_data['client_city']; ?></p>
                <p><strong>State:</strong> <?php echo $invoice_data['client_state']; ?></p>
                <p><strong>Country:</strong> <?php echo $invoice_data['client_country']; ?></p>
                <p><strong>Pincode:</strong> <?php echo $invoice_data['client_pincode']; ?></p>
                <p><strong>GST No.:</strong> <?php echo $invoice_data['client_gst_no']; ?></p>
            </div>
            <div class="details-column">
                <h2>Shipper Details</h2>
                <p><strong>Location:</strong> <?php echo $invoice_data['shipper_location']; ?></p>
                <p><strong>Company:</strong> <?php echo $invoice_data['shipper_company']; ?></p>
                <p><strong>Address:</strong> <?php echo $invoice_data['shipper_address']; ?></p>
                <p><strong>City:</strong> <?php echo $invoice_data['shipper_city']; ?></p>
                <p><strong>State:</strong> <?php echo $invoice_data['shipper_state']; ?></p>
                <p><strong>Country:</strong> <?php echo $invoice_data['shipper_country']; ?></p>
                <p><strong>Pincode:</strong> <?php echo $invoice_data['shipper_pincode']; ?></p>
                <p><strong>Phone:</strong> <?php echo $invoice_data['shipper_phone']; ?></p>
                <p><strong>GST No.:</strong> <?php echo $invoice_data['shipper_gst_no']; ?></p>
            </div>
        </div>

        <div class="product-details">
            <h2>Product Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Unit</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>GST%</th>
                        <th>IGST</th>
                        <th>SGST</th>
                        <th>CGST</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($product = $product_result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $product['product_name'] . "</td>
                            <td>" . $product['unit'] . "</td>
                            <td>" . $product['quantity'] . "</td>
                            <td>" . $product['rate'] . "</td>
                            <td>" . $product['gst_percentage'] . "</td>
                            <td>" . $product['igst'] . "</td>
                            <td>" . $product['sgst'] . "</td>
                            <td>" . $product['cgst'] . "</td>
                            <td>" . $product['amount'] . "</td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="terms-amount-section">
            <div class="terms-conditions">
                <h2>Terms and Conditions</h2>
                <p><?php echo nl2br($invoice_data['terms_and_conditions']); ?></p>
            </div>
            <div class="amount-section">
                <h2>Amount Breakdown</h2>
                <p><strong>Base Value:</strong> <?php echo $invoice_data['base_value']; ?></p>
                <p><strong>Gross Amount:</strong> <?php echo $invoice_data['gross_amount']; ?></p>
                <p><strong>Discount:</strong> <?php echo $invoice_data['discount_amount']; ?></p>
                <p class="total"><strong>Final Amount:</strong> <?php echo $invoice_data['final_amount']; ?></p>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$product_stmt->close();
$conn->close();
?>

