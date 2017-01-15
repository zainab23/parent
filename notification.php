<?php include "include/header.php"; ?>
<?php include_once 'include/translation.php'; ?>

<?php user_update_session(); ?>
<div style="clear: both"></div>
<div class="notification_area">
    <?php
        $noti = noti_get_all();
        if ($noti){
            foreach($noti as $no){
                $user = user_get_by_id($no['pr_id']);
                if ($no['checked'] == 0)
                    echo "<div class='content uncheked'>";
                else
                    echo "<div class='content'>";
                    
                echo "<a href='profile.php?id={$user['id']}'><img src='{$user['img']}' /></a>";
                
                if ($no['type'] == 1)
                    echo "<a href='profile.php?id={$user['id']}'><b>{$user['f_name']}</b></a>
                    $likeyour <a href='show_post.php?id={$no['post_id']}'><i>$Post</i></a>";
                
                if ($no['type'] == 2)
                    echo "<a href='profile.php?id={$user['id']}'><b>{$user['f_name']}</b></a>
                    $commenttoyour <a href='show_post.php?id={$no['post_id']}'><i>$Post</i></a>";
                
                if ($no['type'] == 3)
                    echo "<a href='profile.php?id={$user['id']}'><b>{$user['f_name']}</b></a>
                    $sendyou <i> $friendrequest </i>";
                    
                if ($no['type'] == 4)
                    echo "<a href='profile.php?id={$user['id']}'><b>{$user['f_name']}</b></a>
                    $acceptyour <i>$friendrequest</i>";
                    
                if ($no['type'] == 5)
                    echo "<a href='profile.php?id={$user['id']}'><b>{$user['f_name']}</b></a>
                    $wantyour <a href='show_stuff.php?id={$no['stuff_id']}'><i>$Stuff</i></a>";
                    
                echo "<button class='remove_notification' s_id='{$no['id']}'> $remove </button>
                      </div>";
                
                
                
                
            }
        }else{
            echo "<div class='error'>
                    $EMnonotification
                  </div>";
        }
    ?>
   
    
    
</div>
