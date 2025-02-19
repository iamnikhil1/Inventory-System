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
          <h2>Update Work Experience Details</h2>
          <div >
            <a href="user_info.php">
              <img id="cross" src="close.png" alt="">
            </a>
          </div>
        </div>
            
            <?php
       $conn = mysqli_connect("localhost", "root", "", "employee_info") or die("Connection failed");
       $id=$_GET['id'];
       $query = "SELECT * FROM work_experience_details WHERE id ={$id}";
       $result = mysqli_query($conn, $query) or die("Query Unsuccessful");

       if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
    ?>
            <form id="employeeDetailsForm" action="update_work.php" method="POST" enctype="multipart/form-data">
                    <div class="form-layout">
                      <div class="form-group">
                        <label for="designation">Position</label>
                        <input type="hidden" id="id" name="id" class="form-control" value="<?php echo $rows['id']; ?>" required>
                        <input type="text" class="form-control" id="position" name="position" value="<?php echo $rows['position']; ?>" required>
                      </div>
                      <div class="form-group">
                        <label for="company">Company Name</label>
                        <input type="text" class="form-control" id="company" name="company" value="<?php echo $rows['company_name']; ?>" required>
                      </div>
                      <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $rows['start_date']; ?>"  required>
                      </div>
                      <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $rows['end_date']; ?>">
                      </div>
                      <div class="form-group">
                        <label for="salary">Salary</label>
                        <input type="text" class="form-control" id="salary" name="salary" value="<?php echo $rows['salary']; ?>" required>
                      </div>
                      <div class="form-group">
                        <label for="reason_for_resignation">Reason for Resignation</label>
                        <input type="text" class="form-control" id="reason_for_resignation" name="reason_for_resignation" value="<?php echo $rows['reason_for_resignation']; ?>">
                      </div>
                      <div class="form-group">
                        <button type="submit" class="btn-primary">Save</button>
                      </div>
                        
                      <div class="form-group">
                        <a href="edit_user_info.php"><button type="cancel" class="btn-primary">Cancel</button></a>
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
