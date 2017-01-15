 <?php include_once 'include/translation.php';?>
<div class="col_left">

<?php if (isset($_SESSION['user'])){
    $profile_user = $_SESSION['user'];
    ?>
<div class="top">
    <a href="<?php echo "profile.php?id={$profile_user['id']}"; ?>">
        <img src="<?php echo $profile_user['img']; ?>" class="" alt="profile pictur" />
        <p><?php
                echo $profile_user['f_name'] . " " . $profile_user['l_name'] ;
                if ($profile_user['account_type'] == 2)
                echo "<br><span style='font-size: 14px'>  ($BabySitter )</span>";
            ?></p>
    </a>
    
    <div style="clear: both"></div>
</div>
<?php } ?>

<div class="bottom">
    <h3><?php echo $Category ?></h3>
    <ul>
        <li><a href="index.php?cat=baby_food"><?php echo $BabyFood ?></a></li>
        <li><a href="index.php?cat=baby_health"><?php echo $BabyHealth ?></a></li>
        <li><a href="index.php?cat=newborn_babies"><?php echo $NewbornBabies ?></a></li>
        <li><a href="index.php?cat=baby_gear"><?php echo $BabyGear ?></a></li>
        <li><a href="index.php?cat=baby_games"><?php echo $BabyGames ?></a></li>
    </ul>
</div>
</div>