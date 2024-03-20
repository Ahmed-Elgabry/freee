<?php

$response_data = array(
    'api_status' => 400
);

if (empty($_POST['os_type'])) {
    $error_code    = 2;
    $error_message = 'No OS Type sent.';
} elseif (empty($_POST['version_number'])) {
    $error_code    = 3;
    $error_message = 'No Version Number sent.';
} 
else{
    $os_type = $_POST['os_type'];
    $version_number = $_POST['version_number'];
    
    $sql_query_three = mysqli_query($sqlConnect, "SELECT * FROM `wo_version_app` WHERE `type` LIKE '".$os_type."' AND `version_number` LIKE '".$version_number."'");
    $result3 = mysqli_fetch_assoc($sql_query_three);
    
    if (empty($result3)) {
        $error_code    = 4;
        $error_message = 'Version not found';
    } else {
        $update = $result3['status'];
    }
    
    $sql_query_one = mysqli_query($sqlConnect, "SELECT MAX(version_number) AS version_number FROM `wo_version_app` WHERE `type` LIKE '".$os_type."'");

    $result = mysqli_fetch_assoc($sql_query_one);

    if (empty($result)) {
        $web_view = "0";
        
    } elseif(!empty($result)) {
        if ($result['version_number'] == $version_number)
        {
            $web_view = "0";
        } elseif ($version_number < $result['version_number']) {
            
            $new_version = $result['version_number'];
           $sql_query_two = mysqli_query($sqlConnect, "SELECT * FROM `wo_version_app` WHERE `type` LIKE '".$os_type."' AND `version_number` LIKE '".$new_version."'");
           
            $result2 = mysqli_fetch_assoc($sql_query_two); 
            $web_view = $result2['status'];
            
        } else {
            $web_view = "0";
        }
    } else {
        $error_code    = 4;
        $error_message = 'Version not found';
    }
    
    if(isset($update) && isset($web_view))
    {
        $response_data = array(
            'api_status' => '200',
            'api_text' => 'success',
            'web_view' => $web_view ,
            'update' => $update,
        );
    }
}
?>