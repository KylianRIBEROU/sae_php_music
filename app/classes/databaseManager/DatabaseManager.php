<?php

declare(strict_types=1);

namespace databasemanager;

use PDO;
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

    private function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->albumBD = new AlbumBD($pdo);
        $this->artisteBD = new ArtisteBD($pdo);
        $this->titreBD = new TitreBD($pdo);
        $this->utilisateurBD = new UtilisateurBD($pdo);
    }

    public static function getInstance(PDO $pdo): DatabaseManager
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseManager($pdo);
        }
        return self::$instance;
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