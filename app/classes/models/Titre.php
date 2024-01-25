<?php

declare(strict_types=1);

namespace models;

class Titre {

    private int $idT;

    private string $labelT;

    private int $anneeSortie;

    private int $duree;
    private int $idA;

    // avec documentation

    /**
     * Titre constructor.
     * @param int $idT
     * @param string $labelT
     * @param int $anneeSortie
     * @param int $duree
     * @param int $idA
     */
    public function __construct(int $idT, string $labelT, int $anneeSortie, int $duree, int $idA)
    {
        $this->idT = $idT;
        $this->labelT = $labelT;
        $this->anneeSortie = $anneeSortie;
        $this->duree = $duree;
        $this->idA = $idA;
    }

    /**
     * @return int
     */
    public function getIdT(): int
    {
        return $this->idT;
    }

    /**
     * @return string
     */
    public function getLabelT(): string
    {
        return $this->labelT;
    }

    /**
     * @return int
     */
    public function getAnneeSortie(): int
    {
        return $this->anneeSortie;
    }

    /**
     * @return int
     */
    public function getDuree(): int
    {
        return $this->duree;
    }

    /**
     * @return int
     */
    public function getIdA(): int
    {
        return $this->idA;
    }

    /**
     * @param int $idT
     */
    public function setIdT(int $idT): void
    {
        $this->idT = $idT;
    }

    /**
     * @param string $labelT
     */
    public function setLabelT(string $labelT): void
    {
        $this->labelT = $labelT;
    }

    /**
     * @param int $anneeSortie
     */
    public function setAnneeSortie(int $anneeSortie): void
    {
        $this->anneeSortie = $anneeSortie;
    }

    /**
     * @param int $duree
     */
    public function setDuree(int $duree): void
    {
        $this->duree = $duree;
    }

    /**
     * @param int $idA
     */
    public function setIdA(int $idA): void
    {
        $this->idA = $idA;
    }
    
}