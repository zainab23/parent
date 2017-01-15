<?php
session_start();
include_once 'include/translation.php';
 
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
      
      
     if (isset($_POST['submit'])){
            extract($_POST);
            if (empty($password) || empty($password2) ){

                echo "<div class='error'>
                         $EMfillallfields 
                      </div>";
            }elseif ($password !== $password2){
                echo "<div class='error'>
                         $EMpasswordidentical 
                     </div>";
            }else{
               $id= $_GET['id'];
                $result = user_update_pass($password,$id);
                $user=  user_get_by_id($id);
                $_SESSION['user']=$user;
             header("location: index.php");
                
                }
                     
  
        }  
      ?>
      
      <form method="post">
          
          <p class="explain" > <br>  <?php echo $Mnewpass ?>  </p>
         <input type="password"  name="password"   placeholder=<?php echo $Password ?>  />
        <input type="password"  name="password2"  placeholder=<?php echo $ConfirmPassword ?>  />
        <button class="login" type="submit" name="submit"><?php echo $sub ?></button>
       
      </form>
     <div class="links"> 
          <br>
          <a href="login.php" class="first"  ><?php echo $OrBackLogIn ?></a>
      </div>
    </div>
    
  </body>
</html>