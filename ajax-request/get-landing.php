<?php
$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
require_once('../php/Core.php');


function kucuk_yap($gelen) {
    $gelen=str_replace('Ç', 'ç', $gelen);
    $gelen=str_replace('Ğ', 'ğ', $gelen);
    $gelen=str_replace('I', 'ı', $gelen);
    $gelen=str_replace('İ', 'i', $gelen);
    $gelen=str_replace('Ö', 'ö', $gelen);
    $gelen=str_replace('Ş', 'ş', $gelen);
    $gelen=str_replace('Ü', 'ü', $gelen);
    $gelen=strtolower($gelen);
    return $gelen;
}

$landingNames = $db->query("SELECT page_name FROM landing ORDER BY priority DESC");

foreach ($landingNames as $landing){
    $data[] = array(
        'value' => kucuk_yap($landing['page_name']),
        'label' => $landing['page_name'],
        'icon' => "images/icon/gps.png"
    );
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);
