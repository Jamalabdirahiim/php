<?php
require_once("Connection.php");
session_start();

// Cookie Check
if (isset($_COOKIE['tp_user']) && !isset($_SESSION['user_id'])) {
    $user = $_COOKIE['tp_user'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
         $_SESSION['user_id'] = $row['id'];
         $_SESSION['username'] = $row['username'];
         $_SESSION['user_type'] = $row['user_type'];
         $_SESSION['last_activity'] = time();
         header("Location: dashboard.php");
         exit();
    }
}

$msg = "";

if (isset($_POST['login'])) {
    $u = $_POST['username'];
    $p = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $u);
    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($row = $res->fetch_assoc()) {
        if (password_verify($p, $row['password'])) {
            if ($row['status'] == 'Not Active') {
                $msg = "<p class='error'>Account Deactivated.</p>";
            } else {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_type'] = $row['user_type'];
                $_SESSION['last_activity'] = time();

                if (isset($_POST['remember'])) {
                    setcookie('tp_user', $u, time() + (86400 * 30), "/");
                }

                header("Location: dashboard.php");
                exit();
            }
        } else {
            $msg = "<p class='error'>Incorrect Credential.</p>";
        }
    } else {
        $msg = "<p class='error'>User not found.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - TechPulse</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Access Terminal</h1>
    </header>
    <nav>
        <a href="index.php">Main Site</a>
        <a href="register.php">Join</a>
    </nav>

    <div class="container" style="display:block;">
        <div style="text-align:center; max-width:400px; margin:0 auto;">
            <?php 
                if(isset($_GET['timeout'])) echo "<p class='error'>Session Timeout.</p>";
                echo $msg; 
            ?>
            <form action="login.php" method="post" style="margin-top:20px;">
                <h2 style="text-align:center;">Editor Login</h2>
                
                <label>Username</label>
                <input type="text" name="username" required>
                
                <label>Password</label>
                <input type="password" name="password" required>
                
                <div style="margin-bottom:20px;">
                    <input type="checkbox" name="remember"> <span style="color:var(--text-muted);">Keep me logged in</span>
                </div>
                
                <button type="submit" name="login">Authenticate</button>
                <p style="margin-top:20px; font-size:0.9rem;"><a href="#" style="color:var(--primary-accent);">Reset Password</a></p>
            </form>
        </div>
    </div>
</body>
</html>
