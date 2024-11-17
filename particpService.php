<?php 
require_once('Provider.php');

class ParticipationService{
    private $connexion;

    function __construct()
    {
        $p = new Provider();
        $this->connexion = $p->getconnection();
    }

    public function add($idEtudiant, $idCours){
        $requete = 'INSERT INTO participation (idEtudiant, idCours) VALUES (:idE, :idC)';
        $stat = $this->connexion->prepare($requete);
        $rs = $stat->execute([
            'idE' => $idEtudiant,
            'idC' => $idCours,
        ]);
        return $rs;
    }

    public function delete($idEtudiant, $idCours) {
        $requete = 'DELETE FROM participation WHERE idEtudiant = :idE AND idCours = :idC';
        $stat = $this->connexion->prepare($requete);
        $res = $stat->execute([
            'idE' => $idEtudiant,
            'idC' => $idCours
        ]);
        return $res;
    }

    public function getAll(){
        $requete = 'SELECT * FROM participation';
        $stat = $this->connexion->query($requete);
        $participations = $stat->fetchAll(PDO::FETCH_ASSOC);
        return $participations;
    }

    public function getByIdEtudiant($idEtudiant) {
        $requete = 'SELECT * FROM participation WHERE idEtudiant = :idE';
        $stat = $this->connexion->prepare($requete);
        $stat->execute(['idE' => $idEtudiant]);
        $participations = $stat->fetchAll(PDO::FETCH_ASSOC);
        return $participations;
    }

    public function getByIdCours($idCours) {
        $requete = 'SELECT * FROM participation WHERE idCours = :idC';
        $stat = $this->connexion->prepare($requete);
        $stat->execute(['idC' => $idCours]);
        $participations = $stat->fetchAll(PDO::FETCH_ASSOC);
        return $participations;
    }
}
?>