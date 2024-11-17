<?php
require_once('../models/authService.php');

$authService = new AuthService();

// Détecte l'action (GET ou POST)
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

// Connexion de l'utilisateur
if ($action == 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($authService->login($username, $password)) {
        // Récupérer le rôle de l'utilisateur
        $role = $authService->getRole();
        
        // Rediriger vers la page appropriée en fonction du rôle
        if ($role === 'admin') {
            header('Location: ../views/admin/views/dashboard.php');  // Redirige vers le tableau de bord de l'admin
        } elseif ($role === 'prof') {
            header('Location: ../views/prof/views/dashboard.php');  // Redirige vers le tableau de bord du prof
        } else {
            header('Location: ../views/etudiant/views/dashboard.php');  // Redirige vers le tableau de bord de l'utilisateur
        }
        exit();
    } else {
        header('Location: ../views/login.php?error=invalid_credentials');
        exit();
    }
}


// Déconnexion de l'utilisateur
if ($action == 'logout') {
    $authService->logout();
    header('Location: ../views/login.php?message=logged_out');
    exit();
}
?>
