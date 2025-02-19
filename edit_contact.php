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
					<h2>Edit Contacts Details</h2>
					<div >
						<a href="contact.php">
							<img id="cross" src="close.png" alt="">
						</a>
					</div>
				</div>
      <?php
       $conn = mysqli_connect("localhost", "root", "", "leads_details") or die("Connection failed");
       $id=$_GET['id'];
       $query = "SELECT * FROM contact WHERE id ={$id}";
       $result = mysqli_query($conn, $query) or die("Query Unsuccessful");

       if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
    ?>
        <form id="employeeDetailsForm" method="POST" action="update_contact.php">
        <!-- Row 1 -->
         
        <div class="form-group">

          <div  style="position: relative;">
            <label for="source_lead">Lead Source</label>
            <input type="hidden" id="id" name="id" class="form-control" value="<?php echo $rows['id']; ?>" required>
                <select class="form-control" id="source_lead" name="source_lead" required>
                    <option value="" disabled ><?php echo empty($rows['for_lead'])?></option>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "leads_details");
                    $result = $conn->query("SELECT * FROM source_lead");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>

          <!-- Lead For Input -->
          <div  style="position: relative;">
            <label for="for_lead">Lead For </label>
                <select class="form-control" id="for_lead" name="for_lead" required>
                    <option value="" disabled ><?php echo empty($rows['for_lead'])?></option>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "leads_details");
                    $result = $conn->query("SELECT * FROM for_lead");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                    }
                    ?>
                </select>
            </div>

          <!-- Lead Priority Dropdown -->
          <div>
            <label for="lead-priority">Lead Priority *</label>
            <select id="lead-priority" name="lead-priority">  <!-- added name attribute for POST -->
              <option value="high">High</option>
              <option value="medium">Medium</option>
              <option value="low">Low</option>
            </select>
          </div>
        </div>

        <!-- Row 2 -->
        <div class="form-group">
          <div>
            <label for="contact-person">Contact Person *</label>
            <input type="text" id="contact-person" name="contact-person" value="<?php echo $rows['contact_person']; ?>" placeholder="Enter Contact Person">  <!-- added name attribute -->
          </div>
          <div>
            <label for="company-name">Company Name</label>
            <input type="text" id="company-name" name="company-name" value="<?php echo $rows['company_name']; ?>" placeholder="Enter Company Name">  <!-- added name attribute -->
          </div>
        </div>

        <!-- Row 3 -->
        <div class="form-group">
          <div>
            <label for="mobile-no">Mobile No</label>
            <input type="text" id="mobile-no" name="mobile-no" value="<?php echo $rows['mobile_no']; ?>" placeholder="Enter Mobile No">  <!-- added name attribute -->
          </div>
          <div>
            <label for="whatsapp-no">WhatsApp No</label>
            <input type="text" id="whatsapp-no" name="whatsapp-no" value="<?php echo $rows['whatsapp_no']; ?>" placeholder="Enter WhatsApp No">  <!-- added name attribute -->
          </div>
          <div>
            <label for="email">Email ID</label>
            <input type="email" id="email" name="email" value="<?php echo $rows['email']; ?>" placeholder="Enter Email ID">  <!-- added name attribute -->
          </div>
        </div>

        <!-- Row 4 -->
        <div class="form-group full">
          <label for="address">Address</label>
          <input type="text" id="address" name="address" value="<?php echo $rows['address']; ?>" placeholder="Enter Address">  <!-- added name attribute -->
        </div>

        <!-- Row 5 -->
        <div class="form-group">
          <div>
            <label for="country">Country</label>
            <select id="country" name="country">  <!-- added name attribute -->
              <option value="india">India</option>
              <option value="usa">USA</option>
              <option value="uk">UK</option>
            </select>
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

          <div>
            <label for="city">City</label>
            <input type="text" id="city" name="city" value="<?php echo $rows['city']; ?>" placeholder="Enter City">  <!-- added name attribute -->
          </div>
          <div>
            <label for="pincode">Pincode</label>
            <input type="text" id="pincode" name="pincode" value="<?php echo $rows['pincode']; ?>" placeholder="Enter Pincode">  <!-- added name attribute -->
          </div>
        </div>

        <!-- Row 6 -->
        <div class="form-group">
          <div>
            <label for="reference-person-name">Reference Person Name</label>
            <input type="text" id="reference-person-name" name="reference-person-name" value="<?php echo $rows['reference_person_name']; ?>" placeholder="Enter Reference Person Name">  <!-- added name attribute -->
          </div>
          <div>
            <label for="reference-person-mobile">Reference Person Mobile No.</label>
            <input type="text" id="reference-person-mobile" name="reference-person-mobile" value="<?php echo $rows['reference_person_mobile_no'];?>" placeholder="Enter Reference Person Mobile No.">  <!-- added name attribute -->
          </div>
          <div>
<label for="gst_no">GST Number</label>
<input type="text" id="gst_no" name="gst_no" placeholder="Enter GST Number" value="<?php echo $rows['gst_no']; ?>">

</div>
        </div>

        <!-- Row 7 -->
        <div class="form-group">
          <div>
            <label for="estimate-amount">Estimate Amount</label>
            <input type="text" id="estimate-amount" name="estimate-amount" value="<?php echo $rows['estimate_amount']; ?>" placeholder="Enter Estimate Amount">  <!-- added name attribute -->
          </div>
          <div>
            <label for="next-follow-up-date">Next Follow-Up Date</label>
            <input type="date" id="next-follow-up-date" name="next-follow-up-date" value="<?php echo $rows['next_follow_up_date']; ?>">  <!-- added name attribute -->
          </div>
        </div>

        <!-- Row 8 -->
        <div class="form-group" >
       
            <label for="employee_name">Employee</label>
            <select class="form-control" id="employee_name" name="employee_name"  required>
            <option value="" disabled ><?php echo empty($rows['employee_name'])?></option>
              <?php
              $conn = new mysqli("localhost", "root", "", "employee_info");
              $result = $conn->query("SELECT * FROM user_info");
              while ($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row['employee_name'] . "'>" . $row['employee_name'] . "</option>";
              }
              ?>
            </select>

            <div>
                <label for="remarks">Remarks</label>
                <textarea id="remarks" name="remarks" value="<?php echo $rows['remarks']; ?>" placeholder="Enter Remarks" rows="2.5" class="input-field"></textarea>
            </div>




        </div>




    <!-- Row 9 (Actions) -->

    <div class="form-actions">
        <button type="submit" name="register" class="button">Submit</button>
        <a href="save_contact.php" class="cancel-btn">Cancel</a>
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
