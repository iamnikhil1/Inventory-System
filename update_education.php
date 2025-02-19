<?php
$id= $_POST['id'];
$degree = isset($_POST['degree']) ? htmlspecialchars(trim($_POST['degree'])) : null;
$institution = isset($_POST['institution']) ? htmlspecialchars(trim($_POST['institution'])) : null;
$year = isset($_POST['year']) ? htmlspecialchars(trim($_POST['year'])) : null;
$percentage = isset($_POST['percentage']) ? htmlspecialchars(trim($_POST['percentage'])) : null;


$conn = mysqli_connect("localhost", "root", "", "employee_info"); // Corrected database name
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Updated SQL query to include new fields
$sql_update = "UPDATE education_details SET degree = ?, institution = ?, year_of_graduation = ?, percentage = ? WHERE id = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("ssssi", $degree, $institution, $year, $percentage, $id);
if ($stmt_update->execute()) {
    echo "<p>Education details updated successfully!</p>";
} else {
    echo "<p>Error: " . $stmt_update->error . "</p>";
}
header("Location: user_info.php?message=update_success");
$conn->close();
?>
