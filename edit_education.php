<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tabbed Employee Form</title>
  <link rel="stylesheet" href="styles.css" />
  <style>
 body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    .container {
      display: flex;
    }



    h2 {
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
    
    }

    .form-control {
      width: 80%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .tabs {
      display: flex;
      border-bottom: 2px solid #ddd;
      margin-bottom: 20px;
    }

    .tab {
      flex: 1;
      padding: 10px;
      text-align: center;
      cursor: pointer;
      background: #f4f4f4;
      border: 1px solid #ddd;
      border-bottom: none;
    }

    .tab.active {
      background: #fff;
      font-weight: bold;
      border-bottom: 2px solid #3498db;
    }

    .form-layout {
      display: flex;
      flex-wrap: wrap;
      margin: 30px auto

    }

    .form-group {
      flex: 1 1 calc(50% - 20px); /* Adjust width */
      min-width: 250px;
    }
    #employeeDetailsForm{
        width: 1200px;
      height: 600px;
      overflow-y: auto; 
      margin: 0 auto;
      padding: 20px;
      background: rgba(255, 255, 255, 0.6);
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
      backdrop-filter: blur(3px);
      display: flex;
      flex-wrap: wrap;

    }

    .form-group.textarea {
  flex: 1 1 calc(50% - 20px); /* Adjust width */
  min-width: 250px; /* Ensure responsive behavior */
}

    .btn-primary {
      background-color: #3498db;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .btn-primary:hover {
      background-color: #2980b9;
    }

    .tab-content {
      display: none;
    }

    .tab-content.active {
      display: block;
    }
    table.form-control {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table.form-control th,
table.form-control td {
    padding: 10px;
    text-align: center;
    border: 1px solid #ddd;
   
}

table.form-control th {
    background-color: #2183A0;
    color: white;
}

table.form-control td a {
    margin-right: 10px;
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
	height: 30px;
}


</style>
</head>
<body>
<div class="container">
    <?php include 'topbar.php'; ?>
    <?php include 'sidebar.php'; ?>
    <div class="content">
      <div class="main-content">
      <div class="cro">
          <h2>Update Education Details</h2>
          <div >
            <a href="user_info.php">
              <img id="cross" src="close.png" alt="">
            </a>
          </div>
        </div>>
            <?php
       $conn = mysqli_connect("localhost", "root", "", "employee_info") or die("Connection failed");
       $id=$_GET['id'];
       $query = "SELECT * FROM education_details WHERE id ={$id}";
       $result = mysqli_query($conn, $query) or die("Query Unsuccessful");

       if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
    ?>
            <form id="employeeDetailsForm" action="update_education.php" method="POST" enctype="multipart/form-data">
                <div class="form-layout">
                  <div class="form-group">
                        <label for="degree">Degree</label>
                        <input type="hidden" id="id" name="id" class="form-control" value="<?php echo $rows['id']; ?>" required>
                        <input type="text" class="form-control" id="degree" name="degree" value="<?php echo $rows['degree']; ?>" required>
                        </div>
                        <div class="form-group">
                        <label for="institution">Institution</label>
                        <input type="text" class="form-control" id="institution" name="institution" value="<?php echo $rows['institution']; ?>" required>
                        </div>
                        <div class="form-group">
                        <label for="year">Year of Graduation</label>
                        <input type="text" class="form-control" id="year" name="year" value="<?php echo $rows['year_of_graduation']; ?>" required>
                        </div>
                        <div class="form-group">
                        <label for="percentage">Percentage</label>
                        <input type="text" class="form-control" id="percentage" name="percentage" value="<?php echo $rows['percentage']; ?>" required>
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn-primary">Save</button>
                        </div>
                       
                  </div>
                </div>
                    
            </form>
            <?php } ?>
            <?php } ?>
               
        </div>
    </div>
</div>


                
</body>
</html>
