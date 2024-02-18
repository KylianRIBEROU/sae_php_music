<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Récupérer les paramètres de requête
    

    // Effectuer des opérations pour récupérer les données correspondantes à l'ID
    $response = "test";
    // Envoyer la réponse JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Si la méthode de requête n'est pas GET, renvoyer une erreur
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Méthode non autorisée';
}
