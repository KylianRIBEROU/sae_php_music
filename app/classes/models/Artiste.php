<?php 

declare(strict_types=1);

namespace models;

use pdoFactory\PDOFactory;
use models\ImageArtiste;
use models\Album;
use models\Titre;
use PDO;
use PDOException;
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

    public static function getArtisteById(int $idA): Artiste
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $sql = "SELECT * FROM artiste WHERE idA = :idA";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':idA', $idA, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            throw new PDOException("Erreur : l'artiste n'existe pas");
        }
        return new Artiste($row['idA'], $row['nomA']);
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
            $artistes[] = new Artiste($row['idA'], $row['nomA']);
        }
        return $artistes;
    }

    public function create(): bool 
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $sql = "INSERT INTO artiste (nomA) VALUES (:nomA)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nomA', $this->nomA, PDO::PARAM_STR);
        return $stmt->execute();     
    }

    public function update(): bool 
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $sql = "UPDATE artiste SET nomA = :nomA WHERE idA = :idA";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nomA', $this->nomA, PDO::PARAM_STR);
        $stmt->bindValue(':idA', $this->idA, PDO::PARAM_INT);
        return $stmt->execute();     
    }

    public function delete(): bool 
    {
        // supprimer associations artiste
        ImageArtiste::deleteImageArtisteByIdA($this->idA);
        Album::deleteAlbumsByIdA($this->idA);
        Titre::deleteTitresByIdA($this->idA);

        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $sql = "DELETE FROM artiste WHERE idA = :idA";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':idA', $this->idA, PDO::PARAM_INT);
        return $stmt->execute();     
    }






}