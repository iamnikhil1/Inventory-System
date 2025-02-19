<?php
session_start();

// Retrieve emp_code from session
$emp_code = isset($_SESSION['emp_code']) ? $_SESSION['emp_code'] : null;

// Validate emp_code
if (!$emp_code) {
    echo "<p>Error: Employee Code is missing. Please make sure you have completed the user registration.</p>";
    exit;
}

// Educational Details
$degree = isset($_POST['degree']) ? htmlspecialchars(trim($_POST['degree'])) : null;
$institution = isset($_POST['institution']) ? htmlspecialchars(trim($_POST['institution'])) : null;
$year = isset($_POST['year']) ? htmlspecialchars(trim($_POST['year'])) : null;
$percentage = isset($_POST['percentage']) ? htmlspecialchars(trim($_POST['percentage'])) : null;

$errors = [];

if (!$degree) $errors[] = "Degree is required.";
if (!$institution) $errors[] = "Institution is required.";
if (!$year) $errors[] = "Year is required.";
if (!$percentage) $errors[] = "Percentage is required.";

// Display errors if any
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p>Error: $error</p>";
    }
    exit;
}

// Database connection
$conn = new mysqli("localhost", "root", "", "employee_info");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert education details (with emp_code)
$sql_edu = "INSERT INTO education_details (emp_code, degree, institution, year_of_graduation, percentage) 
            VALUES (?, ?, ?, ?, ?)";
$stmt_edu = $conn->prepare($sql_edu);
$stmt_edu->bind_param("sssss", $emp_code, $degree, $institution, $year, $percentage);

if ($stmt_edu->execute()) {
    echo "<p>Education details saved successfully!</p>";
} else {
    echo "<p>Error: " . $stmt_edu->error . "</p>";
}

$stmt_edu->close();
$conn->close();

header("Location: http://localhost/Log/add_user_info.php");
exit;
?>
