<?php
require_once("Connection.php");
session_start();

$msg = "";

if (isset($_POST['register'])) {
    // Collect Data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass = $_POST['password'];
    $gender = $_POST['gender'];
    $status = $_POST['status'];

    // Auto-Admin Logic
    $check_users = $conn->query("SELECT * FROM users");
    $user_type = ($check_users->num_rows == 0) ? 'Admin' : 'User';

    // Hash Password
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // Image Upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir);
    $image = $_FILES['profile_pic']['name'];
    $target_file = $target_dir . basename($image);
    
    if (empty($fname) || empty($username) || empty($email)) {
        $msg = "<p class='error'>Required fields missing.</p>";
    } else {
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file);
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, phone, password, gender, image, user_type, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $fname, $lname, $username, $email, $phone, $hashed_pass, $gender, $image, $user_type, $status);

        if ($stmt->execute()) {
            $msg = "<p class='success'>Welcome to the Network. <a href='login.php' style='color:#fff;'>Login Now</a></p>";
        } else {
            $msg = "<p class='error'>" . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Join TechPulse</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Join the Network</h1>
    </header>
    <nav>
        <a href="index.php">Back to Site</a>
        <a href="login.php">Login</a>
    </nav>

    <div class="container" style="display:block;">
        <div style="text-align:center; max-width:600px; margin:0 auto;">
            <?php echo $msg; ?>
        </div>

        <form action="register.php" method="post" enctype="multipart/form-data">
            <h2 style="text-align:center; margin-bottom:30px;">Create Profile</h2>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                <div>
                    <label>First Name</label>
                    <input type="text" name="fname" required>
                </div>
                <div>
                    <label>Last Name</label>
                    <input type="text" name="lname" required>
                </div>
            </div>
            
            <label>Username</label>
            <input type="text" name="username" required>
            
            <label>Email Address</label>
            <input type="email" name="email" required>
            
            <label>Phone</label>
            <input type="tel" name="phone" required>
            
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                <div>
                    <label>Gender</label>
                    <select name="gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div>
                    <label>Profile Image</label>
                    <input type="file" name="profile_pic" required style="padding:9px;">
                </div>
            </div>

            <label>Password</label>
            <input type="password" name="password" required>
            
            <div style="margin-bottom:20px;">
                <label style="display:inline-block; margin-right:20px;">Status:</label>
                <input type="radio" name="status" value="Active" checked> <span style="color:#aaa; margin-right:15px;">Active</span>
                <input type="radio" name="status" value="Not Active"> <span style="color:#aaa;">Inactive</span>
            </div>

            <button type="submit" name="register">Create Account</button>
        </form>
    </div>
</body>
</html>
