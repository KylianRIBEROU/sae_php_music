<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les paramètres de requête
    
    $post_body = file_get_contents('php://input');
    $_SESSION['player'] = json_decode($post_body, true);
    // Envoyer la réponse JSON
    header('Content-Type: application/json');
    echo json_encode($post_body);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_SESSION['player'])) {
        $response = $_SESSION['player'];
    } else {
        $response = array();
    }
    // Envoyer la réponse JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Si la méthode de requête n'est pas GET, renvoyer une erreur
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Méthode non autorisée';
}
