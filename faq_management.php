<?php
// This file should be included in dashboard.php for the FAQ management functionality

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Process FAQ updates
if (isset($_POST['update_faq'])) {
    // Update existing FAQs
    $faq_ids = $_POST['faq_ids'] ?? [];
    $faq_questions = $_POST['faq_questions'] ?? [];
    $faq_answers = $_POST['faq_answers'] ?? [];
    
    for ($i = 0; $i < count($faq_ids); $i++) {
        $stmt = $conn->prepare("UPDATE faq SET question = ?, answer = ? WHERE id = ?");
        $stmt->bind_param("ssi", $faq_questions[$i], $faq_answers[$i], $faq_ids[$i]);
        $stmt->execute();
    }
    
    // Add new FAQ if provided
    if (!empty($_POST['new_question']) && !empty($_POST['new_answer'])) {
        $new_question = $_POST['new_question'];
        $new_answer = $_POST['new_answer'];
        
        // Get the highest order number
        $result = $conn->query("SELECT MAX(order_number) as max_order FROM faq");
        $row = $result->fetch_assoc();
        $next_order = ($row['max_order'] ?? 0) + 1;
        
        $stmt = $conn->prepare("INSERT INTO faq (question, answer, order_number) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $new_question, $new_answer, $next_order);
        $stmt->execute();
    }
    
    // Delete FAQs if requested
    if (isset($_POST['delete_faq'])) {
        $delete_ids = $_POST['delete_faq'];
        foreach ($delete_ids as $id) {
            $stmt = $conn->prepare("DELETE FROM faq WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }
    }
    
    $message = "FAQ bijgewerkt!";
    $message_type = "success";
}

// Get all FAQs
$faqs = [];
$result = $conn->query("SELECT * FROM faq ORDER BY order_number ASC");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $faqs[] = $row;
    }
}
?>

<!-- FAQ Management HTML (to be included in dashboard.php) -->
<div id="faq" class="tab-content" <?php echo isset($_GET['tab']) && $_GET['tab'] == 'faq' ? 'style="display:block;"' : ''; ?>>
    <h2>FAQ Beheren</h2>
    
    <form method="POST" action="?tab=faq">
        <div class="faq-list">
            <?php foreach ($faqs as $faq): ?>
                <div class="faq-item">
                    <div class="faq-question">
                        <input type="hidden" name="faq_ids[]" value="<?php