<?php
$conn = new mysqli("localhost", "root", "", "leads_details");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT item_number, item_name, rate FROM items");
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
echo json_encode($products);
?>
