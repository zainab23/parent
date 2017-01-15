<?php include "include/header.php";
include "include/translation.php";
if (!isset($_SESSION['user'])){
    header('location: index.php');
    exit;
}
?>
<script src="js/msg.js"></script>

<div class="col_left">
    <div class="chat_list">
       
        <?php
        // will get all previous chat list
            $ids = user_get_id_user_chat_list();
            
            if ($ids){
                $ids = array_unique($ids);
                $i = 0;
                foreach ($ids as $id){
                    $users[$i] = user_get_by_id($id);
                    $i++;
                }
                
          //will check if it is new massages or not >>
                foreach ($users as $user){
                    if (msg_check($user['id']))
                        echo "<div u_id='{$user['id']}' class='contact' style='background: yellow'>
                                <img src='{$user['img']}' />
                                <p>{$user['f_name']} {$user['l_name']}</p>
                                <div style='clear: both'></div>
                              </div>";
                    else
                        echo "<div u_id='{$user['id']}' class='contact'>
                                <img src='{$user['img']}' />
                                <p>{$user['f_name']} {$user['l_name']}</p>
                                <div style='clear: both'></div>
                              </div>";
                }
            }else{
                echo "<div class='no_list'>$EMnoconversation</div>";                
            }
        ?>
        
        
        
    </div>
    <div class="search_contact"><input class="search_chat_list" type="text" placeholder="<?php echo $Search ;?>" /></div>
</div>
<div class="col_right">
    
    <div class="chat_box">
        
        <?php
        if (!isset($_GET['id'])){
            echo "<div class='shose'> <= $chosecontact </div>";
        }else{
            include "get_msgs.php";
        }
        
        ?>
    </div><!-- chat_box -->
    
    
</div>
<?php include "include/footer.php"; ?>