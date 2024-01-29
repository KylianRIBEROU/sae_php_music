<?php

declare(strict_types=1);

namespace databaseManager;

use PDO;
use PDOException;
use db_models\AlbumBD;
use db_models\ArtisteBD;
use db_models\TitreBD;
use db_models\UtilisateurBD;


class DatabaseManager {

    private static ?DatabaseManager $instance = null;

    private PDO $pdo;

    private AlbumBD $albumBD;

    private ArtisteBD $artisteBD;

    private TitreBD $titreBD;

    private UtilisateurBD $utilisateurBD;

    private function __construct()
    {
        $this->pdo = self::get_sqlite_connection();
        $this->albumBD = new AlbumBD($this->pdo);
        $this->artisteBD = new ArtisteBD($this->pdo);
        $this->titreBD = new TitreBD($this->pdo);
        $this->utilisateurBD = new UtilisateurBD($this->pdo);
    }

    public static function getInstance(): DatabaseManager
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseManager();
        }
        return self::$instance;
    }

    public static function get_sqlite_connection(): PDO | null{
        try {
           $db = new PDO('sqlite:data/app.db'); // chemin depuis l'endroit où get_instance est appelé pour la 1ere fois. Ici, c'est index.php
           $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           return $db;
        } catch (PDOException $e) {
           // Gérer l'exception
            $e -> getMessage();
           return null; 
        }
     }

    /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * @return AlbumBD
     */
    public function getAlbumBD(): AlbumBD
    {
        return $this->albumBD;
    }

    /**
     * @return ArtisteBD
     */
    public function getArtisteBD(): ArtisteBD
    {
        return $this->artisteBD;
    }

    /**
     * @return TitreBD
     */
    public function getTitreBD(): TitreBD
    {
        return $this->titreBD;
    }
    
    /**
     * @return UtilisateurBD
     */
    public function getUtilisateurBD(): UtilisateurBD
    {
        return $this->utilisateurBD;
    }

    //setters

    /**
     * @param PDO $pdo
     */
    public function setPdo(PDO $pdo): void
    {
        $this->pdo = $pdo;
    }

    /**
     * @param AlbumBD $albumBD
     */
    public function setAlbumBD(AlbumBD $albumBD): void
    {
        $this->albumBD = $albumBD;
    }

    /**
     * @param ArtisteBD $artisteBD
     */
    public function setArtisteBD(ArtisteBD $artisteBD): void
    {
        $this->artisteBD = $artisteBD;
    }

    /**
     * @param TitreBD $titreBD
     */
    public function setTitreBD(TitreBD $titreBD): void
    {
        $this->titreBD = $titreBD;
    }

    /**
     * @param UtilisateurBD $utilisateurBD
     */
    public function setUtilisateurBD(UtilisateurBD $utilisateurBD): void
    {
        $this->utilisateurBD = $utilisateurBD;
    }
}