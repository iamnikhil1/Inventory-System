<?php
$id= $_POST['id'];
$x = $_POST['name'];
$y = $_POST['description'];
$z = $_POST['type'];

$conn = mysqli_connect("localhost", "root", "", "items_info");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "UPDATE hsn_sac SET code = '{$x}',description = '{$y}',type = '{$z}' WHERE id = {$id}";
$stmt = $conn->prepare($query);

if ($stmt->execute()) {
    header("Location: hsn.php?message=add_success");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();


exit();

?>


