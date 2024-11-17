<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');
    exit();
}

// Récupère l'ID de l'utilisateur
$userId = $_SESSION['user_id'];

// Inclure le service ou le contrôleur pour récupérer les cours inscrits
require_once('../../../models/etudiantService.php');

// Créer une instance du service et récupérer l'ID de l'étudiant
$etudiantService = new EtudiantService();
$etudiantId = $etudiantService->getEtudiantIdByUserId($userId);

if ($etudiantId) {
    // Récupérer les cours inscrits et les stocker dans la session
    $coursInscrits = $etudiantService->getCoursInscrits($etudiantId);
    $_SESSION['coursInscrits'] = $coursInscrits;
} else {
    $_SESSION['coursInscrits'] = [];
    $message = "Erreur : étudiant introuvable.";
}

$message = $_GET['message'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mes Cours</title>
</head>
<body>
    <h1>Mes Cours</h1>
    <?php if ($message) : ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <h2>Cours auxquels vous êtes inscrit :</h2>
    <ul>
        <?php foreach ($coursInscrits as $cours) : ?>
            <li><?php echo htmlspecialchars($cours['libelle']) . " (Du " . htmlspecialchars($cours['dateDebut']) . " au " . htmlspecialchars($cours['dateFin']) . ")"; ?></li>
            <a href="../../../controllers/etudiantController.php?action=deleteParticipation&user_id=<?php echo $userId; ?>&cours_id=<?php echo $cours['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">Supprimer</a>
            <?php endforeach; ?>
    </ul>

    <h2>Inscription à un nouveau cours</h2>
    <form action="../../../controllers/etudiantController.php" method="get">
    <input type="hidden" name="action" value="inscrireCours">
    <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
    <label for="cours">Choisissez un cours :</label>
    <select name="coursId" id="cours">
        <?php
        // Récupère la liste de tous les cours pour permettre l'inscription
        require_once('../../../models/etudiantService.php');
        $etudiantService = new EtudiantService();
        $coursDisponibles = $etudiantService->getAllCours();
        foreach ($coursDisponibles as $cours) {
            echo '<option value="' . htmlspecialchars($cours['id']) . '">' . htmlspecialchars($cours['libelle']) . '</option>';
        }
        ?>
    </select>
    <button type="submit">S'inscrire</button>
</form>


</body>
</html>
