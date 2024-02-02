<?php
if (!isset($nav)) {
   $nav = '<p>no nav</p>';
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
      <title>TITLE</title>
      <link href="../static/css/output.css" rel="stylesheet" /> 
      <script src="https://unpkg.com/htmx.org@1.9.10"></script>
      <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
      
   </head>

   <body>
        <div class="grid grid-rows-[90%_10%] grid-cols-[22.5%_77.5%] h-screen bg-black">
            <nav class="bg-gray-dark rounded-md p-4 m-2 overflow-auto" id="nav"><?php echo $nav; ?></nav>
            <div class="bg-gray-dark rounded-md p-4 m-2 ml-0" id="main"><?php echo $main; ?></div>
            <div class="bg-black col-span-full grid grid-cols-3 grid-rows-1" id="player"><?php echo $player; ?></div>
        </div>
   </body>
</html>

