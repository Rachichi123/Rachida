<?php 
require_once('Provider.php');

class CoursService{
    private $connexion;

    function __construct()
    {
        $p = new Provider();
        $this->connexion = $p->getconnection();
    }

    public function add($libelle, $dateDebut, $dateFin, $idProf, $idSalle){
        $requete = 'INSERT INTO cours (libelle, dateDebut, dateFin, idProf, idSalle) VALUES (:lib, :dd, :df, :idp, :ids)';
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

    public function update($id, $libelle, $dateDebut, $dateFin, $idProf, $idSalle){
        $requete = 'UPDATE cours SET libelle=:lib, dateDebut=:dd, dateFin=:df, idProf=:idp, idSalle=:ids WHERE id=:id';
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

    public function delete($id){
        $requete = 'DELETE FROM cours WHERE id=:id';
        $sta = $this->connexion->prepare($requete);
        $res = $sta->execute([
            'id' => $id
        ]);
        return $res;
    }

    public function getAll(){
        $requete = 'SELECT * FROM cours';
        $st = $this->connexion->query($requete);
        $cours = $st->fetchAll(PDO::FETCH_ASSOC);
        return $cours;
    }

    public function getByLib($libelle){
        $requete = "SELECT * FROM cours WHERE libelle=:lib";
        $stmt = $this->connexion->prepare($requete);
        $stmt->execute([
            'lib' => $libelle
        ]);
        $cours = $stmt->fetch(PDO::FETCH_ASSOC);
        return $cours;
    }
}
?>
