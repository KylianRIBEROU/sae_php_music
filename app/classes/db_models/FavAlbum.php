<?php 

declare(strict_types=1);

namespace db_models;

use PDO;
use models\favAlbum;

class FavAlbumBD {
    
        /**
        * @var PDO
        */
        private PDO $db;
    
        /**
        * TitreBD constructeur, accesseur BD pour l'association entre un album et un utilisateur, manyToMany
        * @param PDO $db
        */
        public function __construct(PDO $db) {
            $this->db = $db;
        }
    
        /**
        * @param int $idU
        * @param int $idAlbum
        * @return favAlbum
        */
        public function getFavAlbum(int $idU, int $idAlbum): favAlbum {
            $sql = "SELECT * FROM favAlbum WHERE idU = :idU AND idAlbum = :idAlbum";
            $stmt = $this->db->prepare($sql);
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
        public function getFavAlbums(int $idU): array {
            $sql = "SELECT * FROM favAlbum WHERE idU = :idU";
            $stmt = $this->db->prepare($sql);
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
        public function addFavAlbum(int $idU, int $idAlbum): bool {
            $sql = "INSERT INTO favAlbum (idU, idAlbum) VALUES (:idU, :idAlbum)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":idU", $idU);
            $stmt->bindValue(":idAlbum", $idAlbum);
            return $stmt->execute();
        }
    
        /**
        * @param int $idU
        * @param int $idAlbum
        * @return bool
        */
        public function deleteFavAlbum(int $idU, int $idAlbum): bool {
            $sql = "DELETE FROM favAlbum WHERE idU = :idU AND idAlbum = :idAlbum";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":idU", $idU);
            $stmt->bindValue(":idAlbum", $idAlbum);
            return $stmt->execute();
        }

        /**
         * supprime tous les favoris d'un utilisateur
         * @param int $idU
         */
        public function deleteFavAlbumByIdU(int $idU): void {
            $sql = "DELETE FROM favAlbum WHERE idU = :idU";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":idU", $idU);
            $stmt->execute();

        }

        /**
         * supprime tous les favoris d'un album
         * @param int $idAlbum
         */
        public function deleteFavAlbumByIdAlbum(int $idAlbum): void {
            $sql = "DELETE FROM favAlbum WHERE idAlbum = :idAlbum";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":idAlbum", $idAlbum);
            $stmt->execute();
    }

}