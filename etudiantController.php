<?php
require_once('../models/etudiantService.php');

$etudiantService = new EtudiantService();

// Détection de l'action (GET ou POST)
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

// Formulaire de création d'un étudiant
if ($action == 'form') {
    header('Location: ../views/Etudiant/form.php');
}

// Liste des étudiants
if ($action == 'liste') {
    header('Location: ../views/Etudiant/liste.php');
}

// Suppression d'un étudiant
if ($action == 'delete') {
    $id = $_GET['id'];
    $etudiantService->delete($id);
    header('Location: ../views/Etudiant/liste.php?message=Étudiant supprimé');
}

// Ajout d'un étudiant
if ($action == 'ajout') {
    $user = $_POST['user'];
    $password = $_POST['password'];
    $roleUser = $_POST['roleUser'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $genre = $_POST['genre'];
    
    $etudiantService->add($user, $password, $roleUser, $nom, $prenom, $genre);
    header('Location: ../views/Etudiant/liste.php?message=Étudiant ajouté');
}

// Formulaire de modification d'un étudiant
if ($action == 'editForm') {
    $id = $_GET['id'];
    header('Location: ../views/Etudiant/edit.php?id=' . $id);
}

// Modification d'un étudiant
if ($action == 'modifier') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $genre = $_POST['genre'];
    
    $etudiantService->update($id, $nom, $prenom, $genre);
    header('Location: ../views/etudiant/liste.php?message=Étudiant modifié');
}

// Liste des cours auxquels l'étudiant est inscrit
if ($action == 'coursInscrits') {
    // $etudiantId = $_SESSION['user_id'];
    // $coursInscrits = $etudiantService->getCoursInscrits($etudiantId);
    // $_SESSION['coursInscrits'] = $coursInscrits;
    // Récupère l'ID de l'étudiant
    $userId = $_GET['etudiantId'];
    echo "bouy";
    echo $userId;
    $etudiantId = $etudiantService->getEtudiantIdByUserId($userId);
    echo $etudiantId;

    // Vérifie si l'étudiant existe
    if ($etudiantId) {
        $coursInscrits = $etudiantService->getCoursInscrits($etudiantId);
        $_SESSION['coursInscrits'] = $coursInscrits;
        echo $coursInscrits;
    } else {
        echo "Erreur : étudiant introuvable.";
    }

   // header('Location: ../views/etudiant/views/dashboard.php');
}

// Inscription à un cours
// Contrôleur
if ($action == 'inscrireCours') {
    $etudiantId = $_GET['user_id'];  // ID de l'étudiant envoyé dans l'URL
    $coursId = $_GET['coursId']; 
    echo "User ID: " . $etudiantId . "<br>";
        echo "Cours ID: " . $coursId . "<br>";

    // Récupérer l'ID de l'étudiant en fonction de l'user_id
    require_once('../models/etudiantService.php');
    $etudiantService = new EtudiantService();

    // Nouvelle méthode pour obtenir l'id de l'étudiant à partir du user_id
    $etudiantId = $etudiantService->getEtudiantIdByUserId($etudiantId);

    if ($etudiantId) {
        // Appel de la fonction d'inscription avec l'ID de l'étudiant correct
        
        $result = $etudiantService->inscrireCours($etudiantId, $coursId);

        if ($result) {
            echo "Inscription réussie";
        } else {
            echo "Erreur lors de l'inscription";
        }
    } else {
        echo "Étudiant introuvable pour cet utilisateur";
    }

    header('Location: ../views/etudiant/views/dashboard.php?message=Inscription réussie');
}

if ($action === 'deleteParticipation') {
    $userId = $_GET['user_id'];
    $coursId = $_GET['cours_id'];

    $etudiantService = new EtudiantService();
    $etudiantId = $etudiantService->getEtudiantIdByUserId($userId);

    if ($etudiantId && $etudiantService->deleteParticipation($etudiantId, $coursId)) {
       header("Location: ../views/etudiant/views/dashboard.php?message=" . urlencode("Vous avez été désinscrit du cours avec succès."));
       exit();
    } else {
        header("Location: ../views/etudiant/views/dashboard.php?message=" . urlencode("Erreur lors de la désinscription."));
        exit();
    }
}

?>
