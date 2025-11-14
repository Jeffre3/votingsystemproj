<?php
include "connect.php";
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
                        <a href="it.php" class="nav__link <?php echo ($current_page == 'it') ? 'active' : ''; ?>">
                            <i class='bx bx-user nav__icon'></i>
                            <span class="nav__text">Candidates</span>
                        </a>
                        <a href="it.php" class="nav__link <?php echo ($current_page == 'notification') ? 'active' : ''; ?>">
                            <i class='bx bx-bell nav__icon'></i>
                            <span class="nav__text">Vote</span>
                        </a>
                        <a href="#about-us" class="nav__link <?php echo ($current_page == 'about') ? 'active' : ''; ?>">
                            <i class='bx bx-heart nav__icon'></i>
                            <span class="nav__text">About</span>
                        </a>
                        <a href="LR.php" class="nav__link <?php echo ($current_page == 'lr.php') ? 'active' : ''; ?>">
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

        <div class="wrapper_yellow">
            <h1 class="Title">Privacy Policy<hr class="custom-hr3"></h1>
        </div>

<div class="wrapper_gray">
    <section class="columns">
        <div class="column">
            <h2>1. Information We Collect</h2>
            <p>When you use the Website, we may collect personal information that can identify you directly or indirectly, such as: <br> Name 
            <br> Email Address <br> Login Credentials</p>
        </div>
        
        <div class="column">
            <h2>2. How We Use Your Information</h2>
            <p>We use the information collected for various purposes, including but not limited to:<br><br>

Providing and managing the voting system.<br>
Ensuring the accuracy and integrity of votes cast.<br>
Verifying user identity to prevent unauthorized access or fraudulent voting.<br>
Improving the Website's functionality and user experience.<br>
Complying with legal obligations and resolving disputes.</p>
        </div>
      
      <div class="column">
            <h2>3. How We Protect Your Information</h2>
            <p>We implement robust security measures to ensure your personal data is protected, including:<br><br>

Encryption: All sensitive data, including login credentials, is encrypted.<br>
Secure Storage: Data is stored in secure servers with limited access.<br>
Regular Audits: We periodically review our security practices and update them as needed.<br>
Access Control: Only authorized personnel have access to user information.</p>
        </div>

       <div class="column">
            <h2>4. Disclosure of Your Information</h2>
            <p>We do not sell, rent, or share your personal information with third parties except as outlined below:<br><br>

Service Providers: We may share your data with trusted third-party service providers who assist in operating the Website or providing related services (e.g., hosting providers).<br>
Legal Compliance: We may disclose information when required by law, court order, or other legal processes.<br>
Protection of Rights: We may share your information if it is necessary to protect our rights, users, or the public.<br>
With Your Consent: We may share your information if you explicitly authorize us to do so.</p>
        </div>

        <div class="column">
            <h2>5. Data Retention</h2>
            <p>We retain your information only for as long as necessary to fulfill the purposes outlined in this Privacy Policy or as required by law. Once your data is no longer needed, we securely delete or anonymize it.</p>
        </div>
        
    </section>	

    <footer id="footer">
        <nav class="footer-container container">
            <ul class="footer-links">
                <li class="footer-item"><a class="footer-link" href="/privacy">Privacy Policy</a></li>
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
