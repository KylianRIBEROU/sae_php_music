<?php 

declare(strict_types=1);

namespace db_models;

use PDO;
use db_models\NoteBD;
use db_models\FavAlbumBD;
use models\Album;
class AlbumBD {

    private PDO $db;

    private NoteBD $noteBD;

    private FavAlbumBD $favAlbumBD;

    /**
     * AlbumBD constructor.
     * @param PDO $db
     */
    public function __construct(PDO $db) {
        $this->db = $db;
        $this->noteBD = new NoteBD($db);
        $this->favAlbumBD = new FavAlbumBD($db);
    }

    /**
     * @param int $idAlbum
     * @return array
     */
    public function getAlbumById(int $idAlbum): Album | null {
        $sql = "SELECT * FROM album WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idAlbum", $idAlbum);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $album = new Album((int)$row["idAlbum"], $row["titreAlbum"], $row["anneeSortie"], $row["duree"], $row["idA"]);
            return $album;
        }
        return null;
    }

    /**
     * @param int $idA
     * @return array
     */
    public function getAlbumsByIdA(int $idA): array {
        $sql = "SELECT * FROM album WHERE idA = :idA";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idA", $idA);
        $stmt->execute();
        $albums = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $albums[] = new Album((int)$row["idAlbum"], $row["titreAlbum"], $row["anneeSortie"], $row["duree"], $row["idA"]);
        }
        return $albums;
    }

    /**
     * créer un album
     * @param Album $album
     */
    public function createAlbum(Album $album): void {
        $sql = "INSERT INTO album (titreAlbum, imageAlbum, anneeSortie, idA) VALUES (:titreAlbum, :imageAlbum, :anneeSortie, :idA)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":titreAlbum", $album->getTitreAlbum());
        $stmt->bindValue(":imageAlbum", $album->getImageAlbum());
        $stmt->bindValue(":anneeSortie", $album->getAnneeSortie());
        $stmt->bindValue(":idA", $album->getIdA());
        $stmt->execute();
    }

    /**
     * modifier un album
     * @param int $idAlbum 
     * @param Album $album
     */
    public function updateAlbum(int $idAlbum, Album $album): void {
        $sql = "UPDATE album SET titreAlbum = :titreAlbum, imageAlbum = :imageAlbum, anneeSortie = :anneeSortie, idA = :idA WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":titreAlbum", $album->getTitreAlbum());
        $stmt->bindValue(":imageAlbum", $album->getImageAlbum());
        $stmt->bindValue(":anneeSortie", $album->getAnneeSortie());
        $stmt->bindValue(":idA", $album->getIdA());
        $stmt->bindValue(":idAlbum", $idAlbum);
        $stmt->execute();
    }

    /**
     * @param int $idAlbum
     * @return bool
     */
    public function deleteAlbum(int $idAlbum): bool {
        // supprimer associations avant de supprimer l'album
        $this->noteBD->deleteNotesByIdAlbum($idAlbum);
        $this->favAlbumBD->deleteFavAlbumByIdAlbum($idAlbum);

        $sql = "DELETE FROM album WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idAlbum", $idAlbum);
        return $stmt->execute();

    }

    /**
     * supprimer albums d'un auteur
     * @param int $idA
     */
    public function deleteAlbumsByIdA(int $idA): void {
        $albums = $this->getAlbumsByIdA($idA);
        foreach ($albums as $album) {
            $this->deleteAlbum($album->getIdAlbum());
        }
    }



}