<?php
session_start();
if (!isset($_SESSION['user'])){
  header('location: index.php');
  exit;
}

if (isset($_POST['text']))
{
  
	if ($_SESSION['user']['account_status'] === 0)
	  exit;
	  
	extract($_POST);
	include 'include/comment_api.php';
    include 'include/user_api.php';
	include 'include/post_api.php';
	include 'include/function.php';
    
    comment_add($_SESSION['user']['id'], $p_id,$text);
    
    $time = strftime('%d/%m/%Y %H:%M',time());
    echo "<div class='comment'>
            <img src='{$_SESSION['user']['img']}' alt='{$_SESSION['user']['f_name']} {$_SESSION['user']['l_name']}' />
            <p class='time'>$time</p>
            <p class='secend'><a href='#'>{$_SESSION['user']['f_name']} {$_SESSION['user']['l_name']}</a>$text</p>
            <div style='clear: both'></div>
          </div>";	
}
?>