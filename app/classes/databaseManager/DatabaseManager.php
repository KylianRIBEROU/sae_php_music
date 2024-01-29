<?php

declare(strict_types=1);

namespace databasemanager;

use PDO;
use db_models\AlbumBD;
use db_models\ArtisteBD;
use db_models\TitreBD;
use db_models\UtilisateurBD;


class DatabaseManager {

    private PDO $pdo;

    private AlbumBD $albumBD;

    private ArtisteBD $artisteBD;

    private TitreBD $titreBD;

    private UtilisateurBD $utilisateurBD;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->albumBD = new AlbumBD($pdo);
        $this->artisteBD = new ArtisteBD($pdo);
        $this->titreBD = new TitreBD($pdo);
        $this->utilisateurBD = new UtilisateurBD($pdo);
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

    
}