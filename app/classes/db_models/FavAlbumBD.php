<?php 

declare(strict_types=1);

namespace db_models;

use PDO;
use pdoFactory\PDOFactory;

class FavAlbumBD {
    
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
    
    /**
     * @param int $idU
     * @param int $idAlbum
     * @return bool
     */
    public static function addFavAlbum(int $idU, int $idAlbum): bool {
        $sql = "INSERT INTO favAlbum (idU, idAlbum) VALUES (:idU, :idAlbum)";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idU", $idU);
        $stmt->bindValue(":idAlbum", $idAlbum);
        return $stmt->execute();
    }
    
    /**
     * //TODO: CR en static, UD en non static car on interagit avec l'objet 
     * @param int $idU
     * @param int $idAlbum
     * @return bool
     */
    public static function deleteFavAlbum(int $idU, int $idAlbum): bool {
        $sql = "DELETE FROM favAlbum WHERE idU = :idU AND idAlbum = :idAlbum";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idU", $idU);
        $stmt->bindValue(":idAlbum", $idAlbum);
        return $stmt->execute();
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
    }
