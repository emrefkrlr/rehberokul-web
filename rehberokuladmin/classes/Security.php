<?php
    class Security {
        public static function changeSessionIdAndCsrf() {
            session_regenerate_id();
            if(!isset($_SESSION['token'])) {
                $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
            }
        }
        
        public static function checkCsrf($postToken) {
            if (!empty($postToken)) {
                if (isset($_SESSION['token']) && $_SESSION['token'] == $postToken) {
                     return true;
                } else {
                     return false;
                }
            }
        }
        
        public static function preventSessionHijacking() {
            ini_set( 'session.use_only_cookies', TRUE );				
            ini_set( 'session.use_trans_sid', FALSE );
        }
        
        public static function checkUserAgent($userAgentDB, $userIpDB)
        {
            if($_SERVER['HTTP_USER_AGENT'] == $userAgentDB && URLHelper::get_client_ip() == $userIpDB) {
                return true;
            } else {
                return false;
            }
        }
        
        public static function checkIfUserIsActive() {
            if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
                    // last activity was more than 30 minutes ago
                    session_unset();
                    session_destroy();
                    echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            }
            $_SESSION['last_activity'] = time();
        }
    }
?>

