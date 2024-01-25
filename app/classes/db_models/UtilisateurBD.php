<?php

declare(strict_types=1);

namespace db_models;

use PDO;
use models\Utilisateur;

class UtilisateurBD
{
    private PDO $pdo;

    //TODO: rajouter playlistBD pour pouvoir supprimer les playlist associees a un utilisateur supprime

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Crée un nouvel utilisateur dans la base de données.
     *
     * @param Utilisateur $utilisateur
     * @return bool True si l'utilisateur a été créé avec succès, sinon false.
     */
    public function createUtilisateur(Utilisateur $utilisateur): bool
    {
        $query = 'INSERT INTO utilisateur (nomU, motdepasse, admin) VALUES (:nom, :password, :admin)';

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':nom', $utilisateur->getNom());
            $stmt->bindValue(':password', $utilisateur->getPassword());
            $stmt->bindValue(':admin', $utilisateur->getAdmin(), PDO::PARAM_BOOL);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }

    /**
     * Récupère un utilisateur par ID depuis la base de données.
     *
     * @param int $idU L'ID de l'utilisateur.
     * @return Utilisateur|null L'objet utilisateur récupéré, ou null s'il n'est pas trouvé.
     */
    public function getUtilisateurById(int $idU): ?Utilisateur
    {
        $query = 'SELECT * FROM utilisateur WHERE idU = :idU';

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':idU', $idU);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return new Utilisateur(
                    (int)$result['idU'],
                    $result['nomU'],
                    $result['motdepasse'],
                    (bool)$result['admin']
                );
            }

            return null;
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return null;
        }
    }

    /**
     * Met à jour un utilisateur dans la base de données.
     *
     * @param Utilisateur $utilisateur L'objet utilisateur mis à jour.
     * @return bool True si l'utilisateur a été mis à jour avec succès, sinon false.
     */
    public function updateUtilisateur(Utilisateur $utilisateur): bool
    {
        $query = 'UPDATE utilisateur SET nomU = :nom, motdepasse = :password, admin = :admin WHERE idU = :idU';

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':idU', $utilisateur->getIdU());
            $stmt->bindValue(':nom', $utilisateur->getNom());
            $stmt->bindValue(':password', $utilisateur->getPassword());
            $stmt->bindValue(':admin', $utilisateur->getAdmin(), PDO::PARAM_BOOL);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }

    /**
     * Supprime un utilisateur de la base de données.
     *
     * @param int $idU L'ID de l'utilisateur à supprimer.
     * @return bool True si l'utilisateur a été supprimé avec succès, sinon false.
     */
    public function deleteUtilisateur(int $idU): bool
    {
        $query = 'DELETE FROM utilisateur WHERE idU = :idU';

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':idU', $idU);
            return $stmt->execute();
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }
}
