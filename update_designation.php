<?php
$id= $_POST['id'];
$name = $_POST['name'];
$status = $_POST['status'];

$conn = mysqli_connect("localhost", "root", "", "employee_info");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "UPDATE designation SET name = '{$name}' WHERE id = {$id}";
$stmt = $conn->prepare($query);

if ($stmt->execute()) {
    header("Location: designation.php?message=add_success");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: http://localhost/Log/designation.php");
// After updating the lead
header("Location: designation.php?message=Lead updated successfully");
exit();

?>


