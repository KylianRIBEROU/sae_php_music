<?php 

declare(strict_types=1);

namespace models;

use pdoFactory\PDOFactory;
use models\Album;
use models\Titre;
use PDO;
use PDOException;
class Artiste {

    private int $idA;

    private string $nomA;

    private string $imageA;

    // avec documentation

    /**
     * Artiste constructor.
     * @param int $idA
     * @param string $nomA
     * @param string $imageA
     */
    public function __construct(int $idA, string $nomA, mixed $imageA) {
        $this->idA = $idA;
        $this->nomA = $nomA;
        if ( $imageA === null || $imageA === "") {
            $this->imageA = "default.jpg";
        } else {
            $this->imageA = $imageA;
        }
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
     * @return string
     */
    public function getImageA(): string
    {
        return $this->imageA;
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

    /**
     * @param string $imageA
     */
    public function setImageA(string $imageA): void
    {
        $this->imageA = $imageA;
    }

    public function __toString(): string
    {
        return $this->nomA;
    }

    public static function getArtisteById(int $idA): Artiste | null
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $sql = "SELECT * FROM artiste WHERE idA = :idA";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':idA', $idA, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            return null;
        }
        return new Artiste($row['idA'], $row['nomA'], $row['imageA']);
    }

    public static function getArtisteByNom(string $nomA): Artiste | null
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $sql = "SELECT * FROM artiste WHERE nomA = :nomA";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nomA', $nomA, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            return null;
        }
        return new Artiste($row['idA'], $row['nomA'], $row['imageA']);
    }

    public static function getAllArtistes(): array
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $sql = "SELECT * FROM artiste";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $artistes = [];
        foreach ($rows as $row) {
            $artistes[] = new Artiste($row['idA'], $row['nomA'], $row['imageA']);
        }
        return $artistes;
    }

    public function create(): bool 
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $sql = "INSERT INTO artiste (nomA, imageA) VALUES (:nomA, :imageA)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nomA', $this->nomA, PDO::PARAM_STR);
        $stmt->bindValue(':imageA', $this->imageA, PDO::PARAM_STR);
        return $stmt->execute();     
    }

    public function update(): bool 
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $sql = "UPDATE artiste SET nomA = :nomA, imageA = :imageA WHERE idA = :idA";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nomA', $this->nomA, PDO::PARAM_STR);
        $stmt->bindValue(':imageA', $this->imageA, PDO::PARAM_STR);
        $stmt->bindValue(':idA', $this->idA, PDO::PARAM_INT);
        return $stmt->execute();     
    }

    public function delete(): bool 
    {
        // supprimer associations artiste
        Album::deleteAlbumsByIdA($this->idA);
        Titre::deleteTitresByIdA($this->idA);

        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $sql = "DELETE FROM artiste WHERE idA = :idA";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':idA', $this->idA, PDO::PARAM_INT);
        return $stmt->execute();     
    }
}