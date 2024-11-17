<?php
// Démarre la session pour vérifier si l'utilisateur est connecté
session_start();

// Vérifie si l'utilisateur est connecté ; sinon, redirige vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');  // Page de redirection si l'utilisateur n'est pas connecté
    exit();
}

require_once('../../../../models/adminService.php');
$adminService = new adminService();
$cours = $adminService->getAllCours(); // Récupère la liste des cours avec les informations de la salle et du professeur
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Cours</title>
    <link rel="stylesheet" href="styles.css"> <!-- Inclure votre fichier CSS -->
</head>
<body>
    <div class="container">
        <h1>Liste des Cours</h1>
        
        <!-- Tableau affichant les cours -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Libellé</th>
                    <th>Date de Début</th>
                    <th>Date de Fin</th>
                    <th>Professeur</th>
                    <th>Salle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cours as $course) { ?>
                    <tr>
                        <td><?= $course['id'] ?></td>
                        <td><?= $course['libelle'] ?></td>
                        <td><?= $course['dateDebut'] ?></td>
                        <td><?= $course['dateFin'] ?></td>
                        <td><?= $course['nomProf'] . ' ' . $course['prenomProf'] ?></td>
                        <td><?= $course['nomSalle'] ?></td>
                        <td>
                            <a href="../../../../controllers/adminController.php?action=editForm&id=<?= $course['id'] ?>">Modifier</a> |
                            <a href="../../../../controllers/adminController.php?action=delete&id=<?= $course['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
