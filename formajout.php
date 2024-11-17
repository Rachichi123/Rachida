<?php
// Démarre la session pour vérifier si l'utilisateur est connecté
session_start();

// Vérifie si l'utilisateur est connecté ; sinon, redirige vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');  // Page de redirection si l'utilisateur n'est pas connecté
    exit();
}

require_once('../../../../models/adminService.php');
$adminService = new AdminService();
$professeurs = $adminService->getAllProfesseurs(); // Récupère la liste des professeurs
$salles = $adminService->getAllSalles();           // Récupère la liste des salles
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un cours</title>
</head>
<body>
    <div class="container">
        <h1>Ajouter un cours</h1>
        <form action="../../../../controllers/adminController.php?action=ajout" method="POST">
            <!-- Champ pour le libellé du cours -->
            <label for="libelle">Libellé du Cours :</label>
            <input type="text" name="libelle" id="libelle" required><br>

            <!-- Champ pour la date de début du cours -->
            <label for="dateDebut">Date de Début :</label>
            <input type="date" name="dateDebut" id="dateDebut" required><br>

            <!-- Champ pour la date de fin du cours -->
            <label for="dateFin">Date de Fin :</label>
            <input type="date" name="dateFin" id="dateFin" required><br>

            <!-- Menu déroulant pour sélectionner le professeur -->
            <label for="idProf">Professeur :</label>
            <select name="idProf" id="idProf" required>
                <?php foreach ($professeurs as $prof) { ?>
                    <option value="<?= $prof['id'] ?>"><?= $prof['nom'] ?> <?= $prof['prenom'] ?></option>
                <?php } ?>
            </select><br>

            <!-- Menu déroulant pour sélectionner la salle -->
            <label for="idSalle">Salle :</label>
            <select name="idSalle" id="idSalle" required>
                <?php foreach ($salles as $salle) { ?>
                    <option value="<?= $salle['id'] ?>"><?= $salle['nomSalle'] ?></option>
                <?php } ?>
            </select><br>

            <!-- Bouton pour soumettre le formulaire -->
            <button type="submit">Ajouter le Cours</button>
        </form>
    </div>
</body>
</html>
