<?php
// Démarre la session pour vérifier si l'utilisateur est déjà connecté
session_start();

// Si l'utilisateur est déjà connecté, redirigez-le vers la page d'accueil ou le tableau de bord
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');  // ou la page où vous voulez rediriger l'utilisateur
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenue!</h1>
</body>
</html>