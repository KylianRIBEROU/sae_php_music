<?php

declare(strict_types=1);

namespace models;

use pdoFactory\PDOFactory;

use PDO;
use PDOException;
class favAlbum {

    private int $idU;

    private int $idAlbum;

    /**
     * favAlbum constructor, association entre un album et un utilisateur, manyToMany
     * @param int $idU
     * @param int $idAlbum
     */
    public function __construct(int $idU, int $idAlbum) {
        $this->idU = $idU;
        $this->idAlbum = $idAlbum;
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
    public function getIdAlbum(): int {
        return $this->idAlbum;
    }

    /**
     * @param int $idU
     * @return void
     */
    public function setIdU(int $idU): void {
        $this->idU = $idU;

    }

    /**
     * @param int $idAlbum
     * @return void
     */
    public function setIdAlbum(int $idAlbum): void {
        $this->idAlbum = $idAlbum;
    }

      /**
    * @param int $idU
    * @param int $idAlbum
    * @return favAlbum
    */
    public static function getFavAlbum(int $idU, int $idAlbum): ?favAlbum {
        $sql = "SELECT * FROM favAlbum WHERE idU = :idU AND idAlbum = :idAlbum";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idU", $idU);
        $stmt->bindValue(":idAlbum", $idAlbum);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null; // Return null if no results found
        }
        return new favAlbum((int)$row["idU"], (int)$row["idAlbum"]);
    }
    public static function getFavAlbums(): array {
        $sql = "SELECT * FROM favAlbum";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $favAlbums = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $favAlbums[] = new favAlbum((int)$row["idU"], (int)$row["idAlbum"]);
        }
        return $favAlbums;
        
    }

    /**
     * @param int $idU
     * @return array
     */
    public static function getFavAlbumsByIdU(int $idU): array {
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

    public function create(): void {
        $sql = "INSERT INTO favAlbum (idU, idAlbum) VALUES (:idU, :idAlbum)";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idU", $this->idU);
        $stmt->bindValue(":idAlbum", $this->idAlbum);
        $stmt->execute();
    }

    public function update(): void {
        $sql = "UPDATE favAlbum SET idU = :idU, idAlbum = :idAlbum WHERE idU = :idU AND idAlbum = :idAlbum";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idU", $this->idU);
        $stmt->bindValue(":idAlbum", $this->idAlbum);
        $stmt->execute();
    }

    public function delete(): void {
        $sql = "DELETE FROM favAlbum WHERE idU = :idU AND idAlbum = :idAlbum";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idU", $this->idU);
        $stmt->bindValue(":idAlbum", $this->idAlbum);
        $stmt->execute();
    }

    /**
     * @param int $idU
     * @return void
     */
    public static function deleteFavAlbumByIdU(int $idU): void {
        $sql = "DELETE FROM favAlbum WHERE idU = :idU";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idU", $idU);
        $stmt->execute();
    }

    /**
     * @param int $idAlbum
     * @return void
     */
    public static function deleteFavAlbumByIdAlbum(int $idAlbum): void {
        $sql = "DELETE FROM favAlbum WHERE idAlbum = :idAlbum";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idAlbum", $idAlbum);
        $stmt->execute();
    }
}