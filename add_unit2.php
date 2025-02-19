<?php
// Start the session
session_start();

// Connect to the database
$conn = new mysqli("localhost", "root", "", "items_info");

// Retrieve session ID
$id = $_SESSION['item_id'] ?? null; // Check if 'item_id' is set in the session
$item_number=$_SESSION['item_number'] ?? null;;
// Fetch items from the database (You can use $id to filter if necessary)
$items = $conn->query("SELECT id, item_number, item_name FROM items WHERE item_number = {$item_number}");

// Fetch unit values from the database
$units = $conn->query("SELECT unit FROM unit_of_measurement");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details</title>
    <style>
       
        label { font-weight: bold; margin-top: 10px; display: block; }
        select, input { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        button { margin-top: 15px; padding: 10px 20px; background: #28a745; color: white; border: none; cursor: pointer; }
        button:hover { background: #218838; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #2c3e50; color: white; }
        .action-btns button { margin-right: 5px; padding: 5px 10px; cursor: pointer; }
        .edit { background: #f39c12; color: white; }
        .delete { background: #e74c3c; color: white; }
    </style>
</head>
<body>








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
    max-width: 900px;
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

  .btn-primary:active {
    transform: scale(0.98);
  }
    /* Custom Checkbox Style */
    .checkbox-container {
        width: 300px;
        display: flex;
        align-items: center;
        margin-top: 10px;
        gap: 30px;

    }

    .checkbox-label {
        display: inline-block;
        font-size: 16px;
        color: #2c3e50;
    }

    .checkbox-custom {
        position: relative;
        display: inline-block;
        width: 20px;
        height: 20px;
        background-color: #fff;
        border: 2px solid #ccc;
        border-radius: 5px;
        transition: background-color 0.2s, border-color 0.2s;
    }

    .checkbox-label input[type="checkbox"] {
        position: absolute;
        left: 0;
        top: 0;
        width: 20px;
        height: 20px;
        opacity: 0;
        cursor: pointer;
    }

    .checkbox-label input[type="checkbox"]:checked + .checkbox-custom {
        background-color: #007bff;
        border-color: #007bff;
    }

    .checkbox-label input[type="checkbox"]:checked + .checkbox-custom::after {
        content: '';
        position: absolute;
        left: 5px;
        top: 5px;
        width: 10px;
        height: 10px;
        background-color: #fff;
        border-radius: 50%;
    }

    /* Hover effect */
    .checkbox-label:hover .checkbox-custom {
        border-color: #007bff;
    }
</style>

  



</head>
<body>
<div class="container">
    <?php include 'topbar.php'; ?>
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <div class="main-content">
            <form id="itemForm" action="save_unit2.php" method="POST">
                <?php
                 $conn = new mysqli("localhost", "root", "", "items_info");
                 $result = $conn->query("SELECT * FROM items WHERE item_number= {$item_number}"); // Fetch saved data

                 while ($row = $result->fetch_assoc()) {
                ?>
                <!-- Item Number (Fetched) -->
                <label for="item_number">Item Number</label>
<input type="text" id="item_number" value="<?= $row['item_number'] ?>" readonly>

   
             
                <!-- Item Name (Auto-filled) -->
                <label for="item_name">Item Name</label>
                <input type="text" id="item_name" value="<?= $row['item_name'] ?>" readonly>

                <?php
                 }
                 ?>

                <label for="unit">Unit</label>
                <select id="unit" required>
                    <option value="" disabled selected>Select Unit</option>
                    <?php while ($row = $units->fetch_assoc()) { ?>
                        <option value="<?= $row['unit'] ?>">
                            <?= $row['unit'] ?>
                        </option>
                    <?php } ?>
                </select>



                <label for="value">Value</label>
                <input type="text" id="value" name="value">
                
                <div class="checkbox-container">
    <span class="checkbox-label">Base Unit</span>
    <label class="checkbox-label">
        <input type="checkbox" name="base" id="base" value="1">
        <span class="checkbox-custom"></span>
    </label>
</div>


                <!-- Add Button -->
                <button type="button" onclick="addItem()">Add</button>

                   <!-- Item Table -->
                <table id="itemTable">
                    <thead>
                        <tr>
                            <th>Item Number</th>
                            <th>Item Name</th>
                            <th>Unit</th>
                            <th>Value</th>
                            <th>Base</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $conn = new mysqli("localhost", "root", "", "items_info");
                            $result = $conn->query("SELECT * FROM item_unit_details WHERE item_number = '{$item_number}'");

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr data-id='" . $row['id'] . "'>";
                                echo "<td>" . $row['item_number'] . "</td>";
                                echo "<td>" . $row['item_name'] . "</td>";
                                echo "<td>" . $row['unit'] . "</td>";
                                echo "<td>" . $row['value'] . "</td>";
                                echo "<td>" . ($row['base'] == 1 ? "Active" : "Inactive") . "</td>";

                               
                                echo "<td class='action-btns'>
                                        <button class='edit' onclick='editRow(this, \"" . $row['id'] . "\")'>Edit</button>
                                        <button class='delete' onclick='deleteRow(this, \"" . $row['id'] . "\")'>Delete</button>
                                    </td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </form>

         
        </div>
    </div>

</div>

<script>

document.getElementById("unit").addEventListener("change", function() {
    const selectedOption = this.options[this.selectedIndex];
    const unitValue = selectedOption.getAttribute("data-value");
    document.getElementById("value").value = unitValue; // Update value field based on selected unit
});
function addItem() {
    const itemNumber = document.getElementById("item_number").value;
    const itemName = document.getElementById("item_name").value;
    const unitSelect = document.getElementById("unit");
    const unit = unitSelect.value; // Use value instead of text
    const value = document.getElementById("value").value;
    const baseUnit = document.getElementById("base").checked ? 1 : 0; // Get checkbox value

    if (!itemNumber || !unit) {
        alert("Please select an item and a unit.");
        return;
    }

    // Check if there's already an active unit in the table
    const rows = document.querySelectorAll("#itemTable tbody tr");
    for (let row of rows) {
        if (row.cells[4].innerText === "Active" && baseUnit === 1) {
            alert("Only one unit can be active at a time.");
            return;
        }
    }

    // Send Data to Database using AJAX
    fetch("save_unit2.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `item_number=${encodeURIComponent(itemNumber)}&item_name=${encodeURIComponent(itemName)}&unit=${encodeURIComponent(unit)}&value=${encodeURIComponent(value)}&base=${encodeURIComponent(baseUnit)}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data);

        // Add Row Dynamically After Saving in Database
        const table = document.getElementById("itemTable").querySelector("tbody");
        const row = document.createElement("tr");

        row.innerHTML = `
            <td>${itemNumber}</td>
            <td>${itemName}</td>
            <td>${unit}</td>
            <td>${value}</td>
            <td>${baseUnit === 1 ? "Active" : "Inactive"}</td>
            <td class="action-btns">
                <button type="button" class="edit" onclick="editRow(this, '${itemNumber}')">Edit</button>
                <button type="button" class="delete" onclick="deleteRow(this, '${itemNumber}')">Delete</button>
            </td>
        `;

        table.appendChild(row);
    });

    // Reset form fields
    document.getElementById("unit").selectedIndex = 0;
    document.getElementById("value").value = "";
    document.getElementById("base").checked = false;
}




function editRow(button, id) {
    event.preventDefault();
    const row = button.closest("tr");

    document.getElementById("item_number").value = row.cells[0].innerText;
    document.getElementById("item_name").value = row.cells[1].innerText;
    document.getElementById("unit").value = row.cells[2].innerText;
    document.getElementById("value").value = row.cells[3].innerText;

    const addButton = document.querySelector("button[onclick='addItem()']");
    addButton.innerText = "Update";
    addButton.setAttribute("onclick", `updateItem('${id}', this)`);
}


function updateItem(id) {
  const itemNumber = document.getElementById("item_number").value
  const itemName = document.getElementById("item_name").value
  const unit = document.getElementById("unit").value
  const value = document.getElementById("value").value
  const baseUnit = document.getElementById("base").checked ? "1" : "0"

  if (!itemNumber || !unit) {
    alert("Please select an item and a unit.")
    return
  }

  // Check if there's already an active unit in the table
  const rows = document.querySelectorAll("#itemTable tbody tr")
  let activeRowExists = false
  rows.forEach((row) => {
    if (row.getAttribute("data-id") !== id && row.cells[4].innerText === "Active") {
      activeRowExists = true
    }
  })

  if (activeRowExists && baseUnit === "1") {
    alert("Only one unit can be active at a time.")
    return
  }

  fetch("update_item.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `id=${encodeURIComponent(id)}&item_number=${encodeURIComponent(itemNumber)}&item_name=${encodeURIComponent(itemName)}&unit=${encodeURIComponent(unit)}&value=${encodeURIComponent(value)}&base=${encodeURIComponent(baseUnit)}`,
  })
    .then((response) => response.text())
    .then((data) => {
      alert(data)

      // Update the row in the table
      const row = document.querySelector(`#itemTable tbody tr[data-id="${id}"]`)
      row.cells[0].innerText = itemNumber
      row.cells[1].innerText = itemName
      row.cells[2].innerText = unit
      row.cells[3].innerText = value
      row.cells[4].innerText = baseUnit === "1" ? "Active" : "Inactive"

      // Reset form and revert button to "Add"
      document.getElementById("itemForm").reset()
      const addButton = document.querySelector("button[onclick^='updateItem']")
      addButton.innerText = "Add"
      addButton.setAttribute("onclick", "addItem()")
    })
}








// Function to delete row from both table and database
// Function to delete row from both table and database
function deleteRow(button, id) {  // Use ID instead of item_number
    if (confirm("Are you sure you want to delete this item?")) {
        fetch("delete_item.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${encodeURIComponent(id)}`  // Send ID instead of item_number
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Show response from PHP
            if (data.includes("successfully")) {
                button.closest("tr").remove(); // Remove only the clicked row
            }
        });
    }
}


</script>
</body>
</html>
