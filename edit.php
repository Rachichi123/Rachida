<?php
// Démarre la session pour vérifier si l'utilisateur est connecté
session_start();

// Vérifie si l'utilisateur est connecté ; sinon, redirige vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');
    exit();
}

require_once('../../../../models/adminService.php');
$adminService = new adminService();
//Récupère l'ID du cours à partir des paramètres de la requête
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Récupère les informations du cours, des professeurs, et des salles
$cours = $adminService->getCoursById($id);
$professeurs = $adminService->getAllProfesseurs();
$salles = $adminService->getAllSalles();

//Si le cours n'existe pas, redirige vers la liste des cours avec un message d'erreur
if (!$cours) {
    header('Location: liste.php?error=Cours non trouvé');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un cours</title>
    <link rel="stylesheet" href="styles.css"> <!-- Fichier CSS pour le style -->
</head>
<body>
    <div class="container">
        <h1>Modifier un cours</h1>

        <!-- Formulaire de modification du cours -->
        <form action="../../../../controllers/adminController.php" method="POST">
            <input type="hidden" name="action" value="modifier">
            <input type="hidden" name="id" value="<?= $cours['id'] ?>">

            <label for="libelle">Libellé du cours :</label>
            <input type="text" name="libelle" id="libelle" value="<?= htmlspecialchars($cours['libelle']) ?>" required>

            <label for="dateDebut">Date de début :</label>
            <input type="date" name="dateDebut" id="dateDebut" value="<?= $cours['dateDebut'] ?>" required>

            <label for="dateFin">Date de fin :</label>
            <input type="date" name="dateFin" id="dateFin" value="<?= $cours['dateFin'] ?>" required>

            <label for="idProf">Professeur :</label>
            <select name="idProf" id="idProf" required>
                <?php foreach ($professeurs as $prof) { ?>
                    <option value="<?= $prof['id'] ?>" <?= $cours['idProf'] == $prof['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($prof['nom']) . ' ' . htmlspecialchars($prof['prenom']) ?>
                    </option>
                <?php } ?>
            </select>

            <label for="idSalle">Salle :</label>
            <select name="idSalle" id="idSalle" required>
                <?php foreach ($salles as $salle) { ?>
                    <option value="<?= $salle['id'] ?>" <?= $cours['idSalle'] == $salle['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($salle['nomSalle']) ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit">Enregistrer les modifications</button>
        </form>
    </div>
</body>
</html>
