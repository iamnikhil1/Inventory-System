<?php
$id = $_GET['id'];

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "employee_info");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare and execute the DELETE query
$query = "DELETE FROM education_details WHERE id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Failed to prepare statement: " . $conn->error);
}
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    // Check the maximum ID in the table
    $sql_check = "SELECT MAX(id) AS max_id FROM education_details";
    $result_check = mysqli_query($conn, $sql_check);
    if ($result_check) {
        $row = mysqli_fetch_assoc($result_check);
        $next_id = $row['max_id'] ? $row['max_id'] + 1 : 1;

        // Reset the AUTO_INCREMENT value
        $sql_reset = "ALTER TABLE education_details AUTO_INCREMENT = {$next_id}";
        if (!mysqli_query($conn, $sql_reset)) {
            die("Error resetting AUTO_INCREMENT: " . mysqli_error($conn));
        }
    } else {
        die("Error fetching max ID: " . mysqli_error($conn));
    }

    // Redirect with success message
    header("Location: user_info.php?message=Lead deleted successfully");
    exit();
} else {
    die("Error deleting record: " . $stmt->error);
}

// Close the database connection
$stmt->close();
mysqli_close($conn);
?>
