<?php 

declare(strict_types=1);

namespace models;

use pdoFactory\PDOFactory;
use PDO;
use PDOException;

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

    public static function GetFavTitre(int $idU, int $idT): ?favTitre{
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("SELECT * FROM favTitre WHERE idU = :idU AND idT = :idT");
        $req->bindParam(":idU", $idU);
        $req->bindParam(":idT", $idT);
        $req->execute();
        $favTitre = $req->fetch();
        if (!$favTitre) {
            return null; // Return null if no results found
        }
        $favTitre = new favTitre($favTitre['idU'], $favTitre['idT']);
        return $favTitre;
    }

    public static function GetFavTitresByIdU(int $idU): array{
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("SELECT * FROM favTitre WHERE idU = :idU");
        $req->bindParam(":idU", $idU);
        $req->execute();
        $data = $req->fetchAll();
        $favTitres = [];
        for ($i=0; $i < count($data); $i++) { 
            $favTitres[] = new favTitre($data[$i]['idU'], $data[$i]['idT']);
        }
        return $favTitres;
    }

    public static function GetFavTitresByIdT(int $idT): array{
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("SELECT * FROM favTitre WHERE idT = :idT");
        $req->bindParam(":idT", $idT);
        $req->execute();
        $data = $req->fetchAll();
        $favTitres = [];
        for ($i=0; $i < count($data); $i++) { 
            $favTitres[] = new favTitre($data[$i]['idU'], $data[$i]['idT']);
        }
        return $favTitres;
    }

    public function create(){
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("INSERT INTO favTitre (idU, idT) VALUES (:idU, :idT)");
        $req->bindParam(":idU", $this->idU);
        $req->bindParam(":idT", $this->idT);
        $req->execute();
    }

    public function update(){
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("UPDATE favTitre SET idU = :idU, idT = :idT WHERE idU = :idU AND idT = :idT");
        $req->bindParam(":idU", $this->idU);
        $req->bindParam(":idT", $this->idT);
        $req->execute();
    }

    public function delete(){
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("DELETE FROM favTitre WHERE idU = :idU AND idT = :idT");
        $req->bindParam(":idU", $this->idU);
        $req->bindParam(":idT", $this->idT);
        $req->execute();
    }

    public static function deleteFavTitreByIdU(int $idU){
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("DELETE FROM favTitre WHERE idU = :idU");
        $req->bindParam(":idU", $idU);
        $req->execute();
    }

    public static function deleteFavTitreByIdT(int $idT){
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("DELETE FROM favTitre WHERE idT = :idT");
        $req->bindParam(":idT", $idT);
        $req->execute();
    }
}
