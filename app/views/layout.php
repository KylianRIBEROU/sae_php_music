<?php
if( !isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]){
   header('Location: /login');
   exit;
}
if (!isset($nav)) {
   $nav = '<p>no nav</p>';
}
if (!isset($bar)) {
   $bar = '<p>no bar</p>';
}
if (!isset($main)) {
   $main = '<p>no main</p>';
}
if (!isset($player)) {
   $player = '<p>no player</p>';
}
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <title>Accueil</title>
      <link href="../static/css/output.css" rel="stylesheet" /> 
      <script src="https://unpkg.com/htmx.org@1.9.10"></script>
      <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
      
   </head>

   <body class="bg-black">
        <div class="grid grid-rows-[80px_1fr_100px] grid-cols-[350px_1fr] h-screen ">
            <nav hx-trigger="refreshnav from:body" hx-get="/nav" hx-target="#nav" class="bg-gray-dark rounded-md p-4 m-2 overflow-auto row-span-2" id="nav"><?php echo $nav; ?></nav>
            <div class="bg-gray-dark rounded-md px-4 m-2 ml-0 mb-0 flex items-center"><?php echo $bar ?></div>
            <div class="bg-gray-dark rounded-md p-4 m-2 overflow-auto ml-0" id="main"><?php echo $main; ?></div>
            <div class="bg-black col-span-full grid grid-cols-3 grid-rows-1" id="player"><?php echo $player; ?></div>
        </div>
   </body>
</html>



