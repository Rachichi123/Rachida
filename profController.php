<?php
require_once('../models/ProfService.php');

$profService = new ProfService();

// Détection de l'action (GET ou POST)
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

// Ajouter un professeur
if ($action == 'ajout') {
    $user = $_POST['user'];
    $password = $_POST['password'];
    $roleUser = $_POST['roleUser'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $genre = $_POST['genre'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    
    $profService->add($user, $password, $roleUser, $nom, $prenom, $genre, $email, $adresse);
    header('Location: ../views/Prof/liste.php?message=Professeur ajouté');
}

// Supprimer un professeur
if ($action == 'delete') {
    $id = $_GET['id'];
    
    $profService->delete($id);
    header('Location: ../views/Prof/liste.php?message=Professeur supprimé');
}

// Liste de tous les professeurs
if ($action == 'liste') {
    header('Location: ../views/Prof/liste.php');
}

// Afficher un professeur par ID
if ($action == 'detail') {
    $id = $_GET['id'];
    header('Location: ../views/Prof/detail.php?id=' . $id);
}
?>
