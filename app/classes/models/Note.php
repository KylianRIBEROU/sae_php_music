<?php 

declare(strict_types=1);

namespace models;

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
        $this->$idAlbum = $idAlbum;
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
}