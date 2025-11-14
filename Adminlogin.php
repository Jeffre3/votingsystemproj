<?php
// Get the current page name
$current_page = basename($_SERVER['PHP_SELF'], ".php");

// Hardcoded admin credentials (username: carlo, password: carlo123)
define('ADMIN_USERNAME', 'carlo');
define('ADMIN_PASSWORD', 'carlo123');

$loginMessage = ""; // Variable to store login message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the credentials match the hardcoded admin values
    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        // Admin login successful - Redirect to admin folder
        header("Location: Admin/index.php");
        exit(); // Ensure no further code is executed after redirect
    } else {
        // Invalid credentials message
        $loginMessage = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- STYLES CSS -->
    <link rel="stylesheet" href="assets/css/login.css">
    <!-- BOX ICONS CSS -->
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
                    <a href="LR.php" class="nav__link <?php echo ($current_page == 'Adminlogin') ? 'active' : ''; ?>">
                        <i class='bx bx-bookmark nav__icon'></i>
                        <span class="nav__text">Login</span>
                    </a>
                    <a href="signup.php" class="nav__link <?php echo ($current_page == 'signup') ? 'active' : ''; ?>">
                        <i class='bx bx-message-rounded nav__icon'></i>
                        <span class="nav__text">Signup</span>
                    </a>
                </ul>
            </div>
        </nav>
    </div>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <h2>Admin Login</h2>
        <input type="text" name="username" class="text-field" placeholder="Username" required />
        <input type="password" name="password" class="text-field" placeholder="Password" required />
        <button type="submit" class="button">Log In</button>
        <?php if ($loginMessage): ?>
            <p style="color: red;"><?php echo $loginMessage; ?></p>
        <?php endif; ?>
    </form>

    <script src="assets/js/main.js"></script>
</body>
</html>
