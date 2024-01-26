<?php

declare(strict_types=1);

namespace models;

class favAlbum {

    private int $idU;

    private int $idAlbum;

    /**
     * favAlbum constructor.
     * @param int $idU
     * @param int $idAlbum
     */
    public function __construct(int $idU, int $idAlbum) {
        $this->idU = $idU;
        $this->idAlbum = $idAlbum;
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
        $this->idAlbum = $idAlbum;
    }
}