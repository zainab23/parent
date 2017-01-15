<?php

function msg_get_conversation($f_id){
    $my_id = $_SESSION['user']['id'];
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `msgs` WHERE
                                ( `from_id` = ? AND `to_id` = ? ) OR
                                ( `from_id` = ? AND `to_id` = ? )");
    $stmt->bind_param('iiii', $my_id, $f_id, $f_id, $my_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $msgs = $res->fetch_all(MYSQLI_ASSOC);
    $msgs= array_reverse($msgs);
    $stmt = $mysqli->prepare("UPDATE `msgs` SET `checked`= 1  WHERE `from_id` = ? AND `to_id` = ? ");
    $stmt->bind_param('ii', $f_id, $my_id);
    $stmt->execute();
    if ($msgs)
        return $msgs;
    else
        return false;
}

function msg_check($f_id){
    $my_id = $_SESSION['user']['id'];
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `msgs` WHERE `checked`= 0 AND `to_id` = ? AND `from_id` = ? ");
    $stmt->bind_param('ii', $my_id, $f_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $msgs = $res->fetch_all(MYSQLI_ASSOC);
    
    if ($msgs)
        return true;
    else
        return false;
}



function msg_get_unread(){
    $my_id = $_SESSION['user']['id'];
    $mysqli = connect();
    $stmt = $mysqli->prepare("SELECT * FROM `msgs` WHERE `checked`= 0 AND `to_id` = ? ");
    $stmt->bind_param('i', $my_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $msgs = $res->fetch_all(MYSQLI_ASSOC);
    
    if ($msgs)
        return $msgs;
    else
        return false;
}

function msg_send_new($id, $text){
    if ($_SESSION['user']['account_status'] === 0)
        return false;
    $my_id = $_SESSION['user']['id'];
    $mysqli = connect();
    $stmt = $mysqli->prepare("INSERT INTO `msgs`(`from_id`, `to_id`, `time`, `checked`, `text`)
                                        VALUES (?,?,?,?,?)");
    $stmt->bind_param('iiiis', $my_id, $id, $time, $checked, $text);
    $time = time();
    $checked = 0;
    $stmt->execute();
    
}


?>