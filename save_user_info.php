<?php
session_start();
// Retrieve and sanitize form data
$name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : null;
$email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : null;
$designation = isset($_POST['designation']) ? htmlspecialchars(trim($_POST['designation'])) : null;
$department = isset($_POST['department']) ? htmlspecialchars(trim($_POST['department'])) : null;
$mobile_no = isset($_POST['mobile_no']) ? htmlspecialchars(trim($_POST['mobile_no'])) : null;
$password = isset($_POST['password']) ? htmlspecialchars(trim($_POST['password'])) : null;
$confirm_password = isset($_POST['confirm_password']) ? htmlspecialchars(trim($_POST['confirm_password'])) : null;
$address = isset($_POST['address']) ? htmlspecialchars(trim($_POST['address'])) : null;
$status = isset($_POST['status']) ? htmlspecialchars(trim($_POST['status'])) : null;
$emp_code = isset($_POST['code']) ? htmlspecialchars(trim($_POST['code'])) : null;
$doj = isset($_POST['doj']) ? htmlspecialchars(trim($_POST['doj'])) : null;
$dol = isset($_POST['dol']) ? htmlspecialchars(trim($_POST['dol'])) : null;

// Validate required fields
$errors = [];
if (!$name) $errors[] = "Name is required.";
if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "A valid Email is required.";
if (!$designation) $errors[] = "Designation is required.";
if (!$department) $errors[] = "Department is required.";
if (!$mobile_no || strlen($mobile_no) != 10 || !ctype_digit($mobile_no)) $errors[] = "A valid 10-digit Mobile number is required.";
if (!$password || $password !== $confirm_password) $errors[] = "Passwords do not match or are missing.";
if (!$address) $errors[] = "Address is required.";
if (!$status) $errors[] = "Status is required.";
if (!$emp_code) $errors[] = "Employee Code is required.";
if (!$doj) $errors[] = "Date of Joining is required.";

// Display errors if any
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p>Error: $error</p>";
    }
    exit;
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Database connection
$conn = new mysqli("localhost", "root", "", "employee_info");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert user information
$sql_user = "INSERT INTO user_info (emp_code, employee_name, designation, department, email_id, mobile_no, password, address, status, doj, dol)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("sssssssssss", $emp_code, $name, $designation, $department, $email, $mobile_no, $hashed_password, $address, $status, $doj, $dol);

if ($stmt_user->execute()) {
    echo "<p>Employee details saved successfully!</p>";
    $_SESSION['emp_code'] = $emp_code;
    header("Location: http://localhost/Log/add_user_info.php");
    exit;
} else {
    echo "<p>Error: " . $stmt_user->error . "</p>";
}

$stmt_user->close();
$conn->close();
?>
