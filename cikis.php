<?php
    session_start();
    session_destroy();
    if (isset($_GET['sayfa'])) {
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $exitLink = explode("cikis-yap/", $actual_link)[1];
        header('Location: '.$exitLink);
    } else {
		header('Location: /');
    }
?>