<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Lead Source</title>
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

  .btn-primary:HSN {
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
    <form id="leadSourceForm" action="save_hsn.php" method="POST">
      <h2>Add HSN/SAC</h2>
      <label for="name">Code</label>
      <input type="text" id="name" name="name" class="form-control" required>
      <label for="description">Description</label>
      <input type="text" id="description" name="description" class="form-control" required>
      <label for="type">Type</label>
      <select id="type" name="type" class="form-control" required>
      <option value="" disabled selected>Select</option>
        <option value="HSN">HSN</option>
        <option value="SAC">SAC</option>
      </select>
    
      <input class="btn-primary" type="submit" value="Save">
    </form>
  </div>
</div>

</div>

  
</body>
</html>
