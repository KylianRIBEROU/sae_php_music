<?php

declare(strict_types=1);

namespace db_models;

use PDO;
use pdoFactory\PDOFactory;

class DetientBD
{

    /**
     * Crée une nouvelle association "Detient" dans la base de données. Un titre détient un genre.
     *
     * @param int $idG L'ID du genre associé.
     * @param int $idT L'ID du titre associé.
     * @return bool True si l'association "Detient" a été créée avec succès, sinon false.
     */
    public static function createDetient(int $idG, int $idT): bool
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = 'INSERT INTO detient (idG, idT) VALUES (:idG, :idT)';

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idG', $idG);
            $stmt->bindValue(':idT', $idT);
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
    public static function deleteDetient(int $idG, int $idT): bool
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = 'DELETE FROM detient WHERE idG = :idG AND idT = :idT';

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idG', $idG);
            $stmt->bindValue(':idT', $idT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }

    /**
     * Supprime toutes les associations "Detient" selon l'ID d'un genre.
     *
     * @param int $idG L'ID du genre associé.
     * @return bool True si les associations "Detient" ont été supprimées avec succès, sinon false.
     */
    public static function deleteDetientByIdG(int $idG): bool
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = 'DELETE FROM detient WHERE idG = :idG';

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idG', $idG);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Supprime toutes les associations "Detient" selon l'ID d'un titre.
     *
     * @param int $idT L'ID du titre associé.
     * @return bool True si les associations "Detient" ont été supprimées avec succès, sinon false.
     */
    public static function deleteDetientByIdT(int $idT): bool
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = 'DELETE FROM detient WHERE idT = :idT';

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idT', $idT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }
}

class Detient{

    private int $idG;

    private int $idT;


    /**
     * Detient constructeur: association  entre un titre et un genre, un titre détient un genre
     * @param int $idG
     * @param int $idT
     */
    public function __construct(int $idG, int $idT)
    {
        $this->idG = $idG;
        $this->idT = $idT;
    }

    /**
     * @return int
     */
    public function getIdG(): int
    {
        return $this->idG;
    }

    /**
     * @return int
     */
    public function getIdT(): int
    {
        return $this->idT;
    }

    
}
