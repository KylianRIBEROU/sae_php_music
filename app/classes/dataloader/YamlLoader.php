<?php
declare(strict_types=1);

namespace dataloader;

use Exception;
use models\Album;
use models\Artiste;
use models\Genre;

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
                    if (!$artiste) {
                        $artiste = new Artiste(0, $value, "");
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
                    if ($value == "null"){
                        $album->setImageAlbum(null);
                    }
                    else {
                        $album->setImageAlbum(str_replace("%","%25",$value));
                    }
                    break;
                case 'releaseYear':
                    $album->setAnneeSortie((int) $value);
                    break;
                case 'genre':
                    if (strlen($value) <= 2) {
                        break;
                    }
                    $value = substr($value, 1, strlen($value)-2);
                    $genres = explode(",", $value);
                    foreach ($genres as $g){
                        $genre = Genre::getGenreByNom($g);
                        if (!$genre){
                            $genre = new Genre(0, $g);
                            $genre->create();
                            $genre = Genre::getGenreByNom($g);
                            if (!$genre){
                                throw new Exception("Error creating genre");
                            }
                        }
                        $album->addGenre($genre);
                    }
            }
        }
        if ($album) {
            $albums[] = $album;
        }
        fclose($data);
        return $albums;
    }
}