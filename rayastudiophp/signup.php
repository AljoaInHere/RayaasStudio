<?php
$role = $_GET['role'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up - Raya</title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css?v=3">
</head>
<body>

<div class="auth-container">

    <!-- LEFT -->
    <div class="auth-left">
        <h2>Create Your Account Right Now!</h2>
    </div>

    <!-- RIGHT -->
    <div class="auth-right">
        <h2>Welcome to Raya Studio</h2>

        <form action="proses_signup.php" method="POST">
            <input type="hidden" name="role" value="<?= $role ?>">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm" placeholder="Confirm Password" required>

            <button type="submit">Sign Up</button>

        </form>

        <p>Already have an account? <a href="login.php">Sign In</a></p>
    </div>

</div>

<?php if (isset($_GET['success'])) { ?>
<div class="popup">
    <div class="popup-box">
        <h2>Sign Up Successful!</h2>
        <p>Your account has been created</p>
        <a href="login.php" class="popup-btn">Go to Login</a>
    </div>
</div>
<?php } ?>

</body>
</html>
