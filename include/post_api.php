

<?php
   include_once 'include/translation.php';
 

function post_add_like($p_id){
    if ($_SESSION['user']['account_status'] === 0)
        return false;
    $mysqli = connect();
    $stmt = $mysqli->prepare("UPDATE `users` SET `like_post`= ? WHERE `id` = ?");
    $like_post = $_SESSION['user']['like_post'];
    array_push($like_post, $p_id);
    $like_post = serialize($like_post);
    $stmt->bind_param("si", $like_post,$_SESSION['user']['id']);
    $res = $stmt->execute();

    if ($res){
        user_update_session();
        $stmt = $mysqli->prepare("SELECT `likes` , `u_id` FROM `posts` WHERE `id` = ?");
        $stmt->bind_param("i", $p_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $likes = $res->fetch_assoc();
        $u_id = $likes['u_id'];
        $likes = (int) $likes['likes'];
        $likes = $likes + 1;
        $stmt = $mysqli->prepare("UPDATE `posts` SET `likes`= ? WHERE `id` = ?");
        $stmt->bind_param("ii", $likes, $p_id);
        $stmt->execute();
        
        if ($u_id != $_SESSION['user']['id']){
            $stmt = $mysqli->prepare("INSERT INTO `notifications`
                                        (`u_id`, `pr_id`, `post_id`, `stuff_id`, `type`, `time`, `checked`)
                                              VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("iiiiiii", $u_id, $pr_id, $post_id, $stuff_id, $type, $time, $checked);
            $pr_id = $_SESSION['user']['id'];
            $post_id = $p_id;
            $stuff_id = null;
            $type = 1;
            $time = time();
            $checked = 0;
            $stmt->execute();
        }
            
        
        $mysqli->close();
        return true;
    }else{
        $mysqli->close();
        return false;
    }
}


function post_add_new($text, $img, $video, $type, $cat){
    if ($_SESSION['user']['account_status'] === 0)
        return false;
    $u_id = $_SESSION['user']['id'];
    $time = time();
    $last_activity = time();
    $likes = 0;
    $mysqli = connect();
    $stmt = $mysqli->prepare("INSERT INTO `posts`(
                                `u_id`, `time`, `last_activity`,
                                `text`, `img`, `video`, `likes`,
                                `type`, `cat`)
                              VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param('iiisssiis', $u_id, $time, $last_activity, $text, $img, $video, $likes, $type, $cat);
    $res = $stmt->execute();
    
    $stmt = $mysqli->prepare("SELECT * FROM `posts` WHERE `u_id` = ? AND `time` = ? AND `text` = ? ");
    $stmt->bind_param('iis', $u_id, $time, $text);
    $stmt->execute();
    $res2 = $stmt->get_result();
    $new_post = $res2->fetch_assoc();
    
    if ($res){
        $stmt = $mysqli->prepare("UPDATE `users` SET `post`= ? WHERE `id` = ?");
        $posts = $_SESSION['user']['post'];
        array_push($posts, $new_post['id']);
        $posts = serialize($posts);
        $stmt->bind_param("si", $posts,$_SESSION['user']['id']);
        $stmt->execute();
        $mysqli->close();
        user_update_session();
        return true;
    }
    else{
        $mysqli->close();
        return false;
    }
    
}


function post_get_random(){
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `posts` ORDER BY `last_activity` DESC LIMIT 10");
    $stmt->execute();
    $res = $stmt->get_result();
    $posts = $res->fetch_all(MYSQLI_ASSOC);
    
    if ($posts)
        return $posts;
    else
        return array();
}

function post_get_random_by_cat($cat){
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `posts` WHERE `cat` = ? ORDER BY `last_activity` DESC LIMIT 10");
    $stmt->bind_param('s', $cat);
    $stmt->execute();
    $res = $stmt->get_result();
    $posts = $res->fetch_all(MYSQLI_ASSOC);
    
    if ($posts)
        return $posts;
    else
        return array();
}








function post_get_assoc($id){
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `posts` WHERE `u_id` = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $posts1 = $res->fetch_all(MYSQLI_ASSOC);
    if (  count($_SESSION['user']['frineds']) != 0  ){
        $i = 0;
        foreach($_SESSION['user']['frineds'] as $fr_id){
            
            $stmt = $mysqli->prepare("SELECT * FROM `posts` WHERE `u_id` = ?");
            $stmt->bind_param('i', $fr_id);
            $stmt->execute();
            $res = $stmt->get_result();
            $posts2[$i] = $res->fetch_all(MYSQLI_ASSOC);
            $i++;
            
        }
    }
    
    if (  count($_SESSION['user']['like_post']) != 0  ){
        $i = 0;
        foreach($_SESSION['user']['like_post'] as $like_id){
            $stmt = $mysqli->prepare("SELECT * FROM `posts` WHERE `id` = ?");
            $stmt->bind_param('i', $like_id);
            $stmt->execute();
            $res = $stmt->get_result();
            $posts3[$i] = $res->fetch_all(MYSQLI_ASSOC);
            $i++;
        }
    }
    
    if (  count($_SESSION['user']['comment_post']) != 0  ){
        foreach($_SESSION['user']['comment_post'] as $comment_id){
            $i = 0;
            $stmt = $mysqli->prepare("SELECT * FROM `posts` WHERE `id` = ?");
            $stmt->bind_param('i', $comment_id);
            $stmt->execute();
            $res = $stmt->get_result();
            $posts4[$i] = $res->fetch_all(MYSQLI_ASSOC);
            $i++;
        }
    }
    
    $posts5 = post_get_random($id);
    
    
    $posts[1] = $posts1;
    $total = count($posts[1]);
    if (isset($posts2)){
        $posts[2] = multi_array_extract($posts2);
        $total += count($posts[2]);
    }
    if (isset($posts3)){
        $posts[3] = multi_array_extract($posts3);
        $total += count($posts[3]);
    }
    if (isset($posts4)){
        $posts[4] = multi_array_extract($posts4);
        $total += count($posts[4]);
    }
    if (isset($posts5) &&  $total < 20   )
        $posts[5] = $posts5;
        
    $posts = multi_array_extract($posts);
    $posts = multi_array_unique($posts);
    $posts = multi_array_sort($posts, 'last_activity');   
    
    
    if ($posts)
        return $posts;
    else
        return array();
}

function post_get_by_id($id){
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `posts` WHERE `id` = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $post = $res->fetch_assoc();
    if ($post)
        return $post;
    else
        return false;
}

function post_search_detail($text, $cat){
    
	$query = "SELECT * FROM `posts` WHERE 1 ";	
	
	if (!empty($text))
		$query .= " AND ( `text` LIKE '%$text%' ) ";
		
	if (!empty($cat))
		$query .= " AND ( `cat` = '$cat' ) ";
	
    $mysqli = connect();
    $res = $mysqli->query($query, MYSQLI_USE_RESULT);
    $posts = $res->fetch_all(MYSQLI_ASSOC);
    if ($posts)
        return $posts;
    else
        return false;
}

function post_get_by_u_id($u_id){
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `posts` WHERE `u_id` = ?");
    $stmt->bind_param('i', $u_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $post = $res->fetch_all(MYSQLI_ASSOC);
    if ($post)
        return $post;
    else
        return false;
}



 function post_print($posts_array){
     global $Category;
     global $Like;
     global $commenthere;
     global $BabySitter; 
     global $DelletePosts;
    if (count($posts_array) > 0){
        foreach($posts_array as $post){
        $user = user_get_by_id($post['u_id']);
        $post_time = strftime('%d/%m/%Y %H:%M',$post['time']);
        $category = ucwords(str_replace('_', ' ', $post['cat']));
        $category=check_cat_translit($category);
        
        
      if (isset($_SESSION['admin'])){  
          
         $Delete_posts= "<a class='Delete_posts' href='admindelet.php?id={$post['id']}'> $DelletePosts </a>";
         
         }else{
            $Delete_posts="";
         }
        
         
        if ($user['account_type'] == 2)
            $bc = "<span style='font-size: 10px'> ($BabySitter) </span>";
        else
            $bc = "";
        echo "<div class='post'><!-- post -->
                    <div class='head'>
                        <a href='profile.php?id={$user['id']}'>
                            <img src='{$user['img']}' alt='{$user['f_name']} {$user['l_name']}' />$Delete_posts

                            <p class='first'>{$user['f_name']} {$user['l_name']} {$bc}</p>
                        </a>
                        <p class='secend'>$post_time</p>
                        <span class='cat'><b> $Category </b> : $category</span>
                    </div>
                    <div class='text'>
                        {$post['text']}
                    </div>";
        if ($post['type'] == 2)
            echo "<div class='media'>
                        <img src='{$post['img']}' alt='{$post['img']}' />
                  </div>";
        if ($post['type'] == 3){
            $video_type = explode('.', $post['video']);
            $video_type = $video_type[count($video_type) - 1];
            echo "<div class='media'>
                    <video controls>
                          <source src='{$post['video']}' type='video/$video_type'>
                    </video>
                  </div>";
        }
        if (isset($_SESSION['user']))
            echo "<div class='btns'>
                            <a href='#' class='like_btn' pid='{$post['id']}' >$Like</a><p class='first'>{$post['likes']}</p>
                            <div style='clear: both'></div>
                  </div>";
        if (!isset($_SESSION['user']))
            echo "<div class='btns'>
                            $Like <p class='first'>{$post['likes']}</p>
                            <div style='clear: both'></div>
                  </div>";
        echo "<div class='comments'>";
        $comments = comment_get_by_p_id($post['id']);
        if ($comments){
            foreach ($comments as $comm){
                $user_comment = user_get_by_id($comm['u_id']);
                if ($user_comment['account_type'] == 2){
                   $bcc= "<span style='font-size: 16px'> ($BabySitter) </span>";
                }  else {
                    $bcc="";
                }
                $comment_time = strftime('%d/%m/%Y %H:%M',$comm['time']);
                echo "<div class='comment'>
                            <img src='{$user_comment['img']}' alt='{$user_comment['f_name']} {$user_comment['l_name']}' />
                            <p class='time'>$comment_time</p>
                            <p class='secend'><a href='#'>{$user_comment['f_name']} {$user_comment['l_name']}$bcc</a>{$comm['text']}</p>
                            <div style='clear: both'></div>
                        </div>";
            }
        }
        
        if (isset($_SESSION['user']) && $_SESSION['user']['account_status'] !== 0)
            echo "<div class='write'>
                    <textarea class='add_comment' pid='{$post['id']}' placeholder=' $commenthere '></textarea>
                    <div style='clear: both'></div>
                  </div>";
                  
        echo "</div>
                </div><!-- post -->";
        }
    
    }
    
   
}

function post_remove($id){
               
               $mysqli = connect();
                delet_related_post_comment_like($id);
                
		$stmt = $mysqli->prepare("DELETE FROM `posts` WHERE `id` = ?");
		$stmt->bind_param("i",$id);
                $res = $stmt->execute();
    		$mysqli->close();
        
    if ($res)
        return true;
    else
        return false;
	}  
         function delet_related_post_comment_like($num){
             
            $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `users` ");
    $stmt->execute();
    $res = $stmt->get_result();
    $users = $res->fetch_all(MYSQLI_ASSOC);
    foreach($users as $user){
        
       $id= $user['id'];  
      $like_post =$user['like_post'];
       $like_post  = poast_array_check($like_post,$num,$id);
      $post =$user['post'];
       $post=   poast_array_check($post,$num,$id);
      $comment_post =$user['comment_post'];
     $comment_post= poast_array_check($comment_post,$num,$id);
        $mysqli = connect();
        $stmt = $mysqli->prepare("UPDATE `users` SET `like_post` = ?   WHERE `id` = ?");
        $stmt->bind_param('si',$like_post,$id);
        $stmt->execute();
        $stmt = $mysqli->prepare("UPDATE `users` SET `comment_post` = ?   WHERE `id` = ?");
        $stmt->bind_param('si',$comment_post,$id);
        $stmt->execute();
        $stmt = $mysqli->prepare("UPDATE `users` SET `post` = ?   WHERE `id` = ?");
        $stmt->bind_param('si',$post,$id);
        $stmt->execute();
        }
    
           
         }
function poast_array_check ($array,$num,$id){
        $array = unserialize($array);  
        $key = array_search($num,$array);
        if ($key != -1){
		unset($array[$key]);
		$array = array_values($array);
	}
        $array = serialize($array);
        return $array;
    } 
?>

