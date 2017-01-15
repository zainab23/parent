<?php
if (isset($_POST['s_id'])){
include "include/user_api.php";
include "include/notification_api.php";

noti_remove_by_id($_POST['s_id']);

}

?>