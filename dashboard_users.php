<?php
require_once("Connection.php");
require_once("auth_check.php");

check_admin();

// Delete Logic
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: dashboard_users.php");
    exit();
}

$result = $conn->query("SELECT * FROM users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Access - TechPulse</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Access Control</h1>
    </header>

    <nav>
        <a href="dashboard.php">Back to Studio</a>
        <a href="dashboard_users.php" class="active">Members</a>
        <div class="right">
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="content">
            <h2>Registered Accounts</h2>
            <div style="margin-bottom:20px;">
                <input type="text" placeholder="Search by username..." style="max-width:300px; padding:8px; display:inline-block; margin-bottom:0;">
                <button style="width:auto; padding:8px 15px; display:inline-block;">Filter</button>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Command</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:30px; height:30px; border-radius:50%; background:url('uploads/<?php echo $row['image']; ?>') center/cover; background-color:#333;"></div>
                                <?php echo $row['username']; ?>
                            </div>
                        </td>
                        <td><?php echo $row['email']; ?></td>
                        <td><span style="color:<?php echo ($row['user_type']=='Admin')?'var(--primary-accent)':'var(--text-muted)'; ?>"><?php echo $row['user_type']; ?></span></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo date('M d', strtotime($row['created_at'])); ?></td>
                        <td>
                            <a href="register.php?edit=<?php echo $row['id']; ?>" class="action-btn edit-btn">Mod</a>
                            <a href="dashboard_users.php?delete=<?php echo $row['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Revoke Access?')">Revoke</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
