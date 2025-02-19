<?php
require_once 'session_init.php';
$conn = mysqli_connect("localhost", "root", "", "employee_info") or die("Connection failed");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM user_info WHERE email_id='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['employee_name'] = $row['employee_name'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Splendid Infotech</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login-style.css">
</head>
<body>
    <div class="split-container">
        <div class="wave-bg">
            <div class="wave wave1"></div>
            <div class="wave wave2"></div>
            <div class="wave wave3"></div>
            <!-- Add large logo in the wave background -->
            <div class="background-logo">
                <img src="LOGOs.png" alt="Splendid Infotech" class="water-mark-logo">
            </div>
        </div>
        <div class="login-container">
            <div class="login-box">
                <!-- Add logo at the top of the form -->
                <div class="logo-container">
                    <img src="LOGOs.png" alt="Splendid Infotech" class="company-logo">
                </div>
                <h1>Get started!</h1>
                <?php if (isset($error)): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                <form action="" method="POST" class="login-form">
                    <div class="form-group">
                        <label for="email">User name</label>
                        <div class="input-wrapper">
                            <input type="email" id="email" name="email" placeholder="Enter your user name or email" required>
                            <span class="input-icon user-icon">👤</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                            <span class="input-icon password-icon">🔒</span>
                        </div>
                        <a href="forgot_password.php" class="forgot-link">Forgot your password?</a>
                    </div>
                    <div class="remember-me">
                        <label class="checkbox-container">
                            <input type="checkbox" name="remember">
                            <span class="checkmark"></span>
                            Remember me
                        </label>
                    </div>
                    <button type="submit" class="login-button">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

