<?php
// Open a single database connection
$conn = new mysqli("localhost", "root", "", "items_info");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Form</title>
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
</style>

</style>

</head>
<body>
<div class="container">
  <?php include 'topbar.php'; ?>
  <?php include 'sidebar.php'; ?>
  <div class="content">
    <div class="main-content">
      <h2>Add Items Card</h2>
      <form id="employeeDetailsForm" method="POST" action="save_items.php">
        <!-- Row 1 -->
        <div class="form-group">
          <div>
              <label for="item_number">Item Number</label>
              <input type="text" id="item_number" name="item_number" placeholder="Enter Item Number">
          </div>

          <div>
            <label for="item_name">Item Name</label>
            <input type="text" id="item_name" name="item_name" placeholder="Enter Item Name">
          </div>
          

          <!-- Lead Priority Dropdown -->
        </div> 

        <div class="form-group">
          <div>
            <label for="item_type">Item Type</label>
            <select id="item_type" name="item_type" required>
                <option value="" disabled selected>Select option</option>
                <option value="Service">Service</option>
                <option value="Inventory">Inventory</option>
            </select>
          </div>

          <div>
            <label for="item_category">Item Category</label>
            <select class="form-control" id="item_category" name="item_category" required>
                <option value="" disabled selected>Select an option</option>
                <?php
                $result = $conn->query("SELECT * FROM items_list");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['code'] . "'>" . $row['code'] . " - " . $row['description'] . "</option>";
                }
                ?>
            </select>

          </div>
            

        </div>
        <div class="form-group">
          <div>
              <label for="location_details">Location</label>
              <select class="form-control" id="location_details" name="location_details" required>
                  <option value="" disabled selected>Select an option</option>
                  <?php
                  $result = $conn->query("SELECT * FROM location_details");
                  while ($row = $result->fetch_assoc()) {
                      echo "<option value='" . $row['location_name'] . "'>" . $row['location_name'] . "</option>";
                  }
                  ?>
              </select>
          

          </div>
            
          <div>
            <label for="unit_of_measurement">Unit Of Measure</label>
            <select class="form-control" id="unit_of_measurement" name="unit_of_measurement" required>
                <option value="" disabled selected>Select an option</option>
                <?php
                $conn = new mysqli("localhost", "root", "", "items_info");
                $result = $conn->query("SELECT * FROM unit_of_measurement");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['unit'] . "'>" . $row['unit'] . "</option>";
                }
                ?>
            </select>
          </div>
            
         
          

        </div>

        <div class="form-group">
          <div>
              <label for="gst">GST</label>
              <select class="form-control" id="gst" name="gst" required>
                  <option value="" disabled selected>Select an option</option>
                  <?php
                  $conn = new mysqli("localhost", "root", "", "items_info");
                  $result = $conn->query("SELECT * FROM gst");
                  while ($row = $result->fetch_assoc()) {
                      echo "<option value='" . $row['percentage'] . "'>" . $row['percentage'] . "</option>";
                  }
                  ?>
              </select>

            </div>

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
         
          
        </div>

      <div class="form-group">
        <div>
          <label for="sales_price">Sales Price</label>
          <input type="text" id="sales_price" name="sales_price" placeholder="Enter Sales Price">

        </div>

        <div>
          <label for="barcode">Barcode</label>
          <input type="text" id="barcode" name="barcode" placeholder="Enter Barcode">

        </div>
        <input type="hidden" id="timestamp" name="timestamp" value="<?php echo date('Y-m-d H:i:s'); ?>" />

           
      </div>

   

        <div class="check">
          <div>
              <label class="a">
                  <input type="checkbox" name="lot_tracking" value="1"> Lot Tracking
              </label>
          </div>

          <div>
              <label class="a">
                  <input type="checkbox" name="expiration_tracking" value="1"> Expiration Tracking
              </label>
          </div>

          <div>
              <label class="a">
                  <input type="checkbox" name="block" value="1"> Block
              </label>
          </div>

              
        

        </div>
        <div class="form-actions">
                  <button type="submit" name="register" class="button">Submit</button>
                  <a href="save_contact.php" class="cancel-btn">Cancel</a>
        </div>

      </form>
    </div>
  </div>
</div>
</body>


</html>