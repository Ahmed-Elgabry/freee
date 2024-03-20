<?php

if (!empty($_POST['user_id'])) {
    $user_id = $wo['user']['id'];
    $user = $_POST['user_id'];
    
    $sql = " DELETE FROM " . T_REPORTS . " WHERE `user_id` = {$user_id} AND `profile_id` = {$user} ";
    @mysqli_query($sqlConnect, $sql);
        
    $response_data = array(
        'api_status' => 200,
    );
    
}
else{
	$error_code    = 6;
    $error_message = 'Please check your details.';
}