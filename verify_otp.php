<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $enteredOtp = $_POST["otp_input"];
    $email = $_POST["email"];

    if (
        isset($_SESSION["otp"], $_SESSION["email"], $_SESSION["username"], $_SESSION["password"]) &&
        $_SESSION["email"] === $email &&
        $_SESSION["otp"] == $enteredOtp
    ) {
        // DB connection
        require_once 'db_connect.php';
$conn = Database::getInstance()->getConnection();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $username = $_SESSION["username"];
        $hashedPassword = password_hash($_SESSION["password"], PASSWORD_DEFAULT);

        // Insert into DB
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        session_unset();
        session_destroy();
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<h2 style='color:red; text-align:center;'>Invalid OTP. Try again.</h2>";
        echo "<p style='text-align:center;'><a href='index.php?show=otp&email=$email'>Retry</a></p>";
    }
}
?>
