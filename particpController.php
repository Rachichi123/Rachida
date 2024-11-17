<?php
require_once('../models/ParticipationService.php');

$participationService = new ParticipationService();

// Détection de l'action (GET ou POST)
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

// Ajouter une participation
if ($action == 'ajout') {
    $idEtudiant = $_POST['idEtudiant'];
    $idCours = $_POST['idCours'];
    
    $participationService->add($idEtudiant, $idCours);
    header('Location: ../views/Participation/liste.php?message=Participation ajoutée');
}

// Supprimer une participation
if ($action == 'delete') {
    $idEtudiant = $_GET['idEtudiant'];
    $idCours = $_GET['idCours'];
    
    $participationService->delete($idEtudiant, $idCours);
    header('Location: ../views/Participation/liste.php?message=Participation supprimée');
}

// Liste de toutes les participations
if ($action == 'liste') {
    header('Location: ../views/Participation/liste.php');
}

// Participations par étudiant
if ($action == 'byEtudiant') {
    $idEtudiant = $_GET['idEtudiant'];
    header('Location: ../views/Participation/byEtudiant.php?idEtudiant=' . $idEtudiant);
}

// Participations par cours
if ($action == 'byCours') {
    $idCours = $_GET['idCours'];
    header('Location: ../views/Participation/byCours.php?idCours=' . $idCours);
}
?>
