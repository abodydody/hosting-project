<?php
session_start();
$conn = new mysqli("localhost", "root", "", "kras_hosting");

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $confirm_password = $_POST['confirm_password'];
    
    // Check if passwords match
    if ($_POST['password'] !== $confirm_password) {
        $message = "Wachtwoorden komen niet overeen.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);

        if ($stmt->execute()) {
            $message = "Registratie succesvol! U kunt nu <a href='login.php'>inloggen</a>.";
            $message_type = "success";
        } else {
            $message = "E-mailadres bestaat al of er is een fout opgetreden.";
            $message_type = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren - KRAS HOSTING</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .register-container {
            max-width: 500px;
            margin: 50px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
        }
        
        .register-container h2 {
            color: #5a2ca0;
            font-size: 28px;
            margin-bottom: 20px;
        }
        
        .register-container .message {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 4px;
            font-weight: bold;
            display: none;
        }
        
        .register-container .message:not(:empty) {
            display: block;
        }
        
        .message.error {
            color: #ED5E4B;
            background-color: rgba(237, 94, 75, 0.1);
        }
        
        .message.success {
            color: #4CAF50;
            background-color: rgba(76, 175, 80, 0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            border-color: #5a2ca0;
            outline: none;
            box-shadow: 0 0 0 2px rgba(90, 44, 160, 0.2);
        }
        
        .register-button {
            background-color: #5a2ca0;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
            font-weight: bold;
            margin-top: 10px;
        }
        
        .register-button:hover {
            background-color: #4a1a90;
        }
        
        .toggle {
            margin-top: 20px;
            color: #666;
        }
        
        .toggle a {
            color: #5a2ca0;
            text-decoration: none;
            font-weight: bold;
        }
        
        .toggle a:hover {
            color: #ED5E4B;
            text-decoration: underline;
        }
        
        .password-requirements {
            margin-top: 15px;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .password-requirements h4 {
            color: #5a2ca0;
            margin-top: 0;
            margin-bottom: 10px;
        }
        
        .password-requirements ul {
            list-style-type: none;
            padding-left: 0;
            margin: 0;
        }
        
        .password-requirements li {
            margin-bottom: 5px;
            padding-left: 20px;
            position: relative;
            background: none;
        }
        
        .password-requirements li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #4CAF50;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo-container img {
            height: 60px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
               <a href="index.html"> <img src="logo.png" alt="Logo"></a>
            </div>
            <div class="nav-container">
                <ul>
                    <li><a href="index.html">HOME</a></li>
                    <li><a href="about.html">ABOUT</a></li>
                    <li><a href="product.html">PRODUCTS</a></li>
                    <li><a href="contact.html">CONTACTS</a></li>
                    <li>
                        <a href="dashboard.php" class="active">DASHBOARD</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="register-container">
        <div class="logo-container">
            <img src="logo.png" alt="KRAS Hosting Logo" onerror="this.src='data:image/svg+xml;charset=utf-8,%3Csvg xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22 width%3D%22120%22 height%3D%2260%22 viewBox%3D%220 0 120 60%22%3E%3Crect width%3D%22120%22 height%3D%2260%22 fill%3D%22%235a2ca0%22%2F%3E%3Ctext x%3D%2260%22 y%3D%2235%22 font-family%3D%22Arial%22 font-size%3D%2220%22 text-anchor%3D%22middle%22 fill%3D%22%23fff%22%3EKRAS%3C%2Ftext%3E%3C%2Fsvg%3E'">
        </div>
        
        <h2>Registreren</h2>
        
        <div class="message <?php echo isset($message_type) ? $message_type : 'error'; ?>">
            <?php echo $message; ?>
        </div>
        
        <form method="POST" id="register-form">
            <div class="form-group">
                <label for="email">E-mailadres</label>
                <input type="email" id="email" name="email" placeholder="Uw e-mailadres" required>
            </div>
            
            <div class="form-group">
                <label for="password">Wachtwoord</label>
                <input type="password" id="password" name="password" placeholder="Kies een wachtwoord" required minlength="8">
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Bevestig wachtwoord</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Bevestig uw wachtwoord" required minlength="8">
            </div>
            
            <div class="password-requirements">
                <h4>Wachtwoord moet voldoen aan:</h4>
                <ul>
                    <li>Minimaal 8 tekens lang</li>
                    <li>Minimaal één hoofdletter</li>
                    <li>Minimaal één cijfer</li>
                    <li>Minimaal één speciaal teken</li>
                </ul>
            </div>
            
            <button type="submit" class="register-button">Registreren</button>
        </form>
        
        <p class="toggle">Al een account? <a href="login.php">Log in</a></p>
    </div>
    
    <footer>
        <p>&copy; 2025 KRAS HOSTING. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('register-form');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            
            form.addEventListener('submit', function(event) {
                if (password.value !== confirmPassword.value) {
                    event.preventDefault();
                    alert('Wachtwoorden komen niet overeen. Probeer het opnieuw.');
                }
            });
        });
    </script>
</body>
</html>