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
       <meta charset="utf-8" />
    <script src="js/jquery.js"></script>
    <link href="css/main.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    
    <div class="content_form">
      <h1><?php echo $HELLOPARENTS ?></h1>
       <?php
      include "include/user_api.php";
         if (isset($_POST['reset'])){
            extract($_POST);
            if (empty($email) ){
                echo "<div class='error'>
                         $EMfillallfields 
                      </div>";
            }else{
              $user = user_get_by_email($email);
              if ($user == false){
                echo "<div class='error'>
                        $EMEmailwrong 
                      </div>";
              
              }else{
              user_send_email($user['id'],$user['email'],$user['rest_pass']);
              $id=$user['id'];
              $code=$user['rest_pass'];
             header("location: check_number.php");
             
              }
                              
            }
        }
      ?>
      
      <form method="post">
        <input type="text" name="email" placeholder="<?php echo $Email ?>" />
        <button class="login" type="submit" name="reset"><?php echo $ResetPassword ?></button>
       
      </form>
      <div class="links"> 
          <br>
          <a href="login.php" class="first"  ><?php echo $OrBackLogIn ?></a>
      </div>
    </div>
    
  </body>
</html>