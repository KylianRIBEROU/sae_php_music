<?php

require_once __DIR__ .'/classes/autoloader/autoloader.php';

Autoloader::register();

use models\Utilisateur;
use models\favAlbum;
use models\favTitre;
use pdoFactory\PDOFactory;
use models\Playlist;

$pdo = PDOFactory::getInstancePDOFactory()->get_PDO();


$viewDir = '/views/';
$adminDir ='/views/admin/';

session_start();

$route = $_SERVER['REQUEST_URI'];

$hxRequest = isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['HTTP_HX_REQUEST'] == 'true';


register_shutdown_function(function () {
   global $main, $hxRequest, $viewDir, $adminDir, $route, $nav, $player, $isConnected, $bar;
   if ($hxRequest) {
      if ($route == '/nav'){
         echo $nav;
      }
      else{
         echo $main;
      }
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
switch (parse_url($route)['path']){
   case '/nav':
      require __DIR__ . $viewDir . 'nav.php';
      break;
   default:
      require __DIR__ . $viewDir . 'nav.php';
}
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
   case '/artists':
      require __DIR__ . $viewDir . 'artists.php';
      break;
   case '/search':
      require __DIR__ . $viewDir . 'search.php';
      break;
   case '/profil':
      require __DIR__ . $viewDir . 'profil.php';
      break;
   case '/titrefav':
      require __DIR__ . $viewDir . 'titresfav.php';
      break;
   case '/favalbum':
      if (isset($_SESSION["id"]) && isset($_GET['id'])){
         $fav = favAlbum::getFavAlbum($_SESSION["id"], $_GET['id']);
         if ($fav != null){
            $fav = new favAlbum($_SESSION["id"], $_GET['id']);
            $fav->delete();
         }
         else {
            $fav = new favAlbum($_SESSION["id"], $_GET['id']); 
            $fav->create();
         };
      };
      header('HX-Trigger: refreshnav');
      require __DIR__ . $viewDir . 'albums.php';
      break;
   case '/favtitre':
      if (isset($_SESSION["id"]) && isset($_GET['id'])){
         $fav = favTitre::getFavTitre($_SESSION["id"], $_GET['id']);
         if ($fav != null){
            $fav = new favTitre($_SESSION["id"], $_GET['id']);
            $fav->delete();
            echo '<button hx-get="/favtitre?id='. intval($_GET['id']) . '" hx-swap="outerHTML" class="text-white text-xl hidden group-hover:block"><i class="far fa-heart"></i></button>';
         }
         else {
            $fav = new favTitre($_SESSION["id"], $_GET['id']); 
            $fav->create();
            echo '<button hx-get="/favtitre?id='. intval($_GET['id']) . '" hx-swap="outerHTML" class="text-purple text-xl"><i class="fas fa-heart"></i></button>';
         };
      };
      break;
   case '/createplaylist':
      if (isset($_SESSION["id"])){
         $playlist = new Playlist(0,'Nouvelle playlist',$_SESSION["id"]);
         $idP = $playlist->create();
         $_GET['id'] = $idP; // warning: this is a hack
      };
      header('HX-Trigger: refreshnav');
      require __DIR__ . $viewDir . 'playlists.php';
      break;
   case '/deleteplaylist':
      if (isset($_SESSION["id"]) && isset($_GET['id'])){
         $playlist = Playlist::getPlaylistById($_GET['id']);
         if ($playlist != null){
            $playlist->delete();
         }
      };
      header('HX-Trigger: refreshnav');
      require __DIR__ . $viewDir . 'main.php';
      break;
   case '/editplaylist':
      if (isset($_SESSION["id"]) && isset($_GET['id']) && isset($_GET['name'])){
         $playlist = Playlist::getPlaylistById($_GET['id']);
         if ($playlist != null){
            $playlist->setNomP($_GET['name']);
            $playlist->update();
         }
      };
      header('HX-Trigger: refreshnav');
      require __DIR__ . $viewDir . 'playlists.php';
      break;
   default:
      require __DIR__ . $viewDir . '404.php';
}
$main = ob_get_clean();