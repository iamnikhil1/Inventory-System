<?php
$id = $_GET['id'];

$conn = mysqli_connect("localhost", "root", "", "lead_management");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "DELETE FROM lead_for WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: lead_for.php?message=Lead deleted successfully");
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
