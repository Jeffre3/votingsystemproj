<?php
include 'connect.php'; // Ensure your database connection is established here

$current_page = basename($_SERVER['PHP_SELF'], ".php"); // To highlight active page in the navbar

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists in the database
    $sql = "SELECT * FROM accounts WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Username already exists
        echo "Username already taken. Please choose a different username.";
    } else {
        // Hash the password for security

        // Insert the new user into the database
        $insert_sql = "INSERT INTO accounts (username, password) VALUES ('$username', '$password')";
        
        if ($conn->query($insert_sql) === TRUE) {
           
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
                    <a href="home.php" class="nav__link <?php echo ($current_page == 'home') ? 'active' : ''; ?>">
                        <i class='bx bx-grid-alt nav__icon'></i>
                        <span class="nav__text">Home</span>
                    </a>
                    <a href="home.php" class="nav__link <?php echo ($current_page == 'about') ? 'active' : ''; ?>">
                        <i class='bx bx-heart nav__icon'></i>
                        <span class="nav__text">About</span>
                    </a>
                    <a href="LR.php" class="nav__link <?php echo ($current_page == 'Userlogin') ? 'active' : ''; ?>">
                        <i class='bx bx-bookmark nav__icon'></i>
                        <span class="nav__text">Login</span>
                    </a>
                    <a href="register.php" class="nav__link <?php echo ($current_page == 'register') ? 'active' : ''; ?>">
                        <i class='bx bx-message-rounded nav__icon'></i>
                        <span class="nav__text">Signup</span>
                    </a>
                </ul>
            </div>
        </nav>
    </div>

    <!-- Registration Form -->
    <form method="POST">
        <h2>Register</h2>
        <input type="text" name="username" class="text-field" placeholder="Username" required />
        <input type="password" name="password" class="text-field" placeholder="Password" required />
        
        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: #666;">
            Already have an account? 
            <a href="Userlogin.php" style="color: #007BFF; text-decoration: none; font-weight: bold;">
                Login Now
            </a>
        </p>
        
        <input type="submit" class="button" value="Register" />
    </form>

</body>
<script src="assets/js/main.js"></script>
</html>
