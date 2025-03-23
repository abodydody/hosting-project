<?php
session_start();
$conn = new mysqli("localhost", "root", "", "kras_hosting");

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION['email'] = $email;
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Ongeldige inloggegevens. Probeer het opnieuw.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen - KRAS HOSTING</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-container {
            max-width: 500px;
            margin: 50px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
        }
        
        .login-container h2 {
            color: #5a2ca0;
            font-size: 28px;
            margin-bottom: 20px;
        }
        
        .login-container .message {
            color: #ED5E4B;
            margin-bottom: 20px;
            padding: 10px;
            background-color: rgba(237, 94, 75, 0.1);
            border-radius: 4px;
            font-weight: bold;
            display: none;
        }
        
        .login-container .message:not(:empty) {
            display: block;
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
        
        .login-button {
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
        
        .login-button:hover {
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

    <div class="login-container">
        <div class="logo-container">
            <img src="logo.png" alt="KRAS Hosting Logo" onerror="this.src='data:image/svg+xml;charset=utf-8,%3Csvg xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22 width%3D%22120%22 height%3D%2260%22 viewBox%3D%220 0 120 60%22%3E%3Crect width%3D%22120%22 height%3D%2260%22 fill%3D%22%235a2ca0%22%2F%3E%3Ctext x%3D%2260%22 y%3D%2235%22 font-family%3D%22Arial%22 font-size%3D%2220%22 text-anchor%3D%22middle%22 fill%3D%22%23fff%22%3EKRAS%3C%2Ftext%3E%3C%2Fsvg%3E'">
        </div>
        
        <h2>Inloggen</h2>
        
        <p class="message"><?php echo $message; ?></p>
        
        <form method="POST">
            <div class="form-group">
                <label for="email">E-mailadres</label>
                <input type="email" id="email" name="email" placeholder="Uw e-mailadres" required>
            </div>
            
            <div class="form-group">
                <label for="password">Wachtwoord</label>
                <input type="password" id="password" name="password" placeholder="Uw wachtwoord" required>
            </div>
            
            <button type="submit" class="login-button">Inloggen</button>
        </form>
        
        <p class="toggle">Nog geen account? <a href="register.php">Registreer</a></p>
    </div>
    
    <footer>
        <p>&copy; 2025 KRAS HOSTING. All rights reserved.</p>
    </footer>
</body>
</html>