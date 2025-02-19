<?php
// Educational Details
$id = isset($_POST['id']) ? $_POST['id'] : null;
$emp_code = isset($_POST['code']) ? htmlspecialchars(trim($_POST['code'])) : null;
$degree = isset($_POST['degree']) ? htmlspecialchars(trim($_POST['degree'])) : null;
$institution = isset($_POST['institution']) ? htmlspecialchars(trim($_POST['institution'])) : null;
$year = isset($_POST['year']) ? htmlspecialchars(trim($_POST['year'])) : null;
$percentage = isset($_POST['percentage']) ? htmlspecialchars(trim($_POST['percentage'])) : null;

$errors = [];

// Validate input fields
if (!$degree) $errors[] = "Degree is required.";
if (!$institution) $errors[] = "Institution is required.";
if (!$year) $errors[] = "Year is required.";
if (!$percentage) $errors[] = "Percentage is required.";

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p>Error: $error</p>";
    }
    exit;
}

// Database connection
$conn = new mysqli("localhost", "root", "", "employee_info");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert education details
$sql_edu = "INSERT INTO education_details (emp_code, degree, institution, year_of_graduation, percentage) 
            VALUES (?, ?, ?, ?, ?)";
$stmt_edu = $conn->prepare($sql_edu);
if (!$stmt_edu) {
    die("Error preparing the query: " . $conn->error);
}
$stmt_edu->bind_param("sssss", $emp_code, $degree, $institution, $year, $percentage);

if ($stmt_edu->execute()) {
    header("Location: http://localhost/Log/edit_user_info.php?id=$id&emp_code=$emp_code");
    exit;
} else {
    echo "<p>Error: " . $stmt_edu->error . "</p>";
}

$stmt_edu->close();
$conn->close();
?>
