<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Connect to database
$conn = new mysqli("localhost", "root", "", "kras_hosting");

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Handle form submissions for updating content
$message = "";
$message_type = "";

// Update homepage news
if (isset($_POST['update_news'])) {
    $vandaag_text = $_POST['vandaag_text'];
    $gisteren_text = $_POST['gisteren_text'];
    
    // In a real application, this would save to a database
    // For now, we'll just show a success message
    $message = "Nieuwsberichten bijgewerkt!";
    $message_type = "success";
}

// Update package information
if (isset($_POST['update_packages'])) {
    $pakket1_prijs = $_POST['pakket1_prijs'];
    $pakket2_prijs = $_POST['pakket2_prijs'];
    $pakket3_prijs = $_POST['pakket3_prijs'];
    $pakket4_prijs = $_POST['pakket4_prijs'];
    
    // In a real application, this would save to a database
    $message = "Pakket informatie bijgewerkt!";
    $message_type = "success";
}

// Handle FAQ updates
if (isset($_POST['update_faq'])) {
    // In a real application, this would save to a database
    $message = "FAQ bijgewerkt!";
    $message_type = "success";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - KRAS HOSTING</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .dashboard-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 20px;
            margin-top: 20px;
            margin-bottom: 40px;
        }
        
        .sidebar {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            height: fit-content;
        }
        
        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar li {
            margin-bottom: 10px;
            background: none;
            padding: 0;
        }
        
        .sidebar a {
            display: block;
            padding: 12px 15px;
            color: #333;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .sidebar a:hover, .sidebar a.active {
            background-color: #5a2ca0;
            color: white;
        }
        
        .content {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            min-height: 500px;
        }
        
        .content h2 {
            color: #5a2ca0;
            margin-top: 0;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus {
            border-color: #5a2ca0;
            outline: none;
            box-shadow: 0 0 0 2px rgba(90, 44, 160, 0.1);
        }
        
        .form-group textarea {
            height: 120px;
            resize: vertical;
            font-family: inherit;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .message {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 25px;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        
        .message:before {
            content: "";
            display: inline-block;
            width: 24px;
            height: 24px;
            margin-right: 10px;
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
        }
        
        .message.success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #4CAF50;
        }
        
        .message.success:before {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%232e7d32'%3E%3Cpath d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z'/%3E%3C/svg%3E");
        }
        
        .message.error {
            background-color: #fbe9e7;
            color: #c62828;
            border-left: 4px solid #F44336;
        }
        
        .message.error:before {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23c62828'%3E%3Cpath d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z'/%3E%3C/svg%3E");
        }
        
        .dashboard-header {
            margin-bottom: 30px;
        }
        
        .dashboard-header h1 {
            color: #5a2ca0;
            margin: 0 0 10px 0;
        }
        
        .dashboard-header p {
            color: #666;
            margin: 0;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }
        
        .stat-card h3 {
            color: #666;
            margin-top: 0;
            font-size: 16px;
        }
        
        .stat-value {
            color: #5a2ca0;
            font-size: 36px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .activity-list {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
        }
        
        .activity-list h3 {
            color: #5a2ca0;
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .activity-list ul {
            list-style-type: none;
            padding: 0;
        }
        
        .activity-list li {
            background: none;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
        }
        
        .activity-list li:last-child {
            border-bottom: none;
        }
        
        .activity-date {
            color: #666;
            font-size: 14px;
        }
        
        .bestel-btn, .dashboard-btn {
            background-color: #5a2ca0;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-weight: bold;
            display: inline-block;
        }
        
        .bestel-btn:hover, .dashboard-btn:hover {
            background-color: #4a1a90;
        }
        
        .secondary-btn {
            background-color: #f0f0f0;
            color: #333;
            border: 1px solid #ddd;
            margin-right: 10px;
        }
        
        .secondary-btn:hover {
            background-color: #e0e0e0;
        }
        
        .faq-item {
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            overflow: hidden;
        }
        
        .faq-question {
            padding: 15px;
            background-color: #f9f9f9;
            border-bottom: 1px solid #e0e0e0;
            font-weight: bold;
        }
        
        .faq-answer {
            padding: 15px;
        }
        
        .add-faq {
            margin-top: 30px;
        }
        
        @media (max-width: 768px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                margin-bottom: 20px;
            }
            
            .form-row {
                flex-direction: column;
                gap: 15px;
            }
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
    
    <main class="container">
        <div class="dashboard-header">
            <h1>Beheerderspaneel</h1>
            <p>Welkom terug, <strong><?php echo $_SESSION['email']; ?></strong>. Beheer hier uw website content.</p>
        </div>
        
        <?php if (!empty($message)): ?>
            <div class="message <?php echo $message_type; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="dashboard-container">
            <div class="sidebar">
                <ul>
                    <li><a href="#" class="tab-link active" data-tab="dashboard">Dashboard</a></li>
                    <li><a href="#" class="tab-link" data-tab="news">Nieuwsberichten</a></li>
                    <li><a href="#" class="tab-link" data-tab="packages">Pakketten</a></li>
                    <li><a href="#" class="tab-link" data-tab="faq">FAQ</a></li>
                    <li><a href="logout.php">Uitloggen</a></li>
                </ul>
            </div>
            
            <div class="content">
                <div id="dashboard" class="tab-content active">
                    <h2>Dashboard Overzicht</h2>
                    
                    <div class="stats-grid">
                        <div class="stat-card">
                            <h3>Totaal Klanten</h3>
                            <div class="stat-value">128</div>
                        </div>
                        <div class="stat-card">
                            <h3>Actieve Websites</h3>
                            <div class="stat-value">243</div>
                        </div>
                        <div class="stat-card">
                            <h3>Nieuwe Orders</h3>
                            <div class="stat-value">17</div>
                        </div>
                        <div class="stat-card">
                            <h3>Server Uptime</h3>
                            <div class="stat-value">99.9%</div>
                        </div>
                    </div>
                    
                    <div class="activity-list">
                        <h3>Recente Activiteiten</h3>
                        <ul>
                            <li>
                                <span>Website gelanceerd</span>
                                <span class="activity-date">23 maart 2025</span>
                            </li>
                            <li>
                                <span>Nieuwe pakketten toegevoegd</span>
                                <span class="activity-date">22 maart 2025</span>
                            </li>
                            <li>
                                <span>FAQ bijgewerkt</span>
                                <span class="activity-date">20 maart 2025</span>
                            </li>
                            <li>
                                <span>Nieuwe server toegevoegd</span>
                                <span class="activity-date">18 maart 2025</span>
                            </li>
                            <li>
                                <span>Beveiligingsupdate uitgevoerd</span>
                                <span class="activity-date">15 maart 2025</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div id="news" class="tab-content">
                    <h2>Nieuwsberichten Beheren</h2>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="vandaag_text">Vandaag tekst:</label>
                            <textarea id="vandaag_text" name="vandaag_text">Nieuwe servers geïnstalleerd voor nog betere prestaties.</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="gisteren_text">Gisteren tekst:</label>
                            <textarea id="gisteren_text" name="gisteren_text">Verbeterde beveiliging uitgerold voor alle hosting pakketten.</textarea>
                        </div>
                        
                        <button type="submit" name="update_news" class="bestel-btn">Opslaan</button>
                    </form>
                </div>
                
                <div id="packages" class="tab-content">
                    <h2>Pakketten Beheren</h2>
                    <form method="POST" action="">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="pakket1_prijs">Pakket 1 (Easy) Prijs:</label>
                                <input type="text" id="pakket1_prijs" name="pakket1_prijs" value="€2,99/maand">
                            </div>
                            
                            <div class="form-group">
                                <label for="pakket2_prijs">Pakket 2 (Functionals) Prijs:</label>
                                <input type="text" id="pakket2_prijs" name="pakket2_prijs" value="€5,99/maand">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="pakket3_prijs">Pakket 3 (Pro) Prijs:</label>
                                <input type="text" id="pakket3_prijs" name="pakket3_prijs" value="€9,99/maand">
                            </div>
                            
                            <div class="form-group">
                                <label for="pakket4_prijs">Pakket 4 (Heavy user) Prijs:</label>
                                <input type="text" id="pakket4_prijs" name="pakket4_prijs" value="€14,99/maand">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="pakket_beschrijving">Pakket Omschrijving:</label>
                            <textarea id="pakket_beschrijving" name="pakket_beschrijving">Onze web hosting pakketten bieden betrouwbare, snelle en veilige oplossingen voor uw website. Van persoonlijke blogs tot zakelijke websites, wij hebben het perfecte pakket voor u.</textarea>
                        </div>
                        
                        <button type="submit" name="update_packages" class="bestel-btn">Opslaan</button>
                    </form>
                </div>
                
                <div id="faq" class="tab-content">
                    <h2>FAQ Beheren</h2>
                    
                    <form method="POST" action="">
                        <div class="faq-list">
                            <div class="faq-item">
                                <div class="faq-question">
                                    Wat is webhosting en waarom heb ik het nodig?
                                </div>
                                <div class="faq-answer">
                                    <div class="form-group">
                                        <textarea name="faq_answer_1">Webhosting is een service die ruimte biedt op een server om uw website op het internet te publiceren. U heeft het nodig om uw website toegankelijk te maken voor bezoekers op het internet.</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="faq-item">
                                <div class="faq-question">
                                    Wat is het verschil tussen shared hosting, VPS en dedicated hosting?
                                </div>
                                <div class="faq-answer">
                                    <div class="form-group">
                                        <textarea name="faq_answer_2">Bij shared hosting deelt u serverruimte met andere websites, wat goedkoper is maar minder prestaties biedt. Een VPS biedt toegewijde resources binnen een gedeelde omgeving. Dedicated hosting biedt een volledige server exclusief voor uw gebruik, wat de beste prestaties levert maar duurder is.</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="faq-item">
                                <div class="faq-question">
                                    Hoe kies ik de juiste hostingprovider?
                                </div>
                                <div class="faq-answer">
                                    <div class="form-group">
                                        <textarea name="faq_answer_3">Let op betrouwbaarheid, uptime garanties, klantenservice, prijs-kwaliteitverhouding, schaalbaarheid en de specifieke functies die u nodig heeft voor uw website.</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="add-faq">
                            <h3>Nieuwe FAQ toevoegen</h3>
                            <div class="form-group">
                                <label for="new_question">Vraag:</label>
                                <input type="text" id="new_question" name="new_question" placeholder="Voer een nieuwe vraag in">
                            </div>
                            
                            <div class="form-group">
                                <label for="new_answer">Antwoord:</label>
                                <textarea id="new_answer" name="new_answer" placeholder="Voer het antwoord in"></textarea>
                            </div>
                        </div>
                        
                        <button type="submit" name="update_faq" class="bestel-btn">FAQ Opslaan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2025 KRAS HOSTING. All rights reserved.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabLinks = document.querySelectorAll('.tab-link');
            
            tabLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all tabs
                    tabLinks.forEach(tab => tab.classList.remove('active'));
                    
                    // Add active class to clicked tab
                    this.classList.add('active');
                    
                    // Hide all tab contents
                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.classList.remove('active');
                    });
                    
                    // Show the selected tab content
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });
            
            // Make message automatically disappear after 5 seconds
            const message = document.querySelector('.message');
            if (message) {
                setTimeout(() => {
                    message.style.opacity = '0';
                    message.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => {
                        message.style.display = 'none';
                    }, 500);
                }, 5000);
            }
        });
    </script>
</body>
</html>