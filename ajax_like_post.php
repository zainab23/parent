<?php
session_start();
if ($_SESSION['user']['account_status'] === 0)
    exit;
if (!isset($_SESSION['user'])){
  header('location: index.php');
  exit;
}

if (isset($_POST['p_id'])){
    extract($_POST);
	include 'include/user_api.php';
    include 'include/post_api.php';
	include 'include/function.php';
    
    
    if (!in_array($p_id, $_SESSION['user']['like_post'])){
        $res = post_add_like($p_id);
        if ($res)
            echo '{ "result" : "ok" }';
        else
            echo '{ "result" : "no" }';
    } else
            echo '{ "result" : "no" }';

}


?>