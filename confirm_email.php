<?php


session_start();
include_once 'include/translation.php';
if (isset($_SESSION['user'])){
    header('location: index.php');
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
      <h1><?php echo $HELLOPARENTS ?></h1>
        <?php
        include 'include/user_api.php';
        if (isset($_GET['code'],$_GET['id'])){
            
            if($user['rest_pass'] == $code ) {
        
                       user_confirm($_GET['id']);
                   $user=  user_get_by_id($_GET['id']);
                   
                    $_SESSION['user'] = $user;
                  header('location: index.php');  
                  
                  
                  
            }    
        }

?> 
      
      <form name="form" method="post">
          <p class="explain"> <br> We send you an email contain link , press that link to confirm your email </p>
      </form>
     
    </div>
    
      
  </body>
</html>