<?php
session_start();
if (isset($_SESSION['user']) && isset($_POST['u_id']) && $_SESSION['user']['account_status'] !== 0 ){
    include_once 'include/user_api.php';
    include_once 'include/function.php';
    user_accept_req($_POST['u_id']);
}
?>