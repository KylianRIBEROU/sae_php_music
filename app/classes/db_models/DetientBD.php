<?php

declare(strict_types=1);

namespace db_models;

use PDO;
use models\Detient;

class DetientBD
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Crée une nouvelle association "Detient" dans la base de données. Un titre détient un genre.
     *
     * @param Detient $detient
     * @return bool True si l'association "Detient" a été créée avec succès, sinon false.
     */
    public function createDetient(Detient $detient): bool
    {
        $query = 'INSERT INTO detient (idG, idT) VALUES (:idG, :idT)';

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':idG', $detient->getIdG());
            $stmt->bindValue(':idT', $detient->getIdT());
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }

    /**
     * Supprime une association "Detient" de la base de données.
     *
     * @param int $idG L'ID du genre associé.
     * @param int $idT L'ID du titre associé.
     * @return bool True si l'association "Detient" a été supprimée avec succès, sinon false.
     */
    public function deleteDetient(int $idG, int $idT): bool
    {
        $query = 'DELETE FROM detient WHERE idG = :idG AND idT = :idT';

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':idG', $idG);
            $stmt->bindValue(':idT', $idT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }

    /**
     * delete une association detient selon l'id d'un genre
     * 
     * @param int $idG L'ID du genre associé.
     * @return bool True si l'association "Detient" a été supprimée avec succès, sinon false.
     */
    public function deleteDetientByIdG(int $idG): bool
    {
        $query = 'DELETE FROM detient WHERE idG = :idG';

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':idG', $idG);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * delete une association detient selon l'id d'un titre
     * 
     * @param int $idT L'ID du titre associé.
     * @return bool True si l'association "Detient" a été supprimée avec succès, sinon false.
     */
    public function deleteDetientByIdT(int $idT): bool
    {
        $query = 'DELETE FROM detient WHERE idT = :idT';

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':idT', $idT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }
}
