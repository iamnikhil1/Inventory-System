


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Lead For</title>
  <link rel="stylesheet" href="styles.css" />


<style>
  /* Form Styling */
  form {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background: rgba(255, 255, 255, 0.6); /* Semi-transparent white background */
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    backdrop-filter: blur(3px); /* Adds a light blur effect */
  }

  /* Form Heading */
  form h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 20px;
    font-size: 24px;
    font-weight: bold;
  }

  /* Input and Select Fields */
  label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #2c3e50;
  }

  .form-control {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    box-sizing: border-box;
    transition: border-color 0.3s;
  }

  .form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
  }

  /* Submit Button */
  .btn-primary {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #ffffff;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
  }

  .btn-primary:hover {
    background-color: #0056b3;
  }

  .btn-primary:active {
    transform: scale(0.98);
  }
  .cro {
    display: flex;
    justify-content: space-between; /* Positions elements at opposite ends */
    align-items: center; /* Aligns items vertically */
    padding: 10px; /* Adds internal spacing */
    
    margin-bottom: 20px; /* Adds space below the bar */
    
}

.cro h2 {
    margin: 0; /* Ensures the heading doesn't add extra margin */
}


#cross{
	height: 20px;
}

</style>

</head>
<body>
<div class="container">
    <?php include 'topbar.php'; ?>
    <?php include 'sidebar.php'; ?>
    <div class="content">
  <div class="main-content">
    <form id="leadSourceForm" action="update_password.php" method="POST">
    <div class="cro">
          <h2>Change Password</h2>
          <div >
            <a href="user_info.php">
              <img id="cross" src="close.png" alt="">
            </a>
          </div>
        </div>
        <?php
                    $conn = mysqli_connect("localhost", "root", "", "employee_info") or die("Connection failed");
                    $id=$_GET['id'];
                    $query = "SELECT * FROM user_info WHERE id ={$id}";
                    $result = mysqli_query($conn, $query) or die("Query Unsuccessful");

                    if (mysqli_num_rows($result) > 0) {
                    while ($rows = mysqli_fetch_assoc($result)) {
        ?>
     
    
      <div class="form-group">
                            <label for="password">Password</label>
                            <input type="hidden" id="id" name="id" class="form-control" value="<?php echo $rows['id']; ?>" required>

                            <input class="form-control" type="password" id="password" name="password" required>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input class="form-control" type="password" id="confirm_password" name="confirm_password" required>
                        </div>

      <input class="btn-primary" type="submit" value="Save">
    </form>
    <?php }  ?>
    <?php }  ?>

  </div>
</div>

</div>

  
</body>
</html>
