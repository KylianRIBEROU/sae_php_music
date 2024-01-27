<?php 

declare(strict_types=1);

namespace db_models;

use PDO;
use models\Titre;
use db_models\AppartientBD;
use db_models\DetientBD;
use db_models\FavTitreBD;

class TitreBD {

    private PDO $db;

    private AppartientBD $appartientBD;

    private DetientBD $detientBD;

    private FavTitreBD $favTitreBD;

    /**
     * TitreBD constructeur, accesseur BD pour les titres
     * @param PDO $db
     */
    public function __construct(PDO $db) {
        $this->db = $db;
        $this->appartientBD = new AppartientBD($db);
        $this->detientBD = new DetientBD($db);
        $this->favTitreBD = new FavTitreBD($db);
    }

    /**
     * @param int $idT
     * @return Titre|null
     */
    public function getTitreById(int $idT): Titre | null {
        $sql = "SELECT * FROM titre WHERE idT = :idT";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idT", $idT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
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
    public function getTitresByAuteurId(int $idA): array {
        $sql = "SELECT * FROM titre WHERE idA = :idA";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idA", $idA);
        $stmt->execute();
        $titres = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $titres[] = new Titre($row["idT"], $row["labelT"], $row["anneeSortie"], $row["duree"], $row["idA"], $row["idAlbum"]);
        }
        return $titres;
    }

    /**
     * @param int $idAlbum
     * @return array
     */
    public function getTitresByAlbumId(int $idAlbum): array {
        $sql = "SELECT * FROM titre WHERE idAlbum = :idAlbum";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idAlbum", $idAlbum);
        $stmt->execute();
        $titres = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $titres[] = new Titre($row["idT"], $row["labelT"], $row["anneeSortie"], $row["duree"], $row["idA"], $row["idAlbum"]);
        }
        return $titres;
    }

    /**
     * Crée un titre dans la base de données.
     * @param Titre $titre
     */
    public function createTitre(Titre $titre): void {
        $sql = "INSERT INTO titre (labelT, anneeSortie, duree, idA, idAlbum) VALUES (:labelT, :anneeSortie, :duree, :idA, :idAlbum)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":labelT", $titre->getLabelT());
        $stmt->bindValue(":anneeSortie", $titre->getAnneeSortie());
        $stmt->bindValue(":duree", $titre->getDuree());
        $stmt->bindValue(":idA", $titre->getIdA());
        $stmt->bindValue(":idAlbum", $titre->getIdAlbum());
        $stmt->execute();
    }

    /**
     * Met à jour un titre dans la base de données.
     * @param Titre $titre
     */
    public function updateTitre(int $idT, Titre $titre): void {
        $sql = "UPDATE titre SET labelT = :labelT, anneeSortie = :anneeSortie, duree = :duree, idA = :idA, idAlbum = :idAlbum WHERE idT = :idT";
        $stmt = $this->db->prepare($sql);
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
    public function deleteTitre(int $idT): void {
        // suppression des associations avant de supprimer le titre
        $this->appartientBD->deleteAppartientByIdT($idT);
        $this->detientBD->deleteDetientByIdT($idT);
        $this->favTitreBD->deleteFavTitreByIdT($idT);

        $sql = "DELETE FROM titre WHERE idT = :idT";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":idT", $idT);
        $stmt->execute();
    }

    /**
     * supprime tous les titres d'un auteur
     * @param int $idA
     */
    public function deleteTitresByIdA(int $idA): void {
        $titres = $this->getTitresByAuteurId($idA);
        foreach ($titres as $titre) {
            $this->deleteTitre($titre->getIdT());
        }
    }
}