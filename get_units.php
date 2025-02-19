<?php
$conn = new mysqli("localhost", "root", "", "leads_details");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$item_number = $_GET['item_number'];
$result = $conn->query("SELECT unit_name FROM item_unit_details WHERE item_number='$item_number'");
$units = [];
while ($row = $result->fetch_assoc()) {
    $units[] = $row;
}
echo json_encode($units);
?>
