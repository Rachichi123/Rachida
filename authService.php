<?php
require_once('Provider.php');

class AuthService {
    private $connexion;

    function __construct() {
        $p = new Provider();
        $this->connexion = $p->getconnection();
    }

    // Vérifie les informations d'identification de l'utilisateur
    public function login($username, $password) {
        $requete = 'SELECT * FROM user WHERE user = :username';
        $stat = $this->connexion->prepare($requete);
        $stat->execute(['username' => $username]);
        $user = $stat->fetch(PDO::FETCH_ASSOC);

        // Vérification du mot de passe
        if ($user && $user['password'] === $password) {
            // Stocker les informations de l'utilisateur en session
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['roleUser'];
            return true;
        }
        return false;
    }

    // Déconnexion de l'utilisateur
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
    }

    // Vérifie si l'utilisateur est connecté
    public function isLoggedIn() {
        session_start();
        return isset($_SESSION['user_id']);
    }

    public function getRole() {
        return $_SESSION['role'] ?? null;  // Retourne le rôle de l'utilisateur, ou null si non défini
    }
}
?>
