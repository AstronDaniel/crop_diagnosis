<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">
    <title>Farmer's Gateway</title>
</head>

<body>
    <?php include_once "../includes/header.php"; ?>
    <div class="container login">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['errors'])): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php 
                    foreach($_SESSION['errors'] as $error) {
                        echo "<li>$error</li>";
                    }
                    unset($_SESSION['errors']);
                    ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="welcome-section">
            <h1>Farmers' Network</h1>
            <p>Connect, Grow, and Thrive. Your agricultural journey starts here.</p>
        </div>
        <div class="form-section">
            <div class="toggle-forms">
                <button class="toggle-btn active" data-form="login">Login</button>
                <button class="toggle-btn" data-form="signup">Sign Up</button>
            </div>

            <div id="login" class="form-content active">
                <form method="post" action="../handlers/login_handler.php">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" class="submit-btn">Access Your Farm Portal</button>
                </form>
            </div>

            <div id="signup" class="form-content">
                <form method="post" action="../handlers/register_handler.php">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Create Password" required>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    <button type="submit" class="submit-btn">Join Farmers' Community</button>
                </form>
                <div class="social-login">
                    <div class="social-buttons">
                        <a href="#" class="social-btn">G</a>
                        <a href="#" class="social-btn">f</a>
                        <a href="#" class="social-btn">in</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="../js/login.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>