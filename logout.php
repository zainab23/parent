<?php
session_start();
 include "include/translation.php";       

if (!isset($_SESSION['user'])){
    header('location: index.php');
    exit;
}

if (isset($_POST['logout'])){
    $_SESSION['user'] = null;
    $_SESSION['admin'] = null;
    header('location: index.php');
    exit;
}

if (isset($_POST['cencel'])){
    header('location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
  <head>
       <meta charset="utf-8" />
    <script src="js/jquery.js"></script>
    <link href="css/main.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    
    <div class="content_form">
      <form method="post">
        <div class="logout">
           <?php echo $tologout ?>
            <br>
            <input type="submit" name="logout" value="<?php echo $LogOut ?>" />
            <input type="submit" name="cencel" value="<?php echo $Cencel ?>" />
            <div style="clear: both"></div>
        </div>        
      </form>
    </div>
    
  </body>
</html>