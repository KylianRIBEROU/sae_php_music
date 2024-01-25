<?php

declare(strict_types=1);

namespace models;

class Detient{

    private int $idG;

    private int $idT;


    /**
     * Detient constructor.
     * @param int $idG
     * @param int $idT
     */
    public function __construct(int $idG, int $idT)
    {
        $this->idG = $idG;
        $this->idT = $idT;
    }

    /**
     * @return int
     */
    public function getIdG(): int
    {
        return $this->idG;
    }

    /**
     * @return int
     */
    public function getIdT(): int
    {
        return $this->idT;
    }

    
}