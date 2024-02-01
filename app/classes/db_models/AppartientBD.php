<?php

declare(strict_types=1);

namespace db_models;

use pdoFactory\PDOFactory;

class AppartientBD
{
    /**
     * Crée une nouvelle association "Appartient" entre un titre et une playlist dans la base de données.
     *
     * @param int $idP L'ID de la playlist.
     * @param int $idT L'ID du titre.
     * @return bool True si l'association "Appartient" a été créée avec succès, sinon false.
     */
    public static function createAppartient(int $idP, int $idT): bool
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = 'INSERT INTO appartient (idP, idT) VALUES (:idP, :idT)';

        try {
            $stmt = $pdo->prepare($query);
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
    public static function deleteAppartient(int $idP, int $idT): bool
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = 'DELETE FROM appartient WHERE idP = :idP AND idT = :idT';

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idP', $idP);
            $stmt->bindValue(':idT', $idT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }

    /**
     * Supprime toutes les associations "Appartient" selon l'ID d'une playlist.
     *
     * @param int $idP L'ID de la playlist.
     * @return bool True si les associations "Appartient" ont été supprimées avec succès, sinon false.
     */
    public static function deleteAppartientByIdP(int $idP): bool
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = 'DELETE FROM appartient WHERE idP = :idP';

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idP', $idP);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Supprime toutes les associations "Appartient" selon l'ID d'un titre.
     *
     * @param int $idT L'ID du titre.
     * @return bool True si les associations "Appartient" ont été supprimées avec succès, sinon false.
     */
    public static function deleteAppartientByIdT(int $idT): bool
    {
        $pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
        $query = 'DELETE FROM appartient WHERE idT = :idT';

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idT', $idT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }
}

class Appartient {

    private int $idP;

    private int $idT;

    /**
     * Appartient constructor. association entre titre et playlist, manyToMany
     * @param int $idP
     * @param int $idT
     */
    public function __construct(int $idP, int $idT) {
        $this->idP = $idP;
        $this->idT = $idT;
    }

    /**
     * @return int
     */
    public function getIdP(): int {
        return $this->idP;
    }

    /**
     * @return int
     */
    public function getIdT(): int {
        return $this->idT;
    }

    /**
     * @param int $idP
     * @return void
     */
    public function setIdP(int $idP): void {
        $this->idP = $idP;

    }

    /**
     * @param int $idT
     * @return void
     */
    public function setIdT(int $idT): void {
        $this->idT = $idT;
    }

}
