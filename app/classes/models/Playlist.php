<?php 

declare(strict_types=1);

namespace models;

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

}