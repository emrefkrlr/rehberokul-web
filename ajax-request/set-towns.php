<?php
$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(isset($post['selected_city']) && $post['selected_city'] != '') {
    require_once('../php/Core.php');
    $db->orderBy("name","asc");
    $db->where("ilce_sehirkey", $post['selected_city']);
    $cityTowns = $db->get('town');
    $data = array();
    foreach($cityTowns as $row){
        $data[] = array(
            'id' => $row['ilce_key'],
            "text"=>$row['name']
        );
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
} else if(isset($post['selected_town']) && $post['selected_town'] != '') {
    require_once('../php/Core.php');
    $db->orderBy("name","asc");
    $db->where("mahalle_ilcekey", $post['selected_town']);
    $townSubtowns = $db->get('subtown');
    $data = array();
    foreach($townSubtowns as $row){
        $data[] = array(
            'id' => $row['mahalle_key'],
            "text"=>$row['name']
        );
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
} else if(isset($post['selected_cities']) && $post['selected_cities'] != '') {
    require_once('../php/Core.php');
    $data = array();
    foreach ($post['selected_cities'] as $sehir_key) {
        $db->orderBy("name","asc");
        $db->where("ilce_sehirkey", $sehir_key);
        $cityTowns = $db->get('town');
        foreach($cityTowns as $row){
            $data[] = array(
                'id' => $row['ilce_key'],
                "text"=>ucwords_tr($row['name'])
            );
        }
    }
    sort($data);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
} else {
    // Burada 404'e yönlendireceğiz
}

function ucwords_tr($gelen){

    $sonuc='';
    $kelimeler=explode(" ", $gelen);

    foreach ($kelimeler as $kelime_duz){

        $kelime_uzunluk=strlen($kelime_duz);
        $ilk_karakter=mb_substr($kelime_duz,0,1,'UTF-8');

        if($ilk_karakter=='Ç' or $ilk_karakter=='ç'){
            $ilk_karakter='Ç';
        }elseif ($ilk_karakter=='Ğ' or $ilk_karakter=='ğ') {
            $ilk_karakter='Ğ';
        }elseif($ilk_karakter=='I' or $ilk_karakter=='ı'){
            $ilk_karakter='I';
        }elseif ($ilk_karakter=='İ' or $ilk_karakter=='i'){
            $ilk_karakter='İ';
        }elseif ($ilk_karakter=='Ö' or $ilk_karakter=='ö'){
            $ilk_karakter='Ö';
        }elseif ($ilk_karakter=='Ş' or $ilk_karakter=='ş'){
            $ilk_karakter='Ş';
        }elseif ($ilk_karakter=='Ü' or $ilk_karakter=='ü'){
            $ilk_karakter='Ü';
        }else{
            $ilk_karakter=strtoupper($ilk_karakter);
        }

        $digerleri=mb_substr($kelime_duz,1,$kelime_uzunluk,'UTF-8');
        $sonuc.=$ilk_karakter.kucuk_yap($digerleri).' ';

    }

    $son=trim(str_replace('  ', ' ', $sonuc));
    return $son;

}

function kucuk_yap($gelen){

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

