<header class="topbar">
  <div class="logo">
    <img  src="Splendid.avif" alt="Logo" />
  </div>
  <div class="heading">Welcome to the Splendid Infotech CMS!</div>
  <div class="avatar-dropdown">
   <div class="avatar-button">
     <div class="avatar-circle">
       <?php echo isset($_SESSION['user_name']) ? strtoupper(substr($_SESSION['user_name'], 0, 1)) : 'U'; ?>
     </div>
     <span class="username">
       <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Username'; ?>
     </span>
   </div>
   <div class="dropdown-menu">
     <a href="update_form.php?id=<?php echo $_SESSION['user_id']; ?>" class="dropdown-item">Profile</a>
     <a href="logout.php" class="dropdown-item">Logout</a>
   </div>
 </div>
</header>



