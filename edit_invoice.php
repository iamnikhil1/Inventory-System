
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Invoice System</title>
	<script src="https://cdn.tiny.cloud/1/xjbnl7h2c5gwu2oq5x844fhxm80nd2xuf21pwt2ttpc4m1pl/tinymce/5/tinymce.min.js"></script>	<style>
		
		
  /* Styling for Invoice Form */
#invoiceForm {
	background: rgba(255, 255, 255, 0.85);
	padding: 20px;
	border-radius: 8px;
	box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
	backdrop-filter: blur(5px);
	overflow-y: auto;
	max-height: 600px;
}

h2, h3, h4 {
	color: #2c3e50;
}

/* Styling for form sections */
.form-section {
	display: flex;
	flex-wrap: wrap;
	gap: 20px;
}

.column {
	flex: 1;
	min-width: 280px;
}

label {
	display: inline-block;
	font-weight: bold;
	color: #333;
	margin-bottom: 5px; /* Add spacing below labels */
}

input, select, textarea {
	width: 95%; /* Reduce input width to avoid stretching */
	padding: 8px;
	font-size: 14px;
	border: 1px solid #ccc;
	border-radius: 5px;
	box-sizing: border-box;
	outline: none;
	margin-bottom: 15px; /* Adds spacing between inputs */
}
.summary-container input {
	width: 90%; /* Reduce input width in summary section */
}

input:focus, select:focus, textarea:focus {
	border-color: #007bff;
	background-color: #f9f9f9;
}

/* Table Styling */
#invoiceTable {
	width: 100%;
	border-collapse: collapse;
	margin-top: 20px;
}

#invoiceTable th, #invoiceTable td {
	border: 1px solid #ddd;
	padding: 10px;
	text-align: center;
}

#invoiceTable th {
	background: #2c3e50;
	color: #fff;
}

/* Buttons */
button {
	padding: 10px 20px;
	font-size: 16px;
	background: #007bff;
	color: #fff;
	border: none;
	border-radius: 5px;
	cursor: pointer;
	transition: 0.3s;
}

button:hover {
	background: #0056b3;
}

button[type="button"] {
	background: #28a745;
}

button[type="button"]:hover {
	background: #218838;
}

button[type="submit"] {
	background: #17a2b8;
}

button[type="submit"]:hover {
	background: #138496;
}

/* Responsive Design */
@media screen and (max-width: 768px) {
	.form-section {
		flex-direction: column;
	}
}
.summary-container {
    display: flex;
    justify-content: flex-end;
    width: 100%;
    padding: 20px;
}

.summary-card {
    background: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    width: 320px;
}

.summary-card h3 {
    text-align: center;
    font-size: 18px;
    margin-bottom: 15px;
    color: #333;
    font-weight: bold;
    border-bottom: 2px solid #ddd;
    padding-bottom: 10px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    font-size: 16px;
    color: #555;
}

.summary-item input {
    width: 120px;
    padding: 6px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
    text-align: right;
    background: #f9f9f9;
}

.summary-item.total {
    font-weight: bold;
    font-size: 18px;
    color: #222;
    border-top: 2px solid #ddd;
    padding-top: 10px;
}

.summary-item.total input {
    font-weight: bold;
    background: #eef7ff;
    color: #0a58ca;
}


.summary-container button {
	width: 100%;
	background-color: #28a745;
	color: white;
	padding: 10px;
	border: none;
	cursor: pointer;
	margin-top: 15px;
}

.summary-container button:hover {
	background-color: #218838;
}
.header-section {
	display: flex;
	justify-content: space-between;
	align-items: center;
	margin-bottom: 20px;
}

.left-section {
	flex: 1;
}

.right-section {
	display: flex;
	gap: 10px;
	align-items: center;
}

.right-section label {
	font-weight: bold;
}

.right-section input {
	padding: 5px;
	border: 1px solid #ccc;
	border-radius: 4px;
	width: 120px;
}
.invoice-section {
  display: flex;
  justify-content: space-between;
  margin: 20px;
}

.terms-section {
  width: 40%; /* Adjust width based on layout needs */
  margin-right: 10px;
}

.terms-section textarea {
  width: 100%;
  height: 150px;
  padding: 10px;
  border: 1px solid #ddd;
}


.summary-section {
  width: 55%;
  /* Keep existing summary section styles here */
}




	</style>
</head>
<body>

<div class="container">
  <?php include 'topbar.php'; ?>
  <?php include 'sidebar.php'; ?>
  <div class="content">
	<div class="main-content">
	<h2>Edit Invoice</h2>

	<?php
	$conn = new mysqli("localhost", "root", "", "leads_details");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	?>
    <?php
       $servername = "localhost";
       $username = "root";
       $password = "";
       $dbname = "items_info";
       
       $conn = new mysqli($servername, $username, $password, $dbname);
       
       if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
       }
       
       $id = $_GET['id']; 
$sql = "SELECT * FROM invoices,invoice_tems WHERE id = $id";
$result = mysqli_query($conn, $sql);



       if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
    ?>

	<form id="invoiceForm" action="update_invoice.php" method="POST">
		<div class="header-section">
			<div class="left-section">
				<h3>Client & Shipper Details</h3>
			</div>
			<div class="right-section">
				<!-- Quotation Number - Automatically generated -->
				<label>Quotation Number:</label>
                <input type="hidden" id="id" name="id" class="form-control" value="<?php echo $rows['id']; ?>" required>
				<input type="text" name="quotation_number" id="quotation_number"  value="<?php echo $rows['quotation_number'];?>" required readonly>

				<!-- Quotation Date - Automatically set to today's date -->
				<label>Quotation Date:</label>
				<input type="date" name="quotation_date" id="quotation_date"required>
			</div>
		</div>
		<div class="form-section">
			<div class="column">
			
				<h4>Client Details</h4>
				<label>Name:</label>
				<select id="client_name" name="client_name" required>
					<option value="" disabled selected><?php echo empty($rows['client_name'])?></option>
					<?php
					$result = $conn->query("SELECT * FROM contact");
					while ($row = $result->fetch_assoc()) {
						echo "<option value='{$row['contact_person']}' data-phone='{$row['mobile_no']}' data-pincode='{$row['pincode']}' data-address='{$row['address']}' data-city='{$row['city']}' data-state='{$row['state']}' data-country='{$row['country']}' data-gst_no='{$row['gst_no']}'>{$row['contact_person']}</option>";
					}
					?>
				</select>
				<label>Address:</label>
				<input type="text" id="client_address" name="client_address" value="<?php echo $rows['client_address'];?>" required>
				<label>Phone:</label>
				<input type="text" id="client_phone" name="client_phone" value="<?php echo $rows['client_phone'];?>" required>
				<label>City:</label>
				<input type="text" id="client_city" name="client_city" value="<?php echo $rows['client_city'];?>" required>
				<label>State:</label>
				<input type="text" id="client_state" name="client_state" value="<?php echo $rows['client_state'];?>" required>
				<label>Country:</label>
				<input type="text" id="client_country" name="client_country" value="<?php echo $rows['client_country'];?>" required>
				<label>Pincode</label>
				<input type="text" id="client_pincode" name="client_pincode" value="<?php echo $rows['client_pincode'];?>" required>
				<label>GST NO.</label>
				<input type="text" id="client_gst_no" name="client_gst_no" value="<?php echo $rows['client_gst_no'];?>" required>
				
			</div>
			
			<div class="column">
				<h4>Shipper Details</h4>
				<label>Location Name:</label>
				<select id="shipper_location" name="shipper_location" required>
					<option value="" disabled selected><?php echo empty($rows['shipper_location'])?></option>
					<?php
					$conn = new mysqli("localhost", "root", "", "items_info");
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
					}
		
					$result = $conn->query("SELECT * FROM location_details");
					while ($row = $result->fetch_assoc()) {
						echo "<option value='{$row['location_name']}' data-company='{$row['company_name']}' data-address='{$row['address']}' data-city='{$row['city']}' data-state='{$row['state']}' data-pincode='{$row['pincode']}' data-country='{$row['country']}' data-phone='{$row['contact_no']}' data-gst_no='{$row['gst_no']}'>{$row['location_name']}</option>";
					}
					?>
				</select>
				<label>Company Name:</label>
				<input type="text" id="shipper_company" name="shipper_company" value="<?php echo $rows['shipper_company'];?>" required>
				<label>Address:</label>
				<input type="text" id="shipper_address" name="shipper_address" value="<?php echo $rows['shipper_address'];?>" required>
				<label>City:</label>
				<input type="text" id="shipper_city" name="shipper_city" value="<?php echo $rows['shipper_city'];?>" required>
				<label>State:</label>
				<input type="text" id="shipper_state" name="shipper_state" value="<?php echo $rows['shipper_state'];?>" required>
				<label>Country:</label>
				<input type="text" id="shipper_country" name="shipper_country" value="<?php echo $rows['shipper_country'];?>" required>
				<label>Pincode</label>
				<input type="text" id="shipper_pincode" name="shipper_pincode" value="<?php echo $rows['shipper_pincode'];?>" required>
				<label>Phone:</label>
				<input type="text" id="shipper_phone" name="shipper_phone" value="<?php echo $rows['shipper_phone'];?>" required>
				<label>GST NO.</label>
				<input type="text" id="shipper_gst_no" name="shipper_gst_no" value="<?php echo $rows['shipper_gst_no'];?>" required>
			</div>
		</div>

		<h3>Product Details</h3>
		<table id="invoiceTable">
		<thead>
	<tr>
		<th>Product</th>
		<th>Unit</th>
		<th>Quantity</th>
		<th>Rate</th>
		<th>GST (%)</th>
		<th>IGST</th>
		<th>SGST</th>
		<th>CGST</th>
		<th>Amount</th>
		<th>Action</th>
	</tr>
</thead>

	<tbody>
		<!-- Rows will be added here dynamically -->
	</tbody>
</table>

<button type="button" onclick="addRow()">Add Product</button>

<div class="invoice-section">
  <!-- Existing invoice content -->
  
  <div class="terms-section">
    <label for="terms">Terms and Conditions:</label>
    <textarea id="terms" name="terms"><?php echo htmlspecialchars($rows['terms_and_conditions']); ?></textarea>
    </div>
  
  <div class="summary-section">
		<div class="summary-container">
			<div class="summary-card">
				<h3>Invoice Summary</h3>
				<div class="summary-item">
					<span>Base Value:</span>
					<input type="text" id="baseValue" name="base_value" value="<?php echo $rows['base_value'];?>" readonly>
				</div>
				<div class="summary-item">
					<span>Total CGST:</span>
					<input type="text" id="totalCGST" name="total_cgst" value="<?php echo $rows['total_cgst'];?>" readonly>
				</div>
				<div class="summary-item">
					<span>Total SGST:</span>
					<input type="text" id="totalSGST" name="total_sgst" value="<?php echo $rows['total_sgst'];?>" readonly>
				</div>
				<div class="summary-item">
					<span>Total IGST:</span>
					<input type="text" id="totalIGST" name="total_igst" value="<?php echo $rows['total_igst'];?>" readonly>
				</div>
				<div class="summary-item">
					<span>Gross Amount:</span>
					<input type="text" id="grossAmount" name="gross_amount" value="<?php echo $rows['gross_amount'];?>" readonly>
				</div>
				<div class="summary-item">
					<span>Discount:</span>
					<input type="text" id="discountAmount" name="discount_amount" value="<?php echo $rows['discount_amount'];?>" oninput="calculateTotal()">
				</div>
				<div class="summary-item total">
					<span>Net Amount:</span>
					<input type="text" id="finalAmount" name="final_amount" value="<?php echo $rows['final_amount'];?>" readonly>
				</div>
				<div class="save-button">
					<button type="submit" id="saveInvoice" onclick="saveInvoice()">Save Invoice</button>
				</div>

			</div>
		</div>
 </div>
</div>




	</form>
    <?php } ?>
    <?php } ?>
	</div>
	</div>
</div>

<script>
	document.getElementById('quotation_date').value = new Date().toISOString().split('T')[0]; // Sets date in YYYY-MM-DD format

// Fetch the quotation number from the backend (AJAX or another method)
window.onload = function() {
	fetch('get_quotation_number.php') // A PHP file to get the next quotation number
		.then(response => response.json())
		.then(data => {
			document.getElementById('quotation_number').value = data.quotation_number;
		});
};
	// Populate client details when selected
	document.getElementById("client_name").addEventListener("change", function() {
		let selectedOption = this.options[this.selectedIndex];
		document.getElementById("client_address").value = selectedOption.getAttribute("data-address");
		document.getElementById("client_phone").value = selectedOption.getAttribute("data-phone");
		document.getElementById("client_city").value = selectedOption.getAttribute("data-city");
		document.getElementById("client_state").value = selectedOption.getAttribute("data-state");
		document.getElementById("client_country").value = selectedOption.getAttribute("data-country");
		document.getElementById("client_pincode").value = selectedOption.getAttribute("data-pincode");
		document.getElementById("client_gst_no").value = selectedOption.getAttribute("data-gst_no");
	});
	shipper_location
	
	document.getElementById("shipper_location").addEventListener("change", function() {
		let selectedOption = this.options[this.selectedIndex];
		document.getElementById("shipper_company").value = selectedOption.getAttribute("data-company");
		document.getElementById("shipper_address").value = selectedOption.getAttribute("data-address");
		document.getElementById("shipper_city").value = selectedOption.getAttribute("data-city");
		document.getElementById("shipper_state").value = selectedOption.getAttribute("data-state");
		document.getElementById("shipper_country").value = selectedOption.getAttribute("data-country");
		document.getElementById("shipper_pincode").value = selectedOption.getAttribute("data-pincode");
		document.getElementById("shipper_phone").value = selectedOption.getAttribute("data-phone");
		document.getElementById("shipper_gst_no").value = selectedOption.getAttribute("data-gst_no");
	});
	function addRow() {
	let table = document.getElementById("invoiceTable").getElementsByTagName("tbody")[0];
	let row = table.insertRow();
	row.innerHTML = `
		<td>
			<select name="product_name[]" onchange="fetchProductDetails(this)" required>
				<option value="" disabled selected>Select Product</option>
				<?php
				$conn = new mysqli("localhost", "root", "", "items_info");
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				$product_result = $conn->query("SELECT * FROM items");
				while ($row = $product_result->fetch_assoc()) {
					$item_number = $row['item_number'];
					$item_name = $row['item_name'];
					$gst_percentage = $row['gst'];
					$units_query = $conn->query("SELECT DISTINCT unit FROM item_unit_details WHERE item_number = '$item_number'");
					$units = [];
					while ($unit_row = $units_query->fetch_assoc()) {
						$units[] = $unit_row['unit'];
					}
					$units_json = json_encode($units); 
					echo "<option value='" . $item_name . "' 
						  data-item-number='" . $item_number . "' 
						  data-rate='" . $row['sales_price'] . "' 
						  data-gst='" . $gst_percentage . "' 
						  data-units='" . htmlspecialchars($units_json, ENT_QUOTES, 'UTF-8') . "'>" . 
						  $item_name . 
						  "</option>";
				}
				?>
			</select>
		</td>
		<td>
			<select name="unit[]" required>
				<option value="" disabled selected>Select Unit</option>
			</select>
		</td>
		<td><input type="number" name="quantity[]" oninput="calculateRow(this)" required></td>
		<td><input type="number" name="rate[]" readonly required></td>
		<td><input type="number" name="gst[]" readonly required></td>
		<td><input type="number" name="igst[]" readonly required></td>
		<td><input type="number" name="sgst[]" readonly required></td>
		<td><input type="number" name="cgst[]" readonly required></td>
		<td><input type="text" name="amount[]" readonly></td>
		<td><button type="button" onclick="removeRow(this)">Remove</button></td>
	`;
}

function fetchProductDetails(select) {
	let row = select.parentElement.parentElement;
	let selectedOption = select.options[select.selectedIndex];
	
	let itemName = selectedOption.value;
	let itemNumber = selectedOption.getAttribute("data-item-number");
	let rate = selectedOption.getAttribute("data-rate");
	let gst = parseFloat(selectedOption.getAttribute("data-gst")) || 0;
	let units = JSON.parse(selectedOption.getAttribute("data-units"));

	row.cells[3].querySelector("input").value = rate;
	row.cells[4].querySelector("input").value = gst;

	let unitDropdown = row.cells[1].querySelector("select");
	unitDropdown.innerHTML = `<option value="" disabled selected>Select Unit</option>`;

	units.forEach(unit => {
		let option = document.createElement("option");
		option.value = unit;
		option.textContent = unit;
		unitDropdown.appendChild(option);
	});

	// Insert hidden input to hold product name (this will be saved in the database)
	let productNameInput = document.createElement("input");
	productNameInput.type = "hidden";
	productNameInput.name = "product_name_hidden[]";
	productNameInput.value = itemName;
	row.appendChild(productNameInput);

	// Determine GST type
	let clientState = document.getElementById("client_state").value;
	let shipperState = document.getElementById("shipper_state").value;

	if (clientState && shipperState) {
		if (clientState === shipperState) {
			row.cells[6].querySelector("input").value = (gst / 2).toFixed(2); // SGST
			row.cells[7].querySelector("input").value = (gst / 2).toFixed(2); // CGST
			row.cells[5].querySelector("input").value = "0.00"; // IGST
		} else {
			row.cells[5].querySelector("input").value = gst.toFixed(2); // IGST
			row.cells[6].querySelector("input").value = "0.00"; // SGST
			row.cells[7].querySelector("input").value = "0.00"; // CGST
		}
	}
}







function calculateRow(input) {
	let row = input.parentElement.parentElement;
	let qty = parseFloat(row.cells[2].querySelector("input").value) || 0;
	let rate = parseFloat(row.cells[3].querySelector("input").value) || 0;
	let gst_percentage = parseFloat(row.cells[4].querySelector("input").value) || 0;

	let clientState = document.getElementById("client_state").value;
	let shipperState = document.getElementById("shipper_state").value;

	let basicAmount = qty * rate;
	let totalGST = (basicAmount * gst_percentage) / 100;
	let igst = 0, sgst = 0, cgst = 0;

	if (clientState === shipperState) {
		sgst = totalGST / 2;
		cgst = totalGST / 2;
	} else {
		igst = totalGST;
	}

	let totalAmount = basicAmount + igst + sgst + cgst;

	row.cells[5].querySelector("input").value = igst.toFixed(2); // IGST
	row.cells[6].querySelector("input").value = sgst.toFixed(2); // SGST
	row.cells[7].querySelector("input").value = cgst.toFixed(2); // CGST
	row.cells[8].querySelector("input").value = totalAmount.toFixed(2); // Total Amount

	calculateTotal();
}





	function removeRow(button) {
		button.parentElement.parentElement.remove();
		calculateTotal();
	}
	function calculateTotal() {
    let baseValue = 0;
    let totalIGST = 0;
    let totalSGST = 0;
    let totalCGST = 0;

    document.querySelectorAll("#invoiceTable tbody tr").forEach(row => {
        let amount = parseFloat(row.cells[8].querySelector("input").value) || 0;
        let igst = parseFloat(row.cells[5].querySelector("input").value) || 0;
        let sgst = parseFloat(row.cells[6].querySelector("input").value) || 0;
        let cgst = parseFloat(row.cells[7].querySelector("input").value) || 0;

        totalIGST += igst;
        totalSGST += sgst;
        totalCGST += cgst;

        // Base value before GST
        baseValue += amount - (igst + sgst + cgst);
    });

    let discount = parseFloat(document.getElementById("discountAmount").value) || 0;
    let grossAmount = baseValue + totalIGST + totalSGST + totalCGST;
    let finalAmount = grossAmount - discount;

    document.getElementById("baseValue").value = baseValue.toFixed(2);
    document.getElementById("totalIGST").value = totalIGST.toFixed(2);
    document.getElementById("totalSGST").value = totalSGST.toFixed(2);
    document.getElementById("totalCGST").value = totalCGST.toFixed(2);
    document.getElementById("grossAmount").value = grossAmount.toFixed(2);
    document.getElementById("finalAmount").value = finalAmount.toFixed(2);
}

tinymce.init({
      selector: '#terms',  // Targeting the textarea with the ID 'terms'
      menubar: false,       // Hides the menu bar
      plugins: 'lists',     // Enable lists plugin for bullet points and numbering
      toolbar: 'bold italic | bullist numlist | alignleft aligncenter alignright',
    });




</script>

</body>
</html>
