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
			margin-bottom: 5px;
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
			gap: 20px;
		}

		.form-group {
			flex: 1 1 calc(50% - 20px); /* Adjust width */
			min-width: 250px;
		}
		#employeeDetailsForm{
				width: 1200px;
			height: 600px;
			overflow-y: auto; 
			margin: 30px auto;
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
					<h2>Edit Employee Details</h2>
					<div >
						<a href="user_info.php">
							<img id="cross" src="close.png" alt="">
						</a>
					</div>
				</div>
				<div class="tabs">
					<div class="tab active" data-tab="personal">Personal Details</div>
					<div class="tab" data-tab="education">Education Details</div>
					<div class="tab" data-tab="work">Work Experience</div>
				</div>
						
				<div id="employeeDetailsForm">
					<form action="update_user_info.php" method="POST" id="personalForm" >
						<?php
							$conn = mysqli_connect("localhost", "root", "", "employee_info") or die("Connection failed");
							$id=$_GET['id'];
							if (isset($_GET['id'])) {
								$id = $_GET['id'];
							} else {
								// Handle the error if 'id' is not passed
								echo "ID not provided.";
								exit; // Stop further execution
							}
							$query = "SELECT * FROM user_info WHERE id ={$id}";
							$result = mysqli_query($conn, $query) or die("Query Unsuccessful");

							if (mysqli_num_rows($result) > 0) {
								while ($rows = mysqli_fetch_assoc($result)) {
						?>
						<div class="tab-content active" id="personal">
							<h2>Update Employee Details</h2>

							<div class="form-layout">
								<div class="form-group">
									<label for="employee_name">Employee Code</label>
									<input type="hidden" id="id" name="id" class="form-control" value="<?php echo $rows['id']; ?>" required>
									<input type="text" id="emp_code" name="code" class="form-control" value="<?php echo $rows['emp_code']; ?>" required>
								</div>

								<!-- Employee Name -->
								<div class="form-group">
									<label for="employee_name">Employee Name</label>
									<input type="text" id="name" name="name" class="form-control" value="<?php echo $rows['employee_name']; ?>" required>
								</div>                                        

								<!-- Email ID -->
								<div class="form-group">
									<label for="email_id">Email ID</label>
									<input class="form-control" type="email" id="email_id" name="email" value="<?php echo $rows['email_id']; ?>" required>
								</div>

										<!-- Mobile No -->
								<div class="form-group">
									<label for="mobile_no">Mobile No</label>
									<input class="form-control" type="text" id="mobile_no" name="mobile_no" value="<?php echo $rows['mobile_no']; ?>" required>
								</div>

								<!-- Designation -->
								<div class="form-group">
									<label for="designation">Designation</label>
									<select class="form-control" id="designation" name="designation" required>
											<option value="" disabled selected>Select an option</option> <!-- Placeholder option -->
										<?php
											// Fetch designations from the 'designation' table
											$conn = new mysqli("localhost", "root", "", "employee_info"); // Adjust connection
											if ($conn->connect_error) {
													die("Connection failed: " . $conn->connect_error);
											}
											$result = $conn->query("SELECT * FROM designation");
											if ($result->num_rows > 0) {
													// Output data for each row
													while ($row = $result->fetch_assoc()) {
															echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
													}
											} else {
													echo "No designations found.";
											}
										?>
									</select>
								</div>

								<!-- Department -->
								<div class="form-group">
									<label for="department">Department</label>
									<select class="form-control" id="department" name="department" required>
									<option value="" disabled selected>Select an option</option> <!-- Placeholder option -->
										<?php
											// Fetch departments from the 'department' table
											$result = $conn->query("SELECT * FROM department");
											while ($row = $result->fetch_assoc()) {
												echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
											}
										?>
									</select>
								</div>

						

								<div class="form-group">
									<label for="doj">Date of Joining (DOJ)</label>
									<input class="form-control" type="date" id="doj" name="doj" value="<?php echo $rows['doj']; ?>" required>
								</div>

								<!-- DOL -->
								<div class="form-group">
										<label for="dol">Date of Leaving (DOL)</label>
										<input class="form-control" type="date" id="dol" name="dol" value="<?php echo $rows['dol']; ?>">
								</div>

								<!-- Status -->
								<div class="form-group">
									<label for="status">Status</label>
									<select id="status" name="status" class="form-control" required>
											<option value="Active">Active</option>
											<option value="Inactive">Inactive</option>
									</select>
								</div>

							

								<!-- Submit Button -->
								<div class="form-group btn-container">
									<button type="submit" class="btn-primary" id="savePersonal">Save</button>
								</div>
							</div>   
						</div>
						<?php } ?>
						<?php } ?>
					</form>

						
					<form action="save_edit2_edu.php" method="POST" id="educationForm" >
						<div class="tab-content" id="education">
							<h3>Educational Details</h3>

						
							<div class="form-layout">
								<div class="form-group">
									<label for="employee_code">Employee Code</label>
									<input type="hidden" id="id" name="id" class="form-control" value="<?php echo htmlspecialchars($_GET['id']); ?>" required>
									<input type="text" id="emp_code" name="code" class="form-control" value="<?php echo htmlspecialchars($_GET['emp_code']); ?>" readonly> 
								</div>
								<div class="form-group">
								<label for="degree">Degree</label>
								<input type="text" class="form-control" id="degree" name="degree" required>
								</div>
								<div class="form-group">
								<label for="institution">Institution</label>
								<input type="text" class="form-control" id="institution" name="institution" required>
								</div>
								<div class="form-group">
								<label for="year">Year of Graduation</label>
								<input type="text" class="form-control" id="year" name="year" required>
								</div>
								<div class="form-group">
								<label for="percentage">Percentage</label>
								<input type="text" class="form-control" id="percentage" name="percentage" required>
								</div>
								<div class="form-group">
								<button type="submit" class="btn-primary" id="saveEducation">Save</button>
								</div>

							</div>
							<table class="form-control">
								<thead>
									<tr>
										<th>Degree</th>
										<th>Institution</th>
										<th>Year of Graduation</th>
										<th>Percentage</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$conn = mysqli_connect("localhost", "root", "", "employee_info") or die("Connection failed");
									$emp_code = $_GET['emp_code'];

									// Ensure $emp_code is sanitized to prevent SQL injection
									$emp_code = mysqli_real_escape_string($conn, $emp_code);

									$query = "SELECT DISTINCT * FROM education_details WHERE emp_code = '$emp_code'";

$result = mysqli_query($conn, $query) or die("Query Unsuccessful");

if (mysqli_num_rows($result) > 0) {
    while ($rows = mysqli_fetch_assoc($result)) {
 // Output each row to debug duplicates
        echo "<tr>";
        echo "<td>" . htmlspecialchars($rows['degree']) . "</td>";
        echo "<td>" . htmlspecialchars($rows['institution']) . "</td>";
        echo "<td>" . htmlspecialchars($rows['year_of_graduation']) . "</td>";
        echo "<td>" . htmlspecialchars($rows['percentage']) . "</td>";
        echo "<td>
            <a href='edit_education.php?id=" . $rows['id'] . "'>
                <img src='edit.svg' alt='Edit' style='width: 20px; height: 20px;'>
            </a>
            <a href='delete_education.php?id=" . $rows['id'] . "' 
                onclick='return confirm(\"Are you sure you want to delete this education detail?\");'>
                <img src='delete.png' alt='Delete' style='width: 20px; height: 20px;'>
            </a>
        </td>";
        echo "</tr>";
    }
}
?>
								</tbody>
							</table>
						</div> 
					</form>     

					<form action="save_edit2_work.php" method="POST" id="workForm">
						<div class="tab-content" id="work">
							
							<div class="form-layout">
								<div class="form-group">
									<label for="employee_code">Employee Code</label>
									<input type="hidden" id="id" name="id" class="form-control" value="<?php echo htmlspecialchars($_GET['id']); ?>" required>
									<input type="text" id="emp_code" name="code" class="form-control" value="<?php echo htmlspecialchars($_GET['emp_code']); ?>" readonly>
								</div>
								<div class="form-group">
											<label for="designation">Position</label>
											<input type="hidden" id="id" name="id" class="form-control" required>
											<input type="text" class="form-control" id="position" name="position"  required>
								</div>
								<div class="form-group">
										<label for="company">Company Name</label>
										<input type="text" class="form-control" id="company" name="company"  required>
								</div>
								<div class="form-group">
										<label for="start_date">Start Date</label>
										<input type="date" class="form-control" id="start_date" name="start_date"  required>
								</div>
								<div class="form-group">
										<label for="end_date">End Date</label>
										<input type="date" class="form-control" id="end_date" name="end_date" ?>
								</div>
								<div class="form-group">
										<label for="salary">Salary</label>
										<input type="text" class="form-control" id="salary" name="salary" ?>
								</div>
								<div class="form-group">
										<label for="reason_for_resignation">Reason for Resignation</label>
										<input type="text" class="form-control" id="reason_for_resignation" name="reason_for_resignation" ?>
								</div>
								<div class="form-group">
								<button type="submit" class="btn-primary" id="saveWork">Save</button>
								</div>
							</div>
	
					
								<h4>Saved Work Experience Details</h4>
								<table class="form-control">
									<thead>
											<tr>
													<th>Position</th>
													<th>Company</th>
													<th>Start Date</th>
													<th>End Date</th>
													<th>Salary</th>
													<th>Reason for Resignation</th>
													<th>Actions</th>
											</tr>
									</thead>
									<tbody>
									<?php
										// Establish connection to the database


										// Get the emp_code from the URL and sanitize it to prevent SQL injection
										$emp_code = mysqli_real_escape_string($conn, $_GET['emp_code']);

										// Query to fetch work experience details for the given emp_code
										$query = "SELECT * FROM work_experience_details WHERE emp_code = '$emp_code'";

										// Execute the query and handle errors
										$result = mysqli_query($conn, $query);

										// Check if query execution is successful
										if (!$result) {
											die("Query failed: " . mysqli_error($conn));
										}

										if (mysqli_num_rows($result) > 0) {
											// Display the results in a table format
											while ($rows = mysqli_fetch_assoc($result)) {
												echo "<tr>";
												echo "<td>" . htmlspecialchars($rows['position']) . "</td>";
												echo "<td>" . htmlspecialchars($rows['company_name']) . "</td>";
												echo "<td>" . htmlspecialchars($rows['start_date']) . "</td>";
												echo "<td>" . htmlspecialchars($rows['end_date']) . "</td>";
												echo "<td>" . htmlspecialchars($rows['salary']) . "</td>";
												echo "<td>" . htmlspecialchars($rows['reason_for_resignation']) . "</td>";
												echo "<td>
													<a href='edit_work.php?id=" . $rows['id'] . "'>
														<img src='edit.svg' alt='Edit' style='width: 20px; height: 20px;'>
													</a>
													<a href='delete_work.php?id=" . $rows['id'] . "' 
														onclick='return confirm(\"Are you sure you want to delete this work experience detail?\");'>
														<img src='delete.png' alt='Delete' style='width: 20px; height: 20px;'>
													</a>
												</td>";
												echo "</tr>";
											}
										} else {
											echo "<tr><td colspan='7'>No work experience details found.</td></tr>";
										}

										// Close the database connection
										mysqli_close($conn);
										?>

									</tbody>
								</table>
							</div>		
						</div>
					</form>
				</div>
				 
							 
		  

								

			</div>
		</div>
</div>
<script>
	// Tab Switching Logic
document.querySelectorAll('.tab').forEach(tab => {
  tab.addEventListener('click', function () {
	document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
	document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));
	this.classList.add('active');
	document.getElementById(this.dataset.tab).classList.add('active');
  });
});

// Function to handle form submission and tab change
function switchToNextTab(currentTabId) {
	const tabs = document.querySelectorAll('.tab');
	let nextTab = null;
	let isNext = false;

	tabs.forEach(tab => {
		if (isNext) {
			nextTab = tab;
			return;
		}
		if (tab.dataset.tab === currentTabId) {
			isNext = true;
		}
	});

	// Correct order of tabs
	if (currentTabId === 'personal') {
		nextTab = document.querySelector('[data-tab="education"]');
	} else if (currentTabId === 'education') {
		nextTab = document.querySelector('[data-tab="work"]');
	}

	if (nextTab) {
		nextTab.click(); // Trigger click on the next tab
	}
}


// Personal Details form submission
document.getElementById('savePersonal').addEventListener('click', function() {
  const form = document.getElementById('personalForm');
  const formData = new FormData(form);

  fetch('update_user_info.php', {
	method: 'POST',
	body: formData
  })
  .then(response => response.text())
  .then(data => {
	if (data.includes('Details saved successfully!')) {
		alert('Added successfully!'); 
	  switchToNextTab('personal');
	} else {
	  alert('Error while saving form: ' + data);
	}
  })
  .catch(error => alert('Error submitting the form: ' + error));
});

// Educational Details form submission
document.getElementById('saveEducation').addEventListener('click', function(event) {
  event.preventDefault();
  const button = event.target;
    button.disabled = true; //  // Prevent the default form submission
  const form = document.getElementById('educationForm');
  const formData = new FormData(form);

  fetch('save_edit2_edu.php', {
    method: 'POST',
    body: formData
  })
    .then(response => response.text())
    .then(data => {
      if (data.includes('Educational details saved successfully!')) {
		alert('Added successfully!'); 
        switchToNextTab('education');
      } else {
        alert('Error while saving form: ' + data);
      }
    })
    .catch(error => alert('Error submitting the form: ' + error));
});

// Work Experience form submission
document.getElementById('saveWork').addEventListener('click', function () {
	event.preventDefault();
  const button = event.target;
    button.disabled = true;
    const form = document.getElementById('workForm');
    const formData = new FormData(form);

    fetch('save_edit2_work.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.text())
        .then(data => {
            console.log(data); // Debug the response from the server
            if (data.includes('Work experience details saved successfully!')) {
				
                // Redirect to the desired page after success
                window.location.href = 'user_info.php';
				alert('Added successfully!'); 
            } else {
                alert('Error while saving form: ' + data);
            }
        })
        .catch(error => {
            alert('Error submitting the form: ' + error);
        });
});
</script>
</body>
</html>
