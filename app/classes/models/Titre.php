<?php

declare(strict_types=1);

namespace models;
use pdoFactory\PDOFactory;
class Titre {

    private int $idT;

    private string $labelT;

    private int $anneeSortie;

    private int $duree;
    private int $idA;

    private int $idAlbum;

    // avec documentation

    /**
     * Titre constructor.
     * @param int $idT
     * @param string $labelT
     * @param int $anneeSortie
     * @param int $duree
     * @param int $idA
     * @param int $idAlbum (optionnel)
     */
    public function __construct(int $idT, string $labelT, int $anneeSortie, int $duree, int $idA, int $idAlbum = null)
    {
        $this->idT = $idT;
        $this->labelT = $labelT;
        $this->anneeSortie = $anneeSortie;
        $this->duree = $duree;
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
    
    /**
     * @param int $idAlbum
     */
    public function setIdAlbum(int $idAlbum): void
    {
        $this->idAlbum = $idAlbum;
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
            $titre = new Titre($row["idT"], $row["labelT"], $row["anneeSortie"], $row["duree"], $row["idA"], $row["idAlbum"]);
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
            $titres[] = new Titre($row["idT"], $row["labelT"], $row["anneeSortie"], $row["duree"], $row["idA"], $row["idAlbum"]);
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
            $titres[] = new Titre($row["idT"], $row["labelT"], $row["anneeSortie"], $row["duree"], $row["idA"], $row["idAlbum"]);
        }
        return $titres;
    }

    /**
     * Crée un titre dans la base de données.
     */
    public function create(): void {
        $query = "INSERT INTO titre (labelT, anneeSortie, duree, idA, idAlbum) VALUES (:labelT, :anneeSortie, :duree, :idA, :idAlbum)";
        $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($query);
        $stmt->bindValue(":labelT", $this->getLabelT());
        $stmt->bindValue(":anneeSortie", $this->getAnneeSortie());
        $stmt->bindValue(":duree", $this->getDuree());
        $stmt->bindValue(":idA", $this->getIdA());
        $stmt->bindValue(":idAlbum", $this->getIdAlbum());
        $stmt->execute();
    }

    /**
     * Met à jour un titre dans la base de données.
     * @param Titre $titre
     */
    public function update(int $idT, Titre $titre): void {
        $query = "UPDATE titre SET labelT = :labelT, anneeSortie = :anneeSortie, duree = :duree, idA = :idA, idAlbum = :idAlbum WHERE idT = :idT";
        $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($query);
        $stmt->bindValue(":idT", $idT);
        $stmt->bindValue(":labelT", $titre->getLabelT());
        $stmt->bindValue(":anneeSortie", $titre->getAnneeSortie());
        $stmt->bindValue(":duree", $titre->getDuree());
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