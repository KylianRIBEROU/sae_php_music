<?php

require_once __DIR__ .'/classes/autoloader/autoloader.php';

Autoloader::register();

use models\Utilisateur;
use pdoFactory\PDOFactory;

$pdo = PDOFactory::getInstancePDOFactory()->get_PDO();
// $u = new Utilisateur(0, 'admin1', 'admin', 1);
// $u->create();

$viewDir = '/views/';
$adminDir ='/views/admin/';

session_start();

$route = $_SERVER['REQUEST_URI'];

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