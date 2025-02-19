<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee</title>
  <link rel="stylesheet" href="styles.css" />
  <style>
    * {
      overflow-y: hidden;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      overflow-x: auto; 

    }

    table th, table td {
        padding: 12px 12px; /* Increased horizontal padding for better spacing */
  border: 1px solid #ddd;
  text-align: center; /* Center-align text */
  /* Vertically align text for better presentation */
  font-size: 14px; /* Moderate font size for clarity */

    }

    table th {
      background-color: #2183A0;
      color: white;

    }

    .btn-primary {
      padding: 5px 10px;
      border: none;
      border-radius: 4px;
      color: white;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .btn-primary {
      background-color: #007bff;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    #headd {
      color:white;
      font-family: Arial, sans-serif;
      font-weight: bold;
    }

    .form-control {
      padding: 8px;
      margin: 5px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(0, 0, 0, 0.2); /* Semi-transparent black */
    padding: 15px 20px;
    border-radius: 8px; /* Smooth corners */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    margin-bottom: 20px;
    backdrop-filter: blur(3px); /* Adds a subtle blur effect */
    color: white; /* Text remains readable on dark background */
}

.top-bar h2 {
    margin: 0;
    font-size: 24px;
    font-weight: bold;
    flex: 1; /* Allow space for the other elements */
}

.top-bar .form-control.search-bar {
    flex: 2;
    max-width: 400px;
    padding: 10px;
    border: 1px solid #ffffffaa; /* Slightly transparent white border */
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.3); /* Light translucent background */
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2); /* Inset shadow for depth */
    font-size: 14px;
    color: white;
    outline: none;
    transition: all 0.3s ease;
}

.top-bar .form-control.search-bar:focus {
    border-color: #ffffff; /* Fully white border on focus */
    box-shadow: 0 0 5px rgba(255, 255, 255, 0.5); /* Glow effect */
}
.top-bar .plus-icon img {
    max-height: 40px; /* Control icon size */
    width: auto;
    transition: transform 0.3s ease, opacity 0.3s ease;
}
.top-bar .plus-icon {
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px;
    background: rgba(255, 255, 255, 0.2); /* Light translucent button background */
    border-radius: 50%;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.top-bar .plus-icon:hover {
    background: rgba(255, 255, 255, 0.4); /* Brighter hover effect */
    transform: scale(1.1);
}


    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .pagination a {
      padding: 8px 16px;
      margin: 0 4px;
      border: 1px solid #ccc;
      text-decoration: none;
      color: #2183A0;
      border-radius: 4px;
    }

    .pagination a:hover {
      background-color: #2183A0;
      color: white;
    }

    .pagination .disabled {
      color: #ccc;
    }
    .table-wrapper {
  overflow-x: auto; /* Enable horizontal scroll */
  -webkit-overflow-scrolling: touch; /* Smooth scrolling for mobile devices */
  max-width: 100%; /* Ensure the wrapper doesn't exceed the container width */
  padding-bottom: 14px; /* Adds space at the bottom to prevent the scrollbar from overlaying content */
}

/* Style the scrollbar */
.table-wrapper::-webkit-scrollbar {
  height: 11px; /* Set the height of the horizontal scrollbar */
}

.table-wrapper::-webkit-scrollbar-track {
  background: #f1f1f1; /* Light grey background for the track */
  border-radius: 10px; /* Rounded corners for the track */
}

.table-wrapper::-webkit-scrollbar-thumb {
  background: #2183A0; /* Color of the scrollbar thumb */
  border-radius: 10px; /* Rounded corners for the thumb */
  border: 2px solid #f1f1f1; /* Light border around the thumb */
}

.table-wrapper::-webkit-scrollbar-thumb:hover {
  background: #0056b3; /* Darker thumb color on hover */
}

.table-wrapper::-webkit-scrollbar-button {
  display: none; /* Hide scrollbar buttons */
}

</style>
</head>
<body>
<div class="container">
  <?php include 'topbar.php'; ?>
  <?php include 'sidebar.php'; ?>
  <div class="content">
    <div class="main-content">
      <div class="top-bar">
      <!-- Left-aligned heading -->
        <h2 id="headd">Contact Details</h2>

        <!-- Centered search bar -->
        <input type="text" id="searchBar" class="form-control search-bar" placeholder="Search for...">

        <!-- Right-aligned plus icon -->
        <a href="add_contact.php" class="plus-icon" title="Add Lead">
          <img src="plus.png" alt="Add Lead">
        </a>
    </div>


      <!-- Table -->
    <div class="table-wrapper"> 
      <table id="leadTable">
        <thead>
          <tr>
            <th>Id</th>
            <th>Lead Source</th>
            <th>Lead For</th>
            <th>Lead Priority</th>
            <th>Contact Person</th>
            <th>Company Name</th>
            <th>Mobile_no </th>
            <th>WhatsApp No</th>  <!-- Added DOJ -->
            <th>Email ID</th> 
            <th>Country</th>
            <th>State</th>
            <th>City</th>
            <th>Reference Person Name</th>
            <th>Reference Person Mobile No.</th>
            <th>Estimate Amount</th>  <!-- Added DOJ -->
            <th>Next Follow-Up Date</th> 
            <th>Employee</th>
            <th>Remarks</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- PHP Code to Fetch and Display Leads -->
          <?php
          $conn = mysqli_connect("localhost", "root", "", "leads_details") or die("Connection failed: " . mysqli_connect_error());
      
        
          $limit = 5; // Number of entries per page (updated to 10)
          $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
          $offset = ($page - 1) * $limit;

          $query = "SELECT * FROM `contact` LIMIT $limit OFFSET $offset";
          $result = mysqli_query($conn, $query);

          // Get total number of entries
          $count_query = "SELECT COUNT(*) as total FROM contact";
          $count_result = mysqli_query($conn, $count_query);
          $total_rows = mysqli_fetch_assoc($count_result)['total'];
          $total_pages = ceil($total_rows / $limit);

          if (mysqli_num_rows($result) > 0) {
            $start = ($page - 1) * $limit + 1;
            $end = min($start + $limit - 1, $total_rows);
            echo "<p style='color: white;'>Showing $start to $end of $total_rows entries</p>";

            
            while ($rows = mysqli_fetch_assoc($result)) {
          ?>
          <tr>
            <td><?php echo $rows['id']; ?></td>
            <td><?php echo $rows['lead_source']; ?></td>
            <td><?php echo $rows['lead_for']; ?></td> 
            <td><?php echo $rows['lead_priority']; ?></td> 
            <td><?php echo $rows['contact_person']; ?></td>
            <td><?php echo $rows['company_name']; ?></td>
            <td><?php echo $rows['mobile_no']; ?></td>
            <td><?php echo $rows['whatsapp_no']; ?></td> <!-- Display DOJ -->
            <td><?php echo $rows['email']; ?></td> 
            <td><?php echo $rows['country']; ?></td> 
            <td><?php echo $rows['state']; ?></td> 
            <td><?php echo $rows['city']; ?></td>
            <td><?php echo $rows['reference_person_name']; ?></td>
            <td><?php echo $rows['reference_person_mobile_no']; ?></td>
            <td><?php echo $rows['estimate_amount']; ?></td>
            <td><?php echo $rows['next_follow_up_date']; ?></td> <!-- Display DOJ -->
            <td><?php echo $rows['employee_name']; ?></td> 
            <td><?php echo $rows['remarks']; ?></td>
            <td>
              <a href='edit_contact.php?id=<?php echo $rows['id']; ?>'><img src="edit.svg" alt="Edit" style="width: 20px; height: 20px;"></a>
              <a href='delete_contact.php?id=<?php echo $rows['id']; ?>' onclick="return confirm('Are you sure you want to delete this lead?');">
                <img src="delete.png" alt="Delete" style="width: 20px; height: 20px;">
            </a>
            </td>
          </tr>
          <?php
            }
          } else {
            echo "<tr><td colspan='4'>No records found</td></tr>";
          }
          mysqli_close($conn);
          ?>
        </tbody>
      </table>
      <div class="pagination">
        <a href="?page=1" class="<?php echo ($page == 1) ? 'disabled' : ''; ?>">Previous</a>
        <?php
        for ($i = 1; $i <= $total_pages; $i++) {
          echo "<a href='?page=$i' class='" . ($i == $page ? 'disabled' : '') . "'>$i</a>";
        }
        ?>
        <a href="?page=<?php echo $total_pages; ?>" class="<?php echo ($page == $total_pages) ? 'disabled' : ''; ?>">Next</a>
      </div>
    </div>
  </div>
</div>
<script>
  document.getElementById('searchBar').addEventListener('keyup', function() {
  const filter = this.value.toLowerCase();
  const rows = document.querySelectorAll('#leadTable tbody tr');

  rows.forEach(row => {
    // Check all cells in the row
    const cells = row.querySelectorAll('td');
    let matchFound = false;

    cells.forEach(cell => {
      if (cell.textContent.toLowerCase().includes(filter)) {
        matchFound = true;
      }
    });

    // Show the row if a match is found, otherwise hide it
    row.style.display = matchFound ? '' : 'none';
  });
});

</script>
</body>
</html>
