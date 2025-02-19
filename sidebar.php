<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar with Submenu</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Sidebar styles */
        .sidebar {
            width: 250px;
            background: #2183A0;
            color: white;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            overflow-y: auto;
            padding-top: 20px;
            z-index: 999;
        }
        .logo {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .nav-menu li {
            margin: 10px 0;
        }
        .nav-menu a {
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            display: block;
            font-size: 18px;
            transition: background-color 0.3s;
        }
        .nav-menu a:hover,
        .nav-menu a.active {
            background-color: #99CBD6;
        }
        .icon {
            margin-right: 10px;
        }
        .has-submenu > a:after {
            content: "▼";
            float: right;
            font-size: 12px;
            transition: transform 0.3s ease;
        }
        .has-submenu.open > a:after {
            transform: rotate(-180deg);
        }
        .submenu {
            display: none;
            list-style: none;
            padding-left: 20px;
        }
        .has-submenu.open .submenu {
            display: block;
        }
        .submenu li {
            margin: 5px 0;
        }
        .submenu a {
            font-size: 16px;
        }
    </style>
</head>
<body>
<nav class="sidebar">
  <h2 class="logo">My Dashboard</h2>
  <ul class="nav-menu">
    <li><a href="dashboard.html" class="active"><i class="icon">🏠</i>Dashboard</a></li>
    <li><a href="crm.html"><i class="icon">👥</i>CRM</a></li>
    <li class="has-submenu">
      <a href="#"><i class="icon">⚙️</i>CMS</a>
      <ul class="submenu">
        <li><a href="lead_for.php">📝 Lead For</a></li>
        <li><a href="lead_source.php">🔍 Lead Source</a></li>
        <li><a href="contact.php">📇 Contact</a></li>
        <li><a href="test2.php">⚙️ Test2</a></li>
      </ul>
    </li>
    <li><a href="lead_source.html"><i class="icon">📊</i>Leads Analytics</a></li>
    <li class="has-submenu">
      <a href="#"><i class="icon">📈 </i>Sales</a>
      <ul class="submenu">
        <li><a href="items.php">📦 Items</a></li>
        <li><a href="quotation.php">📝Quotation</a></li>
        <li><a href="invoice.php">🧾 Invoices</a></li>
        <li><a href="item_leisure.php">📇 Item_Leisure</a></li>
        <li><a href="test3.php">📦 Test3</a></li>

      </ul>
    </li>
    <li class="has-submenu">
      <a href="#"><i class="icon">⚙️</i>Settings</a>
      <ul class="submenu">
        <li><a href="user_info.php">👤 User</a></li>
        <li><a href="department.php">🏢 Department</a></li>
        <li><a href="designation.php">💼 Designation</a></li>
        <li><a href="profile.php">🧑 Profile</a></li>
        <li><a href="location.php">📍 Location</a></li>
        <li><a href="items_list.php">📦 Items_List</a></li>
        <li><a href="gst.php">🧾 GST</a></li>
        <li><a href="hsn.php">🔢 HSN</a></li>
        <li><a href="unit.php">📏 Unit of Measurement</a></li>
        <li><a href="item_unit.php">📦Item Unit of Measurement</a></li>
      </ul>
    </li>
  </ul>
</nav>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const submenuItems = document.querySelectorAll('.has-submenu > a');

        submenuItems.forEach(item => {
            item.addEventListener('click', function (e) {
                // Prevent default only if the link has a submenu
                const parent = this.parentElement;
                if (parent.classList.contains('has-submenu')) {
                    e.preventDefault(); // Prevent navigation
                    parent.classList.toggle('open'); // Toggle 'open' class
                }
            });
        });
    });
</script>

</body>
</html>


