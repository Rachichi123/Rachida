<?php 

require_once('Provider.php');

class EtudiantService {
    private $connexion;

    function __construct() {
        $p = new Provider();
        $this->connexion = $p->getconnection();
    }

    public function add($user, $password, $roleUser, $nom, $prenom, $genre) {

        $requeteUser = 'INSERT INTO user (user, password, roleUser) VALUES (:user, :pass, :role)';
        $statUser = $this->connexion->prepare($requeteUser);
        $userInserted = $statUser->execute([
            'user' => $user,
            'pass' => $password,
            'role' => $roleUser
        ]);

        if ($userInserted) {
            $userId = $this->connexion->lastInsertId();

            $requeteEtudiant = 'INSERT INTO etudiant (nom, prenom, genre, user_id) VALUES (:nom, :prenom, :genre, :user_id)';
            $statEtudiant = $this->connexion->prepare($requeteEtudiant);
            $etudiantInserted = $statEtudiant->execute([
                'nom' => $nom,
                'prenom' => $prenom,
                'genre' => $genre,
                'user_id' => $userId
            ]);

            return $etudiantInserted;
        }
        
        return false;
    }

    public function getById($id) {
        $requete = 'SELECT * FROM etudiant WHERE id = :id';
        $stat = $this->connexion->prepare($requete);
        $stat->execute(['id' => $id]);
        return $stat->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $requete = 'SELECT * FROM etudiant';
        $stat = $this->connexion->query($requete);
        return $stat->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $nom, $prenom, $genre) {
        $requete = 'UPDATE etudiant SET nom = :nom, prenom = :prenom, genre = :genre WHERE id = :id';
        $stat = $this->connexion->prepare($requete);
        $result = $stat->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'genre' => $genre,
            'id' => $id
        ]);
        return $result;
    }

    public function delete($id) {
        $requeteGetUserId = 'SELECT user_id FROM etudiant WHERE id = :id';
        $statGetUserId = $this->connexion->prepare($requeteGetUserId);
        $statGetUserId->execute(['id' => $id]);
        $etudiant = $statGetUserId->fetch(PDO::FETCH_ASSOC);
    
        if ($etudiant) {
            $userId = $etudiant['user_id'];
    
            $requeteDeleteEtudiant = 'DELETE FROM etudiant WHERE id = :id';
            $statDeleteEtudiant = $this->connexion->prepare($requeteDeleteEtudiant);
            $etudiantDeleted = $statDeleteEtudiant->execute(['id' => $id]);
    
            if ($etudiantDeleted) {
                $requeteDeleteUser = 'DELETE FROM user WHERE id = :userId';
                $statDeleteUser = $this->connexion->prepare($requeteDeleteUser);
                $userDeleted = $statDeleteUser->execute(['userId' => $userId]);
    
                return $userDeleted;
            }
        }
    
        return false;
    }

    public function getCoursInscrits($etudiantId) {
        $requete = 'SELECT c.libelle, c.dateDebut, c.dateFin, c.id
                    FROM participation p
                    JOIN cours c ON p.idCours = c.id
                    WHERE p.idEtudiant = :etudiantId';
        $stmt = $this->connexion->prepare($requete);
        $stmt->execute(['etudiantId' => $etudiantId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Méthode pour inscrire un étudiant à un cours
    public function inscrireCours($etudiantId, $coursId) {
        $requete = 'INSERT INTO participation (idEtudiant, idCours) VALUES (:etudiantId, :coursId)';
        $stat = $this->connexion->prepare($requete);
    
        // Exécute la requête et vérifie si elle a réussi
        if ($stat->execute([
            'etudiantId' => $etudiantId,
            'coursId' => $coursId
        ])) {
            return true;
        } else {
            // Affiche les informations d'erreur PDO
            $errorInfo = $stat->errorInfo();
            echo "Erreur SQL : " . $errorInfo[2];
            return false;
        }
    }    

    // Méthode pour obtenir tous les cours disponibles
    public function getAllCours() {
        $requete = 'SELECT * FROM cours';
        $stat = $this->connexion->query($requete);
        return $stat->fetchAll(PDO::FETCH_ASSOC);
    }

    // Dans `etudiantService.php`
    public function getEtudiantIdByUserId($userId) {
        $requete = 'SELECT id FROM etudiant WHERE user_id = :userId';
        $stat = $this->connexion->prepare($requete);
        $stat->execute(['userId' => $userId]);
        $etudiant = $stat->fetch(PDO::FETCH_ASSOC);

        return $etudiant ? $etudiant['id'] : null;
    }

    public function deleteParticipation($etudiantId, $coursId) {
        $requete = 'DELETE FROM participation WHERE idEtudiant = :etudiantId AND idCours = :coursId';
        $stat = $this->connexion->prepare($requete);
        return $stat->execute([
            'etudiantId' => $etudiantId,
            'coursId' => $coursId
        ]);
    }
    

    
}
?>
