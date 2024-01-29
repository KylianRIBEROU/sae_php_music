<?php

declare(strict_types=1);

namespace accessManager;
use databaseManager\DatabaseManager;


$dbManager = DatabaseManager::getInstance();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // traitement de la connexion, après faudra voir pour afficher les erreurs ou jsp
}