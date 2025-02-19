<?php
// Retrieve and sanitize form data
$id = $_POST['id'];
$password = isset($_POST['password']) ? htmlspecialchars(trim($_POST['password'])) : null;
$confirm_password = isset($_POST['confirm_password']) ? htmlspecialchars(trim($_POST['confirm_password'])) : null;
$errors = [];

if (!$password || $password !== $confirm_password) {
    $errors[] = "Passwords do not match or are missing.";
}

if (empty($errors)) {
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Database connection
    $conn = new mysqli("localhost", "root", "", "employee_info");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update password in the database
    $sql_user = "UPDATE user_info SET password = '{$hashed_password}' WHERE id = {$id}";
    if ($conn->query($sql_user) === TRUE) {
        echo "<p>Password updated successfully!</p>";
        header("Location: http://localhost/Log/user_info.php"); // Redirect to user info page
        exit;
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }

    $conn->close();
} else {
    // Display error messages
    foreach ($errors as $error) {
        echo "<p>{$error}</p>";
    }
}
?>
