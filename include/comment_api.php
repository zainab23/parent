<?php
function comment_get_by_p_id($p_id){
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `comments` WHERE `p_id` = ? ORDER BY `time` DESC");
    $stmt->bind_param('i', $p_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $posts = $res->fetch_all(MYSQLI_ASSOC);
    
    if ($posts)
        return $posts;
    else
        return array();
}

function comment_add($u_id, $p_id,$text){
    if ($_SESSION['user']['account_status'] === 0)
        return false;
    $time = time();
    $mysqli = connect();
    $stmt = $mysqli->prepare("INSERT INTO `comments`(`u_id`, `p_id`, `time`, `text`)
                                           VALUES (?,?,?,?)");
    $stmt->bind_param('iiis', $u_id, $p_id ,$time, $text);
    $res = $stmt->execute();
    
    if ($res){
        $stmt = $mysqli->prepare("UPDATE `users` SET `comment_post`= ? WHERE `id` = ?");
        $comment_post = $_SESSION['user']['comment_post'];
        array_push($comment_post, $p_id);
        $comment_post = serialize($comment_post);
        $stmt->bind_param("si", $comment_post, $_SESSION['user']['id']);
        $stmt->execute();
        $post = post_get_by_id($p_id);
        $u_id = $post['u_id'];
        if ($u_id != $_SESSION['user']['id']){
            $stmt = $mysqli->prepare("INSERT INTO `notifications`
                                        (`u_id`, `pr_id`, `post_id`, `stuff_id`, `type`, `time`, `checked`)
                                              VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("iiiiiii", $u_id, $pr_id, $post_id, $stuff_id, $type, $time, $checked);
            $pr_id = $_SESSION['user']['id'];
            $post_id = $p_id;
            $stuff_id = null;
            $type = 2;
            $time = time();
            $checked = 0;
            $stmt->execute();
        }
        
        
        $mysqli->close();
        user_update_session();
        return true;
    }
}

function comment_remove($id){
    
               $mysqli = connect();
		$stmt = $mysqli->prepare("DELETE FROM `comments` WHERE `p_id` = ?");
		$stmt->bind_param("i",$id);
                $res = $stmt->execute();
    		$mysqli->close();

    if ($res)
        return true;
    else
        return false;
	}

?>