<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

require_once 'db_connect.php';
$conn = Database::getInstance()->getConnection();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION["user"];
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(90deg, #e2e2e2, #982dea);
            margin: 0;
            padding: 0;
            color: #333;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #982dea;
            padding: 10px 20px;
            color: white;
        }

        .profile-icon {
            font-size: 28px;
            cursor: pointer;
        }

        .logout-btn {
            background: #fff;
            color: #982dea;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 99;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
        }

        .modal-content {
    background: white;
    width: 90%;
    max-width: 400px;
    max-height: 80vh;
    overflow-y: auto;
    margin: 100px auto;
    padding: 30px;
    border-radius: 15px;
    position: relative;
    overflow: hidden;
    box-sizing: border-box;
}

.modal-content {
    background: white;
    width: 90%;
    max-width: 400px;
    max-height: 80vh;            
    overflow-y: auto;            
    margin: 100px auto;
    padding: 30px;
    border-radius: 15px;         
    position: relative;
    box-sizing: border-box;      
}

.features-row {
    display: flex;
    justify-content: space-around;
    gap: 20px;
    margin: 50px auto;
    max-width: 1000px;
    flex-wrap: wrap;
}

.feature-card {
    background: white;
    padding: 30px;
    border-radius: 20px;
    width: 280px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 25px rgba(152, 45, 234, 0.3);
}

.feature-card img {
    width: 80px;
    height: 80px;
    margin-bottom: 15px;
}

.feature-card h3 {
    color: #982dea;
    margin-bottom: 10px;
}

.feature-card p {
    font-size: 14px;
    color: #444;
}



.modal button:hover {
    background: #7d1ac6;
}


        .modal h2 {
            margin-bottom: 20px;
        }

        .modal label {
            font-weight: 600;
            display: block;
            margin-top: 15px;
        }

        .modal input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .modal button {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background: #982dea;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 22px;
            cursor: pointer;
        }

        .profile-pic {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 2px solid #982dea;
        }
    </style>
</head>
<body>

    <!-- Top bar -->
    <div class="top-bar">
        <i class='bx bx-user-circle profile-icon' id="profileIcon"></i>
        <h1 class="top-title">Register&Login_OTP</h1>
        <form action="logout.php" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal" id="profileModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Your Profile</h2>

            <!-- Profile Picture -->
            <?php if ($user['profile_pic']): ?>
                <img src="uploads/<?php echo $user['profile_pic']; ?>" class="profile-pic">
            <?php endif; ?>

            <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                <label>Name</label>
                <input type="text" name="username" value="<?php echo $user['username']; ?>" readonly>

                <label>Email</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" readonly>

                <label>Phone Number</label>
                <input type="text" name="phone" value="<?php echo $user['phone']; ?>">

                <label>Present Address</label>
                <input type="text" name="present_address" value="<?php echo $user['present_address']; ?>">

                <label>Work Address</label>
                <input type="text" name="work_address" value="<?php echo $user['work_address']; ?>">

                <label>Profile Picture</label>
                <input type="file" name="profile_pic">

                <button type="submit">Save Profile</button>
                

            </form>
        </div>
    </div>
    

</div>


    <script>
        const modal = document.getElementById("profileModal");
        const profileIcon = document.getElementById("profileIcon");

        profileIcon.addEventListener("click", () => {
            modal.style.display = "block";
        });

        function closeModal() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>

</body>
</html>


