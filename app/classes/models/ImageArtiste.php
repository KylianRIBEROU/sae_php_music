<?php 

declare(strict_types=1);

namespace models;

use pdoFactory\PDOFactory;
use PDO;

class ImageArtiste {

    private int $idImage;

    private string $lienImage;

    private int $pos;

    private int $idA;

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
    
    public static function getImagesArtisteById(int $idA):array{
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $sql = "SELECT * FROM image WHERE idA = :idA";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":idA", $idA);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $images = [];
        foreach ($data as $d){
            $images[] = new ImageArtiste($d['idImage'], $d['lienImage'], $d['pos'], $d['idA']);
        }
        return $images;
    }

    public function create(): bool {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $sql = "INSERT INTO image (lienImage, pos, idA) VALUES (:lienImage, :pos, :idA)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":lienImage", $this->lienImage);
        $stmt->bindValue(":pos", $this->pos);
        $stmt->bindValue(":idA", $this->idA);
        return $stmt->execute();
    }

    public function update(): bool {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $sql = "UPDATE image SET lienImage = :lienImage, pos = :pos, idA = :idA WHERE idImage = :idImage";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":lienImage", $this->lienImage);
        $stmt->bindValue(":pos", $this->pos);
        $stmt->bindValue(":idA", $this->idA);
        $stmt->bindValue(":idImage", $this->idImage);
        return $stmt->execute();
    }

    public function delete(): bool {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $sql = "DELETE FROM image WHERE idImage = :idImage";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":idImage", $this->idImage);
        return $stmt->execute();
    }

    public static function deleteImageArtisteByIdA(int $idA): bool {
        $liste_imagesArtistes = ImageArtiste::getImagesArtisteById($idA);
        foreach ($liste_imagesArtistes as $imageArtiste){
            $imageArtiste->delete();
        }
        return true;
    }
}

