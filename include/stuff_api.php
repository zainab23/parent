<?php
include_once 'include/translation.php';
function stuff_add_new($name, $desc, $price, $image){
    $mysqli = connect();
    $stmt = $mysqli->prepare("INSERT INTO
                             `stuffs` (`u_id`, `name`, `desc`, `img`, `price`, `time`, `who_want_it`)
                             VALUES   (?,?,?,?,?,?,?)");
    $time = time();
    $who_want_it = serialize(array());
    $stmt->bind_param("isssiis", $_SESSION['user']['id'], $name, $desc, $image, $price, $time, $who_want_it);
    $res = $stmt->execute();
    $mysqli->close();
    
    if ($res)
        return true;
    else
        return false;
		
}

function stuff_remove_wanted($id, $u_id){
    $mysqli = connect();
	$stmt = $mysqli->prepare("SELECT `who_want_it` FROM `stuffs` WHERE `id` = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    
	$who_want_it = $res->fetch_assoc();
	$who_want_it = $who_want_it['who_want_it'];
	$who_want_it = unserialize($who_want_it);
	
	$key = array_search($_SESSION['user']['id'], $who_want_it);
	if ($key != -1){
		unset($who_want_it[$key]);
		$who_want_it = array_values($who_want_it);
	}
	
	
	$who_want_it = array_unique($who_want_it);
	$who_want_it = serialize($who_want_it);
	
	
	$stmt = $mysqli->prepare("UPDATE `stuffs` SET `who_want_it`= ? WHERE `id` = ?");
    $stmt->bind_param('si', $who_want_it, $id);
    $stmt->execute();
	
	
    $mysqli->close();
    
    if ($res)
        return true;
    else
        return false;
		
}

function stuff_search_detail($stuff_name, $price_from, $price_to){
	
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
	$query = "SELECT * FROM `stuffs` WHERE 1 ";
	
	
	
	if (!empty($stuff_name))
		$query .= " AND ( `name` LIKE '%$stuff_name%' OR `desc` LIKE '%$stuff_name%'  ) ";
		
	if (!empty($price_from))
		$query .= " AND ( `price` >= $price_from ) ";
		
	if (!empty($price_to))
		$query .= " AND ( `price` <= $price_to ) ";
		
	
	
    $mysqli = connect();
    $res = $mysqli->query($query, MYSQLI_USE_RESULT);
    $stuff = $res->fetch_all(MYSQLI_ASSOC);
    if ($stuff)
        return $stuff;
    else
        return false;
}

function stuff_add_wanted($id, $u_id){
    $mysqli = connect();
	$stmt = $mysqli->prepare("SELECT `who_want_it` FROM `stuffs` WHERE `id` = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    
	$who_want_it = $res->fetch_assoc();
	$who_want_it = $who_want_it['who_want_it'];
	$who_want_it = unserialize($who_want_it);
	
	array_push($who_want_it, $_SESSION['user']['id']);
	
	$who_want_it = array_unique($who_want_it);
    $who_want_it = serialize($who_want_it);
	
	$stmt = $mysqli->prepare("UPDATE `stuffs` SET `who_want_it`= ? WHERE `id` = ?");
    $stmt->bind_param('si', $who_want_it, $id);
    $stmt->execute();
	
	
	$stmt = $mysqli->prepare("INSERT INTO `notifications`
                                        (`u_id`, `pr_id`, `post_id`, `stuff_id`, `type`, `time`, `checked`)
                                              VALUES (?,?,?,?,?,?,?)");
	$stmt->bind_param("iiiiiii", $u_id, $pr_id, $post_id, $stuff_id, $type, $time, $checked);

	$pr_id = $_SESSION['user']['id'];
	$post_id = null;
	$stuff_id = $id;
	$type = 5;
	$time = time();
	$checked = 0;
	$stmt->execute();
	
	
	
    $mysqli->close();
    
    if ($res)
        return true;
    else
        return false;
		
}

function stuff_print($array){
    global $Dellete;
    foreach ($array as $stuff){
        echo "<div class='stuff'>
                    <a href='show_stuff.php?id={$stuff['id']}'><img src='{$stuff['img']}' /></a>
                    <div class='desc'>
                        <p class='name'>{$stuff['name']}</p>
                        <p class='price'>{$stuff['price']}$</p>
                    </div>
                    <div class='btns'>";
        
        if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $stuff['u_id']){
        echo"<button u_id='{$stuff['u_id']}' id='{$stuff['id']}' class='dellete dellete_stuff'>$Dellete</button>"; 
    }elseif (isset($_SESSION['admin'])) {
            echo"<button u_id='{$stuff['u_id']}' id='{$stuff['id']}' class='dellete dellete_stuff'>$Dellete</button>";

            }
        echo "</div>
                </div>";
    }
}

function suff_get_by_u_id($u_id){
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `stuffs` WHERE `u_id` = ?");
    $stmt->bind_param('i', $u_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $stuffs = $res->fetch_all(MYSQLI_ASSOC);
	    
    if ($stuffs)
        return $stuffs;
    else
        return false;
    
}

function suff_get_by_id($id){
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `stuffs` WHERE `id` = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $stuff = $res->fetch_assoc();
    
    if ($stuff){
        $stuff['who_want_it'] = unserialize($stuff['who_want_it']);
        return $stuff;
    }
    else
        return false;
    
}

function suff_remove($id, $u_id){
    $mysqli = connect();
    $stmt = $mysqli->prepare("DELETE FROM `stuffs` WHERE `id` = ? AND `u_id` = ?");
    $stmt->bind_param('ii', $id, $u_id);
    $res = $stmt->execute();
    
    if ($res)
        return true;
    else
        return false;
    
}

?>