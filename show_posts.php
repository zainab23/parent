
<?php
$post = post_get_assoc($_SESSION['user']['id']);
if($post)
    post_print($post);
else
    include "show_posts_random.php";
?>