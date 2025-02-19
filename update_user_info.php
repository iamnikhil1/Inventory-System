<?php
// Sanitize and validate input data
$id = isset($_POST['id']) ? $_POST['id'] : null;
$name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : null;
$email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : null;
$designation = isset($_POST['designation']) ? htmlspecialchars(trim($_POST['designation'])) : null;
$department = isset($_POST['department']) ? htmlspecialchars(trim($_POST['department'])) : null;
$mobile_no = isset($_POST['mobile_no']) ? htmlspecialchars(trim($_POST['mobile_no'])) : null;
$status = isset($_POST['status']) ? htmlspecialchars(trim($_POST['status'])) : null;
$emp_code = isset($_POST['code']) ? htmlspecialchars(trim($_POST['code'])) : null;
$doj = isset($_POST['doj']) ? htmlspecialchars(trim($_POST['doj'])) : null;
$dol = isset($_POST['dol']) ? htmlspecialchars(trim($_POST['dol'])) : null;

$errors = [];

// Basic validation to ensure required fields are filled
if (!$name) $errors[] = "Name is required.";
if (!$email) $errors[] = "Email is required.";
if (!$designation) $errors[] = "Designation is required.";
if (!$mobile_no) $errors[] = "Mobile number is required.";
if (!$emp_code) $errors[] = "Employee code is required.";
if (!$doj) $errors[] = "Date of Joining is required.";
if (!$id) $errors[] = "ID is missing.";

// Return errors if validation fails
if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(", ", $errors)]);
    exit;
}

// Database connection
$conn = new mysqli("localhost", "root", "", "employee_info");

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Prepare the update query
$query = "UPDATE user_info 
          SET emp_code = ?, employee_name = ?, email_id = ?, designation = ?, department = ?, mobile_no = ?, status = ?, DOJ = ?, DOL = ? 
          WHERE id = ?";
$stmt = $conn->prepare($query);

// Check if the statement was prepared successfully
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => "Prepare failed: " . $conn->error]);
    exit;
}

// Bind parameters
$stmt->bind_param("sssssssssi", $emp_code, $name, $email, $designation, $department, $mobile_no, $status, $doj, $dol, $id);

// Execute the query and check for errors
if ($stmt->execute()) {
    // Redirect with ID and emp_code
    header("Location: http://localhost/Log/edit_user_info.php?id=$id&emp_code=$emp_code");
    exit;
} else {
    echo json_encode(['success' => false, 'message' => "Execute failed: " . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
