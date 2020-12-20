<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
set_time_limit(0); // safe_mode is off

ini_set('max_execution_time', 600);
session_start();
require('../config.php');
require('../classes/helper/DateHelper.php');
require('../classes/db/Model.php');
require('../classes/db/DBOperation.php');

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


function saveSSS() {
    try {
        $db = new DBOperation();

        $db->findByColumn('school', 'state', '3', 'NOT'); // Onaylanmış Okullar
        $schools = $db->resultSet();

        $db->findByColumn('sss', 'sss_place', 'okul-detay');
        $db->addAndClause('state', 1);
        $sssler = $db->resultSet();

        foreach($schools as $school) {

            foreach($sssler as $sss) {

                if($sss['sss_connection'] == 'yas-araligi') {// Yaş Aralığı İçin
                    if ($sss['sss_answer_type'] == 'otomatik') {
                        $db->statement = $db->databaseHandler->prepare("SELECT age_interval FROM `school` where id =" . $school['id']);
                        $db->statement->execute();
                        $fetchDataYas = $db->statement->fetch();

                        $answer = $fetchDataYas['age_interval'];

                        if ($fetchDataYas['age_interval'] && $fetchDataYas['age_interval'] != '') {
                            $answer = str_replace('{xxxx}', $answer, $sss['answer']);
                        }
                        if (trim($answer) != '') {
                            $db->save('weekly_sss',
                                array('school_link', 'question', 'answer'),
                                array($school['link'], $sss['question'], $answer));
                        }
                    }  else {
                        if (trim($sss['answer']) != '') {
                            $db->save('weekly_sss',
                                array('school_link', 'question', 'answer'),
                                array($school['link'], $sss['question'], $sss['answer']));
                        }
                    }
                }

            }
        }
    }catch(PDOException $e) {
        echo $e->getMessage();
    }



}

saveSSS();
