<?php
$conn = new mysqli("localhost", "root", "", "items_info");

$item_number = $_POST['item_number'];
$item_name = $_POST['item_name'];
$unit = $_POST['unit'];
$value = $_POST['value'];
$base_unit = $_POST['base']; // Get checkbox value

if ($base == 1) {
    $checkActive = $conn->query("SELECT id FROM item_unit_details WHERE base = 1 AND item_number = '$item_number'");
    if ($checkActive->num_rows > 0) {
        echo "Error: Only one unit can be active.";
        exit;
    }
}

$sql = "INSERT INTO item_unit_details (item_number, item_name, unit, value, base) 
        VALUES ('$item_number', '$item_name', '$unit', '$value', '$base_unit')";

if ($conn->query($sql) === TRUE) {
    echo "Item added successfully";
} else {
    echo "Error: " . $conn->error;
}
?>
