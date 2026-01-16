<?php
require_once("Connection.php");
require_once("auth_check.php");

check_admin();

if (isset($_POST['update_content'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    $stmt = $conn->prepare("UPDATE site_content SET title=?, content=? WHERE id=?");
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();
    $msg = "<p class='success'>Live Content Updated.</p>";
}

$result = $conn->query("SELECT * FROM site_content");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CMS - TechPulse</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Content Manager</h1>
    </header>

    <nav>
        <a href="dashboard.php">Back to Studio</a>
        <a href="dashboard_content.php" class="active">CMS</a>
        <div class="right">
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="content">
            <?php if(isset($msg)) echo $msg; ?>
            <h2>Live Sections</h2>
            
            <?php while($row = $result->fetch_assoc()): ?>
                <div style="background:var(--bg-panel); border:1px solid var(--border-color); padding:20px; border-radius:8px; margin-bottom:30px;">
                    <form action="dashboard_content.php" method="post" style="box-shadow:none; padding:0; border:none; background:none; max-width:100%;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                            <h3 style="margin:0; color:var(--primary-accent);"><?php echo $row['section_name']; ?></h3>
                            <span style="font-size:0.8rem; color:var(--text-muted);">Last Updated: <?php echo date('H:i, M d', strtotime($row['updated_at'])); ?></span>
                        </div>

                        <label>Headline</label>
                        <input type="text" name="title" value="<?php echo $row['title']; ?>">
                        
                        <label>Body Text</label>
                        <textarea name="content" rows="4"><?php echo $row['content']; ?></textarea>
                        
                        <button type="submit" name="update_content" style="width:auto; padding:10px 30px;">Publish Changes</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
