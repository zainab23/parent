<?php
session_start();
if ($_SESSION['user']['account_status'] === 0)
    exit;
if (isset($_SESSION['user']['id']) && isset($_POST['text']) && isset($_POST['u_id'])){
    include_once 'include/user_api.php';
    include_once 'include/msg_api.php';
    include_once 'include/function.php';
    
    msg_send_new($_POST['u_id'], $_POST['text']);
    

}

?>