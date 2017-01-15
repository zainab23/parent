<?php
session_start();
include_once 'include/user_api.php';
include_once 'include/post_api.php';
include_once 'include/comment_api.php';
include_once 'include/stuff_api.php';
include_once 'include/notification_api.php';
include_once 'include/msg_api.php';
include_once 'include/function.php';
include_once 'include/translation.php';

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
    <script src="js/jquery.js"></script>
    <script src="js/ajax.js"></script>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <div class="container">
      <ul class="top_nav">
        <li><a href="about.php"><?php echo $AboutUs ?></a></li>
        <?php if (isset($_SESSION['user'])){?>
        <li><a href="logout.php"><?php echo $LogOut ?></a></li>
        <?php } ?>
        <?php if (!isset($_SESSION['user'])){?>
        <li><a href="login.php"><?php echo $LogIn ?></a></li>
        <li><a href="signup.php"> <?php echo $SignUp ?></a></li>
        <?php } ?>
      </ul>
      <?php if (isset($_SESSION['user']) && $_SESSION['user']['account_status'] === 0){?>
      <div class="blocked_account">
        <span><?php echo $EMisblocked ?></span>
        <i><?php echo $EMblocked ?></i>
      </div>
      <?php } ?>
        <header>
            <span class="logo"><?php echo $HELLOPARENTS ?></span>
            <form action="search.php" method="post">
            <button class="btn_search" name="btn" value="search" type="submit"><?php echo $Search ?></button>
            <input class="input_search" name="search" type="text" placeholder="<?php echo $Search ?>" />
            </form>
        </header>

        <ul class="navbar">
          <?php if (isset($_SESSION['user'])){ ?>
            <li><a href="index.php"><?php echo $Home ?></a></li>
            <li><a href="profile.php"><?php echo $Profile ?></a></li>
            <li><a href="msg.php" <?php if (msg_get_unread()) echo "class='alert'"; ?> ><?php echo $Messages ?></a></li>            
            <li><a href="notification.php" <?php if (noti_get_new()) echo "class='alert'"; ?> ><?php echo $Notifications ?></a></li>
            
          <?php } ?>
        </ul>
        
        
    
           

                
        <ul class="lang">
          <li><a href="index.php?lang=english" >En</a></li>
          <li><a href="index.php?lang=arabic">عربي</a></li>
        </ul>
        <div style="clear: both"></div>
        <div class="block">
          