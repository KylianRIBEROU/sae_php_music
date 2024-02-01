<?php 

declare(strict_types=1);

namespace models;
use pdoFactory\PDOFactory;
class Playlist {

    private int $idP;

    private string $nomP;


    private int $idU;

    /**
     * Playlist constructor.
     * @param int $idP
     * @param string $nomP
     * @param int $idU
     */
    public function __construct(int $idP, string $nomP, int $idU) {
        $this->idP = $idP;
        $this->nomP = $nomP;
        $this->idU = $idU;
    }

    /**
     * @return int
     */
    public function getIdP(): int {
        return $this->idP;
    }

    /**
     * @return string
     */

    public function getNomP(): string {
        return $this->nomP;
    }

    /**
     * @return int
     */
    public function getIdU(): int {
        return $this->idU;
    }

    /**
     * @param int $idP
     * @return void
     */
    public function setIdP(int $idP): void {
        $this->idP = $idP;
    }

    /**
     * @param string $nomP
     * @return void
     */
    public function setNomP(string $nomP): void {
        $this->nomP = $nomP;
    }

    /**
     * @param int $idU
     * @return void
     */
    public function setIdU(int $idU): void {
        $this->idU = $idU;
    }

    /**
     * @param int $idU
     * @return array
     */
    public static function getPlaylistsByIdU(int $idU): array {
        $sql = "SELECT * FROM playlist WHERE idU = :idU";
        $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($sql);
        $stmt->bindValue(":idU", $idU);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
    public static function getPlaylistById(int $idP): Playlist {
        $sql = "SELECT * FROM playlist WHERE idP = :idP";
        $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($sql);
        $stmt->bindValue(":idP", $idP);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return new Playlist((int)$result["idP"], $result["nomP"], (int)$result["idU"]);
    }

    /**
     * @param int $idU
     * @param string $nomP
     * @return int
     */
    public function create(int $idU, string $nomP): int {
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $sql = "INSERT INTO playlist (nomP, idU) VALUES (:nomP, :idU)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":nomP", $nomP);
        $stmt->bindValue(":idU", $idU);
        $stmt->execute();
        return (int)$db->lastInsertId();
    }

    /**
     * @param int $idP
     * @param string $nomP
     * @return void
     */
    public function update(int $idP, string $nomP): void {
        $sql = "UPDATE playlist SET nomP = :nomP WHERE idP = :idP";
        $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($sql);
        $stmt->bindValue(":nomP", $nomP);
        $stmt->bindValue(":idP", $idP);
        $stmt->execute();
    }

    /**
     * @param int $idP
     * @return void
     */
    public static function deleteById(int $idP): void {
        // Supprimer les associations de la table appartient avant de supprimer la playlist
        Appartient::deleteAppartientByIdP($idP);
    
        $sql = "DELETE FROM playlist WHERE idP = :idP";
        $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($sql);
        $stmt->bindValue(":idP", $idP);
        $stmt->execute();
    }

    public function delete(): void {
        $this->deleteById($this->idP);
    }

    /**
     * @param int $idU
     * @return void
     */
    public static function deleteAllPlaylistsByIdU(int $idU): void {
        $playlists = self::getPlaylistsByIdU($idU);
        foreach ($playlists as $playlist) {
            self::deleteById($playlist->getIdP());
        }
    }

    /**
     * @param int $idP
     * @param int $idT
     * @return bool
     */
    public function addTitreToPlaylist(int $idP, int $idT): bool {
        return (new Appartient($idP, $idT))->create();
    }

    /**
     * @param int $idP
     * @param int $idT
     * @return bool
     */
    public function removeTitreFromPlaylist(int $idP, int $idT): bool {
        return (new Appartient($idP, $idT))->delete();
    }

}