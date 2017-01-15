
<?php include "include/header.php" ?>
    <?php
if (!isset($_SESSION['user']) && !isset($_GET['id'])){
    header('location: index.php');
    exit;
}

if (isset($_GET['id'])){
    if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $_GET['id']){
        $profile_user = $_SESSION['user'];
    }else{
        $profile_user = user_get_by_id($_GET['id']);
        if (!$profile_user){
            header('location: index.php');
            exit;
        }
    }
}elseif (isset($_SESSION['user'])){
    $profile_user = $_SESSION['user'];
}  
?>
<div class="col_left">

<div class="top">
    <a href="<?php echo "profile.php?id={$profile_user['id']}"; ?>">
        <img src="<?php echo $profile_user['img']; ?>" class="" alt="profile pictur" />
        <p><?php
                echo $profile_user['f_name'];
                if (isset($profile_user['l_name']))
                echo " ".$profile_user['l_name'];
            ?></p>
    </a>
    <?php if (isset($_SESSION['user']) && $profile_user['id'] != $_SESSION['user']['id']){?>
    
        <?php if (!in_array($profile_user['id'], $_SESSION['user']['frineds'])  &&
                  !in_array($profile_user['id'], $_SESSION['user']['req_in'])  &&
                  !in_array($profile_user['id'], $_SESSION['user']['req_out'])){ ?>
                  
            <button class="add" action="add" uid="<?php echo $profile_user['id']; ?>">Add Friend</button>
        <?php } ?>
        
        <?php if (!in_array($profile_user['id'], $_SESSION['user']['frineds'])  &&
                   in_array($profile_user['id'], $_SESSION['user']['req_in'])  &&
                  !in_array($profile_user['id'], $_SESSION['user']['req_out'])){ ?>
                  
            <button class="add" action="accept" uid="<?php echo $profile_user['id']; ?>">Accept</button>
        <?php } ?>
        
        <?php if (!in_array($profile_user['id'], $_SESSION['user']['frineds'])  &&
                  !in_array($profile_user['id'], $_SESSION['user']['req_in'])  &&
                   in_array($profile_user['id'], $_SESSION['user']['req_out'])){ ?>
                  
            <button class="add" action="cencel" uid="<?php echo $profile_user['id']; ?>">Cencel</button>
        <?php } ?>
        
        <?php if ( in_array($profile_user['id'], $_SESSION['user']['frineds'])  &&
                  !in_array($profile_user['id'], $_SESSION['user']['req_in'])  &&
                  !in_array($profile_user['id'], $_SESSION['user']['req_out'])){ ?>
                  
            <button class="add" action="unfriend" uid="<?php echo $profile_user['id']; ?>">Unfriend</button>
        <?php } ?>
        
        <?php if (in_array($profile_user['id'], $_SESSION['user']['frineds']) ) {?>
            <a hre="#" class="msg" uid="<?php echo $profile_user['id']; ?>">Message</a>
        <?php } ?>
        
        
        <button class="show_post" uid="<?php echo $profile_user['id']; ?>">Posts</button>
        
    <?php } ?>
    <div style="clear: both"></div>
</div>


<div class="bottom">
    <h3>Category</h3>
    <ul>
        <li><a href="index.php?cat=baby_food">Baby Food</a></li>
        <li><a href="index.php?cat=baby_health">Baby Health</a></li>
        <li><a href="index.php?cat=newborn_babies">Newborn Babies</a></li>
        <li><a href="index.php?cat=baby_gear">Baby Gear</a></li>
        <li><a href="index.php?cat=baby_games">Baby Games</a></li>
    </ul>
</div>
</div>


<?php include_once 'include/translation.php';?>

<div class="col_right">
    <?php if ($profile_user['account_type'] == 2){
                echo "<div class='bc_header'>Baby Center Profile</div>";
          }
    ?>
   
    
    <div class="profile_conten">
    
    <?php
    
    $post = post_get_by_u_id($profile_user['id']);
    if($post)
        post_print($post);
    else
        echo "<br><br><br><br><br><br><br><br><br>
              <div class='error' style='width: 500px'>
                 $Noposts
              </div>";
        
    
    
    
    ?>
    
    </div>
    
</div>
<?php include "include/footer.php" ?>