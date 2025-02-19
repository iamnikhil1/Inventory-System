<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "items_info");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST['id'];
    $item_number = $_POST['item_number'];
    $item_name = $_POST['item_name'];
    $item_type = $_POST['item_type'];
    $item_category = $_POST['item_category'];
    $location_details = $_POST['location_details'];
    $unit_of_measurement = $_POST['unit_of_measurement'];
    $gst = $_POST['gst'];
    $hsn_sac = $_POST['hsn_sac'];
    $sales_price = $_POST['sales_price'];
    $lot_tracking = isset($_POST['lot_tracking']) ? 1 : 0;
    $expiration_tracking = isset($_POST['expiration_tracking']) ? 1 : 0;
    $block = isset($_POST['block']) ? 1 : 0;
    $barcode = $_POST['barcode'];

    // Update query
    $sql = "UPDATE items SET 
                item_number='$item_number', 
                item_name='$item_name', 
                item_type='$item_type', 
                item_category='$item_category', 
                location='$location_details', 
                unit_of_measurement='$unit_of_measurement', 
                gst='$gst', 
                hsn_sac='$hsn_sac', 
                sales_price='$sales_price', 
                lot_tracking='$lot_tracking', 
                expiration_tracking='$expiration_tracking', 
                block='$block',
                barcode='$barcode' 
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect to items.php after successful update
        header("Location: items.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>
