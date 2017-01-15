<?php
include "include/user_api.php";
include "include/post_api.php";
include "include/comment_api.php";
include "include/notification_api.php";


session_start();

include_once 'include/translation.php';

if (isset($_SESSION['admin']) ){
    if (isset($_GET['id'])){
    $post= post_get_by_id($_GET['id']);
   $post_type=$post['type'];
    $id=$post['id'];
    
    if ($post_type == 3){
		unlink($post['video']);
	}else if($post_type == 2){
		if ($post['img'] != $_SESSION['user']['img'])
			unlink($post['img']);
	}
        noti_remove_by_post_id($id);
        comment_remove($id);
	post_remove($id);
            $M= "post deleted succsesly";
        }  else {
            $M= "post dont deleted :( ";
        }
    
    
           
    

}  else {
        $M= "you are not allowed to enter this page";

}

    
?>

<!DOCTYPE html>
<html>
  <head>
    <link href="css/main.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    
    <div class="content_form">
      
      <?php
     
echo  $M
      ?>  
        <a href="<?php echo "index.php"; ?>">....>>Back to home bage</a> 
    </div>
    
  </body>
</html>