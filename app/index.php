<?php
$viewDir = '/views/';
$route = $_SERVER['REQUEST_URI'];
$hxRequest = isset($_SERVER['HTTP_HX_REQUEST']) && $_SERVER['HTTP_HX_REQUEST'] == 'true';

register_shutdown_function(function () {
   global $main, $hxRequest, $viewDir, $route, $nav, $player;
   if ($hxRequest) {
      echo $main;
   }
   elseif ($route == '/login') {
      require __DIR__ . $viewDir . 'login.php';
   }
   elseif ($route == '/register') {
      require __DIR__ . $viewDir . 'register.php';
   }
   else {
      require __DIR__ . $viewDir . 'layout.php';
   }
});


ob_start();
require __DIR__ . $viewDir . 'nav.php';
$nav = ob_get_clean();

ob_start();
require __DIR__ . $viewDir . 'player.php';
$player = ob_get_clean();

ob_start();
switch ($route) {
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
   default:
      http_response_code(404);
      require __DIR__ . $viewDir . '404.php';
}
$main = ob_get_clean();