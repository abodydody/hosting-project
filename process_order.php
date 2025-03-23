<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "kras_hosting");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate a unique order number
function generateOrderNumber() {
    return 'ORDER-' . date('Ymd') . '-' . rand(1000, 9999);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $package_id = $_POST['pakket-id'];
    $first_name = $_POST['voornaam'];
    $last_name = $_POST['achternaam'];
    $email = $_POST['email'];
    $phone = $_POST['telefoon'];
    $company_name = $_POST['bedrijfsnaam'] ?? null;
    $domain = $_POST['domein'];
    $payment_method = $_POST['payment-method'];
    
    // Generate unique order number
    $order_number = generateOrderNumber();
    
    // Insert order into database
    $stmt = $conn->prepare("INSERT INTO orders (order_number, package_id, first_name, last_name, email, phone, company_name, domain, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("sisssssss", $order_number, $package_id, $first_name, $last_name, $email, $phone, $company_name, $domain, $payment_method);
    
    if ($stmt->execute()) {
        // Redirect to thank you page with order details
        $redirect_url = "bedankt.html?order=" . $order_number . "&pakket-id=" . $package_id . "&domein=" . urlencode($domain) . "&payment-method=" . $payment_method;
        header("Location: " . $redirect_url);
        exit;
    } else {
        // Error handling
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    // If not submitted properly, redirect to order page
    header("Location: bestellen.html");
    exit;
}

$conn->close();
?>