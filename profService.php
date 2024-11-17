<?php 

require_once('Provider.php');

class ProfService{

    private $connexion;

    function __construct(){
        $p = new Provider();
        $this->connexion = $p->getconnection();
    }
    
    public function add($user, $password, $roleUser, $nom, $prenom, $genre, $email, $adresse) {

        $requeteUser = 'INSERT INTO user (user, password, roleUser) VALUES (:user, :pass, :role)';
        $statUser = $this->connexion->prepare($requeteUser);
        $userInserted = $statUser->execute([
            'user' => $user,
            'pass' => $password,
            'role' => $roleUser
        ]);

        if ($userInserted) {
            $userId = $this->connexion->lastInsertId();

            $requete = 'INSERT INTO prof (nom, prenom, genre, email, adresse, user_id) VALUES (:nom, :prenom, :genre, :email, :adresse, :user_id)';
            $stat = $this->connexion->prepare($requete);
            $profInserted = $stat->execute([
                'nom' => $nom,
                'prenom' => $prenom,
                'genre' => $genre,
                'email' => $email,
                'adresse' => $adresse,
                'user_id' => $userId
            ]);
            return $profInserted;
        }
        return false;
    }

     public function getById($id) {
        $requete = 'SELECT * FROM prof WHERE id = :id';
        $stat = $this->connexion->prepare($requete);
        $stat->execute(['id' => $id]);
        $prof = $stat->fetch(PDO::FETCH_ASSOC);
        return $prof;
    }

    public function getAll() {
        $requete = 'SELECT * FROM prof';
        $stat = $this->connexion->query($requete);
        $profs = $stat->fetchAll(PDO::FETCH_ASSOC);
        return $profs;
    }

    public function update($id, $nom, $prenom, $genre, $email, $adresse) {
        $requete = 'UPDATE prof SET nom = :nom, prenom = :prenom, genre = :genre, email = :email, adresse = :adresse WHERE id = :id';
        $stat = $this->connexion->prepare($requete);
        $profUpdated = $stat->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'genre' => $genre,
            'email' => $email,
            'adresse' => $adresse,
            'id' => $id
        ]);
        return $profUpdated;
    }

    public function delete($id) {
        $requeteGetUserId = 'SELECT user_id FROM prof WHERE id = :id';
        $statGetUserId = $this->connexion->prepare($requeteGetUserId);
        $statGetUserId->execute(['id' => $id]);
        $prof = $statGetUserId->fetch(PDO::FETCH_ASSOC);
    
        if ($prof) {
            $userId = $prof['user_id'];
    
            $requeteDeleteProf = 'DELETE FROM prof WHERE id = :id';
            $statDeleteProf = $this->connexion->prepare($requeteDeleteProf);
            $profDeleted = $statDeleteProf->execute(['id' => $id]);
    
            if ($profDeleted) {
                $requeteDeleteUser = 'DELETE FROM user WHERE id = :userId';
                $statDeleteUser = $this->connexion->prepare($requeteDeleteUser);
                $userDeleted = $statDeleteUser->execute(['userId' => $userId]);
    
                return $userDeleted;
            }
        }
        return false;
    }
}

?>