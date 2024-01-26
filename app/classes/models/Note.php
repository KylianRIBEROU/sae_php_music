<?php 

declare(strict_types=1);

namespace models;

class Note {

    private int $idU;

    private int $idT;

    private int $note;

    /**
     * Note constructor.
     * @param int $idU
     * @param int $idT
     * @param int $note
     */
    public function __construct(int $idU, int $idT, int $note) {
        $this->idU = $idU;
        $this->idT = $idT;
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
    public function getIdT(): int {
        return $this->idT;
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
     * @param int $idT
     * @return void
     */
    public function setIdT(int $idT): void {
        $this->idT = $idT;
    }

    /**
     * @param int $note
     * @return void
     */
    public function setNote (int $note): void {
        $this->note = $note;
    }
}