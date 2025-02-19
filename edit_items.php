<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Employee Details</title>
  <link rel="stylesheet" href="styles.css" />
  <style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
  }

  .cancel-btn {
    text-decoration: none;
  }

  .form-container {
    width: 80%;
    max-width: 1200px;
    background: #fff;
    border-radius: 10px;
    padding: 20px 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .form-group {
    display: flex;
    gap: 15px; /* Equal spacing between fields */
    margin-bottom: 20px;
    flex-wrap: wrap; /* Wrap fields for smaller screens */
  }

  .form-group > div {
    flex: 1; /* Ensures each field takes equal width */
    display: flex;
    flex-direction: column;
    min-width: 280px; /* Ensures a consistent minimum size */
  }

  .form-group input,
  .form-group select,
  .form-group textarea {
    width: 100%; /* All inputs take the full width of their container */
    padding: 14px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    outline: none;
  }

  .form-group label {
    display: block;
      font-weight: bold;
      margin-bottom: 5px;
  }

  .form-group input:focus,
  .form-group select:focus,
  .form-group textarea:focus {
    border-color: #007bff;
    background-color: #f8f8f8;
  }

  .form-group.full {
    width: 100%; /* Fields in the full row span 100% of the container */
  }

  textarea {
    resize: none;
    font-size: 16px;
    height: 100px; /* Fixed height for better appearance */
  }

  select {
 
    background: #fff;
    padding: 14px;
  }

  .form-actions {
    text-align: center;
    margin-top: 20px;
  }

  .form-actions button,
  .cancel-btn {
    padding: 12px 30px;
    font-size: 16px;
    background: #2c3e50;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
  }

  .form-actions button:hover,
  .cancel-btn:hover {
    background: #34495e;
  }

  /* Adjust input alignment for smaller screens */
  @media screen and (max-width: 768px) {
    .form-group {
      flex-direction: column;
    }
    .form-group > div {
      min-width: 100%; /* Full width for small screens */
    }
  }
  #employeeDetailsForm{
        /* width: 1200px;
      height: 600px;
      overflow-y: auto; 
      margin: 30px auto; */
      /* padding: 20px; */
      background: rgba(255, 255, 255, 0.6);
      overflow-y: auto;
      height: 600px;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
      backdrop-filter: blur(3px);
      /* display: flex;
      flex-wrap: wrap; */

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
.check{
  display: flex;
  width: 100%;
  justify-content: space-evenly;
  margin-bottom: 20px;
  flex-wrap: wrap;
}
.a{
  display: block;
      font-weight: bold;

}
.nik{
    display: flex;
    gap: 20px;
    align-items: center;
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
					<h2>Edit items Details</h2>
                    <div class="nik" >
                        <a href="add_unit2.php" class="cancel-btn">Add</a>

						<a href="items.php">
                            
							<img id="cross" src="close.png" alt="">
						</a>
					</div>
				</div>
      <?php
  
       $conn = mysqli_connect("localhost", "root", "", "items_info") or die("Connection failed");
       $id=$_GET['id'];
       $_SESSION['item_id'] = $id;
       $query = "SELECT * FROM items WHERE id ={$id}";
       $result = mysqli_query($conn, $query) or die("Query Unsuccessful");

       if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
          $_SESSION['item_number'] = $rows['item_number'];

    ?>
        <form id="employeeDetailsForm" method="POST" action="update_items.php">
          

        <div class="form-group">
        <div>
                        <label for="item_number">Item Number</label>
                        <input type="hidden" id="id" name="id" class="form-control" value="<?php echo $rows['id']; ?>" required>

                        <input type="text" id="item_number" name="item_number" value="<?php echo $rows['item_number']; ?>" placeholder="Enter Item Number">
                    </div>

          <div>
          <label for="item_name">Item Name</label>
          <input type="text" id="item_name" name="item_name" value="<?php echo $rows['item_name']; ?>" placeholder="Enter Item Name">
          </div>
          

          <!-- Lead Priority Dropdown -->
          <!-- Item Type Dropdown -->
<div>
  <label for="item_type">Item Type</label>
  <select id="item_type" name="item_type" required>
      <option value="" disabled>Select option</option>
      <option value="Service" <?php if ($rows['item_type'] == 'Service') echo 'selected'; ?>>Service</option>
      <option value="Inventory" <?php if ($rows['item_type'] == 'Inventory') echo 'selected'; ?>>Inventory</option>
  </select>
</div>

</div>

        <div class="form-group">

                    <div>
            <label for="item_category">Item Category</label>
            <select id="item_category" name="item_category" required>
                <option value="" disabled>Select an option</option>
                <?php
                $result = $conn->query("SELECT * FROM items_list");
                while ($row = $result->fetch_assoc()) {
                    $selected = ($rows['item_category'] == $row['code']) ? 'selected' : '';
                    echo "<option value='" . $row['code'] . "' $selected>" . $row['code'] . " - " . $row['description'] . "</option>";
                }
                ?>
            </select>
            </div>

            <div>
                <label for="location_details">Location</label>
                <select class="form-control" id="location_details" name="location_details" required>
                    <option value="" disabled>Select an option</option>
                    <?php
                    $result = $conn->query("SELECT * FROM location_details");
                    while ($row = $result->fetch_assoc()) {
                        $selected = ($rows['location_details'] == $row['location_name']) ? 'selected' : '';
                        echo "<option value='" . $row['location_name'] . "' $selected>" . $row['location_name'] . "</option>";
                    }
                    ?>
                </select>
            </div>

                        
                        
            <div>
    <label for="unit_of_measurement">Unit Of Measure</label>
    <select class="form-control" id="unit_of_measurement" name="unit_of_measurement" required>
        <option value="" disabled selected>Select an option</option>
        <?php
        $item_number = $_SESSION['item_number'] ?? null;

        // Use the correct AND operator in SQL
        $result = $conn->query("SELECT unit FROM item_unit_details WHERE base = 1 AND item_number = {$item_number}");

        if ($result->num_rows > 0) {
            while ($row1 = $result->fetch_assoc()) {
                echo "<option value='" . $row1['unit'] . "'>" . $row1['unit'] . "</option>";
            }
        } else {
            echo "<option value='' disabled>No units found with base = 1</option>";
        }
        ?>
    </select>
</div>


            <div>
                    <label for="gst">GST</label>
                    <select class="form-control" id="gst" name="gst" required>
                        <option value="" disabled>Select an option</option>
                        <?php
                        $result = $conn->query("SELECT * FROM gst");
                        while ($row = $result->fetch_assoc()) {
                            $selected = ($rows['gst'] == $row['percentage']) ? 'selected' : '';
                            echo "<option value='" . $row['percentage'] . "' $selected>" . $row['percentage'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

           

        </div>

        <div class="form-group">
            
            <!-- Row 5 -->
            <div>
            <label for="hsn_sac">HSN/SAC</label>
            <select class="form-control" id="hsn_sac" name="hsn_sac" required>
                <option value="" disabled selected>Select an option</option>
                <?php
                $conn = new mysqli("localhost", "root", "", "items_info");
                $result = $conn->query("SELECT * FROM hsn_sac");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['description'] . "'>" . $row['description'] . "</option>";
                }
                ?>
            </select>

            </div>
         
          <div>
          <label for="sales_price">Sales Price</label>
<input type="text" id="sales_price" name="sales_price"  value="<?php echo $rows['sales_price']?>";/> 
          </div>
          
        <div>
          <label for="barcode">Barcode</label>
          <input type="text" id="barcode" name="barcode" value="<?php echo $rows['barcode']?>";>

        </div>
          <input type="hidden" id="created_at" name="created_at" value="<?php $rows['created_at']; ?>" />

        </div>

  
        <div class="check">
        <div>
  <label class="a">
      <input type="checkbox" name="lot_tracking" value="1" <?php if ($rows['lot_tracking'] == 1) echo 'checked'; ?>> Lot Tracking
  </label>
</div>

<div>
  <label class="a">
      <input type="checkbox" name="expiration_tracking" value="1" <?php if ($rows['expiration_tracking'] == 1) echo 'checked'; ?>> Expiration Tracking
  </label>
</div>

<div>
  <label class="a">
      <input type="checkbox" name="block" value="1" <?php if ($rows['block'] == 1) echo 'checked'; ?>> Block
  </label>
</div>

        

        </div>

        


    <!-- Row 9 (Actions) -->

    <div class="form-actions">
        <button type="submit" name="register" class="button">Submit</button>
        <a href="save_items.php" class="cancel-btn">Cancel</a>
    </div>

      </form>
        <?php } ?>
        <?php } ?>

      </div>
    </div>
</div>
<script>
  document.getElementById('employeeDetailsForm').addEventListener('submit', function(event) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    if (password !== confirmPassword) {
      event.preventDefault(); // Prevent the form from submitting
      alert('Passwords do not match. Please try again.');
    }
  });
</script>


</body>
</html>









