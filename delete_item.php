<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "items_info");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get ID from AJAX request
$id = $_POST['id']; // Use 'id' instead of 'item_number'

// Prepare and execute the delete query
$sql = "DELETE FROM item_unit_details WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Item deleted successfully.";

    // Reset AUTO_INCREMENT
    $sql_check = "SELECT MAX(id) AS max_id FROM item_unit_details";
    $result_check = mysqli_query($conn, $sql_check);
    $row = mysqli_fetch_assoc($result_check);

    if ($row['max_id']) {
        $next_id = $row['max_id'] + 1;
        $sql_reset = "ALTER TABLE item_unit_details AUTO_INCREMENT = {$next_id}";
    } else {
        $sql_reset = "ALTER TABLE item_unit_details AUTO_INCREMENT = 1";
    }

    mysqli_query($conn, $sql_reset) or die("Error resetting AUTO_INCREMENT: " . mysqli_error($conn));

} else {
    echo "Error deleting item: " . $conn->error;
}

// Close connections
$stmt->close();
$conn->close();
?>
