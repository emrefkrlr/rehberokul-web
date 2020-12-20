<?php
    require('classes/Library.php');
    $db = new DBOperation();
    $db->findByColumn('user', 'email', $_SESSION['user_data']['email']);
    $user = $db->single();
    if(isset($_SESSION['is_logged_in']) && !Security::checkUserAgent($user['user_agent'], $user['ip_address'])) {
       unset($_SESSION['is_logged_in']);
       unset($_SESSION['user_data']);
       session_destroy();
       echo '<script>window.location.href ="'.ROOT_URL.'";</script>'; 
    } else {
        $bootstrap = new Bootstrap($_GET);
        $controller = $bootstrap->createController();
        if($controller) {
            $controller->executeAction();
        }
    }
//error_reporting(1);
//echo '123';
