<?php
session_start();
include_once 'include/translation.php';
if (isset($_GET['id'])){
    $_GET['id'] = (int) $_GET['id'];
    include_once 'include/user_api.php';
    include_once 'include/msg_api.php';
    include_once 'include/function.php';
    $user = user_get_by_id($_GET['id']);
    if ($user){
        echo "<div class='scroll'>";
        
        $msgs = msg_get_conversation($_GET['id']);
        if ($msgs){
            foreach($msgs as $msg){
                if ($msg['from_id'] == $_SESSION['user']['id'])
                    echo "<div class='msg_left'>
                                <img class='profile' src='{$_SESSION['user']['img']}' />
                                <p>{$msg['text']}</p>
                                <div style='clear: both'></div>
                          </div>";
                else
                    echo "<div class='msg_right'>
                                <img class='profile' src='{$user['img']}' />
                                <p>{$msg['text']}</p>
                                <div style='clear: both'></div>
                          </div>";
            }
        }else{
            echo "<div class='shose'> $nomesswritething</div>";
        }
        
              
        echo "</div>";
    }else{
        echo "<div class='shose'> <= $chosecontact </div>";
    }
    
    
    
}
?>

<script>
	$(document).ready(function(){
        $(".content_msg").scrollTop(200000000);        
	});

	

</script>
