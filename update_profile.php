<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["user"])) {
   require_once 'db_connect.php';
$conn = Database::getInstance()->getConnection();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_SESSION["user"];
    $phone = $_POST["phone"];
    $present = $_POST["present_address"];
    $work = $_POST["work_address"];

    // Handle file upload
    $filename = null;
    if (!empty($_FILES['profile_pic']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir);
        $filename = uniqid() . "_" . basename($_FILES["profile_pic"]["name"]);
        $targetFile = $targetDir . $filename;

        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFile);
    }

    // Update with or without photo
    if ($filename) {
        $stmt = $conn->prepare("UPDATE users SET phone=?, present_address=?, work_address=?, profile_pic=? WHERE username=?");
        $stmt->bind_param("sssss", $phone, $present, $work, $filename, $username);
    } else {
        $stmt = $conn->prepare("UPDATE users SET phone=?, present_address=?, work_address=? WHERE username=?");
        $stmt->bind_param("ssss", $phone, $present, $work, $username);
    }

    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: dashboard.php");
    exit();
}
?>

