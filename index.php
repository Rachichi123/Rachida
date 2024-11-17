<?php
// Démarre la session pour vérifier si l'utilisateur est déjà connecté
session_start();

// Si l'utilisateur est déjà connecté, redirigez-le vers la page d'accueil ou le tableau de bord
if (!isset($_SESSION['user_id'])) {
    header('Location: views/login.php');  // ou la page où vous voulez rediriger l'utilisateur
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <?php if (isset($_GET['error'])): ?>
        <p style="color: red;">Nom d'utilisateur ou mot de passe incorrect</p>
    <?php endif; ?>
    <form action="controllers/authController.php" method="post">
        <input type="hidden" name="action" value="login">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required><br>
        
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br>
        
        <button type="submit">Connexion</button>
    </form>
</body>
</html>
