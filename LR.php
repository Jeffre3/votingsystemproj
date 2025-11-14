<?php
include 'connect.php';
$current_page = basename($_SERVER['PHP_SELF'], "LR.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            <!-- STYLES CSS -->
            <link rel="stylesheet" href="assets/css/login.css">

            <!-- BOX ICONS CSS-->
            <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    
    </head>
    
    <body id="body">
      <div class="l-navbar" id="navbar">
          <nav class="nav">
              <div>
                  <a href="home.php" class="nav__logo">
                      <img src="assets/icons/logo.svg" alt="" class="nav__logo-icon">
                      <span class="nav__logo-text">VotingInaMo</span>
                  </a>
  
                  <div class="nav__toggle" id="nav-toggle">
                      <i class='bx bx-chevron-right'></i>
                  </div>
  
                  <ul class="nav__list">
                      <a href="home.php" class="nav__link <?php echo ($current_page == 'home.php') ? 'active' : ''; ?>">
                          <i class='bx bx-grid-alt nav__icon'></i>
                          <span class="nav__text">Home</span>
                      </a>
                      <a href="home.php" class="nav__link <?php echo ($current_page == 'about') ? 'active' : ''; ?>">
                          <i class='bx bx-heart nav__icon'></i>
                          <span class="nav__text">About</span>
                      </a>
                      <a href="LR.php" class="nav__link <?php echo ($current_page == 'LR.php') ? 'active' : ''; ?>">
                          <i class='bx bx-bookmark nav__icon'></i>
                          <span class="nav__text">Login</span>
                      </a>
                      <a href="register.php" class="nav__link <?php echo ($current_page == 'signup') ? 'active' : ''; ?>">
                          <i class='bx bx-message-rounded nav__icon'></i>
                          <span class="nav__text">Signup</span>
                      </a>                 
                  </ul>
              </div>
          </nav>
      </div>
    
    <form>
    
    <div class="login-box">
        <h2>Welcome to Voting System</h2>
        <p>Please choose how you want to login</p>
        <a href="Adminlogin.php"><input type="button"  class="button" value="Admin Login" /></a>     
        <a href="Userlogin.php"><input type="button"  class="button" value="User Login" /></a>
    
    </form>
    
    </body>
    <script src="assets/js/main.js"></script>
</html>