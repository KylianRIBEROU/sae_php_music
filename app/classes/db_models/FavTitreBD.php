<?php 

declare(strict_types=1);

namespace db_models;


use pdoFactory\PDOFactory;

class FavTitreBD{

   /**
     * @param int $idU
     * @param int $idT
     * @return bool
     */
    public static function addFavTitre(int $idU, int $idT): bool {
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("INSERT INTO favTitre(idU, idT) VALUES (:idU, :idT)");
        $req->bindParam(":idU", $idU);
        $req->bindParam(":idT", $idT);
        return $req->execute();
    }

    /**
     * @param int $idU
     * @param int $idT
     * @return bool
     */
    public static function removeFavTitre(int $idU, int $idT): bool {
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("DELETE FROM favTitre WHERE idU = :idU AND idT = :idT");
        $req->bindParam(":idU", $idU);
        $req->bindParam(":idT", $idT);
        return $req->execute();
    }

    /**
     * @param int $idU
     * @return void
     */
    public static function deleteFavTitreByIdU(int $idU): void {
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("DELETE FROM favTitre WHERE idU = :idU");
        $req->bindParam(":idU", $idU);
        $req->execute();
    }

    /**
     * @param int $idT
     * @return void
     */
    public static function deleteFavTitreByIdT(int $idT): void {
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("DELETE FROM favTitre WHERE idT = :idT");
        $req->bindParam(":idT", $idT);
        $req->execute();    
    }

    /**
     * @param int $idU
     * @param int $idT
     * @return bool
     */
    public static function isFavTitre(int $idU, int $idT): bool {
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("SELECT * FROM favTitre WHERE idU = :idU AND idT = :idT");
        $req->bindParam(":idU", $idU);
        $req->bindParam(":idT", $idT);
        $req->execute();
        return $req->rowCount() > 0;
    }

    /**
     * @param int $idU
     * @return array
     */
    public static function getFavTitresByUtilisateurId(int $idU): array {
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("SELECT * FROM favTitre WHERE idU = :idU");
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

class favTitre { 
    
    private int $idU;

    private int $idT;

    /**
    * favTitre constructor, association entre un titre et un utilisateur, manyToMany
    * @param int $idU
    * @param int $idT
    */
    public function __construct(int $idU, int $idT) {
        $this->idU = $idU;
        $this->idT = $idT;
    }

    /**
    * @return int
    */
    public function getIdU(): int {
        return $this->idU;
    }

    /**
    * @return int
    */
    public function getIdT(): int {
        return $this->idT;
    }

    /**
    * @param int $idU
    * @return void
    */
    public function setIdU(int $idU): void {
        $this->idU = $idU;

    }

    /**
    * @param int $idT
    * @return void
    */
    public function setIdT(int $idT): void {
        $this->idT = $idT;
    }
}