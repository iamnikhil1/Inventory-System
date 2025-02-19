<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "items_info";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT MAX(CAST(SUBSTRING(quotation_number, 5) AS UNSIGNED)) AS last_quotation_number FROM invoices";
$result = $conn->query($query);

$quotation_number = "QUO0001"; // Default value if no records are found
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $last_quotation_number = $row['last_quotation_number'];
    $quotation_number = "QUO" . str_pad($last_quotation_number + 1, 4, "0", STR_PAD_LEFT);
}

echo json_encode(['quotation_number' => $quotation_number]);

$conn->close();
?>
