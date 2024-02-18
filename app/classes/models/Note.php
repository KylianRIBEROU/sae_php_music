<?php 

declare(strict_types=1);

namespace models;

use pdoFactory\PDOFactory;
use PDO;
use PDOException;

class Note {

    private int $idU;

    private int $idAlbum;

    private int $note;

    /**
     * Note constructor, association entre un album et un utilisateur, manyToMany, avec une note
     * @param int $idU
     * @param int $idAlbum
     * @param int $note
     */
    public function __construct(int $idU, int $idAlbum, int $note) {
        $this->idU = $idU;
        $this->idAlbum = $idAlbum;
        $this->note = $note;
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
     * @return int
     */
    public function getNote(): int {
        return $this->note;
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
        $this->$idAlbum = $idAlbum;
    }

    /**
     * @param int $note
     * @return void
     */
    public function setNote (int $note): void {
        $this->note = $note;
    }

    public static function getNoteByIdUAndidAlbum(int $idU, int $idAlbum): ?Note {
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("SELECT * FROM note WHERE idU = :idU AND idAlbum = :idAlbum");
        $req->bindParam(":idU", $idU);
        $req->bindParam(":idAlbum", $idAlbum);
        $req->execute();
        $noteBD = $req->fetch();
        if (!$noteBD){
            return null;
        }
        return new Note((int)$noteBD['idU'], (int)$noteBD['idAlbum'], (int)$noteBD['note']);
    }

    public static function getNotes(): array {
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("SELECT * FROM note");
        $req->execute();
        $notes = [];
        $notesBD = $req->fetchAll();
        foreach ($notesBD as $note) {
            $notes[] = new Note((int)$note['idU'], (int)$note['idAlbum'], (int)$note['note']);
        }
        return $notes;
    }

    public static function getNoteByAlbumId(int $idAlbum): array {
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("SELECT * FROM note WHERE idAlbum = :idAlbum");
        $req->bindParam(":idAlbum", $idAlbum);
        $req->execute();
        $notes = [];
        $notesBD = $req->fetchAll();
        foreach ($notesBD as $note) {
            $notes[] = new Note((int)$note['idU'], (int)$note['idAlbum'], (int)$note['note']);
        }
        return $notes;
    }

    public function create(): bool{
        $idU = $this->getIdU();
        $idAlbum = $this->getIdAlbum();
        $notep = $this->getNote();


        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("INSERT INTO note (idU, idAlbum, note) VALUES (:idU, :idAlbum, :note)");
        $req->bindParam(":idU", $idU);
        $req->bindParam(":idAlbum", $idAlbum);
        $req->bindParam(":note", $notep);
        return $req->execute();
    }

    public function update(): bool{
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("UPDATE note SET note = :note WHERE idU = :idU AND idAlbum = :idAlbum");
        $req->bindParam(":idU", $this->idU);
        $req->bindParam(":idAlbum", $this->idAlbum);
        $req->bindParam(":note", $this->note);
        return $req->execute();
    }

    public function delete(): bool{
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("DELETE FROM note WHERE idU = :idU AND idAlbum = :idAlbum");
        $req->bindParam(":idU", $this->idU);
        $req->bindParam(":idAlbum", $this->idAlbum);
        return $req->execute();
    }

    public static function deleteNoteByidAlbum(int $idAlbum): bool{
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("DELETE FROM note WHERE idAlbum = :idAlbum");
        $req->bindParam(":idAlbum", $idAlbum);
        return $req->execute();
    }

    public static function deleteNoteByidU(int $idU): bool{
        $db = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $db->prepare("DELETE FROM note WHERE idU = :idU");
        $req->bindParam(":idU", $idU);
        return $req->execute();
    }

}