<?php

declare(strict_types=1);

namespace models;

use pdoFactory\PDOFactory;
use PDO;
use PDOException;
class Detient{

    private int $idG;

    private int $idAlbum;


    /**
     * Detient constructeur: association  entre un album et un genre, un titre détient un genre
     * @param int $idG
     * @param int $idAlbum
     */
    public function __construct(int $idG, int $idAlbum)
    {
        $this->idG = $idG;
        $this->idAlbum = $idAlbum;
    }

    /**
     * @return int
     */
    public function getIdG(): int
    {
        return $this->idG;
    }

    /**
     * @return int
     */
    public function getidAlbum(): int
    {
        return $this->idAlbum;
    }

    public static function getDetient(int $idG, int $idAlbum): Detient | null {
        $sql = "SELECT * FROM detient WHERE idG = :idG AND idAlbum = :idAlbum";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idG", $idG);
        $stmt->bindValue(":idAlbum", $idAlbum);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            return null;
        }
        return new Detient((int)$row["idG"], (int)$row["idAlbum"]);
    }

    public static function getDetientByIdG(int $idG): array {
        $sql = "SELECT * FROM detient WHERE idG = :idG";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idG", $idG);
        $stmt->execute();
        $detient = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $detient[] = new Detient((int)$row["idG"], (int)$row["idAlbum"]);
        }
        return $detient;
    }

    public static function getDetientByIdAlbum(int $idAlbum): array {
        $sql = "SELECT * FROM detient WHERE idAlbum = :idAlbum";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idAlbum", $idAlbum);
        $stmt->execute();
        $detient = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $detient[] = new Detient((int)$row["idG"], (int)$row["idAlbum"]);
        }
        return $detient;
    }

    public function save(): bool {
        $sql = "INSERT INTO detient (idG, idAlbum) VALUES (:idG, :idAlbum)";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idG", $this->idG);
        $stmt->bindValue(":idAlbum", $this->idAlbum);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update(): bool {
        $sql = "UPDATE detient SET idG = :idG, idAlbum = :idAlbum WHERE idG = :idG AND idAlbum = :idAlbum";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idG", $this->idG);
        $stmt->bindValue(":idAlbum", $this->idAlbum);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete(): bool {
        $sql = "DELETE FROM detient WHERE idG = :idG AND idAlbum = :idAlbum";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idG", $this->idG);
        $stmt->bindValue(":idAlbum", $this->idAlbum);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function deleteAll(): bool {
        $sql = "DELETE FROM detient";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }


    /**
     * Supprime toutes les associations Detient avec un genre donné
     * ( un genre peut etre associé à un ou plusieurs albums)
     */
    public static function deleteDetientByIdG(int $idG): bool {
        $sql = "DELETE FROM detient WHERE idG = :idG";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idG", $idG);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Supprime toutes les associations Detient avec un album donné
     *  ( un album peut etre associé à un ou plusieurs genres)
     */
    public static function deleteDetientByIdAlbum(int $idAlbum): bool {
        $sql = "DELETE FROM detient WHERE idAlbum = :idAlbum";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idAlbum", $idAlbum);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}