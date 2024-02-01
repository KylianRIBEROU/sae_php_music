<?php 

declare(strict_types=1);

namespace models;

use pdoFactory\PDOFactory;
use PDO;
use PDOException;

class Appartient {

    private int $idP;

    private int $idT;

    /**
     * Appartient constructor. association entre titre et playlist, manyToMany
     * @param int $idP
     * @param int $idT
     */
    public function __construct(int $idP, int $idT) {
        $this->idP = $idP;
        $this->idT = $idT;
    }

    /**
     * @return int
     */
    public function getIdP(): int {
        return $this->idP;
    }

    /**
     * @return int
     */
    public function getIdT(): int {
        return $this->idT;
    }

    /**
     * @param int $idP
     * @return void
     */
    public function setIdP(int $idP): void {
        $this->idP = $idP;

    }

    /**
     * @param int $idT
     * @return void
     */
    public function setIdT(int $idT): void {
        $this->idT = $idT;
    }

    /**
    * @param int $idU
    * @param int $idAlbum
    * @return favAlbum
    */
    public static function getFavAlbum(int $idU, int $idAlbum): favAlbum {
        $sql = "SELECT * FROM favAlbum WHERE idU = :idU AND idAlbum = :idAlbum";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idU", $idU);
        $stmt->bindValue(":idAlbum", $idAlbum);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new favAlbum((int)$row["idU"], (int)$row["idAlbum"]);
    }
    
    /**
     * @param int $idU
     * @return array
     */
    public static function getFavAlbums(int $idU): array {
        $sql = "SELECT * FROM favAlbum WHERE idU = :idU";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idU", $idU);
        $stmt->execute();
        $favAlbums = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $favAlbums[] = new favAlbum((int)$row["idU"], (int)$row["idAlbum"]);
        }
        return $favAlbums;
    }
    
    public function create(): bool {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = "INSERT INTO appartient (idP, idT) VALUES (:idP, :idT)";
        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idP', $this->idP);
            $stmt->bindValue(':idT', $this->idT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update(): bool {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = "UPDATE appartient SET idP = :idP, idT = :idT WHERE idP = :idP AND idT = :idT";
        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idP', $this->idP);
            $stmt->bindValue(':idT', $this->idT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete(): bool {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = "DELETE FROM appartient WHERE idP = :idP AND idT = :idT";
        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idP', $this->idP);
            $stmt->bindValue(':idT', $this->idT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function deleteAll(): bool {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = "DELETE FROM appartient";
        try {
            $stmt = $pdo->prepare($query);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function deleteAppartientByIdP(int $idP): bool {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = "DELETE FROM appartient WHERE idP = :idP";
        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idP', $idP);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function deleteAppartientByIdT(int $idT): bool {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = "DELETE FROM appartient WHERE idT = :idT";
        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idT', $idT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}