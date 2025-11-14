<?php
include 'connect.php';  // Ensure that database connection is established

session_start(); // Start the session to track the user's login status

// Initialize error message as an empty string
$error_message = "";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username exists in the database
    $sql = "SELECT * FROM accounts WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);  // Bind parameters to prevent SQL injection
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, fetch data
        $row = $result->fetch_assoc();

        // Directly compare the entered password with the one stored in the database
        if ($password == $row['password']) {
            // Password is correct, start session and store username
            $_SESSION['username'] = $username;
            header("Location: it.php"); // Redirect to home page after successful login
            exit();
        } else {
            // Password is incorrect
            $error_message = "Invalid password";
        }
    } else {
        // User not found in database
        $error_message = "No user found with this username";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="assets/css/login.css"> <!-- Your CSS -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet">
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

    <form method="POST">
        <h2>User Login</h2>

        <!-- Displaying login feedback -->
        <?php
        if (!empty($error_message)) {
            echo '<p style="color: red; text-align: center;">' . $error_message . '</p>';
        }
        ?>

        <input type="text" name="username" class="text-field" placeholder="Username" required />
        <input type="password" name="password" class="text-field" placeholder="Password" required />

        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: #666;">
            Don't have an account? 
            <a href="register.php" style="color: #007BFF; text-decoration: none; font-weight: bold;">
                Register Now
            </a>
        </p>

        <input type="submit" class="button" value="Log In" />
    </form>
</body>

<script src="assets/js/main.js"></script>
</html>
        