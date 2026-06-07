<!DOCTYPE html>
<html>
<head>
    <title>Login - Raya</title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css?v=4">
</head>
<body>

<div class="auth-container">

    <!-- LEFT -->
    <div class="auth-left">
        <h2>Welcome Back!</h2>
    </div>

    <!-- RIGHT -->
    <div class="auth-right">
        <h2>Login to Your Account</h2>
        <?php if(isset($_GET['error'])){ ?>
        <p style="color:red;">Email atau password salah!</p>
        <?php } ?>
        <form id="loginForm" action="proses_login.php" method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <button type="submit">SIGN IN</button>
        </form>

        <!-- Login loader overlay -->
        <div id="loginOverlay" class="login-overlay" aria-hidden="true">
            <div class="login-progress"><span></span></div>
        </div>

        <p>Don't have an account? <a href="choose_role.php">Sign Up</a></p>
    </div>

</div>

    <script>
    document.getElementById('loginForm').addEventListener('submit', function(e){
        // show animated loader then submit
        e.preventDefault();
        var overlay = document.getElementById('loginOverlay');
        // restart animation by reflow
        overlay.classList.add('active');
        var span = overlay.querySelector('span');
        span.style.width = '0%';
        // force reflow
        void span.offsetWidth;
        // add animation by setting animation property (re-run)
        span.style.animation = 'none';
        void span.offsetWidth;
        span.style.animation = null;

        setTimeout(function(){
            e.target.submit();
        }, 1400);
    });
    </script>

</body>
</html>
