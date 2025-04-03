<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Compte</title>
</head>
<body>
    <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['user']['name']); ?>!</h1>
    <p>Email : <?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>

    <a href="deconnexion.php">Se déconnecter</a>
</body>
</html>