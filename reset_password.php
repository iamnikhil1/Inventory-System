<?php
require_once 'session_init.php';
$conn = mysqli_connect("localhost", "root", "", "employee_info") or die("Connection failed");

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['token'])) {
    $token = $_GET['token'];
    $query = "SELECT * FROM user_info WHERE reset_token='$token' AND reset_expiry > NOW()";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $email = $user['email_id'];
    } else {
        die("Invalid or expired reset link.");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    $update_query = "UPDATE user_info SET password='$new_password', reset_token=NULL, reset_expiry=NULL WHERE email_id='$email'";
    mysqli_query($conn, $update_query);

    header("Location: login.php?reset_success=true");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="login-style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>Reset Password</h1>
            <form action="" method="POST">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter new password" required>
                </div>
                <button type="submit" class="login-button">Reset Password</button>
            </form>
        </div>
    </div>
</body>
</html>
