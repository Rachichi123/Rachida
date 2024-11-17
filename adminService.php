<?php
require_once('Provider.php');

class AdminService {
    private $connexion;

    function __construct() {
        $p = new Provider();
        $this->connexion = $p->getconnection();
    }

    // Méthode pour ajouter un cours
    public function addCours($libelle, $dateDebut, $dateFin, $idProf, $idSalle) {
        $requete = 'INSERT INTO cours (libelle, dateDebut, dateFin, idProf, idSalle) 
                    VALUES (:lib, :dd, :df, :idp, :ids)';
        $stat = $this->connexion->prepare($requete);
        $rs = $stat->execute([
            'lib' => $libelle,
            'dd' => $dateDebut,
            'df' => $dateFin,
            'idp' => $idProf,
            'ids' => $idSalle
        ]);
        return $rs;
    }

    // Méthode pour modifier un cours
    public function updateCours($id, $libelle, $dateDebut, $dateFin, $idProf, $idSalle) {
        $requete = 'UPDATE cours SET libelle=:lib, dateDebut=:dd, dateFin=:df, 
                    idProf=:idp, idSalle=:ids WHERE id=:id';
        $stat = $this->connexion->prepare($requete);
        $rs = $stat->execute([
            'lib' => $libelle,
            'dd' => $dateDebut,
            'df' => $dateFin,
            'idp' => $idProf,
            'ids' => $idSalle,
            'id' => $id
        ]);
        return $rs;
    }

    // Méthode pour supprimer un cours
    public function deleteCours($id) {
        $requete = 'DELETE FROM cours WHERE id=:id';
        $stat = $this->connexion->prepare($requete);
        $rs = $stat->execute([
            'id' => $id
        ]);
        return $rs;
    }

    // Méthode pour récupérer tous les cours
    public function getAllCours() {
        $requete = 'SELECT * FROM cours';
        $st = $this->connexion->query($requete);
        $cours = $st->fetchAll(PDO::FETCH_ASSOC);
        return $cours;
    }

    // Méthode pour récupérer un cours par son libellé
    public function getCoursByLibelle($libelle) {
        $requete = 'SELECT * FROM cours WHERE libelle=:lib';
        $stmt = $this->connexion->prepare($requete);
        $stmt->execute([
            'lib' => $libelle
        ]);
        $cours = $stmt->fetch(PDO::FETCH_ASSOC);
        return $cours;
    }

    public function getCoursById($id) {
        $requete = 'SELECT * FROM cours WHERE id=:id';
        $stmt = $this->connexion->prepare($requete);
        $stmt->execute([
            'id' => $id
        ]);
        $cours = $stmt->fetch(PDO::FETCH_ASSOC);
        return $cours;
    }

    // Méthode pour récupérer les professeurs disponibles
    public function getAllProfesseurs() {
        $requete = 'SELECT * FROM prof';
        $stmt = $this->connexion->query($requete);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer toutes les salles disponibles
    public function getAllSalles() {
        $requete = 'SELECT * FROM salle';
        $stmt = $this->connexion->query($requete);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
