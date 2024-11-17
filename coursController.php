<?php
require_once('../models/CoursService.php');

$coursService = new CoursService();

// Détection de l'action (GET ou POST)
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

// Formulaire de création de cours
if ($action == 'form') {
    header('Location: ../views/Cours/form.php');
}

// Liste des cours
if ($action == 'liste') {
    header('Location: ../views/Cours/liste.php');
}

// Suppression d'un cours
if ($action == 'delete') {
    $id = $_GET['id'];
    $coursService->delete($id);
    header('Location: ../views/Cours/liste.php?message=Cours supprimé');
}

// Ajout d'un cours
if ($action == 'ajout') {
    $libelle = $_POST['libelle'];
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];
    $idProf = $_POST['idProf'];
    $idSalle = $_POST['idSalle'];
    
    $coursService->add($libelle, $dateDebut, $dateFin, $idProf, $idSalle);
    header('Location: ../views/Cours/liste.php?message=Cours ajouté');
}

// Formulaire de modification d'un cours
if ($action == 'editForm') {
    $id = $_GET['id'];
    header('Location: ../views/Cours/edit.php?id=' . $id);
}

// Modification d'un cours
if ($action == 'modifier') {
    $id = $_POST['id'];
    $libelle = $_POST['libelle'];
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];
    $idProf = $_POST['idProf'];
    $idSalle = $_POST['idSalle'];
    
    $coursService->update($id, $libelle, $dateDebut, $dateFin, $idProf, $idSalle);
    header('Location: ../views/Cours/liste.php?message=Cours modifié');
}
?>
