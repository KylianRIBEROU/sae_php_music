<?php

require_once __DIR__ .'/classes/autoloader/autoloader.php';

Autoloader::register();

use pdoFactory\PDOFactory;

$pdo = PDOFactory::getInstancePDOFactory()->get_PDO();


$viewDir = '/views/';
$adminDir ='/views/admin/';

session_start();

$route = $_SERVER['REQUEST_URI'];

$hxRequest = isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['HTTP_HX_REQUEST'] == 'true';


register_shutdown_function(function () {
   global $main, $hxRequest, $viewDir, $adminDir, $route, $nav, $player, $isConnected, $bar;
   if ($hxRequest) {
      echo $main;
   }
   elseif ($route == '/login') {
      http_response_code(200);
      require __DIR__ . $viewDir . 'login.php';
   }
   elseif ($route == '/logout') {
      session_unset();
      header('Location: /login');
      exit();
   }
   elseif ($route == '/profil') {
      http_response_code(200);
      require __DIR__ . $viewDir . 'profil.php';
   }
   elseif ($route == '/register') {
      http_response_code(200);
      require __DIR__ . $viewDir . 'register.php';
   }
   elseif ($route == '/admin') {
      http_response_code(200);
      require __DIR__ . $viewDir . 'accueil_admin.php';
   }
   elseif ($route == '/admin/ajout-album'){
      http_response_code(200);
      require __DIR__ . $adminDir . 'ajout_album.php';
   }
   elseif ($route == '/admin/ajout-artiste'){
      http_response_code(200);
      require __DIR__ . $adminDir . 'ajout_artiste.php'; // IL FAUDRA FACTORISER TOUT CA
   }
   elseif ($route == '/admin/ajout-genre'){
      http_response_code(200);
      require __DIR__ . $adminDir . 'ajout_genre.php';
   }
   elseif ($route == '/admin/genres'){
      http_response_code(200);
      require __DIR__ . $adminDir . 'genres.php';
   }
   elseif ($route == '/admin/albums'){
      http_response_code(200);
      require __DIR__ . $adminDir . 'albums.php';
   }
   elseif (parse_url($route)['path'] == '/admin/update-genre') { // il faut passer l'id  !!! 
      http_response_code(200);
      require __DIR__ . $adminDir . 'update_genre.php';
   }
   else {
      require __DIR__ . $viewDir . 'layout.php';
   }
});


ob_start();
require __DIR__ . $viewDir . 'nav.php';
$nav = ob_get_clean();

ob_start();
require __DIR__ . $viewDir . 'bar.php';
$bar = ob_get_clean();

ob_start();
require __DIR__ . $viewDir . 'player.php';
$player = ob_get_clean();

ob_start();
switch (parse_url($route)['path']){
   case '':
   case '/':
      require __DIR__ . $viewDir . 'main.php';
      break;
   case '/main':
      require __DIR__ . $viewDir . 'main.php';
      break;
   case '/albums':
      require __DIR__ . $viewDir . 'albums.php';
      break;
   case '/playlists':
      require __DIR__ . $viewDir . 'playlists.php';
      break;
   case '/search':
      require __DIR__ . $viewDir . 'search.php';
      break;
   default:
      require __DIR__ . $viewDir . '404.php';
}
$main = ob_get_clean();