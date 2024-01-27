<?php 

declare(strict_types=1);

namespace db_models;


use PDO;
use models\favTitre;

class FavTitreBD{

    private PDO $db;

    /**
     * TitreBD constructeur, accesseur BD pour l'association entre un titre et un utilisateur, manyToMany
     * @param \PDO $db
     */
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * @param int $idU
     * @param int $idT
     * @return bool
     */
    public function addFavTitre(int $idU, int $idT): bool {
        $req = $this->db->prepare("INSERT INTO favTitre(idU, idT) VALUES (:idU, :idT)");
        $req->bindParam(":idU", $idU);
        $req->bindParam(":idT", $idT);
        return $req->execute();
    }

    /**
     * @param int $idU
     * @param int $idT
     * @return bool
     */
    public function removeFavTitre(int $idU, int $idT): bool {
        $req = $this->db->prepare("DELETE FROM favTitre WHERE idU = :idU AND idT = :idT");
        $req->bindParam(":idU", $idU);
        $req->bindParam(":idT", $idT);
        return $req->execute();
    }

    /**
     * suppprime tous les favoris d'un utilisateur
     * @param int $idU
     */
    public function deleteFavTitreByIdU(int $idU): void {
        $req = $this->db->prepare("DELETE FROM favTitre WHERE idU = :idU");
        $req->bindParam(":idU", $idU);
        $req->execute();
    }

    /**
     * supprimer toutes les associations favoris d'un titre
     * @param int $idT
     */
    public function deleteFavTitreByIdT(int $idT): void {
        $req = $this->db->prepare("DELETE FROM favTitre WHERE idT = :idT");
        $req->bindParam(":idT", $idT);
        $req->execute();    
    }

    /**
     * @param int $idU
     * @param int $idT
     * @return bool
     */
    public function isFavTitre(int $idU, int $idT): bool {
        $req = $this->db->prepare("SELECT * FROM favTitre WHERE idU = :idU AND idT = :idT");
        $req->bindParam(":idU", $idU);
        $req->bindParam(":idT", $idT);
        $req->execute();
        return $req->rowCount() > 0;
    }

    /**
     * @param int $idU
     * @return array
     */
    public function getFavTitresByUtilisateurId(int $idU): array {
        $req = $this->db->prepare("SELECT * FROM favTitre WHERE idU = :idU");
        $req->bindParam(":idU", $idU);
        $req->execute();
        $titresFavoris = [];
        $favTitres = $req->fetchAll();
        foreach ($favTitres as $favTitre) {
            $titresFavoris[] = new favTitre((int)$favTitre['idU'], (int)$favTitre['idT']);
        }
        return $titresFavoris;
    }
        
}