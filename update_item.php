<?php
$conn = new mysqli("localhost", "root", "", "items_info");

$id = $_POST['id'];  // Get the unique row ID
$item_number = $_POST['item_number'];
$item_name = $_POST['item_name'];
$unit = $_POST['unit'];
$value = $_POST['value'];
$base_unit = $_POST['base']; // Get checkbox value

// Ensure only one unit is active at a time
if ($base_unit == 1) {
    $checkActive = $conn->query("SELECT id FROM item_unit_details WHERE base = 1 AND item_number = '$item_number' AND id != '$id'");
    if ($checkActive->num_rows > 0) {
        echo "Error: Only one unit can be active.";
        exit;
    }
}

// Update the specific row using ID
$sql = "UPDATE item_unit_details SET 
        item_number='$item_number', 
        item_name='$item_name', 
        unit='$unit', 
        value='$value',
        base='$base_unit' 
        WHERE id='$id'";  // Use ID instead of item_number

if ($conn->query($sql) === TRUE) {
    echo "Item updated successfully";
} else {
    echo "Error: " . $conn->error;
}
?>
