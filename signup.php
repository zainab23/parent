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
        if (isset($_POST['signin'])){
            extract($_POST);
            if (empty($first_name) || empty($email) || empty($password) || empty($password2) ){
                 $error="error"; 
                echo "<div class=$error>
                         $EMfillallfields 
                      </div>";
            }elseif ($password !== $password2){
                echo "<div class='error'>
                         $EMpasswordidentical 
                     </div>";
            }elseif (user_email_exist($email)){
                echo "<div class='error'>
                       $EMEmailexist 
                     </div>";  
                
            }else{
                 list($userName, $mailDomain) = split("@", $email);
              if (checkdnsrr($mailDomain, "MX")) {
               
                $result = user_singup($first_name, $email, $password, $type, $gender, $age);
                if ($result){
                    $user = user_get_by_email($email);
                    user_confirm_email($user['id'],$email,$user['rest_pass']);
                    header('location: confirm_email.php');
                }
                }else{
                   echo "<div class='error'>
                         $EMinvalidEmail 
                     </div>"; 
                }
                }
                       
                unset($_POST["signin"]);
  
        }

?> 
      
      <form name="form" method="post">
        <input type="text" name="first_name" placeholder=<?php echo $FirstName ?> />
        <input type="email"     name="email"      placeholder=<?php echo $Email ?> />
        <input type="password"  name="password"   placeholder=<?php echo $Password ?>  />
        <input type="password"  name="password2"  placeholder=<?php echo $ConfirmPassword ?>  />
        <label><?php echo $Areyou ?></label>
        <select name="type">
            <option value="1"><?php echo $NormalUser ?></option>
            <option value="2"><?php echo $BabySitter ?></option>
        </select>
        <label style="margin-right: 2px;"><?php echo $Gneder ?></label>
        <select name="gender">
            <option value="1"><?php echo $Male ?></option>
            <option value="2"><?php echo $Female ?></option>
        </select>
        <label style="margin-right: 27px;"><?php echo $Age ?></label>
        <select name="age">
            
            <?php
                for ($i = 18 ; $i < 100 ; $i++){
                    echo "<option value='$i'>$i</option>";
                }
            ?>
            
        </select> 
        <button class="login" name="signin" type="submit" ><?php echo $SignUp ?></button>
        <div class="bar"><span><?php echo $oruse ?></span></div>
        <button class="facebook"><?php echo $Facebook ?></button>
      </form>
      <div class="links">
        <a href="reset.php" class="first"  ><?php echo $ResetPassword ?></a>
        <a href="login.php" class="secend" ><?php echo $LogIn ?></a>
      </div>
    </div>
    
      
  </body>
</html>