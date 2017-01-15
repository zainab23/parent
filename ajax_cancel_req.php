<?php
session_start();
if ($_SESSION['user']['account_status'] === 0)
    exit;
if (isset($_SESSION['user']) && isset($_POST['u_id']) ){
    include_once 'include/user_api.php';
    include_once 'include/function.php';
    user_cancel_req($_POST['u_id']);
}
?>