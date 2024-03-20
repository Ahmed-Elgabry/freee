<?php

$json_error_data   = array();
$json_success_data = array();
if (empty($_GET['type']) || !isset($_GET['type'])) {
    $json_error_data = array(
        'api_status' => '400',
        'api_text' => 'failed',
        'api_version' => $api_version,
        'errors' => array(
            'error_id' => '1',
            'error_text' => 'Bad request, no type specified.'
        )
    );
    header("Content-type: application/json");
    echo json_encode($json_error_data, JSON_PRETTY_PRINT);
    exit();
}

$type = Wo_Secure($_GET['type'], 0);

if ($type == 'check_app_version') {
    if (empty($_POST['os_type'])) {
        $json_error_data = array(
            'api_status' => '400',
            'api_text' => 'failed',
            'api_version' => $api_version,
            'errors' => array(
                'error_id' => '2',
                'error_text' => 'No OS Type sent.'
            )
        );
    } else if (empty($_POST['version_number'])) {
        $json_error_data = array(
            'api_status' => '400',
            'api_text' => 'failed',
            'api_version' => $api_version,
            'errors' => array(
                'error_id' => '3',
                'error_text' => 'No Version Number sent.'
            )
        );
    }
    
    if (empty($json_error_data)) {
        $os_type = $_POST['os_type'];
        $version_number = $_POST['version_number'];
        
        $query_one     = "SELECT MAX(version_number) FROM " . T_VERSION_APP . " WHERE `type` = '{$os_type}'";
        $sql_query_one = mysqli_query($sqlConnect, $query_one);
        $result = mysqli_fetch_assoc($sql_query_one);
        
        if (empty($result)) {
            $json_success_data = array(
                'api_status' => '200',
                'api_text' => 'success',
                'api_version' => $api_version,
                'version_status' => '0',
            );
        } else {
            if ($result['version_number'] == $version_number)
            {
                $json_success_data = array(
                    'api_status' => '200',
                    'api_text' => 'success',
                    'api_version' => $api_version,
                    'version_status' => '0',
                );
            } else {
                $new_version = $result['version_number'];
               $query_two     = "SELECT * FROM " . T_VERSION_APP . " WHERE `type` = '{$os_type}' AND 'version_number' = '{$new_version}'";
                $sql_query_two = mysqli_query($sqlConnect, $query_two);
                $result2 = mysqli_fetch_assoc($sql_query_two); 
                
                $json_success_data = array(
                    'api_status' => '200',
                    'api_text' => 'success',
                    'api_version' => $api_version,
                    'version_status' => $result2['status'],
                );
            }
        }
        
    }else {
        header("Content-type: application/json");
        echo json_encode($json_error_data);
        exit();
    }
}

    header("Content-type: application/json");
    echo json_encode($json_success_data);
    exit();
?>