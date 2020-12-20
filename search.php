<?php
require_once('php/Core.php');
$robotsStatus = "noindex, nofollow";

if (isset($_POST['searchTerm'])) {
    $searchTerm = $_POST['searchTerm'];
    // okul araması
    $db->where("name", $searchTerm);
    $singleSchool = $db->getOne("school");
    if ($singleSchool) {
        header("location: " . WEBURL . "okul/" . $singleSchool['link']);
    }else {
        // bölge araması
        $regionLanding = $db->rawQuery("SELECT page_url FROM landing WHERE search_term LIKE '%".$searchTerm."%' LIMIT 1");
        if ($regionLanding) {
            header("Location: ".WEBURL . $regionLanding[0]['page_url']);
        }
    }
}
