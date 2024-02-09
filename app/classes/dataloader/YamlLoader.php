<?php
declare(strict_types=1);

namespace dataloader;

use dataloader\LoaderInterface;
use Exception;
use models\Album;
use models\Artiste;

class YamlLoader // implements LoaderInterface
{
    /**
     * Parses a file and returns an array of albums
     * File format :
     * - by: Superdrag
     * entryId: 67913
     * genre: [Rock, Punk]
     * img: Superdrag-Stereo_360_Sound.jpg
     * parent: Superdrag
     * releaseYear: 1998
     * title: Stereo 360 Sound
     * - by: 16 Horsepower
     * entryId: 10575
     * genre: [Alternative country, neofolk]
     * img: 220px-Folklore_hp.jpg
     * parent: 16 Horsepower
     * releaseYear: 2002
     * title: Folklore
     * @param string $file
     * @return array
     * @throws Exception
     */
    public static function load(string $file): array
    {
        $data = fopen($file, 'r');
        $albums = [];
        $album = null;
        while ($line = fgets($data)) {
            list($key, $value) = explode(': ', $line);
            $key = trim($key);
            $value = trim($value);
            switch ($key) {
                case '- by':
                    if ($album) {
                        $albums[] = $album;
                    }
                    $album = new Album(0, "", "", 0, 0);
                    $artiste = Artiste::getArtisteByNom($value);
                    if ($artiste) {
                        $artist_id = $artiste->getIdA();
                    } else {
                        $artiste = new Artiste(0, $value);
                        $artiste->create();
                        $artiste = Artiste::getArtisteByNom($value);
                        if (!$artiste) {
                            throw new Exception('Error creating artist');
                        }
                    }
                    $artist_id = (int) $artiste->getIdA();
                    $album->setIdA($artist_id);
                    break;
                case 'entryId':
                    $album->setIdAlbum((int) $value);
                    break;
                case 'title':
                    $album->setTitreAlbum($value);
                    break;
                case 'img':
                    $album->setImageAlbum($value);
                    break;
                case 'releaseYear':
                    $album->setAnneeSortie((int) $value);
                    break;
            }
        }
        if ($album) {
            $albums[] = $album;
        }
        fclose($data);
        return $albums;
    }
}