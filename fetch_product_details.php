<?php
// fetch_product_details.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "leads_details";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_id = $_GET['product_id'];

// Fetch the rate from the items table
$productQuery = "SELECT rate FROM items WHERE item_number = ?";
$stmt = $conn->prepare($productQuery);
$stmt->bind_param("s", $product_id);
$stmt->execute();
$productResult = $stmt->get_result();
$product = $productResult->fetch_assoc();

// Fetch unit details from the item_unit_details table
$unitQuery = "SELECT unit_name FROM item_unit_details WHERE item_number = ?";
$stmt = $conn->prepare($unitQuery);
$stmt->bind_param("s", $product_id);
$stmt->execute();
$unitResult = $stmt->get_result();

$units = [];
while ($unit = $unitResult->fetch_assoc()) {
    $units[] = $unit;
}

echo json_encode(['rate' => $product['rate'], 'units' => $units]);
?>
