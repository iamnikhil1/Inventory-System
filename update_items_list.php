<?php
$id= $_POST['id'];
$x = $_POST['name'];
$y = $_POST['description'];

$conn = mysqli_connect("localhost", "root", "", "items_info");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "UPDATE items_list SET code = '{$x}',description = '{$y}' WHERE id = {$id}";
$stmt = $conn->prepare($query);

if ($stmt->execute()) {
    header("Location: items_list.php?message=add_success");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();


exit();

?>


