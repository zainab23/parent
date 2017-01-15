<?php

/*
 *  notification type :)
 *      01 => like post
 *      02 => comment post
 *      03 => req_in
 *      04 => accept_req
 *      05 => want your stuff
*/


function noti_get_new(){
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `notifications` WHERE `u_id` = ? AND `checked` = 0");
    $stmt->bind_param('i', $_SESSION['user']['id']);
    $stmt->execute();
    $res = $stmt->get_result();
    $noti = $res->fetch_all(MYSQLI_ASSOC);
    if ($noti)
        return $noti;
    else
        return false;
}

function noti_remove_by_id($id){
    $mysqli = connect();
    $stmt = $mysqli->prepare("DELETE FROM `notifications` WHERE `id` = ?");
    $stmt->bind_param('i', $id);
    $res = $stmt->execute();
    
    return $res;
    
}

function noti_get_all(){
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `notifications` WHERE `u_id` = ? ");
    $stmt->bind_param('i', $_SESSION['user']['id']);
    $stmt->execute();
    $res = $stmt->get_result();
    $noti = $res->fetch_all(MYSQLI_ASSOC);
    
    
    $stmt = $mysqli->prepare("UPDATE `notifications` SET `checked`= 1 WHERE `u_id` = ?");
    $stmt->bind_param('i', $_SESSION['user']['id']);
    $stmt->execute();
    
    if ($noti)
        return $noti;
    else
        return false;
}
function noti_remove_by_post_id($id){
    
    $mysqli = connect();
    $stmt = $mysqli->prepare("DELETE FROM `notifications` WHERE `post_id` = ?");
    $stmt->bind_param('i', $id);
    $res = $stmt->execute();
    
    return $res;
}
   

?>