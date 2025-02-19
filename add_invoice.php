<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Invoice System</title>
	<script src="https://cdn.tiny.cloud/1/xjbnl7h2c6gwu2oq6x855fhxm80nd2xuf21pwt2ttpc5m1pl/tinymce/6/tinymce.min.js"></script>	<style>
		
		
  /* Styling for Invoice Form */
#invoiceForm {
	background: rgba(266, 266, 266, 0.86);
	padding: 20px;
	border-radius: 8px;
	box-shadow: 0 5px 10px rgba(0, 0, 0, 0.16);
	backdrop-filter: blur(6px);
	overflow-y: auto;
	max-height: 700px;
}

h2, h4, h5 {
	color: #2c4e60;
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
	color: #444;
	margin-bottom: 6px; /* Add spacing below labels */
}

input, select, textarea {
	width: 96%; /* Reduce input width to avoid stretching */
	padding: 8px;
	font-size: 15px;
	border: 1px solid #ccc;
	border-radius: 6px;
	box-sizing: border-box;
	outline: none;
	margin-bottom: 16px; /* Adds spacing between inputs */
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
	background: #2c4e60;
	color: #fff;
}

/* Buttons */
button {
	padding: 10px 20px;
	font-size: 17px;
	background: #007bff;
	color: #fff;
	border: none;
	border-radius: 6px;
	cursor: pointer;
	transition: 0.4s;
}

button:hover {
	background: #0067b4;
}

button[type="button"] {
	background: #28a756;
}

button[type="button"]:hover {
	background: #218848;
}

button[type="submit"] {
	background: #17a2b8;
}

button[type="submit"]:hover {
	background: #148597;
}

/* Responsive Design */
@media screen and (max-width: 778px) {
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
	box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
	width: 420px;
}

.summary-card h4 {
	text-align: center;
	font-size: 18px;
	margin-bottom: 16px;
	color: #444;
	font-weight: bold;
	border-bottom: 2px solid #ddd;
	padding-bottom: 10px;
}

.summary-item {
	display: flex;
	justify-content: space-between;
	align-items: center;
	padding: 8px 0;
	font-size: 17px;
	color: #666;
}

.summary-item input {
	width: 120px;
	padding: 7px;
	font-size: 17px;
	border: 1px solid #ddd;
	border-radius: 6px;
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
	color: #0a68ca;
}


.summary-container button {
	width: 100%;
	background-color: #28a756;
	color: white;
	padding: 10px;
	border: none;
	cursor: pointer;
	margin-top: 16px;
}

.summary-container button:hover {
	background-color: #218848;
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
	padding: 6px;
	border: 1px solid #ccc;
	border-radius: 5px;
	width: 120px;
}
.invoice-section {
  display: flex;
  justify-content: space-between;
  margin: 20px;
}

.terms-section {
  width: 50%; /* Adjust width based on layout needs */
  margin-right: 10px;
}

.terms-section textarea {
  width: 100%;
  height: 160px;
  padding: 10px;
  border: 1px solid #ddd;
}


.summary-section {
  width: 66%;
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
	<h2>Add Invoice</h2>

	<?php
	$conn = new mysqli("localhost", "root", "", "leads_details");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	?>

	<form id="invoiceForm" action="save_invoice.php" method="POST">
		<div class="header-section">
			<div class="left-section">
				<h4>Client & Shipper Details</h4>
			</div>
			<div class="right-section">
				<!-- Quotation Number - Automatically generated -->
				<label>Invoice Number:</label>
				<input type="text" name="invoice_number" id="invoice_number" required readonly>

				<!-- Quotation Date - Automatically set to today's date -->
				<label>Invoice Date:</label>
				<input type="date" name="quotation_date" id="quotation_date" required>
			</div>
		</div>
		<div class="form-section">
			<div class="column">
			
				<h5>Client Details</h5>
				<label>Name:</label>
				<select id="client_name" name="client_name" required>
					<option value="" disabled selected>Select Client</option>
					<?php
					$result = $conn->query("SELECT * FROM contact");
					while ($row = $result->fetch_assoc()) {
						echo "<option value='{$row['contact_person']}' data-phone='{$row['mobile_no']}' data-pincode='{$row['pincode']}' data-address='{$row['address']}' data-city='{$row['city']}' data-state='{$row['state']}' data-country='{$row['country']}' data-gst_no='{$row['gst_no']}'>{$row['contact_person']}</option>";
					}
					?>
				</select>
				<label>Address:</label>
				<input type="text" id="client_address" name="client_address" required>
				<label>Phone:</label>
				<input type="text" id="client_phone" name="client_phone" required>
				<label>City:</label>
				<input type="text" id="client_city" name="client_city" required>
				<label>State:</label>
				<input type="text" id="client_state" name="client_state" required>
				<label>Country:</label>
				<input type="text" id="client_country" name="client_country" required>
				<label>Pincode</label>
				<input type="text" id="client_pincode" name="client_pincode" required>
				<label>GST NO.</label>
				<input type="text" id="client_gst_no" name="client_gst_no" required>
				
			</div>
			
			<div class="column">
				<h5>Shipper Details</h5>
				<label>Location Name:</label>
				<select id="shipper_location" name="shipper_location" required>
					<option value="" disabled selected>Select Company</option>
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
				<input type="text" id="shipper_company" name="shipper_company" required>
				<label>Address:</label>
				<input type="text" id="shipper_address" name="shipper_address" required>
				<label>City:</label>
				<input type="text" id="shipper_city" name="shipper_city" required>
				<label>State:</label>
				<input type="text" id="shipper_state" name="shipper_state" required>
				<label>Country:</label>
				<input type="text" id="shipper_country" name="shipper_country" required>
				<label>Pincode</label>
				<input type="text" id="shipper_pincode" name="shipper_pincode" required>
				<label>Phone:</label>
				<input type="text" id="shipper_phone" name="shipper_phone" required>
				<label>GST NO.</label>
				<input type="text" id="shipper_gst_no" name="shipper_gst_no" required>
			</div>
		</div>

		<h4>Product Details</h4>
		<table id="invoiceTable">
		<thead>
	<tr>
		<th>Product</th>
		<th>Unit</th>
		<th>Value</th>
		<th>Quantity</th>
		<th>Rate</th>
		<th>GST (%)</th>
		<th>IGST</th>
		<th>SGST</th>
		<th>CGST</th>
		<th>Amount</th>
		<th>Lot Tracking Id</th>
		<th>Expiration Date</th>
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
	<textarea id="terms" name="terms" placeholder="Write terms and conditions here..."></textarea>
  </div>
  
  <div class="summary-section">
		<div class="summary-container">
			<div class="summary-card">
				<h4>Invoice Summary</h4>
				<div class="summary-item">
					<span>Base Value:</span>
					<input type="text" id="baseValue" name="base_value" readonly>
				</div>
				<div class="summary-item">
					<span>Total CGST:</span>
					<input type="text" id="totalCGST" name="total_cgst" readonly>
				</div>
				<div class="summary-item">
					<span>Total SGST:</span>
					<input type="text" id="totalSGST" name="total_sgst" readonly>
				</div>
				<div class="summary-item">
					<span>Total IGST:</span>
					<input type="text" id="totalIGST" name="total_igst" readonly>
				</div>
				<div class="summary-item">
					<span>Gross Amount:</span>
					<input type="text" id="grossAmount" name="gross_amount" readonly>
				</div>
				<div class="summary-item">
					<span>Discount:</span>
					<input type="text" id="discountAmount" name="discount_amount" oninput="calculateTotal()">
				</div>
				<div class="summary-item total">
					<span>Net Amount:</span>
					<input type="text" id="finalAmount" name="final_amount" readonly>
				</div>
				<div class="save-button">
					<button type="submit" id="saveInvoice" onclick="saveInvoice()">Save Invoice</button>
				</div>

			</div>
		</div>
 </div>
</div>




	</form>
	</div>
	</div>
</div>

<script>
	document.getElementById('quotation_date').value = new Date().toISOString().split('T')[0]; // Sets date in YYYY-MM-DD format

// Fetch the invoice number from the backend (AJAX or another method)
window.onload = function() {
	fetch('get_invoice_number.php') // A PHP file to get the next invoice number
		.then(response => response.json())
		.then(data => {
			document.getElementById('invoice_number').value = data.invoice_number;
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
                    $units_query = $conn->query("SELECT unit,value FROM item_unit_details WHERE item_number = '$item_number'");
                    $units = [];
                    $values = [];

                    while ($unit_row = $units_query->fetch_assoc()) {
                        $units[] = $unit_row['unit'];
                        $values[] = $unit_row['value'];
                    }
                    $units_json = json_encode($units); 
                    $values_json = json_encode($values); 
                    echo "<option value='" . $item_name . "' 
                          data-item-number='" . $item_number . "' 
                          data-gst='" . $gst_percentage . "' 
                          data-units='" . htmlspecialchars($units_json, ENT_QUOTES, 'UTF-8') . "' 
                          data-values='" . htmlspecialchars($values_json, ENT_QUOTES, 'UTF-8') . "'>" . 
                          $item_name . 
                          "</option>";
                }
                ?>
            </select>
            <input type="hidden" name="item_number[]" class="item-number">
        </td>
        <td>
            <select name="unit[]" onchange="updateValueForUnit(this)" required>
                <option value="" disabled selected>Select Unit</option>
            </select>
        </td>
        <td>
            <input type="text" name="value[]" readonly required>
        </td>
        <td><input type="number" name="quantity[]" oninput="calculateRow(this)" required></td>
        <td><input type="number" name="rate[]" oninput="calculateRow(this)" required></td>
        <td><input type="number" name="gst[]" readonly required></td>
        <td><input type="number" name="igst[]" readonly required></td>
        <td><input type="number" name="sgst[]" readonly required></td>
        <td><input type="number" name="cgst[]" readonly required></td>
        <td><input type="text" name="amount[]" readonly></td>

        <!-- NEW LOT TRACKING ID FIELD -->
        <td><input type="text" name="lot_tracking_id[]" placeholder="Enter Lot ID"></td>

        <!-- NEW EXPIRING DATE FIELD -->
        <td><input type="date" name="expiring_date[]"></td>

        <td><button type="button" onclick="removeRow(this)">Remove</button></td>
    `;
}




function fetchProductDetails(select) {
    let row = select.parentElement.parentElement;
    let selectedOption = select.options[select.selectedIndex];

    let itemNumber = selectedOption.getAttribute("data-item-number");
    let rate = selectedOption.getAttribute("data-rate");
    let gst = parseFloat(selectedOption.getAttribute("data-gst")) || 0;
    let units = JSON.parse(selectedOption.getAttribute("data-units"));
    let values = JSON.parse(selectedOption.getAttribute("data-values"));

    // Store item_number in the hidden input field
    row.querySelector(".item-number").value = itemNumber;

    // Update rate and GST fields
    row.cells[4].querySelector("input").value = rate; // Update rate input
    row.cells[5].querySelector("input").value = gst; // Update GST input

    // Clear and populate unit dropdown
    let unitDropdown = row.cells[1].querySelector("select");
    unitDropdown.innerHTML = `<option value="" disabled selected>Select Unit</option>`;

    // Hidden input for storing only the unit name
    let unitNameInput = document.createElement("input");
    unitNameInput.type = "hidden";
    unitNameInput.name = "unit_cleaned[]";
    row.cells[1].appendChild(unitNameInput);

    // Create a mapping for unit-value pairs
    let unitValueMap = {};
    units.forEach((unit, index) => {
        let value = values[index];
        let option = document.createElement("option");

        // Store unit and value as a combined string to differentiate
        let uniqueKey = `${unit} - ${value}`;
        unitValueMap[uniqueKey] = { unit, value };

        option.value = uniqueKey; // Store unit and value together
        option.textContent = uniqueKey; // Display "Unit - Value"
        unitDropdown.appendChild(option);
    });

    // Set the value when unit is selected
    let valueInput = row.cells[2].querySelector("input");

    unitDropdown.addEventListener("change", function () {
        let selectedUnit = unitDropdown.value;
        if (selectedUnit && unitValueMap[selectedUnit]) {
            valueInput.value = unitValueMap[selectedUnit].value; // Assign correct value
            unitNameInput.value = unitValueMap[selectedUnit].unit; // Store only unit name
        }
    });

    // Determine GST type
    let clientState = document.getElementById("client_state").value;
    let shipperState = document.getElementById("shipper_state").value;

    if (clientState && shipperState) {
        if (clientState === shipperState) {
            row.cells[7].querySelector("input").value = (gst / 2).toFixed(2); // SGST
            row.cells[8].querySelector("input").value = (gst / 2).toFixed(2); // CGST
            row.cells[6].querySelector("input").value = "0.00"; // IGST
        } else {
            row.cells[6].querySelector("input").value = gst.toFixed(2); // IGST
            row.cells[7].querySelector("input").value = "0.00"; // SGST
            row.cells[8].querySelector("input").value = "0.00"; // CGST
        }
    }
}




function calculateRow(input) {
	let row = input.parentElement.parentElement;
	let qty = parseFloat(row.cells[3].querySelector("input").value) || 0;
	let rate = parseFloat(row.cells[4].querySelector("input").value) || 0;
	let gst_percentage = parseFloat(row.cells[5].querySelector("input").value) || 0;

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

	row.cells[6].querySelector("input").value = igst.toFixed(2); // IGST
	row.cells[7].querySelector("input").value = sgst.toFixed(2); // SGST
	row.cells[8].querySelector("input").value = cgst.toFixed(2); // CGST
	row.cells[9].querySelector("input").value = totalAmount.toFixed(2); // Total Amount

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
		let amount = parseFloat(row.cells[9].querySelector("input").value) || 0;
		let igst = parseFloat(row.cells[6].querySelector("input").value) || 0;
		let sgst = parseFloat(row.cells[7].querySelector("input").value) || 0;
		let cgst = parseFloat(row.cells[8].querySelector("input").value) || 0;

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