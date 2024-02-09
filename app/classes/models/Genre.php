<?php 

declare(strict_types=1);

namespace models;

use pdoFactory\PDOFactory;
use PDO;
use models\Detient;

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
    public static function existsById(int $idG): bool {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $pdo->prepare("SELECT * FROM genre WHERE idG = :idG");
        $req->bindParam(":idG", $idG);
        $req->execute();
        $genre = $req->fetch(PDO::FETCH_ASSOC);
        if ($genre) {
            return true;
        }
        return false;
    }

    public static function getGenreById(int $idG): Genre | null {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $pdo->prepare("SELECT * FROM genre WHERE idG = :idG");
        $req->bindParam(":idG", $idG);
        $req->execute();
        $genre = $req->fetch(PDO::FETCH_ASSOC);

        if ($genre) {
            return new Genre((int)$genre['idG'], $genre['nomG']);
        }
        return null;
    }

    public static function getAllGenres(): array {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $pdo->prepare("SELECT * FROM genre");
        $req->execute();
        $genres = $req->fetchAll(PDO::FETCH_ASSOC);
        $tabGenres = [];

        foreach ($genres as $genre) {
            $tabGenres[] = new Genre((int)$genre['idG'], $genre['nomG']);
        }
        return $tabGenres;
    }

    public static function getGenresByIdAlbum(int $idAlbum): array {
        $liste_detient = Detient::getDetientByIdAlbum($idAlbum);
        $tabGenres = [];
        foreach ($liste_detient as $detient) {
            array_push($tabGenres, self::getGenreById($detient->getIdG())); 
        }
        return $tabGenres;
    }
    
    public function create(): bool {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $pdo->prepare("INSERT INTO genre (nomG) VALUES (:nomG)");
        $req->bindParam(":nomG", $this->nomG);
        $req->execute();
        $this->idG = (int)$pdo->lastInsertId();
        return true;
    }

    public function update(): bool {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $pdo->prepare("UPDATE genre SET nomG = :nomG WHERE idG = :idG");
        $req->bindParam(":nomG", $this->nomG);
        $req->bindParam(":idG", $this->idG);
        $req->execute();
        return true;
    }

    public static function deleteById(int $idG): bool {
        Detient::deleteDetientByIdG($idG);

        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $pdo->prepare("DELETE FROM genre WHERE idG = :idG");
        $req->bindParam(":idG", $idG);
        return $req->execute();
    }

    public function delete(): bool {
        Detient::deleteDetientByIdG($this->idG);

        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $pdo->prepare("DELETE FROM genre WHERE idG = :idG");
        $req->bindParam(":idG", $this->idG);
        $req->execute();
        return true;
    }

    public static function deleteAll(): bool {
        Detient::deleteAll();

        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $req = $pdo->prepare("DELETE FROM genre");
        return $req->execute();  
    }
}