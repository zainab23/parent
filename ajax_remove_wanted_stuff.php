<?php
session_start();
if (!isset($_SESSION['user'])){
    header('location: index.php');
    exit;
}
include "include/stuff_api.php";
include "include/user_api.php";
extract($_POST);

stuff_remove_wanted($id, $u_id);

?>