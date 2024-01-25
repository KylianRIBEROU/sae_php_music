<?php 

declare(strict_types=1);

namespace models;

class ImageArtiste {

    private int $idImage;

    private string $lienImage;

    private int $pos;

    private int $idA;

    // avec documentation

    /**
     * ImageArtiste constructor.
     * @param int $idImage
     * @param string $lienImage
     * @param int $pos
     * @param int $idA
     */
    public function __construct(int $idImage, string $lienImage, int $pos, int $idA)
    {
        $this->idImage = $idImage;
        $this->lienImage = $lienImage;
        $this->pos = $pos;
        $this->idA = $idA;
    }

    /**
     * @return int
     */
    public function getIdImage(): int
    {
        return $this->idImage;
    }

    /**
     * @return string
     */
    public function getLienImage(): string
    {
        return $this->lienImage;
    }

    /**
     * @return int
     */
    public function getPos(): int
    {
        return $this->pos;
    }

    /**
     * @return int
     */
    public function getIdA(): int
    {
        return $this->idA;
    }

    /**
     * @param int $idImage
     */
    public function setIdImage(int $idImage): void
    {
        $this->idImage = $idImage;
    }

    /**
     * @param string $lienImage
     */
    public function setLienImage(string $lienImage): void
    {
        $this->lienImage = $lienImage;
    }

    /**
     * @param int $pos
     */
    public function setPos(int $pos): void
    {
        $this->pos = $pos;
    }

    /**
     * @param int $idA
     */
    public function setIdA(int $idA): void
    {
        $this->idA = $idA;
    }

    public function __toString(): string
    {
        return "ImageArtiste : $this->idImage, $this->lienImage, $this->pos, $this->idA";
    }
    
}