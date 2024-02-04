<?php

declare(strict_types=1);

namespace db_models;

use PDO;
use db_models\ImageArtisteBD;
use db_models\AlbumBD;
use db_models\TitreBD;
use models\Artiste;

class ArtisteBD
{
    private PDO $pdo;

    private ImageArtisteBD $imageArtisteBD;

    private AlbumBD $albumBD;

    private TitreBD $titreBD;



    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->imageArtisteBD = new ImageArtisteBD($pdo);
    }

    /**
     * Crée un nouvel artiste dans la base de données.
     *
     * @param Artiste $artiste
     * @return bool True si l'artiste a été créé avec succès, sinon false.
     */
    public function createArtiste(Artiste $artiste): bool
    {
        $query = 'INSERT INTO artiste (nomA) VALUES (:nomA)';

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':nomA', $artiste->getNomA());
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }

    /**
     * Récupère un artiste par ID depuis la base de données.
     *
     * @param int $idA L'ID de l'artiste.
     * @return Artiste|null L'objet artiste récupéré, ou null s'il n'est pas trouvé.
     */
    public function getArtisteById(int $idA): ?Artiste
    {
        $query = 'SELECT * FROM artiste WHERE idA = :idA';

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':idA', $idA);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return new Artiste((int)$result['idA'], $result['nomA']);
            }

            return null;
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return null;
        }
    }

    /**
     * Met à jour un artiste dans la base de données.
     *
     * @param Artiste $artiste L'objet artiste mis à jour.
     * @return bool True si l'artiste a été mis à jour avec succès, sinon false.
     */
    public function updateArtiste(Artiste $artiste): bool
    {
        $query = 'UPDATE artiste SET nomA = :nomA WHERE idA = :idA';

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':idA', $artiste->getIdA());
            $stmt->bindValue(':nomA', $artiste->getNomA());
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }

    /**
     * Supprime un artiste de la base de données.
     *
     * @param int $idA L'ID de l'artiste à supprimer.
     * @return bool True si l'artiste a été supprimé avec succès, sinon false.
     */
    public function deleteArtiste(int $idA): bool

    {
        $this->imageArtisteBD->deleteAllImageByArtiste($idA);
        $this->albumBD->deleteAlbumsByIdA($idA);
        $this->titreBD->deleteTitresByIdA($idA); 
        
        $query = 'DELETE FROM artiste WHERE idA = :idA';

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':idA', $idA);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }
}