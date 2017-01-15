<?php 
session_start();
include_once 'include/translation.php';

?>
    
<!DOCTYPE html>
<html>
  <head>
       <meta charset="utf-8" />
    <link href="css/main.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    
    <h1 class="about_title"><?php echo $AboutUs ?></h1>
    <div class="about">
        <p><?php echo $aboutpart1 ?></p>
        <p><?php echo $aboutpart2 ?></p>
        <p><?php echo $aboutpart3 ?><a href="index.php"><?php echo $aboutpart4 ?></a></p>
    </div>
    
  </body>
</html>

