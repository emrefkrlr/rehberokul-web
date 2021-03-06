<?php
	session_start();

    define("WEBURL","https://www.rehberokul.com/");
    define("SITENAME","Rehber Okul");
    define("INFOSECVAL","e057857db2cef2bdb5d89fa91505d499bd87d975");
    define("SUBFOLDER", false);

    require_once('Classes/MysqliDb.php');
    require_once('Classes/Security.php');

    $db = new MysqliDb('localhost', 'rehberok_web_user', 'P(ie*igC*juoRehberO', 'rehberok_web_db');
    $sec = new Security;

    $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));

    if (!isset($_SESSION['cookie_accept'])) {
        $_SESSION['cookie_accept'] = "NO";
    }
?>