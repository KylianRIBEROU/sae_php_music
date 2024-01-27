<?php

declare(strict_types=1);

namespace models;

class Album {

    private int $idAlbum;

    private string $titreAlbum;

    private string $imageAlbum;

    private int $anneeSortie;

    private int $idA;

    /**
     * Album constructor.
     * @param int $idAlbum
     * @param string $titreAlbum
     * @param string $imageAlbum
     * @param int $anneeSortie
     * @param int $idA
     */
    public function __construct(int $idAlbum, string $titreAlbum, string $imageAlbum, int $anneeSortie, int $idA) {
        $this->idAlbum = $idAlbum;
        $this->titreAlbum = $titreAlbum;
        $this->imageAlbum = $imageAlbum;
        $this->anneeSortie = $anneeSortie;
        $this->idA = $idA;
    }

    /**
     * @return int
     */
    public function getIdAlbum(): int {
        return $this->idAlbum;
    }

    /**
     * @return string
     */
    public function getTitreAlbum(): string {
        return $this->titreAlbum;
    }

    /**
     * @return string
     */
    public function getImageAlbum(): string {
        return $this->imageAlbum;
    }

    /**
     * @return int
     */
    public function getAnneeSortie(): int {
        return $this->anneeSortie;
    }

    /**
     * @return int
     */
    public function getIdA(): int {
        return $this->idA;
    }

    /**
     * @param int $idAlbum
     * @return void
     */
    public function setIdAlbum(int $idAlbum): void {
        $this->idAlbum = $idAlbum;

    }

    /**
     * @param string $titreAlbum
     * @return void
     */
    public function setTitreAlbum(string $titreAlbum): void {
        $this->titreAlbum = $titreAlbum;
    }

    /**
     * @param string $imageAlbum
     * @return void
     */
    public function setImageAlbum(string $imageAlbum): void {
        $this->imageAlbum = $imageAlbum;
    }

    /**
     * @param int $anneeSortie
     * @return void
     */
    public function setAnneeSortie(int $anneeSortie): void {
        $this->anneeSortie = $anneeSortie;
    }

    /**
     * @param int $idA
     * @return void
     */
    public function setIdA(int $idA): void {
        $this->idA = $idA;
    } 
}