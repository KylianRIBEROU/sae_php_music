<?php
require "classes/autoloader/autoloader.php";
use dataloader\YamlLoader;

define('SQLITE_DB', __DIR__.'/../data/app.db');
Autoloader::register();
$pdo = new PDO('sqlite:' . SQLITE_DB);

try {
    $action = $argv[1];
    if (count($argv) > 2) {
        $args = array_slice($argv, 2);
    }
    else {
        $args = [];
    }
}
catch (Exception $e) {
    echo 'argument manquant. Syntaxe : php sqlite.php [create-database, delete-database, create-tables, drop-tables, import-yml <nom_fichier_yml>]' . PHP_EOL;
    exit(1);
}

switch ($action){
    case 'create-database':
        echo '→ Création base de données "' . SQLITE_DB . '"' . PHP_EOL;
        shell_exec('sqlite3 ' . SQLITE_DB);
        break;

    case 'create-tables':
        createTables();
        break;

    case 'drop-tables':
        dropTables();
        break;

    case 'delete-database':
        echo '→ Suppression base de données "' . SQLITE_DB . '"' . PHP_EOL;
        unlink(SQLITE_DB);
        break;
    case 'import-yml':
        $file = $args[0];
        echo '→ Importation du fichier "' . $file . '"' . PHP_EOL;
        try {
            $albums = YamlLoader::load($file);
            echo '→ ' . count($albums) . ' albums importés' . PHP_EOL;
            foreach ($albums as $album) {
                try {
                    $album->create();
                }
                catch (Exception $e) {
                    if (str_contains($e->getMessage(), 'UNIQUE constraint failed')) {
                        echo '→ Album déjà existant'. PHP_EOL;
                    }
                    else {
                        echo '→ ' . $e->getMessage() . PHP_EOL;
                    }
                }
            }
        } catch (Exception $e) {
            echo '→ ' . $e->getMessage() . PHP_EOL;
        }
        break;
    default:
        echo 'Action incorrecte 🙀. Actions possibles [create-database, delete-database, create-tables, drop-tables, import-yml <nom_fichier_yml>]' . PHP_EOL;
        break;
}

function createTables()
{
    global $pdo;

    $tableQueries = [
    'utilisateur' => <<<EOF
        CREATE TABLE IF NOT EXISTS utilisateur (
            idU        INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            nomU       VARCHAR(100) UNIQUE,
            motdepasse VARCHAR(200),
            admin      INTEGER
        )
    EOF,

    'album' => <<<EOF
        CREATE TABLE IF NOT EXISTS album (
            idAlbum     INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            titreAlbum  VARCHAR(100),
            imageAlbum  VARCHAR(200),
            anneeSortie  INTEGER,
            idA          INTEGER NOT NULL,
            FOREIGN KEY (idA) REFERENCES artiste (idA)
        )
    EOF,

    'artiste' => <<<EOF
        CREATE TABLE IF NOT EXISTS artiste (
            idA  INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            nomA VARCHAR(100) UNIQUE,
            imageA VARCHAR(200)
        )
    EOF,

    'detient' => <<<EOF
        CREATE TABLE IF NOT EXISTS detient (
            idAlbum INTEGER NOT NULL,
            idG INTEGER NOT NULL,
            PRIMARY KEY (idAlbum, idG),
            FOREIGN KEY (idAlbum) REFERENCES titre (idAlbum),
            FOREIGN KEY (idG) REFERENCES genre (idG)
        )
    EOF,

    'favAlbum' => <<<EOF
        CREATE TABLE IF NOT EXISTS favAlbum (
            idU     INTEGER NOT NULL,
            idAlbum INTEGER NOT NULL,
            PRIMARY KEY (idU, idAlbum),
            FOREIGN KEY (idU) REFERENCES utilisateur (idU),
            FOREIGN KEY (idAlbum) REFERENCES album (idAlbum)
        )
    EOF,

    'favTitre' => <<<EOF
        CREATE TABLE IF NOT EXISTS favTitre (
            idU INTEGER NOT NULL,
            idT INTEGER NOT NULL,
            PRIMARY KEY (idU, idT),
            FOREIGN KEY (idU) REFERENCES utilisateur (idU),
            FOREIGN KEY (idT) REFERENCES titre (idT)
        )
    EOF,

    'genre' => <<<EOF
        CREATE TABLE IF NOT EXISTS genre (
            idG  INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            nomG VARCHAR(100) UNIQUE
        )
    EOF,

    'note' => <<<EOF
        CREATE TABLE IF NOT EXISTS note (
            idU     INTEGER NOT NULL,
            idAlbum INTEGER NOT NULL,
            note    INTEGER NOT NULL,
            PRIMARY KEY (idU, idAlbum),
            FOREIGN KEY (idU) REFERENCES utilisateur (idU),
            FOREIGN KEY (idAlbum) REFERENCES album (idAlbum)
        )
    EOF,

    'playlist' => <<<EOF
        CREATE TABLE IF NOT EXISTS playlist (
            idP  INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            nomP VARCHAR(100),
            idU INTEGER NOT NULL,
            FOREIGN KEY (idU) REFERENCES utilisateur (idU)
        )
    EOF,

    'titre' => <<<EOF
        CREATE TABLE IF NOT EXISTS titre (
            idT         INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            labelT      VARCHAR(100),
            anneeSortie INTEGER,
            duree       VARCHAR(10),
            url         VARCHAR(200),
            idAlbum     INTEGER NOT NULL,
            idA         INTEGER NOT NULL,
            FOREIGN KEY (idAlbum) REFERENCES album (idAlbum),
            FOREIGN KEY (idA) REFERENCES artiste (idA)
        )
    EOF,

    'appartient' => <<<EOF
        CREATE TABLE IF NOT EXISTS appartient (
            idP INTEGER NOT NULL,
            idT INTEGER NOT NULL,
            PRIMARY KEY (idP, idT),
            FOREIGN KEY (idP) REFERENCES playlist(idP),
            FOREIGN KEY (idT) REFERENCES titre (idT)
        )
    EOF,
];


    // Execute the table creation queries
    foreach ($tableQueries as $tableName => $tableQuery) {
        // print $tableQuery;
        print $tableName;


        try {
            $pdo->exec($tableQuery);
            echo "→ Création table \"$tableName\"" . PHP_EOL;
        } catch (PDOException $e) {
            echo '→ ' . $e->getMessage() . PHP_EOL;
        }
    }
}

function dropTables()
{
    global $pdo;

    $tableDeletionQueries = [
        'album' => 'DROP TABLE IF EXISTS album',
        'appartient' => 'DROP TABLE IF EXISTS appartient',
        'artiste' => 'DROP TABLE IF EXISTS artiste',
        'detient' => 'DROP TABLE IF EXISTS detient',
        'favAlbum' => 'DROP TABLE IF EXISTS favAlbum',
        'favTitre' => 'DROP TABLE IF EXISTS favTitre',
        'genre' => 'DROP TABLE IF EXISTS genre',
        'note' => 'DROP TABLE IF EXISTS note',
        'playlist' => 'DROP TABLE IF EXISTS playlist',
        'titre' => 'DROP TABLE IF EXISTS titre',
        'utilisateur' => 'DROP TABLE IF EXISTS utilisateur',
    ];

    // Execute the table deletion queries
    foreach ($tableDeletionQueries as $tableName => $tableDeletionQuery) {
        try {
            $pdo->exec($tableDeletionQuery);
            echo "→ Drop table  \"$tableName\"" . PHP_EOL;
        } catch (PDOException $e) {
            echo '→ ' . $e->getMessage() . PHP_EOL;
        }
    }
}
