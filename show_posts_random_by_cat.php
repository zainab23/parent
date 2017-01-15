<?php
include_once 'include/translation.php';
if (!isset($_GET['cat'])){
    header('location: index.php');
    exit;
}
$post = post_get_random_by_cat($_GET['cat']);
if ($post)
    post_print($post);
else
    echo "<div class='error'>
            $Categoryempty
          </div>";
?>