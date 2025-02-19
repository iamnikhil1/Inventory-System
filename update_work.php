<?php
// Retrieve POST data
$id= $_POST['id'];
$position = isset($_POST['position']) ? htmlspecialchars(trim($_POST['position'])) : null;
$company = isset($_POST['company']) ? htmlspecialchars(trim($_POST['company'])) : null;
$start_date = isset($_POST['start_date']) ? htmlspecialchars(trim($_POST['start_date'])) : null;
$end_date = isset($_POST['end_date']) ? htmlspecialchars(trim($_POST['end_date'])) : null;
$salary = isset($_POST['salary']) ? htmlspecialchars(trim($_POST['salary'])) : null;
$reason_for_resignation = isset($_POST['reason_for_resignation']) ? htmlspecialchars(trim($_POST['reason_for_resignation'])) : null;
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "employee_info");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Update query for work experience
$sql_update = "UPDATE work_experience_details 
               SET position = ?, company_name = ?, start_date = ?, end_date = ?, salary = ?, reason_for_resignation = ? 
               WHERE id = ?";

// Prepare the statement
$stmt_update = $conn->prepare($sql_update);
if (!$stmt_update) {
    echo "<p>Error: " . $conn->error . "</p>";
    exit;
}

// Bind parameters
$stmt_update->bind_param(
    "ssssisi", // Data types: s (string), i (integer)
    $position,
    $company,
    $start_date,
    $end_date,
    $salary,
    $reason_for_resignation,
    $id
);

// Execute the statement
if ($stmt_update->execute()) {
    // Redirect after successful update
    header("Location: user_info.php?message=update_success");
    exit;
} else {
    echo "<p>Error: " . $stmt_update->error . "</p>";
}

// Close the statement and connection
$stmt_update->close();
$conn->close();
?>


