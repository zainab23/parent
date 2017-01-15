<?php
function connect(){
    $mysqli = new mysqli('localhost','root','','parent');
	$mysqli->query("SET NAMES 'utf8'");
    return $mysqli;
}

function user_email_exist($email){
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE `email` = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $array = $res->fetch_assoc();
    if ($array)
        return true;
    else
        return false;
}

function user_get_by_email($email){
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE `email` = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    if ($user){
		$user = user_unserialize($user);
        return $user;
    }
    else
        return false;
}

function user_get_by_name($name){
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE `f_name` = ?");
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    if ($user){
		$user = user_unserialize($user);
        return $user;
    }
    else
        return false;
}
function user_get_by_id($id){
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE `id` = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    if ($user){
		$user = user_unserialize($user);
        return $user;
    }
    else
        return false;
}

function user_get_id_user_chat_list(){
	$mysqli = connect();
    $stmt = $mysqli->prepare("SELECT `from_id`, `to_id` FROM `msgs` WHERE `from_id` = ? OR `to_id` = ?");
    $stmt->bind_param('ii', $_SESSION['user']['id'], $_SESSION['user']['id']);
    $stmt->execute();
    $res = $stmt->get_result();
    $users = $res->fetch_all(MYSQLI_ASSOC);
	
    if ($users){
		$i = 0;
		foreach($users as $user){
			
			if ($user['from_id'] == $_SESSION['user']['id'] )
				$ids[$i] = $user['to_id'];
			else
				$ids[$i] = $user['from_id'];
				
			$i++;
		}
    }
	if (isset($ids))
		return $ids;
	else
		return false;
}

function user_search($input){
    $mysqli = connect();
	
    $stmt = $mysqli->prepare("SELECT `id`, `f_name`, `l_name`, `img`, `account_type` FROM `users` WHERE
							 `f_name` LIKE ? OR
							 `l_name` LIKE ? OR
							 `email`  LIKE ?  ");
    $stmt->bind_param('sss', $input, $input, $input);
	$input = "%".$input."%";
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_all(MYSQLI_ASSOC);
    if ($user)
        return $user;
    else
        return false;
}

function user_search_detail($post){
	
	/*
	 
	 [user_name] =>
	 [type] => 0
	 [gender] => 0
	 [country] => 0
	 [marital_status] => 0
	 [age_from] =>
	 [age_to] =>
	 [user_search] => Search
	 
	*/
	$query = "SELECT `id`, `f_name`, `l_name`, `img`, `account_type` FROM `users` WHERE 1 ";
	extract($post);
	
	
	if (!empty($user_name))
		$query .= " AND ( `f_name` LIKE '%$user_name%' OR `l_name` LIKE '%$user_name%' OR `email`  LIKE '%$user_name%' ) ";
		
	if ($type != 0)
		$query .= " AND ( `account_type` = $type ) ";
		
	if ($gender!= 0)
		$query .= " AND ( `gender` = $gender ) ";
		
	if (!empty($country))
		$query .= " AND ( `contry` = '$country' ) ";
		
	if ($marital_status!= 0)
		$query .= " AND ( `marital_status` = $marital_status ) ";
		
	if (!empty($age_from))
		$query .= " AND ( `age` >= $age_from ) ";
		
	if (!empty($age_to))
		$query .= " AND ( `age` <= $age_to ) ";
		
	
	
    $mysqli = connect();
    $res = $mysqli->query($query, MYSQLI_USE_RESULT);
    $user = $res->fetch_all(MYSQLI_ASSOC);
    if ($user)
        return $user;
    else
        return false;
}

function user_send_req($f_id){
	if ($_SESSION['user']['account_status'] === 0)
        return false;
	$f_id = (int) $f_id;
	$my_id = (int) $_SESSION['user']['id'];
	$mysqli = connect();
	$stmt = $mysqli->prepare("SELECT `req_out` FROM `users` WHERE `id` = ?");
    $stmt->bind_param('i', $my_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $req_out = $res->fetch_assoc();
	$req_out = unserialize($req_out['req_out']);
	array_push($req_out, $f_id);
	$req_out = array_unique($req_out);
	$req_out = serialize($req_out);
	
	$stmt = $mysqli->prepare("UPDATE `users` SET `req_out` = ? WHERE `id` = ?");
    $stmt->bind_param('si', $req_out, $my_id);
    $stmt->execute();
	
	$stmt = $mysqli->prepare("SELECT `req_in` FROM `users` WHERE `id` = ?");
    $stmt->bind_param('i', $f_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $req_in = $res->fetch_assoc();
	$req_in = unserialize($req_in['req_in']);
	array_push($req_in, $my_id);
	$req_in = array_unique($req_in);
	$req_in = serialize($req_in);
	
	
	$stmt = $mysqli->prepare("INSERT INTO `notifications`
                                        (`u_id`, `pr_id`, `post_id`, `stuff_id`, `type`, `time`, `checked`)
                                              VALUES (?,?,?,?,?,?,?)");
	$stmt->bind_param("iiiiiii", $u_id, $pr_id, $post_id, $stuff_id, $type, $time, $checked);
	$u_id = $f_id;
	$pr_id = $_SESSION['user']['id'];
	$post_id = null;
	$stuff_id = null;
	$type = 3;
	$time = time();
	$checked = 0;
	$stmt->execute();
	
	
	$stmt = $mysqli->prepare("UPDATE `users` SET `req_in` = ? WHERE `id` = ?");
    $stmt->bind_param('si', $req_in, $f_id);
    $stmt->execute();
	
	$mysqli->close();
	user_update_session();
	
	
	
}


function user_cancel_req($f_id){
	if ($_SESSION['user']['account_status'] === 0)
        return false;
	$f_id = (int) $f_id;
	$my_id = (int) $_SESSION['user']['id'];
	$mysqli = connect();
	$stmt = $mysqli->prepare("SELECT `req_out` FROM `users` WHERE `id` = ?");
    $stmt->bind_param('i', $my_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $req_out = $res->fetch_assoc();
	$req_out = unserialize($req_out['req_out']);
	$key = array_search($f_id, $req_out);
	if ($key != -1){
		unset($req_out[$key]);
		$req_out = array_values($req_out);
	}
	$req_out = array_unique($req_out);
	$req_out = serialize($req_out);
	
	$stmt = $mysqli->prepare("UPDATE `users` SET `req_out` = ? WHERE `id` = ?");
    $stmt->bind_param('si', $req_out, $my_id);
    $stmt->execute();
	
	$stmt = $mysqli->prepare("SELECT `req_in` FROM `users` WHERE `id` = ?");
    $stmt->bind_param('i', $f_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $req_in = $res->fetch_assoc();
	$req_in = unserialize($req_in['req_in']);
	$key = array_search($my_id, $req_in);
	if ($key != -1){
		unset($req_in[$key]);
		$req_in = array_values($req_in);
	}
	
	
	$req_in = array_unique($req_in);
	$req_in = serialize($req_in);
	
	$stmt = $mysqli->prepare("UPDATE `users` SET `req_in` = ? WHERE `id` = ?");
    $stmt->bind_param('si', $req_in, $f_id);
    $stmt->execute();
	
	$mysqli->close();
	user_update_session();
	
	
	
}

function user_unfriend($f_id){
	if ($_SESSION['user']['account_status'] === 0)
        return false;
	$f_id = (int) $f_id;
	$my_id = (int) $_SESSION['user']['id'];
	$mysqli = connect();
	$stmt = $mysqli->prepare("SELECT `frineds` FROM `users` WHERE `id` = ?");
    $stmt->bind_param('i', $my_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
	
	$frineds = unserialize($user['frineds']);
	
	
	$key = array_search($f_id, $frineds);
	if ($key != -1){
		unset($frineds[$key]);
		$frineds = array_values($frineds);
	}
	
	$frineds = array_unique($frineds);
	$frineds = serialize($frineds);
	
	$stmt = $mysqli->prepare("UPDATE `users` SET `frineds` = ? WHERE `id` = ?");
    $stmt->bind_param('si', $frineds, $my_id);
    $stmt->execute();
	
	
	$stmt = $mysqli->prepare("SELECT `frineds` FROM `users` WHERE `id` = ?");
    $stmt->bind_param('i', $f_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
	
	$frineds = unserialize($user['frineds']);
	
	$key = array_search($my_id, $frineds);
	if ($key != -1){
		unset($frineds[$key]);
		$frineds = array_values($frineds);
	}
	
	
	$frineds = array_unique($frineds);
	$frineds = serialize($frineds);
	
	$stmt = $mysqli->prepare("UPDATE `users` SET `frineds` = ? WHERE `id` = ?");
    $stmt->bind_param('ssi', $frineds, $f_id);
    $stmt->execute();
	
	$mysqli->close();
	user_update_session();
	
}


function user_accept_req($f_id){
	if ($_SESSION['user']['account_status'] === 0)
        return false;
	$f_id = (int) $f_id;
	$my_id = (int) $_SESSION['user']['id'];
	$mysqli = connect();
	$stmt = $mysqli->prepare("SELECT `req_in`, `frineds` FROM `users` WHERE `id` = ?");
    $stmt->bind_param('i', $my_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
	
	
	$req_in = unserialize($user['req_in']);
	$frineds = unserialize($user['frineds']);
	
	
	$key = array_search($f_id, $req_in);
	if ($key != -1){
		unset($req_in[$key]);
		$req_in = array_values($req_in);
	}
	
	$req_in = array_unique($req_in);
	$req_in = serialize($req_in);
	
	
	array_push($frineds, $f_id);
	$frineds = array_unique($frineds);
	$frineds = serialize($frineds);
	
	$stmt = $mysqli->prepare("UPDATE `users` SET `req_in` = ? , `frineds` = ? WHERE `id` = ?");
    $stmt->bind_param('ssi', $req_in, $frineds, $my_id);
    $stmt->execute();
	
	
	$stmt = $mysqli->prepare("SELECT `req_out`, `frineds` FROM `users` WHERE `id` = ?");
    $stmt->bind_param('i', $f_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
	
	$req_out = unserialize($user['req_out']);
	$frineds = unserialize($user['frineds']);
	
	$key = array_search($my_id, $req_out);
	if ($key != -1){
		unset($req_out[$key]);
		$req_out = array_values($req_out);
	}
	
	
	$req_out = array_unique($req_out);
	$req_out = serialize($req_out);
	
	array_push($frineds, $my_id);
	$frineds = array_unique($frineds);
	$frineds = serialize($frineds);
	
	$stmt = $mysqli->prepare("UPDATE `users` SET `req_out` = ? , `frineds` = ? WHERE `id` = ?");
    $stmt->bind_param('ssi', $req_out, $frineds, $f_id);
    $stmt->execute();
	
	$stmt = $mysqli->prepare("INSERT INTO `notifications`
                                        (`u_id`, `pr_id`, `post_id`, `stuff_id`, `type`, `time`, `checked`)
                                              VALUES (?,?,?,?,?,?,?)");
	$stmt->bind_param("iiiiiii", $u_id, $pr_id, $post_id, $stuff_id, $type, $time, $checked);
	$u_id = $f_id;
	$pr_id = $_SESSION['user']['id'];
	$post_id = null;
	$stuff_id = null;
	$type = 4;
	$time = time();
	$checked = 0;
	$stmt->execute();
	
	$mysqli->close();
	user_update_session();
}

function user_unserialize($user){
    $user['frineds'] = unserialize($user['frineds']);
    $user['req_in'] = unserialize($user['req_in']);
    $user['req_out'] = unserialize($user['req_out']);
    $user['post'] = unserialize($user['post']);
    $user['like_post'] = unserialize($user['like_post']);
    $user['comment_post'] = unserialize($user['comment_post']); 
    return $user;
}

function user_update($f_name, $l_name, $email, $age, $img, $gender, $marital, $country, $children, $children_age, $type){
    $mysqli = connect();
    $stmt = $mysqli->prepare("UPDATE `users` SET
                                `f_name`=?,`l_name`=?,`email`=?,
                                `age`=?,`img`=?,`gender`=?,
                                `marital_status`=?,`contry`=?,
                                `children`=?,`children_age`=?,
                                `account_type`=? WHERE `id` = ?");
    $stmt->bind_param('sssisiisiiii', $f_name, $l_name, $email, $age, $img, $gender, $marital, $country, $children, $children_age, $type, $_SESSION['user']['id']);
    $res = $stmt->execute();
    $mysqli->close();
    
    if ($res)
        return true;
    else
        return false;
}

function user_singup($user_name, $user_mail, $user_password, $user_type, $user_gender, $user_age){
    $mysqli = connect();
    $stmt = $mysqli->prepare("INSERT INTO `users`(`f_name`, `l_name`, `password`, `email`,
                                    `age`, `img`, `date`, `frineds`, `req_in`, `req_out`,
                                    `account_status`, `post`, `like_post`,
                                    `comment_post`, `gender`, `marital_status`, `contry`,
                                    `children`, `children_age`, `account_type`, `rest_pass`,`confirm`)
                              VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    
		$stmt->bind_param('ssssisisssisssiisiiiii',
                                           $f_name,
                                           $l_name,
                                           $password,
                                           $email,
                                           $age,
                                           $img,
                                           $date,
                                           $frineds,
                                           $req_in,
                                           $req_out,
                                           $account_status,
                                           $post,
                                           $like_post,
                                           $comment_post,
                                           $gender,
                                           $marital_status,
                                           $contry,
                                           $children,
                                           $children_age,
                                           $account_type,
				             $random_num,
                                             $confirm
						  );
        
        
        $f_name = $user_name;
        $l_name = null;
        $password = md5($user_password);
        $email = $user_mail;
        $age = $user_age;
        if ($user_gender == 2)
            $img = 'imgs/female.png';
        else
            $img = 'imgs/male.png';
        $date = time();
        $frineds = serialize(array());
        $req_in = serialize(array());
        $req_out = serialize(array());
        $account_status = 1;
        $post = serialize(array());
        $like_post = serialize(array());
        $comment_post = serialize(array());
        $gender = $user_gender;
        $marital_status = null;
        $contry = null;
        $children = null;
        $children_age = null;
        $account_type = $user_type;
        $random_num=0;
        $random_num= mt_rand();
        $confirm=0;
		$res = $stmt->execute();
		$mysqli->close();
        
        if ($res)
            return true;
        else
            return false;
		
}


function user_update_session(){
	$_SESSION['user'] = user_get_by_id($_SESSION['user']['id']);
}

function user_block_user($status,$id){
    $mysqli = connect();
    $stmt = $mysqli->prepare("UPDATE `users` SET `account_status`= ? WHERE `id` = ?");
    $stmt->bind_param("ii", $status ,$id);
  $res = $stmt->execute();  
   
}

function user_update_pass($user_password,$id){
    $mysqli = connect();
    $stmt = $mysqli->prepare("UPDATE `users` SET
                                `password`=? WHERE `id` = ?");
    $stmt->bind_param('si', $password,$id);
     $password = md5($user_password);
    $res = $stmt->execute();
    $mysqli->close();
    
    if ($res)
        return true;
    else
        return false;
}



function user_send_email ($id,$email,$num){
    
  $to = $email;
  $subject = " Hello Parent ";
  $txt = "Hello.. open the link http://localhost/parent/check_number.php?code=$num&id=$id" ;
  $headers = "From: HelloParent.com" . "\r\n" .
  "CC: zhhz1992@hotmail.com";

   mail($to,$subject,$txt,$headers);  
    
   
}

function  user_confirm($id){
    
   $mysqli = connect();
    $stmt = $mysqli->prepare("UPDATE `users` SET
                                `confirm`=? WHERE `id` = ?");
    $stmt->bind_param('ii', $num,$id);
     $num = 1;
    $res = $stmt->execute();
    $mysqli->close();
    
    if ($res)
        return true;
    else
        return false;  
    
}

function user_confirm_email ($id,$email,$num){
    
  $to = $email;
  $subject = " Hello Parent ";
  $txt = "Hello.. open the link http://localhost/parent/confirm_email.php?code=$num&id=$id" ;
  $headers = "From: HelloParent.com" . "\r\n" .
  "CC: zhhz1992@hotmail.com";

   mail($to,$subject,$txt,$headers);  
    
   
}
?>