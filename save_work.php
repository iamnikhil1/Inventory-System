<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
} else {
    echo "No data received.";
}



session_start();
$emp_code = isset($_SESSION['emp_code']) ? $_SESSION['emp_code'] : null;
if (!$emp_code) {
    echo "<p>Error: Employee Code is missing. Please make sure you have completed the user registration.</p>";
    exit;
}
// Retrieve and sanitize form data
$position = isset($_POST['position']) ? htmlspecialchars(trim($_POST['position'])) : null;
$company = isset($_POST['company']) ? htmlspecialchars(trim($_POST['company'])) : null;
$start_date = isset($_POST['start_date']) ? htmlspecialchars(trim($_POST['start_date'])) : null;
$end_date = isset($_POST['end_date']) ? htmlspecialchars(trim($_POST['end_date'])) : null;
$salary = isset($_POST['salary']) ? htmlspecialchars(trim($_POST['salary'])) : null;
$reason_for_resignation = isset($_POST['reason_for_resignation']) ? htmlspecialchars(trim($_POST['reason_for_resignation'])) : null;

// Validate required fields
$errors = [];
if (!$position) $errors[] = "Position is required.";
if (!$company) $errors[] = "Company is required.";
if (!$start_date) $errors[] = "Start Date is required.";
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

$sql_work = "INSERT INTO work_experience_details (emp_code, company_name, position, start_date, end_date, salary, reason_for_resignation) 
             VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt_work = $conn->prepare($sql_work);
$stmt_work->bind_param("sssssss", $emp_code, $company, $position, $start_date, $end_date, $salary, $reason_for_resignation);

if ($stmt_work->execute()) {
    echo "<p>Work experience details saved successfully!</p>";
} else {
    echo "<p>Error: " . $stmt_work->error . "</p>";
}

$stmt_work->close();
$conn->close();

exit;
?>