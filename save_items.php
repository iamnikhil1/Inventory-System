<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "items_info");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$item_number = trim($_POST['item_number']);
$item_name = trim($_POST['item_name']);
$item_type = trim($_POST['item_type']);
$item_category = trim($_POST['item_category']);
$location_details = trim($_POST['location_details']);
$unit_of_measurement = trim($_POST['unit_of_measurement']);
$gst = trim($_POST['gst']);
$hsn_sac = trim($_POST['hsn_sac']);
$sales_price = trim($_POST['sales_price']);
$lot_tracking = isset($_POST['lot_tracking']) ? 1 : 0;
$expiration_tracking = isset($_POST['expiration_tracking']) ? 1 : 0;
$block = isset($_POST['block']) ? 1 : 0;
$created_at = date("Y-m-d H:i:s");
$barcode = trim($_POST['barcode']);

// Check if item_number already exists
$check_sql = "SELECT * FROM items WHERE item_number = ?";
$stmt_check = $conn->prepare($check_sql);
$stmt_check->bind_param("s", $item_number);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    echo "Error: Item number already exists!";
    exit();
}

// Prepare SQL query to insert data into items table
$sql = "INSERT INTO items(item_number, item_name, item_type, item_category, location, unit_of_measurement, gst, hsn_sac, sales_price, lot_tracking, 
        expiration_tracking, block, created_at, barcode) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssdiiisi", $item_number, $item_name, $item_type, $item_category, 
                  $location_details, $unit_of_measurement, 
                  $gst, $hsn_sac, $sales_price, $lot_tracking, $expiration_tracking, 
                  $block, $created_at, $barcode);
if ($stmt->execute()) {
    // If the first query is successful, insert into item_unit_details
    $sql2 = "INSERT INTO item_unit_details (item_number, item_name, unit, base) 
            VALUES (?, ?, ?, 1)";  // Use prepared statement

    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("sss", $item_number, $item_name, $unit_of_measurement);

    if ($stmt2->execute()) {
        // If both queries are successful, redirect to items.php
        header("Location: items.php");
        exit();
    } else {
        echo "Error in inserting item unit details: " . $stmt2->error;
    }
} else {
    echo "Error in inserting item: " . $stmt->error;
}

// Close connections
$stmt->close();
$stmt2->close();
$conn->close();

?>
