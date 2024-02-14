<?php

declare(strict_types=1);

namespace models;
use pdoFactory\PDOFactory;
use models\Album;
use models\favAlbum;
use models\favTitre;

class Utilisateur
{
    private int $idU;
    private string $nom;
    private string $password;
    private bool $admin;

    public function __construct(int $idU, string $nom, string $password, bool $admin)
    {
        $this->idU = $idU;
        $this->nom = strtolower($nom);
        $this->password = $password;
        $this->admin = $admin;
    }


    public function getIdU(): int
    {
        return $this->idU;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAdmin(): bool
    {
        return $this->admin;
    }

    public function setIdU(int $idU): void
    {
        $this->idU = $idU;
    }

    public function setNom(string $nom): void
    {
        $this->nom = strtolower($nom);
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setAdmin(bool $admin): void
    {
        $this->admin = $admin;
    }

    public function __toString(): string
    {
        return "Utilisateur : " . $this->idU . " " . $this->nom . " " . $this->password . " " . $this->admin;
    }

    /**
     * Crée un nouvel utilisateur dans la base de données.
     *
     * @param Utilisateur $utilisateur
     * @return bool True si l'utilisateur a été créé avec succès, sinon false.
     */
    public function create(): bool
    {
        $query = 'INSERT INTO utilisateur (nomU, motdepasse, admin) VALUES (:nom, :password, :admin)';

        try {
            $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($query);
            $stmt->bindValue(':nom', $this->getNom());
            $encrypted_pwd = password_hash($this->getPassword(), PASSWORD_DEFAULT);
            $stmt->bindValue(':password', $encrypted_pwd);
            $stmt->bindValue(':admin', $this->getAdmin(), \PDO::PARAM_BOOL);
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
    public static function getUtilisateurById(int $idU): ?Utilisateur
    {
        $query = 'SELECT * FROM utilisateur WHERE idU = :idU';

        try {
            $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($query);
            $stmt->bindValue(':idU', $idU);
            $stmt->execute();

            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

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
     * get tous les utilisateurs
     * @return array
     */
    public static function getAllUtilisateurs(): array
    {
        $query = 'SELECT * FROM utilisateur';
        $utilisateurs = [];

        try {
            $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->query($query);
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($result as $row) {
                array_push($utilisateurs, new Utilisateur(
                    (int)$row['idU'],
                    $row['nomU'],
                    $row['motdepasse'],
                    (bool)$row['admin']
                ));
            }

            return $utilisateurs;
        } catch (\PDOException $e) {
            return [];
        }
    }

    /**
     * Récupère un utilisateur par nom depuis la base de données.
     *
     * @param string $nomU Le nom de l'utilisateur.
     * @return Utilisateur|null L'objet utilisateur récupéré, ou null s'il n'est pas trouvé.
     */
    public function getUtilisateurByNom(string $nomU): ?Utilisateur
    {
        $query = 'SELECT * FROM utilisateur WHERE nomU = :nomU';

        try {
            $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($query);
            $stmt->bindValue(':nomU', strtolower($nomU));
            $stmt->execute();

            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

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
            return null;
        }
    }

    /**
     * Met à jour un utilisateur dans la base de données.
     *
     * @param Utilisateur $utilisateur L'objet utilisateur mis à jour.
     * @return bool True si l'utilisateur a été mis à jour avec succès, sinon false.
     */
    public function update(): bool
    {
        $query = 'UPDATE utilisateur SET nomU = :nom, motdepasse = :password, admin = :admin WHERE idU = :idU';

        try {
            $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($query);
            $stmt->bindValue(':idU', $this->getIdU());
            $stmt->bindValue(':nom', $this->getNom());
            $new_encrypted_pwd = password_hash($this->getPassword(), PASSWORD_DEFAULT);
            $stmt->bindValue(':password', $new_encrypted_pwd);
            $stmt->bindValue(':admin', $this->getAdmin(), \PDO::PARAM_BOOL);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Supprime un utilisateur de la base de données.
     *
     * @return bool True si l'utilisateur a été supprimé avec succès, sinon false.
     */
    public function delete(): bool{
        $idU = $this->getIdU();
        // suppression des associations avant de supprimer l'utilisateur
        Playlist::deleteAllPlaylistsByIdU($idU);
        Note::deleteNoteByidAlbum($idU);
        FavTitre::deleteFavTitreByIdU($idU);
        FavAlbum::deleteFavAlbumByIdU($idU);

        $query = 'DELETE FROM utilisateur WHERE idU = :idU';

        try {
            $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($query);
            $stmt->bindValue(':idU', $idU);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Vérifie si un utilisateur existe dans la base de données.
     */
    public static function checkUtilisateurExiste(string $nomU): Utilisateur | null{
        $query = 'SELECT * FROM utilisateur WHERE nomU = :nomU';

        try {
            $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($query);
            $stmt->bindValue(':nomU', strtolower($nomU));
            $stmt->execute();

            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($result) {
            return new Utilisateur(
                (int)$result['idU'],
                $result['nomU'],
                $result['motdepasse'],
                (bool)$result['admin']
            );
        } else {
            return null;
        }
        } catch (\PDOException $e) {
            return null;
        }
    }

    /**
     * Vérifie si les credentials d'un utilisateur sont corrects.
     */
    public static function checkCredentials(string $nomU, string $password): bool {
        $query = 'SELECT * FROM utilisateur WHERE nomU = :nomU';

        try {
            $stmt = PDOFactory::getInstancePDOFactory()->get_PDO()->prepare($query);
            $stmt->bindValue(':nomU', strtolower($nomU));
            $stmt->execute();

            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($result) {
                return password_verify($password, $result['motdepasse']);
            }
            return false;
        } catch (\PDOException $e) {
            // Gérer l'exception (par exemple, journaliser l'erreur ou lancer une exception personnalisée)
            return false;
        }
    }

    /**
     * Obtenir tous les albums favoris d'un utilisateur
     */
    public static function getAllAlbumsFavoris(int $idU):array{
        $favAlbums = favAlbum::getFavAlbumsByIdU($idU);
        $albums = [];
        foreach ($favAlbums as $favAlbum){
            array_push($albums, Album::getAlbumById($favAlbum->getIdAlbum()));
        }
        return $albums;
    }
    
}
