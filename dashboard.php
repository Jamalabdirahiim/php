<?php
require_once("Connection.php");
require_once("auth_check.php");

check_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Studio - TechPulse</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Creator Studio</h1>
    </header>

    <nav>
        <a href="index.php">View Live Site</a>
        <a href="dashboard.php" class="active">Overview</a>
        <?php if($_SESSION['user_type'] == 'Admin'): ?>
            <a href="dashboard_users.php">Member Access</a>
            <a href="dashboard_content.php">Content CMS</a>
        <?php endif; ?>
        <div class="right">
            <a href="logout.php" style="color:#ef4444;">Disconnect</a>
        </div>
    </nav>

    <div class="container">
        <!-- Sidebar Navigation within Dashboard? Or just stats. Let's do Stats. -->
        <div class="content">
            <h2 style="border:none;">Hello, <?php echo $_SESSION['username']; ?>.</h2>
            <p style="color:var(--text-muted); margin-bottom:40px;">Access Level: <span style="color:var(--primary-accent); font-weight:bold;"><?php echo $_SESSION['user_type']; ?></span></p>

            <div style="display:flex; flex-wrap:wrap; gap:30px;">
                <div class="dash-card">
                    <h3>My Profile</h3>
                    <p style="color:var(--text-muted); font-size:0.9rem;">Edit personal details and avatar.</p>
                    <a href="#" class="cta-button" style="margin-top:15px; width:100%; text-align:center;">Edit Profile</a>
                </div>

                <?php if($_SESSION['user_type'] == 'Admin'): ?>
                <div class="dash-card">
                    <h3>User Management</h3>
                    <p style="color:var(--text-muted); font-size:0.9rem;">Control access and subscription status.</p>
                    <a href="dashboard_users.php" class="cta-button" style="margin-top:15px; width:100%; text-align:center; background:var(--secondary-accent);">Manage Users</a>
                </div>

                <div class="dash-card">
                    <h3>Content Manager</h3>
                    <p style="color:var(--text-muted); font-size:0.9rem;">Publish news and update home sections.</p>
                    <a href="dashboard_content.php" class="cta-button" style="margin-top:15px; width:100%; text-align:center; background:#22c55e;">Edit Content</a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Recent Activity Placeholder -->
            <div style="margin-top:60px;">
                <h3>System Status</h3>
                <div style="background:var(--bg-panel); padding:20px; border-radius:8px; border:1px solid var(--border-color);">
                    <p style="color:var(--text-muted);"><span style="color:#10b981;">●</span> All Systems Operational</p>
                    <p style="color:var(--text-muted); margin-top:10px;">Database Connection: <strong>TechPulse_BIT29</strong></p>
                    <p style="color:var(--text-muted); margin-top:10px;">Session ID: <strong><?php echo session_id(); ?></strong></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
