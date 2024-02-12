<?php

declare(strict_types=1);

namespace models;
use pdoFactory\PDOFactory;
use models\Appartient;
class Titre {

    private int $idT;

    private string $labelT;

    private int $anneeSortie;

    private string $duree;

    private string $url;
    
    private int $idA;

    private int $idAlbum;

    // avec documentation

    /**
     * Titre constructor.
     * @param int $idT
     * @param string $labelT
     * @param int $anneeSortie
     * @param string $duree
     * @param string $url
     * @param int $idA
     * @param int $idAlbum
     */
    public function __construct(int $idT, string $labelT, int $anneeSortie, string $duree, mixed $url , int $idA, int $idAlbum = null)
    {
        $this->idT = $idT;
        $this->labelT = $labelT;
        $this->anneeSortie = $anneeSortie;
        $this->duree = $duree;
        if ($url === null) {
            $this->url = "nosoundtrack.mp3";
        } else {
            $this->url = $url;
        }
        $this->idA = $idA;
        $this->idAlbum = $idAlbum;
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
    public function getDuree(): string
    {
        return $this->duree;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getIdA(): int
    {
        return $this->idA;
    }

    /**
     * @return int | null
     */
    public function getIdAlbum(): int
    {
        return $this->idAlbum;
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
     * @param string $duree
     */
    public function setDuree(string $duree): void
    {
        $this->duree = $duree;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @param int $idA
     */
    public function setIdA(int $idA): void
    {
        $this->idA = $idA;
    }
    
    /**
     * @param int $idAlbum
     */
    public function setIdAlbum(int $idAlbum): void
    {
        $this->idAlbum = $idAlbum;
    }

    /**
     * get tous les titres
     * return @array
     */
    public static function getAllTitres(): array {
        $query = "SELECT * FROM titre";
        $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->query($query);
        $titres = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $titres[] = new Titre($row["idT"], $row["labelT"], $row["anneeSortie"], $row["duree"],  $row["url"], $row["idA"], $row["idAlbum"]);
        }
        return $titres;
    }
    
    /**
     * @param int $idT
     * @return Titre|null
     */
    public static function getTitreById(int $idT): Titre | null {
        $query = "SELECT * FROM titre WHERE idT = :idT";
        $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($query);
        $stmt->bindValue(":idT", $idT);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            $titre = new Titre($row["idT"], $row["labelT"], $row["anneeSortie"], $row["duree"], $row["url"], $row["idA"], $row["idAlbum"]);
            return $titre;
        }
        return null;

    }

    /**
     * @param int $idA
     * @return array
     */
    public static function getTitresByAuteurId(int $idA): array {
        $query = "SELECT * FROM titre WHERE idA = :idA";
        $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($query);
        $stmt->bindValue(":idA", $idA);
        $stmt->execute();
        $titres = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $titres[] = new Titre($row["idT"], $row["labelT"], $row["anneeSortie"], $row["duree"], $row["url"], $row["idA"], $row["idAlbum"]);
        }
        return $titres;
    }

    public static function getTitresByIdP(int $idP){
        $liste_appartient = Appartient::getAppartientsByIdP($idP);
        $titres = [];
        foreach ($liste_appartient as $appartient){
            array_push($titres, self::getTitreById($appartient->getIdT()));
        }
        return $titres;
    }

    /**
     * @param int $idAlbum
     * @return array
     */
    public static function getTitresByAlbumId(int $idAlbum): array {
        $query = "SELECT * FROM titre WHERE idAlbum = :idAlbum";
        $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($query);
        $stmt->bindValue(":idAlbum", $idAlbum);
        $stmt->execute();
        $titres = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $titres[] = new Titre($row["idT"], $row["labelT"], $row["anneeSortie"], $row["duree"], $row["url"], $row["idA"], $row["idAlbum"]);
        }
        return $titres;
    }

    /**
     * Crée un titre dans la base de données.
     */
    public function create(): void {
        $query = "INSERT INTO titre (labelT, anneeSortie, duree, url, idA, idAlbum) VALUES (:labelT, :anneeSortie, :duree, :url, :idA, :idAlbum)";
        $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($query);
        $stmt->bindValue(":labelT", $this->getLabelT());
        $stmt->bindValue(":anneeSortie", $this->getAnneeSortie());
        $stmt->bindValue(":duree", $this->getDuree());
        $stmt->bindValue(":url", $this->getUrl());
        $stmt->bindValue(":idA", $this->getIdA());
        $stmt->bindValue(":idAlbum", $this->getIdAlbum());
        $stmt->execute();
    }

    /**
     * Met à jour un titre dans la base de données.
     * @param Titre $titre
     */
    public function update(int $idT, Titre $titre): void {
        $query = "UPDATE titre SET labelT = :labelT, anneeSortie = :anneeSortie, duree = :duree, url = :url, idA = :idA, idAlbum = :idAlbum WHERE idT = :idT";
        $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($query);
        $stmt->bindValue(":idT", $idT);
        $stmt->bindValue(":labelT", $titre->getLabelT());
        $stmt->bindValue(":anneeSortie", $titre->getAnneeSortie());
        $stmt->bindValue(":duree", $titre->getDuree());
        $stmt->bindValue(":url", $titre->getUrl());
        $stmt->bindValue(":idA", $titre->getIdA());
        $stmt->bindValue(":idAlbum", $titre->getIdAlbum());
        $stmt->execute();
    }

    /**
     * Supprime un titre de la base de données.
     * @param int $idT
     */
    public static function deleteById(int $idT): void {
        // suppression des associations avant de supprimer le titre
        Appartient::deleteAppartientByIdT($idT);
        FavTitre::deleteFavTitreByIdT($idT);

        $query = "DELETE FROM titre WHERE idT = :idT";
        $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($query);
        $stmt->bindValue(":idT", $idT);
        $stmt->execute();
    }

    public function delete(): void {
        $this->deleteById($this->getIdT());
    }
    /**
     * supprime tous les titres d'un auteur
     * @param int $idA
     */
    public static function deleteTitresByIdA(int $idA): void {
        $titres = self::getTitresByAuteurId($idA);
        foreach ($titres as $titre) {
            self::deleteById($titre->getIdT());
        }
    }

    public static function deleteTitresByIdAlbum(int $idAlbum): void {
        $titres = self::getTitresByAlbumId($idAlbum);
        foreach ($titres as $titre) {
            self::deleteById($titre->getIdT());
        }
    }
}