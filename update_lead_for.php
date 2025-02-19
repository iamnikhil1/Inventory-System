<?php
$id= $_POST['id'];
$name = $_POST['name'];
$status = $_POST['status'];

$conn = mysqli_connect("localhost", "root", "", "leads_details");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "UPDATE for_lead SET name = '{$name}', status = '{$status}' WHERE id = {$id}";
$stmt = $conn->prepare($query);

if ($stmt->execute()) {
    header("Location: lead_for.php?message=add_success");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: http://localhost/Log/lead_for.php");
// After updating the lead
header("Location: lead_for.php?message=Lead updated successfully");
exit();

?>


