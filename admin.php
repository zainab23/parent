
<?php
include "include/user_api.php";
session_start();

include_once 'include/translation.php';

if (isset($_SESSION['admin']) ){
    if (isset($_GET['id'])){
    $User= user_get_by_id($_GET['id']);
    $id=$User['id'];
    
  if ($User['account_status'] === 0){
      $status= 1;
      User_block_user($status,$id);
        $M="user unblocked successfully";
 }else {
   $status=0;
     User_block_user($status,$id);
            $M="user blocked successfully";
  }
    
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