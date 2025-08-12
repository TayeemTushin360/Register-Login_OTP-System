<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register&Login_OTP</title>
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <div class="form-box login">
                <form action="login.php" method="POST">
                    <h1>Login</h1>
                    <div class="input-box">
                        <input type="text" name="username" placeholder="Username" required>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" placeholder="Password" required>
                        <i class="bx bx-lock"></i>
                    </div>
                    <div class="forgot-link">
                        <a href="#">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn">Login</button>
                </form>
            </div>

            <div class="form-box register">
                <form action="send_otp.php" method="POST">
                    <h1>Registration</h1>
                    <div class="input-box">
                        <input type="text" name="username" placeholder="Username" required>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="email" name="email" placeholder="E-mail" required>
                        <i class="bx bx-envelope"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" placeholder="Password" required>
                        <i class="bx bx-lock"></i>
                    </div>
                    <button type="submit" class="btn">Sign Up</button>
                </form>
            </div>
            <!-- OTP Verification Form -->
<div class="form-box otp-box">
    <form action="verify_otp.php" method="POST">
        <h1>OTP Verification</h1>
        <p>Please enter the OTP sent to your email</p>
        <div class="input-box">
            <input type="text" name="otp_input" placeholder="Enter OTP" required>
        </div>
        <input type="hidden" name="email" value="<?php echo $_GET['email'] ?? ''; ?>">
        <button type="submit" class="btn">Verify OTP</button>
    </form>
</div>


            <div class="toggle-box">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome!</h1>
                    <p>Don't have an account?</p>
                    <button class="btn register-btn">Register</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Welcome Back!</h1>
                    <p>Already have an account?</p>
                    <button class="btn login-btn">Login</button>
                </div>
            </div>
        </div>

        <script src="script.js"></script>
        <?php
if (isset($_GET['show']) && $_GET['show'] === 'otp') {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.container').classList.add('otp-active');
        });
    </script>";
}
?>

   </body>
</html>