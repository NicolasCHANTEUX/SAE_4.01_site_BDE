<?php
require_once 'app/views/template/header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDE IUT Informatique</title>
    <link rel="stylesheet" href="/assets/css/style.css">
	<link rel="stylesheet" href="/assets/css/questionsFrequentes.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="navigation-buttons">
        <a href="/contact.php" class="nav-btn back-btn">
            <i class="fas fa-arrow-left"></i>
            <span>Retour</span>
        </a>
    </div>


	<main id="app">
    <div class="faq-container"></div>
        <script>
            // Conversion des données PHP en JSON pour JavaScript
            const FAQ_DATA = <?php echo json_encode($questionsFrequentes); ?>;
        </script>
    </main>

    <footer>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> BDE IUT Informatique - Tous droits réservés</p>
        </div>
    </footer>
    <script src="/assets/js/questionsfrequentes.js"></script>
</body>
</html>
