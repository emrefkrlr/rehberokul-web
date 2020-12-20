<?php

class Message {
    public static function setMessage($text, $type) {
        switch($type) {
            case 'error':
                $_SESSION['error_message'] = $text;
                break;
            case 'success':
                $_SESSION['success_message'] = $text;
                break;
            default :
                break;
        }
    }
    
    public static function display() {
        if(isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger">'.$_SESSION['error_message'].'</div>';
            
        }
        
        if(isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success">'.$_SESSION['success_message'].'</div>';
        }
    }
}

?>

