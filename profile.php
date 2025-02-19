<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <title>Profile Page</title>
</head>
<body>
  <div class="container">
    <?php include 'topbar.php'; ?>
    <?php include 'sidebar.php'; ?>
    <div class="content">
      <div class="main-content">
        <?php
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }

        $conn = mysqli_connect("localhost", "root", "", "employee_info") or die("Connection failed");
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM user_info WHERE id = $user_id";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
        } else {
            die("User not found.");
        }
        ?>
        <section id="employeeDetailsForm" class="profile-section">
          <div class="profile-container">
            <h2>My Profile</h2>
            <div class="profile-card">
              <div class="profile-info">
                <h3><?php echo htmlspecialchars($user['employee_name']); ?></h3>
                <p><strong>Designation:</strong> <?php echo htmlspecialchars($user['designation']); ?></p>
                <p><strong>Department:</strong> <?php echo htmlspecialchars($user['department']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email_id']); ?></p>
                <p><strong>Mobile:</strong> <?php echo htmlspecialchars($user['mobile_no']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
                <p><strong>Date of Joining:</strong> <?php echo htmlspecialchars($user['doj']); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($user['status']); ?></p>
              </div>
            </div>
            <div class="profile-actions">
              <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
              <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
          </div>
        </section>
        <style>
          body {
              font-family: 'Arial', sans-serif;
              background-color: #f4f6f9;
              margin: 0;
              padding: 0;
          }

          .profile-section {
              padding: 20px;
              background-color: #ffffff;
              max-width: 900px;
              margin: 20px auto;
              border-radius: 10px;
              box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
          }

          .profile-container h2 {
              text-align: center;
              font-size: 28px;
              color: #333;
              margin-bottom: 30px;
          }

          .profile-card {
              background: linear-gradient(135deg, #e3f2fd, #90caf9);
              padding: 25px;
              border-radius: 8px;
              margin-bottom: 20px;
              box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
          }

          .profile-info h3 {
              font-size: 24px;
              color: #1e88e5;
              margin-bottom: 10px;
          }

          .profile-info p {
              font-size: 16px;
              margin: 6px 0;
              color: #555;
          }

          .profile-info strong {
              font-weight: bold;
              color: #333;
          }

          .profile-actions {
              text-align: center;
          }

          .profile-actions .btn {
              text-decoration: none;
              padding: 10px 20px;
              border-radius: 5px;
              font-size: 16px;
              margin: 0 10px;
              transition: all 0.3s ease;
          }

          .btn-primary {
              background-color: #1e88e5;
              color: #fff;
          }

          .btn-primary:hover {
              background-color: #1565c0;
          }

          .btn-danger {
              background-color: #e53935;
              color: #fff;
          }

          .btn-danger:hover {
              background-color: #b71c1c;
          }

          #employeeDetailsForm {
            background: rgba(255, 255, 255, 0.6);
              padding: 30px;
              border-radius: 10px;
              backdrop-filter: blur(5px);
              height: auto;
              overflow: hidden;
          }
          
     
        </style>
      </div>
    </div>
  </div>
</body>
</html>