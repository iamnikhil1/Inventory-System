<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "items_info";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT MAX(CAST(SUBSTRING(invoice_number, 5) AS UNSIGNED)) AS last_invoice_number FROM quotations";
$result = $conn->query($query);

$invoice_number = "INV0001"; // Default value if no records are found
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $last_invoice_number = $row['last_invoice_number'];
    $invoice_number = "INV" . str_pad($last_invoice_number + 1, 4, "0", STR_PAD_LEFT);
}

echo json_encode(['invoice_number' => $invoice_number]);

$conn->close();
?>
