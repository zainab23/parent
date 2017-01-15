<?php
session_start();
if ($_SESSION['user']['account_status'] === 0)
    exit;
if (!isset($_SESSION['user'])){
    header('location: index.php');
    exit;
}
include "include/stuff_api.php";
include "include/user_api.php";
extract($_POST);

stuff_add_wanted($id, $u_id);

?>