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
        echo "<div class='head'>
                <a href='profile.php?id={$user['id']}'><img src='{$user['img']}' /></a>
                <a href='profile.php?id={$user['id']}'><p>{$user['f_name']} {$user['l_name']}</p></a>
              </div>
             
              <br>
              <div class='content_msg'><div class='scroll'>";
        
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
            echo "<div class='shose'> $nomesswritething </div>";
        }
        
              
        echo "</div></div><!-- content_msg -->
        
              <div class='send_msg'>
                <textarea id='new_msg' u_id='{$_GET['id']}' placeholder='$nomesswritething'></textarea>
              </div>";
    }else{
        echo "<div class='shose'> <= $chosecontact </div>";
    }
    
    
    
}
?>

<script>
	$(document).ready(function(){
        $(".content_msg").scrollTop(200000000);
		$("#new_msg").keyup(function(e){
            
	        var _this = $(this);
	        if (e.keyCode == 13  &&  _this.val().length > 1){
	          var text = _this.val();
	          var u_id = _this.attr('u_id');
              var new_msg = $("<div></div>");
              var html_msg = "<?php echo "<img class='profile' src='{$_SESSION['user']['img']}' /><p>  "; ?>" + text + "</p><div style='clear: both'></div>";
              
              $(new_msg).addClass("msg_left");
              $(new_msg).addClass("not_yet");
              $(new_msg).html(html_msg);
              $(".content_msg").append(new_msg);
              
	          $.ajax({
	          	url     :  'ajax_add_new_msg.php',
	            type    :  'POST',
	            data    :  {text : text, u_id : u_id},
	            
                success :  function(){
                    _this.val('');
                    $(new_msg).removeClass("not_yet");
		            $(".content_msg").scrollTop(200000000);
	            }
                
	          });
              
              
	        }
        });
		
		
		for (var i = 1; i < 99999; i++)
			window.clearInterval(i);
			
        setInterval(function(){
            
            var id = <?php echo $_GET['id']; ?>;
            $.ajax({
                url : 'ajax_get_msgs2.php',
                type : 'GET',
                data : { id : id},
                success : function(rt){
                    $(".content_msg").html(rt);
                }
            });
            
        }, 3000);
		


        
        
	});

	

</script>
