<?php
require_once("Connection.php");
session_start();

function getContent($conn, $section) {
    $stmt = $conn->prepare("SELECT title, content FROM site_content WHERE section_name = ?");
    $stmt->bind_param("s", $section);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) return $row;
    return ['title'=> $section, 'content'=>'Content loading...']; 
}

$hero = getContent($conn, 'Hero');
$about = getContent($conn, 'About');
$footer = getContent($conn, 'Footer');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TechPulse | The Future of Tech</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body>
    <header id="home">
        <h1>TechPulse<span style="color:var(--primary-accent)">.</span></h1>
    </header>

    <nav>
        <a href="#home">Latest News</a>
        <a href="#reviews">Reviews</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
        <div class="right">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="active">Studio</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php" style="border:1px solid #333;">Subscribe</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">
        <!-- Sidebar - Trending Topics -->
        <div class="sidebar">
            <h3>Trending Now</h3>
            <ul style="padding-left:0;">
                 <li style="color:#fff;">#ArtificialIntelligence</li>
                 <li>#QuantumComputing</li>
                 <li>#VRGaming</li>
                 <li>#CyberSecurity</li>
                 <li>#GreenTech</li>
            </ul>
            
            <div style="background:#222; padding:15px; border-radius:8px; margin-top:30px;">
                <h4 style="color:var(--text-main); margin-bottom:10px;">Newsletter</h4>
                <p style="font-size:0.85rem; color:var(--text-muted);">Get the daily digest.</p>
                <input type="text" placeholder="Email" style="margin-bottom:10px; margin-top:10px;">
                <button style="font-size:0.8rem; padding:8px;">Subscribe</button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <!-- Hero Section -->
            <section id="hero">
                <h2><?php echo $hero['title']; ?></h2>
                <p><?php echo $hero['content']; ?></p>
                <a href="register.php" class="cta-button">Read Full Story</a>
            </section>

            <!-- Reviews Grid (Static for Demo, could be dynamic) -->
            <section id="reviews">
                <h2>Latest Reviews</h2>
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:20px;">
                    <div class="dash-card" style="width:100%;">
                        <h3>RTX 5090 Preview</h3>
                        <p style="color:var(--text-muted); font-size:0.9rem;">Is the power consumption worth the performance leap?</p>
                        <a href="#" style="color:var(--primary-accent); display:block; margin-top:15px; text-decoration:none;">Read More &rarr;</a>
                    </div>
                    <div class="dash-card" style="width:100%;">
                        <h3>Vision Pro 2</h3>
                        <p style="color:var(--text-muted); font-size:0.9rem;">Lighter, cheaper, and finally mainstream ready.</p>
                        <a href="#" style="color:var(--primary-accent); display:block; margin-top:15px; text-decoration:none;">Read More &rarr;</a>
                    </div>
                </div>
            </section>

            <!-- About Section -->
            <section id="about">
                <h2><?php echo $about['title']; ?></h2>
                <p style="color:var(--text-muted);"><?php echo $about['content']; ?></p>
            </section>

            <!-- Contact Form -->
            <section id="contact">
                <h2>Contact Editorial</h2>
                <?php
                    if (isset($_POST['send_msg'])) {
                        $name = $_POST['name'];
                        $email = $_POST['email'];
                        $msg = $_POST['message'];
                        
                        $stmt = $conn->prepare("INSERT INTO messages (sender_name, sender_email, message) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $name, $email, $msg);
                        if ($stmt->execute()) echo "<p class='success'>Inquiry Received.</p>";
                        else echo "<p class='error'>Transmission Failed.</p>";
                        $stmt->close();
                    }
                ?>
                <form action="index.php#contact" method="post">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" name="send_msg">Send Inquiry</button>
                </form>
            </section>
        </div>
    </div>

    <footer>
        <p><?php echo $footer['content']; ?></p>
        <p>&copy; 2026 TechPulse Media Group.</p>
    </footer>
</body>
</html>
