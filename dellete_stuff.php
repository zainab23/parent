<?php
session_start();
include_once 'include/translation.php';

if (!isset($_SESSION['user']) && isset($_SESSION['admin'])){
    

    header('location: index.php');
    exit;    

}
if (  ( !isset(  $_GET['id']) || !isset($_GET['u_id']) ) &&  !isset($_POST['dellete'])   &&     !isset($_POST['cencel'])    ){
    header('location: index.php');
    exit;    
}

if (!isset($_POST['dellete'])){    
    if($_GET['u_id'] != $_SESSION['user']['id'] && !isset($_SESSION['admin'])){
        header('location: index.php');
        exit;
    }
}

if (isset($_POST['dellete'])){
    extract($_POST);
    include "include/user_api.php";
    include "include/stuff_api.php";
    suff_remove($id, $u_id);
    header('location: profile.php');
}

if (isset($_POST['cencel'])){
    header('location: profile.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <script src="js/jquery.js"></script>
    <link href="css/main.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    
    <div class="content_form">
      <form method="post">
        <div class="logout">
           <?php echo $toDellete ?>
             <br>
            <input type="submit" name="dellete" value="<?php echo $Dellete ?>" />
            <input type="submit" name="cencel" value="<?php echo $Cencel ?>" />
            <div style="clear: both"></div>
        </div>
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
        <input type="hidden" name="u_id" value="<?php echo $_GET['u_id']; ?>" />
      </form>
    </div>
    
  </body>
</html>