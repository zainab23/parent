<?php
session_start();
if (isset($_SESSION['user']) && isset($_POST['text']) ){
    
    include_once 'include/user_api.php';
    include_once 'include/post_api.php';
    include_once 'include/comment_api.php';
    include_once 'include/stuff_api.php';
    include_once 'include/notification_api.php';
    include_once 'include/msg_api.php';
    include_once 'include/function.php';
    
    
    
    
    $ids = user_get_id_user_chat_list();
    
    if ($ids){
        
        $ids = array_unique($ids);
        
        if (!empty($_POST['text'])){
            $i = 0;
            foreach ($ids as $id){
                $tmp = user_get_by_id($id);
                if (
                        (strpos($tmp['f_name'], $_POST['text']) !== false) ||
                        (strpos($tmp['l_name'], $_POST['text']) !== false) ||
                        (strpos($tmp['email'], $_POST['text']) !== false)
                   )
                {
                    $users[$i] = $tmp;
                    $i++;
                }
            }
        }else{
            $i = 0;
            foreach ($ids as $id){
                $users[$i] = user_get_by_id($id);
                $i++;
            }
        }
        
        
        
        
        if (isset($users)){
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
        echo "<div class='no_list'>There is not search reasult</div>";                
        }
        
        
    }else{
        echo "<div class='no_list'>There is not any recently conversations</div>";                
    }
}
?>

<script>
$(document).ready(function(){
    $(".contact").click(function(){
		var _this = $(this);
		$(this).css('background','#fff');
		var id = $(this).attr("u_id");

		$.ajax({
            url : 'ajax_get_msgs.php',
            type : 'GET',
            data : { id : id},
            success : function(rt){
            	$(".chat_box").html(rt);
            }
          });

	});
});
</script>