<?php

declare(strict_types=1);

namespace models;
use pdoFactory\PDOFactory;
class Album {

    private int $idAlbum;

    private string $titreAlbum;

    private string $imageAlbum;

    private int $anneeSortie;

    private int $idA;

    /**
     * Album constructor.
     * @param int $idAlbum
     * @param string $titreAlbum
     * @param string $imageAlbum
     * @param int $anneeSortie
     * @param int $idA
     */
    public function __construct(int $idAlbum, string $titreAlbum, mixed $imageAlbum, int $anneeSortie, int $idA) {
        $this->idAlbum = $idAlbum;
        $this->titreAlbum = $titreAlbum;
        if (empty($imageAlbum)) {
            $imageAlbum = "default.png";
        }
        $this->imageAlbum = $imageAlbum;
        $this->anneeSortie = $anneeSortie;
        $this->idA = $idA;
    }

    /**
     * @return int
     */
    public function getIdAlbum(): int {
        return $this->idAlbum;
    }

    /**
     * @return string
     */
    public function getTitreAlbum(): string {
        return $this->titreAlbum;
    }

    /**
     * @return string
     */
    public function getImageAlbum(): string {
        return $this->imageAlbum;
    }

    /**
     * @return int
     */
    public function getAnneeSortie(): int {
        return $this->anneeSortie;
    }

    /**
     * @return int
     */
    public function getIdA(): int {
        return $this->idA;
    }

    /**
     * @param int $idAlbum
     * @return void
     */
    public function setIdAlbum(int $idAlbum): void {
        $this->idAlbum = $idAlbum;

    }

    /**
     * @param string $titreAlbum
     * @return void
     */
    public function setTitreAlbum(string $titreAlbum): void {
        $this->titreAlbum = $titreAlbum;
    }

    /**
     * @param string $imageAlbum
     * @return void
     */
    public function setImageAlbum(string $imageAlbum): void {
        $this->imageAlbum = $imageAlbum;
    }

    /**
     * @param int $anneeSortie
     * @return void
     */
    public function setAnneeSortie(int $anneeSortie): void {
        $this->anneeSortie = $anneeSortie;
    }

    /**
     * @param int $idA
     * @return void
     */
    public function setIdA(int $idA): void {
        $this->idA = $idA;
    } 
    

    /**
     * Renvoie une liste contenant tous les albums
     * @return array
     */
    public static function getAllAlbums(): array {
        $sql = "SELECT * FROM album";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->query($sql);
        $albums = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $albums[] = new Album((int)$row["idAlbum"], $row["titreAlbum"], $row["imageAlbum"], $row["anneeSortie"], $row["idA"]);
        }
        return $albums;
    }

    /**
     * @param int $idAlbum
     * @return array
     */
    public static function getAlbumById(int $idAlbum): Album | null {
        $sql = "SELECT * FROM album WHERE idAlbum = :idAlbum";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idAlbum", $idAlbum);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
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
    public static function getAlbumsByIdA(int $idA): array {
        $sql = "SELECT * FROM album WHERE idA = :idA";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idA", $idA);
        $stmt->execute();
        $albums = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $albums[] = new Album((int)$row["idAlbum"], $row["titreAlbum"], $row["anneeSortie"], $row["duree"], $row["idA"]);
        }
        return $albums;
    }

    /**
     * créer un album
     */
    public function create(): void {
        $sql = "INSERT INTO album (titreAlbum, imageAlbum, anneeSortie, idA) VALUES (:titreAlbum, :imageAlbum, :anneeSortie, :idA)";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);        
        $stmt->bindValue(":titreAlbum", $this->getTitreAlbum());
        $stmt->bindValue(":imageAlbum", $this->getImageAlbum());
        $stmt->bindValue(":anneeSortie", $this->getAnneeSortie());
        $stmt->bindValue(":idA", $this->getIdA());
        $stmt->execute();
    }

    /**
     * modifier un album
     * @param Album $album
     */
    public function update(): void {
        $sql = "UPDATE album SET titreAlbum = :titreAlbum, imageAlbum = :imageAlbum, anneeSortie = :anneeSortie, idA = :idA WHERE idAlbum = :idAlbum";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":titreAlbum", $this->getTitreAlbum());
        $stmt->bindValue(":imageAlbum", $this->getImageAlbum());
        $stmt->bindValue(":anneeSortie", $this->getAnneeSortie());
        $stmt->bindValue(":idA", $this->getIdA());
        $stmt->bindValue(":idAlbum", $this->getIdAlbum());
        $stmt->execute();
    }

    /**
     * @param int $idAlbum
     * @return bool
     */
    public static function deleteById(int $idAlbum): bool {
        // supprimer associations avant de supprimer l'album

        Detient::deleteDetientByIdAlbum($idAlbum);
        Note::deleteNoteByidAlbum($idAlbum);
        FavAlbum::deleteFavAlbumByIdAlbum($idAlbum);

        $sql = "DELETE FROM album WHERE idAlbum = :idAlbum";
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idAlbum", $idAlbum);
        return $stmt->execute();

    }

    public function delete(){
        $this->deleteById($this->getIdAlbum());
    }
    /**
     * supprimer albums d'un auteur
     * @param int $idA
     */
    public static function deleteAlbumsByIdA(int $idA): void {
        $albums = self::getAlbumsByIdA($idA);
        foreach ($albums as $album) {
            Album::deleteById($album->getIdAlbum());
        }
    }
}