<?php

declare(strict_types=1);

namespace db_models;

use PDO;
use models\Note;

class NoteBD {

    private PDO $db;

    /**
     * NoteBD constructor, accesseur BD pour l'association entre un titre et un utilisateur, manyToMany
     * @param PDO $db
     */
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * @param int $idU
     * @param int $idAlbum
     * @return Note|null
     */
    public function getNote(int $idU, int $idAlbum): Note | null {
        $sql = "SELECT * FROM note WHERE idU = :idU AND idAlbum = :idAlbum";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idU", $idU);
        $stmt->bindValue(":idAlbum", $idAlbum);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            return null;
        }
        return new Note((int)$row["idU"], (int)$row["idAlbum"], (int)$row["note"]);

    }

    /**
     * @param int $idAlbum
     * @return array
     */
    public function getNotesByIdAlbum(int $idAlbum): array {
        $sql = "SELECT * FROM note WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idAlbum", $idAlbum);
        $stmt->execute();
        $notes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $notes[] = new Note((int)$row["idU"], (int)$row["idAlbum"], (int)$row["note"]);
        }
        return $notes;
    }

    /**
     * @param int $idU
     * @param int $idAlbum
     * @param int $note
     * @return bool
     */
    public function addNote(int $idU, int $idAlbum, int $note): bool {
        $sql = "INSERT INTO note (idU, idAlbum, note) VALUES (:idU, :idAlbum, :note)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idU", $idU);
        $stmt->bindValue(":idAlbum", $idAlbum);
        $stmt->bindValue(":note", $note);
        return $stmt->execute();
    }

    /**
     * @param int $idU
     * @param int $idAlbum
     * @param int $note
     * @return bool
     */
    public function updateNote(int $idU, int $idAlbum, int $note): bool {
        $sql = "UPDATE note SET note = :note WHERE idU = :idU AND idAlbum = :idAlbum";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idU", $idU);
        $stmt->bindValue(":idAlbum", $idAlbum);
        $stmt->bindValue(":note", $note);
        return $stmt->execute();
    }

    /**
     * @param int $idU
     * @param int $idAlbum
     * @return bool
     */
    public function deleteNote(int $idU, int $idAlbum): bool {
        $sql = "DELETE FROM note WHERE idU = :idU AND idAlbum = :idAlbum";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idU", $idU);
        $stmt->bindValue(":idAlbum", $idAlbum);
        return $stmt->execute();
    }

    /**
     * @param int $idAlbum
     * @return bool
     */
    public function deleteNotesByIdAlbum(int $idAlbum): bool {
        $sql = "DELETE FROM note WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idAlbum", $idAlbum);
        return $stmt->execute();
    
    }

    /**
     * @param int $idU
     * @return bool
     */
    public function deleteNotesByIdU(int $idU): bool {
        $sql = "DELETE FROM note WHERE idU = :idU";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idU", $idU);
        return $stmt->execute();
    }

}