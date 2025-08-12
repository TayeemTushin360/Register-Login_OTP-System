<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    require_once 'db_connect.php';
$conn = Database::getInstance()->getConnection();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            // ✅ Login success
            $_SESSION["user"] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<h2 style='color:red; text-align:center;'>Incorrect password.</h2>";
        }
    } else {
        echo "<h2 style='color:red; text-align:center;'>User not found.</h2>";
    }

    $stmt->close();
    $conn->close();
}
?>
