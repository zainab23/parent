<?php
include "include/header.php";
include_once 'include/translation.php';
if (!isset($_GET['id'])){
    header('location: index.php');
    exit;
}

$post[0] = post_get_by_id($_GET['id']);

if($post[0]){
    post_print($post);
}
else
    echo "<br><br><br><br><br><br><br><br><br>
          <div class='error' style='width: 500px'>
            $wrongLink
          </div>
          <br><br><br><br><br><br><br><br><br>";

include "include/footer.php";
?>