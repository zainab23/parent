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
         if (isset($_POST['login'])){
            extract($_POST);
            if (empty($email) || empty($password) ){
                echo "<div class='error'>
                         $EMfillallfields
                             
                      </div>";
                
            }else{
              $user = user_get_by_email($email);
              if ($user == false){
                echo "<div class='error'>
                        $EMEmailwrong 
                      </div>";
              }elseif($user['password'] != md5($password)){
                echo "<div class='error'>
                       $EMPasswordwrong
                      </div>";
              }else{
                $_SESSION['user'] = $user;
                if (isset($_SESSION['user'])&& $_SESSION['user']['email']=="helloparentsweb@gmail.com" ){
                $_SESSION['admin']=$_SESSION['user']['id'];}
                header('location: index.php');
              }
                              
            }
        }
      ?>
      
      <form method="post">
        <input type="text" name="email" placeholder="<?php echo $Email ?>" />
        <input type="password" name="password"  placeholder="<?php echo $Password ?>" />
        <button class="login" type="submit" name="login"><?php echo $LogIn ?></button>
        <div class="bar"><span><?php echo $oruse ?></span></div>
        <button class="facebook"><?php echo $Facebook ?></button>
      </form>
      <div class="links">
        <a href="reset.php" class="first"  ><?php echo $ResetPassword ?></a>
        <a href="signup.php" class="secend" ><?php echo $SignUp ?></a>
      </div>
    </div>
    
  </body>
</html>