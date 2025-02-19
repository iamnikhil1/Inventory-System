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


</style>
</head>
<body>

<div class="container">
    <?php include 'topbar.php'; ?>
    <?php include 'sidebar.php'; ?>
    <div class="content">
      <div class="main-content">
      <div class="cro">
					<h2>Edit Location Details</h2>
					<div >
						<a href="location.php">
							<img id="cross" src="close.png" alt="">
						</a>
					</div>
				</div>
      <?php
       $conn = mysqli_connect("localhost", "root", "", "items_info") or die("Connection failed");
       $id=$_GET['id'];
       $query = "SELECT * FROM location_details WHERE id ={$id}";
       $result = mysqli_query($conn, $query) or die("Query Unsuccessful");

       if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
    ?>
        <form id="employeeDetailsForm" method="POST" action="update_loaction.php">
        <!-- Row 1 -->
        <div class="form-group">

<div  style="position: relative;">
<label for="location_code">Location Code</label>
<input type="hidden" id="id" name="id" class="form-control" value="<?php echo $rows['id']; ?>" required>
<input type="text" id="location_code" name="location_code" placeholder="Enter Location Code" value="<?php echo $rows['location_code']; ?>">
  </div>

<!-- Lead For Input -->
<div  style="position: relative;">
<label for="location_name">Location Name</label>
<input type="text" id="location_name" name="location_name" placeholder="Enter Location Name" value="<?php echo $rows['location_name']; ?>">


  </div>

<!-- Lead Priority Dropdown -->
<div>
<label for="address">Address</label>
<input type="text" id="address" name="address" placeholder="Enter Address" value="<?php echo $rows['address']; ?>">
</div>
</div>

<!-- Row 2 -->
<div class="form-group">
  <div>
  <label for="pincode">Pincode</label>
<input type="text" id="pincode" name="pincode" placeholder="Enter Pincode" value="<?php echo $rows['pincode']; ?>">

  </div>
  <div>
  <label for="city">City</label>
  <input type="text" id="city" name="city" placeholder="Enter City" value="<?php echo $rows['city']; ?>">
  </div>
  

  <div>
  <label for="state">State</label>
<select id="state" name="state">
<option value="" disabled selected>Select State</option>
<option value="Andhra Pradesh">Andhra Pradesh</option>
<option value="Arunachal Pradesh">Arunachal Pradesh</option>
<option value="Assam">Assam</option>
<option value="Bihar">Bihar</option>
<option value="Chhattisgarh">Chhattisgarh</option>
<option value="Goa">Goa</option>
<option value="Gujarat">Gujarat</option>
<option value="Haryana">Haryana</option>
<option value="Himachal Pradesh">Himachal Pradesh</option>
<option value="Jharkhand">Jharkhand</option>
<option value="Karnataka">Karnataka</option>
<option value="Kerala">Kerala</option>
<option value="Madhya Pradesh">Madhya Pradesh</option>
<option value="Maharashtra">Maharashtra</option>
<option value="Manipur">Manipur</option>
<option value="Meghalaya">Meghalaya</option>
<option value="Mizoram">Mizoram</option>
<option value="Nagaland">Nagaland</option>
<option value="Odisha">Odisha</option>
<option value="Punjab">Punjab</option>
<option value="Rajasthan">Rajasthan</option>
<option value="Sikkim">Sikkim</option>
<option value="Tamil Nadu">Tamil Nadu</option>
<option value="Telangana">Telangana</option>
<option value="Tripura">Tripura</option>
<option value="Uttar Pradesh">Uttar Pradesh</option>
<option value="Uttarakhand">Uttarakhand</option>
<option value="West Bengal">West Bengal</option>
<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
<option value="Chandigarh">Chandigarh</option>
<option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
<option value="Delhi">Delhi</option>
<option value="Jammu and Kashmir">Jammu and Kashmir</option>
<option value="Ladakh">Ladakh</option>
<option value="Lakshadweep">Lakshadweep</option>
<option value="Puducherry">Puducherry</option>
</select>
      </div>

  </div>
<!-- Row 3 -->

<div class="form-group">
  <div>
  <label for="country">Country</label>
<input type="text" id="country" name="country" placeholder="Enter Country" value="<?php echo $rows['country']; ?>">

  </div>
  <div>
  <label for="contact_no">Contact No</label>
<input type="tel" id="contact_no" name="contact_no" placeholder="Enter Contact Number" value="<?php echo $rows['contact_no']; ?>">

  </div>

  <!-- Row 4 -->
  <div>
  <label for="whatsapp_no">WhatsApp Number</label>
<input type="text" id="whatsapp_no" name="whatsapp_no" placeholder="Enter WhatsApp Number" value="<?php echo $rows['whatsapp_no']; ?>">

  </div>

</div>
<div class="form-group">
  
  <!-- Row 5 -->
  <div>
  <label for="email_id">Email ID</label>
<input type="email" id="email_id" name="email_id" placeholder="Enter Email ID" value="<?php echo $rows['email_id']; ?>">

  </div>
  <div>
<label for="company_name">Company Name</label>
<input type="text" id="company_name" name="company_name" placeholder="Enter Company Name" value="<?php echo $rows['company_name']; ?>">

</div>

<div>
<label for="gst_no">GST Number</label>
<input type="text" id="gst_no" name="gst_no" placeholder="Enter GST Number" value="<?php echo $rows['gst_no']; ?>">

</div>
</div>








<!-- Row 9 (Actions) -->

<div class="form-actions">
  <button type="submit" name="register" class="button">Submit</button>

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











