<?php

declare(strict_types=1);

namespace db_models;

use PDO;
use models\Genre;
use db_models\DetientBD;

class GenreBD
{
    private PDO $db;
    private DetientBD $detientBD;

    /**
     * GenreBD constructor.
     * @param PDO $db
     * @param DetientBD $detientBD
     */
    public function __construct(PDO $db, DetientBD $detientBD)
    {
        $this->db = $db;
        $this->detientBD = $detientBD;
    }

    /**
     * Récupère tous les genres depuis la base de données.
     *
     * @return array Un tableau d'objets Genre.
     */
    public function getAllGenres(): array
    {
        $query = $this->db->prepare("SELECT * FROM genre");
        $query->execute();
        $genres = $query->fetchAll(PDO::FETCH_ASSOC);
        $genresArray = [];
        foreach ($genres as $genre) {
            $genresArray[] = new Genre((int)$genre['idG'], $genre['nomG']);
        }
        return $genresArray;
    }

    /**
     * Récupère un genre par ID depuis la base de données.
     *
     * @param int $idG L'ID du genre.
     * @return Genre|null L'objet Genre récupéré, ou null s'il n'est pas trouvé.
     */
    public function getGenreById(int $idG): ?Genre
    {
        $query = $this->db->prepare("SELECT * FROM genre WHERE idG = :idG");
        $query->bindValue(':idG', $idG);
        $query->execute();

        $genre = $query->fetch(PDO::FETCH_ASSOC);

        if ($genre) {
            return new Genre((int)$genre['idG'], $genre['nomG']);
        }

        return null;
    }

    /**
     * Crée un nouveau genre dans la base de données.
     *
     * @param Genre $genre L'objet Genre à créer.
     * @return bool True si le genre a été créé avec succès, sinon false.
     */
    public function createGenre(Genre $genre): bool
    {
        $query = 'INSERT INTO genre (nomG) VALUES (:nomG)';

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nomG', $genre->getNomG());
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }

    /**
     * Met à jour un genre dans la base de données.
     *
     * @param Genre $genre L'objet Genre mis à jour.
     * @return bool True si le genre a été mis à jour avec succès, sinon false.
     */
    public function updateGenre(Genre $genre): bool
    {
        $query = 'UPDATE genre SET nomG = :nomG WHERE idG = :idG';

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':idG', $genre->getIdG());
            $stmt->bindValue(':nomG', $genre->getNomG());
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }

    /**
     * Supprime un genre de la base de données.
     *
     * @param int $idG L'ID du genre à supprimer.
     * @return bool True si le genre a été supprimé avec succès, sinon false.
     */
    public function deleteGenre(int $idG): bool
    {
        // Supprimer d'abord les associations Detient liées au genre
        $this->detientBD->deleteDetientByIdG($idG);

        $query = 'DELETE FROM genre WHERE idG = :idG';

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':idG', $idG);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }
}
