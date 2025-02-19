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
    }

    table th, table td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: center; /* Center table content */
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
        <h2 id="headd">Employee Details</h2>

        <!-- Centered search bar -->
        <input type="text" id="searchBar" class="form-control search-bar" placeholder="Search for...">

        <!-- Right-aligned plus icon -->
        <a href="add_user_info.php" class="plus-icon" title="Add Lead">
          <img src="plus.png" alt="Add Lead">
        </a>
      </div>


      <!-- Table -->
      <table id="leadTable">
        <thead>
          <tr>
            <th>Id</th>
            <th>Employee_Code</th>
            <th>Employee_Name</th>
            <th>Designation</th>
            <th>Department</th>
            <th>Email_id</th>
            <th>Mobile_no </th>
            <th>DOJ</th>  <!-- Added DOJ -->
            <th>DOL</th> 
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- PHP Code to Fetch and Display Leads -->
          <?php
          $conn = mysqli_connect("localhost", "root", "", "employee_info") or die("Connection failed: " . mysqli_connect_error());
      
        
          $limit = 10; // Number of entries per page (updated to 10)
          $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
          $offset = ($page - 1) * $limit;

          $query = "SELECT * FROM `user_info` LIMIT $limit OFFSET $offset";
          $result = mysqli_query($conn, $query);

          // Get total number of entries
          $count_query = "SELECT COUNT(*) as total FROM user_info";
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
            <td><?php echo $rows['emp_code']; ?></td>
            <td><?php echo $rows['employee_name']; ?></td> 
            <td><?php echo $rows['designation']; ?></td> 
            <td><?php echo $rows['department']; ?></td>
            <td><?php echo $rows['email_id']; ?></td>
            <td><?php echo $rows['mobile_no']; ?></td>
            <td><?php echo $rows['doj']; ?></td> <!-- Display DOJ -->
            <td><?php echo $rows['dol']; ?></td> 
            <td><?php echo $rows['status']; ?></td>
            <td>
            <a href="edit_user_info.php?id=<?php echo htmlspecialchars($rows['id']); ?>&emp_code=<?php echo htmlspecialchars($rows['emp_code']); ?>">
    <img src="edit.svg" alt="Edit" class="edit-icon">
</a>


              <a href='delete_user_info.php?id=<?php echo $rows['id']; ?>' onclick="return confirm('Are you sure you want to delete this lead?');">
                <img src="delete.png" alt="Delete" style="width: 20px; height: 20px;">
            </a>
            <a href='password_user_info.php?id=<?php echo $rows['id']; ?>'><img src="password.png" alt="Password" style="width: 20px; height: 20px;">
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
  // Search Bar Functionality
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
