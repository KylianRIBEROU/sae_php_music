<?php 

declare(strict_types=1);

namespace models;

class Artiste {

    private int $idA;

    private string $nomA;

    // avec documentation

    /**
     * Artiste constructor.
     * @param int $idA
     * @param string $nomA
     */
    public function __construct(int $idA, string $nomA)
    {
        $this->idA = $idA;
        $this->nomA = $nomA;
    }

    /**
     * @return int
     */
    public function getIdA(): int
    {
        return $this->idA;
    }

    /**
     * @return string
     */
    public function getNomA(): string
    {
        return $this->nomA;
    }   

    /**
     * @param int $idA
     */
    public function setIdA(int $idA): void
    {
        $this->idA = $idA;
    }

    /**
     * @param string $nomA
     */
    public function setNomA(string $nomA): void
    {
        $this->nomA = $nomA;
    }

    public function __toString(): string
    {
        return $this->nomA;
    }
}