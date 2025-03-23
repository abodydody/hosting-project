<?php
// This file should be included in dashboard.php for the news management functionality

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Update news content
if (isset($_POST['update_news'])) {
    $vandaag_title = $_POST['vandaag_title'];
    $vandaag_text = $_POST['vandaag_text'];
    $gisteren_title = $_POST['gisteren_title'];
    $gisteren_text = $_POST['gisteren_text'];
    $vandaag_date = date('Y-m-d'); // Today's date
    $gisteren_date = date('Y-m-d', strtotime('-1 day')); // Yesterday's date
    
    // Update today's news
    $stmt = $conn->prepare("UPDATE news SET title = ?, content = ?, date = ? WHERE display_location = 'today'");
    $stmt->bind_param("sss", $vandaag_title, $vandaag_text, $vandaag_date);
    $stmt->execute();
    
    // Update yesterday's news
    $stmt = $conn->prepare("UPDATE news SET title = ?, content = ?, date = ? WHERE display_location = 'yesterday'");
    $stmt->bind_param("sss", $gisteren_title, $gisteren_text, $gisteren_date);
    $stmt->execute();
    
    $message = "Nieuwsberichten bijgewerkt!";
    $message_type = "success";
}

// Get current news content
$today_news = ['title' => 'Vandaag', 'content' => ''];
$yesterday_news = ['title' => 'Gisteren', 'content' => ''];

$result = $conn->query("SELECT * FROM news WHERE display_location = 'today'");
if ($result->num_rows > 0) {
    $today_news = $result->fetch_assoc();
}

$result = $conn->query("SELECT * FROM news WHERE display_location = 'yesterday'");
if ($result->num_rows > 0) {
    $yesterday_news = $result->fetch_assoc();
}
?>

<!-- News Management HTML (to be included in dashboard.php) -->
<div id="news" class="tab-content" <?php echo isset($_GET['tab']) && $_GET['tab'] == 'news' ? 'style="display:block;"' : ''; ?>>
    <h2>Nieuwsberichten Beheren</h2>
    <form method="POST" action="?tab=news">
        <div class="form-group">
            <label for="vandaag_title">Vandaag titel:</label>
            <input type="text" id="vandaag_title" name="vandaag_title" value="<?php echo htmlspecialchars($today_news['title']); ?>">
        </div>
        
        <div class="form-group">
            <label for="vandaag_text">Vandaag tekst:</label>
            <textarea id="vandaag_text" name="vandaag_text"><?php echo htmlspecialchars($today_news['content']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="gisteren_title">Gisteren titel:</label>
            <input type="text" id="gisteren_title" name="gisteren_title" value="<?php echo htmlspecialchars($yesterday_news['title']); ?>">
        </div>
        
        <div class="form-group">
            <label for="gisteren_text">Gisteren tekst:</label>
            <textarea id="gisteren_text" name="gisteren_text"><?php echo htmlspecialchars($yesterday_news['content']); ?></textarea>
        </div>
        
        <button type="submit" name="update_news" class="bestel-btn">Opslaan</button>
    </form>
</div>