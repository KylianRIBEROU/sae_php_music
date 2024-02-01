<?php

declare(strict_types=1);

namespace pdoFactory;

use PDO;
use PDOException;

class PDOFactory
{
    private static ?PDOFactory $instance = null;
    private PDO $pdo;
    private function __construct(){
        $this->pdo = self::get_sqlite_connection();
    }

    public static function getInstancePDOFactory(): PDOFactory
    {
        if (self::$instance === null) {
            self::$instance = new PDOFactory();
        }
        return self::$instance;
    }


    public function get_PDO(): PDO{
        return $this->pdo;
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


}
