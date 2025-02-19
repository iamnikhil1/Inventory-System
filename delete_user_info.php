<?php
$id = $_GET['id'];

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "employee_info");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to delete a record and reset AUTO_INCREMENT
function deleteRecord($conn, $table, $id) {
    // Prepare and execute the DELETE query
    $query = "DELETE FROM {$table} WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Failed to prepare statement for table {$table}: " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        die("Error deleting record from table {$table}: " . $stmt->error);
    }
    $stmt->close();

    // Check the maximum ID in the table
    $sql_check = "SELECT MAX(id) AS max_id FROM {$table}";
    $result_check = mysqli_query($conn, $sql_check);
    if ($result_check) {
        $row = mysqli_fetch_assoc($result_check);
        $next_id = $row['max_id'] ? $row['max_id'] + 1 : 1;

        // Reset the AUTO_INCREMENT value
        $sql_reset = "ALTER TABLE {$table} AUTO_INCREMENT = {$next_id}";
        if (!mysqli_query($conn, $sql_reset)) {
            die("Error resetting AUTO_INCREMENT for table {$table}: " . mysqli_error($conn));
        }
    } else {
        die("Error fetching max ID from table {$table}: " . mysqli_error($conn));
    }
}

// Delete records from all required tables
deleteRecord($conn, "user_info", $id);
deleteRecord($conn, "work_experience_details", $id);
deleteRecord($conn, "education_details", $id);

// Close the database connection
mysqli_close($conn);

// Redirect with success message
header("Location: user_info.php?message=Lead deleted successfully");
exit();
?>
