<?php 

declare(strict_types=1);

namespace models;

class Genre {

    private int $idG;

    private string $nomG;

    // avec documentation

    /**
     * Genre constructor.
     * @param int $idG
     * @param string $nomG
     */
    public function __construct(int $idG, string $nomG)
    {
        $this->idG = $idG;
        $this->nomG = $nomG;
    }

    /**
     * @return int
     */
    public function getIdG(): int
    {
        return $this->idG;
    }

    /**
     * @return string
     */
    public function getNomG(): string
    {
        return $this->nomG;
    }

    /**
     * @param int $idG
     */
    public function setIdG(int $idG): void
    {
        $this->idG = $idG;
    }

    /**
     * @param string $nomG
     */
    public function setNomG(string $nomG): void
    {
        $this->nomG = $nomG;
    }

    public function __toString(): string
    {
        return $this->nomG;
    }
}