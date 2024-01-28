<?php

declare(strict_types=1);

namespace db_models;

use PDO;

use models\Playlist;
class PlaylistBD {

    private PDO $db;

    private AppartientBD $appartientBD;
    /**
     * PlaylistBD constructor.
     * @param PDO $db
     */
    public function __construct(PDO $db) {
        $this->db = $db;
        $this->appartientBD = new AppartientBD($db);
    }

    /**
     * @param int $idU
     * @return array
     */
    public function getPlaylistsByIdU(int $idU): array {
        $sql = "SELECT * FROM playlist WHERE idU = :idU";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idU", $idU);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $playlists = [];
        foreach ($result as $row) {
            $playlists[] = new Playlist((int)$row["idP"], $row["nomP"], (int)$row["idU"]);
        }
        return $playlists;
    }

    /**
     * @param int $idP
     * @return Playlist
     */
    public function getPlaylistById(int $idP): Playlist {
        $sql = "SELECT * FROM playlist WHERE idP = :idP";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idP", $idP);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Playlist((int)$result["idP"], $result["nomP"], (int)$result["idU"]);
    }

    /**
     * @param int $idU
     * @param string $nomP
     * @return int
     */
    public function createPlaylist(int $idU, string $nomP): int {
        $sql = "INSERT INTO playlist (nomP, idU) VALUES (:nomP, :idU)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":nomP", $nomP);
        $stmt->bindValue(":idU", $idU);
        $stmt->execute();
        return (int)$this->db->lastInsertId();
    }

    /**
     * @param int $idP
     * @param string $nomP
     * @return void
     */
    public function updatePlaylist(int $idP, string $nomP): void {
        $sql = "UPDATE playlist SET nomP = :nomP WHERE idP = :idP";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":nomP", $nomP);
        $stmt->bindValue(":idP", $idP);
        $stmt->execute();
    }

    /**
     * @param int $idP
     * @return void
     */
    public function deletePlaylist(int $idP): void {
        // Supprimer les associations de la table appartient avant de supprimer la playlist
        $this->appartientBD->deleteAppartientByIdP($idP);
    
        $sql = "DELETE FROM playlist WHERE idP = :idP";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idP", $idP);
        $stmt->execute();
    }

    /**
     * @param int $idU
     * @return void
     */
    public function deleteAllPlaylistsByIdU(int $idU): void {
        $playlists = $this->getPlaylistsByIdU($idU);
        foreach ($playlists as $playlist) {
            $this->deletePlaylist($playlist->getIdP());
        }
    }

    /**
     * @param int $idP
     * @param int $idT
     * @return bool
     */
    public function addTitreToPlaylist(int $idP, int $idT): bool {
        return $this->appartientBD->createAppartient($idP, $idT);
    }

    /**
     * @param int $idP
     * @param int $idT
     * @return bool
     */
    public function removeTitreFromPlaylist(int $idP, int $idT): bool {
        return $this->appartientBD->deleteAppartient($idP, $idT);
    }

}

