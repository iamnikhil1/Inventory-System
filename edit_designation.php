<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Lead For</title>
  <link rel="stylesheet" href="styles.css" />
  <style>
    
/* Parent Container for Centering *
/* Form Styling */
form {
  max-width: 600px;
  width: 100%; /* Ensure responsiveness */
  padding: 20px;
  background-color: #ffffff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

   /* Form Container */
form {
  max-width: 600px;
  margin: 20px auto;
  padding: 20px;
  background-color: #ffffff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

  </style>
</head>
<body>
<div class="container">
    <?php include 'topbar.php'; ?>
    <?php include 'sidebar.php'; ?>
    <div class="content">
  <div class="main-content">
  <?php
       $conn = mysqli_connect("localhost", "root", "", "employee_info") or die("Connection failed");
       $id=$_GET['id'];
       $query = "SELECT * FROM designation WHERE id ={$id}";
       $result = mysqli_query($conn, $query) or die("Query Unsuccessful");

       if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
    ?>
    <form id="leadSourceForm" action="update_designation.php" method="POST">
      <h2>Update Designation</h2>
      <label for="name">Designation</label>
      <input type="hidden" id="id" name="id" class="form-control" value="<?php echo $rows['id']; ?>" required>
      <input type="text" id="name" name="name" class="form-control" value="<?php echo $rows['name']; ?>" required>
      <input class="btn-primary" type="submit" value="Save">
    </form>
    <?php } ?>
    <?php } ?>
  </div>
</div>

</div>

  
</body>
</html>
