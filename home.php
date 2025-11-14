<?php
include "connect.php";
$current_page = basename($_SERVER['PHP_SELF'], "home.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- STYLES CSS -->
        <link rel="stylesheet" href="assets/css/home.css">
        <!-- BOX ICONS CSS-->
        <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
        <title>Sidebar menu</title>
    </head>
    <body id="body">
        <div class="l-navbar" id="navbar">
            <nav class="nav">
                <div>
                    <a href="home.php" class="nav__logo">
                        <img src="assets/icons/logo.svg" alt="" class="nav__logo-icon">
                        <span class="nav__logo-text">Voting System TIP Manila CCS Dept</span>
                    </a>
    
                    <div class="nav__toggle" id="nav-toggle">
                        <i class='bx bx-chevron-right'></i>
                    </div>
    
                    <ul class="nav__list">
                        <a href="home.php" class="nav__link <?php echo ($current_page == 'home.php') ? 'active' : ''; ?>">
                            <i class='bx bx-grid-alt nav__icon'></i>
                            <span class="nav__text">Home</span>
                        </a>
                        
                        </a>
                        <a href="#about-us" class="nav__link <?php echo ($current_page == 'about') ? 'active' : ''; ?>">
                            <i class='bx bx-heart nav__icon'></i>
                            <span class="nav__text">About</span>
                        </a>
                        <a href="LR.php" class="nav__link <?php echo ($current_page == 'lr.php') ? 'active' : ''; ?>">
                            <i class='bx bx-log-in nav__icon'></i>
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
        <div class="wrapper">
        
            <h1 class="Title">TIP 2024 Election Guide</h1>
        
            <p class="Learn">Learn about the candidates for the 2024 TIP Election</p>

            
    <section class="columns">
        <div class="column">
            <h2>Voter's Guide<hr class="custom-hr1">
            <section class="color-1">
                <p>
                    <button class="btn btn-1 btn-1a" onclick="window.location.href='it.php'">IT</button>
                    <button class="btn btn-1 btn-1b" onclick="window.location.href='is.php'">IS</button>
                </p>
                <p>
                    <button class="btn btn-1 btn-1c" onclick="window.location.href='cs.php'">CS</button>
                    <button class="btn btn-1 btn-1d" onclick="window.location.href='emc.php'">EMC</button>
                </p>
            </section>
        </div>

    </section>  
    </div>

    <div class="wrapper_gray">
        
            <h1 class="Title">How to Vote<hr class="custom-hr2"></h1>
        

    <section class="columns">
        <div class="column">
            <h2>Step 1</h2>
            <p>Go to the Vote Webpage by clicking the button below</p>
        </div>
        
        <div class="column">
            <h2>Step 2</h2>
            <p>Fill up the Voter Information form</p>
        </div>
      
      <div class="column">
            <h2>Step 3</h2>
            <p>Choose your candidates</p>
        </div>

       <div class="column">
            <h2>Step 4</h2>
            <p>After you're done filling up the form, click the "Submit" button.</p>
        </div>
        
    </section>  
    
    <div class="wrapper">         
    <section class="columns">
        <button class="btn btn-1 btn-1a" onclick="window.location.href='LR.php'">Login to Vote</button>
        <button class="btn btn-1 btn-1b" onclick="window.location.href='register.php'">Sign Up to Vote</button>

    </section>  
    </div>


    </div>

    <div class="wrapper_yellow">
    
            <h1 class="Title">Secure & Trustworthy<hr class="custom-hr3"></h1>
        

    <section class="columns">
        <div class="column">
            <h2>Secure</h2>
            <img src="https://cdn-icons-png.flaticon.com/512/30/30367.png">
            <p>Our voting pages are secured with encryption, ensuring that your voters can cast their ballots with full privacy and security.</p>
        </div>
        
        <div class="column">
            <h2>Anonymous</h2>
            <img src="https://uxwing.com/wp-content/themes/uxwing/download/peoples-avatars/anonymous-user-icon.png">
            <p>We provide the highest assurance of voter anonymity by not tracking individual choices; we only record who votes and the outcome of the vote.</p>
        </div>
      
      <div class="column">
            <h2>Private</h2>
            <img src="https://cdn-icons-png.flaticon.com/512/876/876820.png">
            <p>We do not utilize or disclose your voters' email addresses for any reasons beyond the scope of your election.</p>
        </div>
        
    </section>  
    
    </div>

    <div class="wrapper">
    
            <div class="wrapper" id="about-us">
                <h1 class="Title">About Us<hr class="custom-hr2"></h1>
                <section class="columns">
                    <div class="column">
                        <p>We are a group of dedicated students and faculty members who believe in the importance of student voice and representation. 
                            As part of our commitment to fostering a vibrant school community, we have developed this online voting system to modernize the election process at 
                            TIP.</p>
                    </div>
                </section>    
            </div>
    
    </div>

    <footer id="footer">
        <nav class="footer-container container">
            <ul class="footer-links">
                <li class="footer-item"><a class="footer-link" href="privacy.php">Privacy Policy</a></li>
                <li class="footer-item"><a class="footer-link" href="/terms">Terms of Service</a></li>
                <li class="footer-item"><a class="footer-link" href="/contact">Contact</a></li>
            </ul>
        </nav>
        <div class="footer-info">
            <p>&copy; 2024 VotingIna Mo. All rights reserved.</p>
        </div>
    </footer>
    </body>
    <!-- MAIN JS -->
    <script src="assets/js/main.js"></script>
</html>
