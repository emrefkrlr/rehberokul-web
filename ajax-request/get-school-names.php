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

$db->where('state', 2);
$db->where('type', 1);
$schoolNames = $db->get("school", null, "name");

foreach ($schoolNames as $school) {
    $data[] = array(
        'value' => kucuk_yap($school['name']),
        "label"=> $school['name'],
        "icon" => 'images/ikonlar/okul-tipleri/anaokulu-kres.png'
    );
}

$db->where('state', 2);
$db->where('type', 2);
$schoolNames = $db->get("school", null, "name");

foreach ($schoolNames as $school) {
    $data[] = array(
        'value' => kucuk_yap($school['name']),
        "label"=> $school['name'],
        "icon" => 'images/ikonlar/okul-tipleri/ilkokul.png'
    );
}

$db->where('state', 2);
$db->where('type', 3);
$schoolNames = $db->get("school", null, "name");

foreach ($schoolNames as $school) {
    $data[] = array(
        'value' => kucuk_yap($school['name']),
        "label"=> $school['name'],
        "icon" => 'images/ikonlar/okul-tipleri/ortaokul.png'
    );
}

$db->where('state', 2);
$db->where('type', 4);
$schoolNames = $db->get("school", null, "name");

foreach ($schoolNames as $school) {
    $data[] = array(
        'value' => kucuk_yap($school['name']),
        "label"=> $school['name'],
        "icon" => 'images/ikonlar/okul-tipleri/lise.png'
    );
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);
