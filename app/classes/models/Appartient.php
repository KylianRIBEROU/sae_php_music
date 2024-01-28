<?php 

declare(strict_types=1);

namespace models;

class Appartient {

    private int $idP;

    private int $idT;

    /**
     * Appartient constructor. association entre titre et playlist, manyToMany
     * @param int $idP
     * @param int $idT
     */
    public function __construct(int $idP, int $idT) {
        $this->idP = $idP;
        $this->idT = $idT;
    }

    /**
     * @return int
     */
    public function getIdP(): int {
        return $this->idP;
    }

    /**
     * @return int
     */
    public function getIdT(): int {
        return $this->idT;
    }

    /**
     * @param int $idP
     * @return void
     */
    public function setIdP(int $idP): void {
        $this->idP = $idP;

    }

    /**
     * @param int $idT
     * @return void
     */
    public function setIdT(int $idT): void {
        $this->idT = $idT;
    }

}