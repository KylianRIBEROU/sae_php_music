<?php

declare(strict_types=1);

namespace db_models;

use PDO;
use models\Appartient;

//TODO: continuer les modeles BD avec delete en cascade
class AppartientBD
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Crée une nouvelle association "Appartient" entre un titre et une playlist dans la base de données.
     *
     * @param int $idP L'ID de la playlist.
     * @param int $idT L'ID du titre.
     * @return bool True si l'association "Appartient" a été créée avec succès, sinon false.
     */
    public function createAppartient(int $idP, int $idT): bool
    {
        $query = 'INSERT INTO appartient (idP, idT) VALUES (:idP, :idT)';

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':idP', $idP);
            $stmt->bindValue(':idT', $idT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }

    /**
     * Supprime une association "Appartient" entre un titre et une playlist de la base de données.
     *
     * @param int $idP L'ID de la playlist.
     * @param int $idT L'ID du titre.
     * @return bool True si l'association "Appartient" a été supprimée avec succès, sinon false.
     */
    public function deleteAppartient(int $idP, int $idT): bool
    {
        $query = 'DELETE FROM appartient WHERE idP = :idP AND idT = :idT';

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':idP', $idP);
            $stmt->bindValue(':idT', $idT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }

    /**
     * delete association appartient selon un id de playlist
     * @param int $idP
     */
    public function deleteAppartientByIdP(int $idP): bool
    {
        $query = 'DELETE FROM appartient WHERE idP = :idP';

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':idP', $idP);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * delete association appartient selon un id de titre
     * @param int $idT
     */
    public function deleteAppartientByIdT(int $idT): bool
    {
        $query = 'DELETE FROM appartient WHERE idT = :idT';

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':idT', $idT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }
}
