<?php
require_once('../models/adminService.php');

$adminService = new AdminService();

// Détection de l'action (GET ou POST)
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

// Formulaire de création de cours
if ($action == 'form') {
    header('Location: ../views/admin/views/cours/formajout.php');
}

// Liste des cours
if ($action == 'liste') {
    $cours = $adminService->getAllCours();
    header('Location: ../views/admin/views/cours/liste.php');
}

// Suppression d'un cours
if ($action == 'delete') {
    $id = $_GET['id'];
    $adminService->deleteCours($id);
    header('Location: ../views/admin/views/cours/liste.php?message=Cours supprimé');
}

// Ajout d'un cours
if ($action == 'ajout') {
    $libelle = $_POST['libelle'];
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];
    $idProf = $_POST['idProf'];
    $idSalle = $_POST['idSalle'];
    
    $adminService->addCours($libelle, $dateDebut, $dateFin, $idProf, $idSalle);
    header('Location: ../views/admin/views/cours/liste.php?message=Cours ajouté');
}

// Formulaire de modification d'un cours
if ($action == 'editForm') {
    $id = $_GET['id'];
    $cours = $adminService->getCoursById($id);
    header('Location: ../views/admin/views/cours/edit.php?id=' . $id);
}

// Modification d'un cours
if ($action == 'modifier') {
    $id = $_POST['id'];
    $libelle = $_POST['libelle'];
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];
    $idProf = $_POST['idProf'];
    $idSalle = $_POST['idSalle'];
    
    $adminService->updateCours($id, $libelle, $dateDebut, $dateFin, $idProf, $idSalle);
    header('Location: ../views/admin/views/cours/liste.php?message=Cours modifié');
}
?>
