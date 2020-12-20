<?php
require_once('php/Core.php');
$robotsStatus = "index, follow";

if (isset($_SERVER['REQUEST_URI'])) {
    $url = array_filter(explode('/', $_SERVER['REQUEST_URI']));
    if ($url > 2) {
        $getRegion = $url[1] .'/' .$url[2];

    }else{
        $getRegion = ltrim($_SERVER['REQUEST_URI'], "/");
    }

    $getRegionQuery = $db->rawQuery("SELECT * FROM landing WHERE page_url = '".$getRegion."' LIMIT 1");
    // sayfa bilgileri
    $pageTitle = $getRegionQuery[0]['page_title']. ' | Rehber Okul';
    $pageDescription = $getRegionQuery[0]['page_description'];
    $regionQuery = $getRegionQuery[0]['query'];
    $searchTerm = $getRegionQuery[0]['page_name'];
    $pageUrl = WEBURL . ltrim($_SERVER['REQUEST_URI'], "/");
    $headerContent = $getRegionQuery[0]['header_content'];
    $landingContent = $getRegionQuery[0]['landing_content'];



    $getSortedSchoolId = $db->query($regionQuery);
    if (isset($_GET['sayfa'])) {
        $pageNumber = $_GET['sayfa'];
    } else {
        $pageNumber = 1;
    }

    try {
        $pageLimit = 10;
        if ($pageNumber) {
            $startPoint = (($pageNumber-1)*$pageLimit);
        }
        $schoolsByPage = array_slice($getSortedSchoolId, $startPoint, $pageLimit);
        $featuresResult = Array("Yok", "Var");
        foreach ($schoolsByPage as $schoolByPage) {
            $db->where("id", $schoolByPage['id']);
            $school = $db->getOne("school");
        }
    } catch (Exception $e){

    }
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <?php require_once('php/Components/SEO.php'); ?>
    <link href="https://fonts.googleapis.com/css?family=Poppins%7CQuicksand:500,700" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link href="css/materialize.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="css/responsive.css" rel="stylesheet">
    <link href="css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css"/>
    <link href="css/custom.css" rel="stylesheet">
    <script src="js/login.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/autcomplete-custom.js"></script>
    <script>
        var perfEntries = performance.getEntriesByType("navigation");
        if(perfEntries[0]) { // CHROME
            if (perfEntries[0].type === "back_forward") {
                location.reload();
            }
        } else { // OTHER NOT COMPATIBLE BROWSERLAR
            window.addEventListener( "pageshow", function ( event ) {
                var historyTraversal = event.persisted ||
                    ( typeof performance != "undefined" &&
                        performance.navigation.type === 2 );
                if ( historyTraversal ) {
                    // Handle page restore.
                    location.reload();
                }
            });
        }

    </script>
    <?php require_once('php/Components/Scripts.php'); ?></head>
<body>
<?php require_once('php/Components/Header-Part-1.php'); ?>
<?php
$db->orderBy("name","asc");
$allCities = $db->rawQuery('select * from city where sehir_key IN (select sehir_key from school group by sehir_key) order by name ASC');

if(isset($_GET['iller'])) {
    $selected_cities = implode(",", $_SESSION['cities']);
    $allTowns = $db->rawQuery('select * from town where ilce_sehirkey IN ('.$selected_cities.') order by name ASC');
}

?>
<div class="container dir-ho-t-sp" style="padding: 20px 0px 0px 0px;">
    <div class="row xs-py">
        <div class="col-md-8">
            <h1 style="color: #ffffff;float: left !important;"><?php echo $searchTerm; ?></h1> <br><br>
            <p style="color: #c7c7c7;" class="xxs-pt"><?php echo $headerContent?></p>
        </div>
        <div class="col-md-4">
            <a href="<?php echo $pageUrl; ?>#ucretsiz-danismanlik-formu" style="font-size: 14px !important;color: #fff !important;border: 1px solid #44526c !important;font-weight: 400 !important;border-radius: 4px !important;padding: 10px 10px !important;margin-left: 7px !important;max-width: 200px !important;cursor:pointer !important;height: 55px !important;line-height: 35px !important;" class="waves-effect waves-light tourz-sear-btn waves-input-wrapper float-right"><i class="fa fa-bookmark"></i> &nbsp;Ücretsiz Danışmanlık Al</a>
        </div>

    </div>
</div>
<?php require_once('php/Components/Header-Part-2.php'); ?>
<?php
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
?>

<section class="dir-alp-1 dir-pa-sp-top">
    <div class="container">
        <div class="row">
            <div class="dir-alp-con dir-alp-con-1">
                <div class="col-md-3 dir-alp-con-left">
                    <!-- FİLTRELER -->
                    <form id="frm-talep-filtre" action="<?php echo WEBURL; ?>arama-sonucu" method="get">
                        <div class="dir-alp-l3 dir-alp-l-com hidden-mobile">
                            <h4>Puan</h4>
                            <div class="dir-alp-l-com1 dir-alp-p3">
                                <ul>
                                    <li>
                                        <input <?php echo $_SESSION['puan_45_5'] ? 'checked' : ''; ?> name="puan_45_5" value="1" type="checkbox" class="filled-in" id="lr101" />
                                        <label for="lr101">Çok İyi (4.5 ve üzeri)</label>
                                    </li>
                                    <li>
                                        <input <?php echo $_SESSION['puan_4_45'] ? 'checked' : ''; ?> name="puan_4_45" value="1" type="checkbox" class="filled-in" id="lr102" />
                                        <label for="lr102">İyi (4.0 ve üzeri)</label>
                                    </li>
                                    <li>
                                        <input <?php echo $_SESSION['puan_3_4'] ? 'checked' : ''; ?> name="puan_3_4" value="1" type="checkbox" class="filled-in" id="lr103" />
                                        <label for="lr103">Ortalama (3.0 ve üzeri)</label>
                                    </li>
                                    <li>
                                        <input <?php echo $_SESSION['puan_Diger'] ? 'checked' : ''; ?> name="puan_Diger" value="1" type="checkbox" class="filled-in" id="lr104" />
                                        <label for="lr104">Diğer</label>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="dir-alp-l3 dir-alp-l-com hidden-mobile">
                            <h4>Bölge</h4>
                            <div class="dir-alp-l-com1 dir-alp-p3">
                                <ul>
                                    <li>
                                        <select id="select-iller" onchange="set_multiple_towns('il-select2')" data-select-search="true" class="il-select2" name="iller[]"  multiple="multiple">
                                            <?php foreach ($allCities as $city) :?>
                                                <option value="<?php echo $city['sehir_key']; ?>" <?php foreach($_SESSION['cities'] as $sehir_key) { echo $city['sehir_key'] == $sehir_key ? 'selected' : '';}?>><?php echo ucwords_tr($city['name']); ?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </li>
                                    <li>
                                        <select id="select-ilceler" onchange="set_select2_multiple_icerik_ilce('ilce-select2')" data-select-search="true" class="ilce-select2" name="ilceler[]"  multiple="multiple">
                                            <?php foreach ($allTowns as $town) :?>
                                                <option value="<?php echo $town['ilce_key']; ?>" <?php foreach($_SESSION['towns'] as $ilce_key) { echo $town['ilce_key'] == $ilce_key ? 'selected' : '';}?>><?php echo ucwords_tr($town['name']); ?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="dir-alp-l3 dir-alp-l-com hidden-mobile">
                            <h4>Özellikler</h4>
                            <div class="dir-alp-l-com1 dir-alp-p3">
                                <ul>
                                    <li>
                                        <input <?php echo $_SESSION['okulServisi'] ? 'checked' : ''; ?> name="okulServisi"  value="1" type="checkbox" class="filled-in" id="lr5" />
                                        <label for="lr5">Okul Servisi</label>
                                    </li>
                                    <li>
                                        <input <?php echo $_SESSION['psikolojikDanisman'] ? 'checked' : ''; ?> name="psikolojikDanisman" value="1" type="checkbox" class="filled-in" id="lr6" />
                                        <label for="lr6">Psikolojik Danışman</label>
                                    </li>
                                    <li>
                                        <select onchange="set_select2_multiple_icerik_fiziksel('fiziksel-imkanlar-select2')" data-select-search="true" class="fiziksel-imkanlar-select2" id="fiziksel-imkanlar-select2" name="fizikselImkanlar[]"  multiple="multiple">
                                            <?php
                                            $db->where("type", 1);
                                            $fizikselImkanlar = $db->get("facility");
                                            foreach ($fizikselImkanlar as $fizikselImkan) {
                                                echo in_array($fizikselImkan['id'], $_SESSION['fizikselImkanlar']) ? '<option value="'.$fizikselImkan['id'].'" selected>'.$fizikselImkan['name'].'</option>'
                                                    : '<option value="'.$fizikselImkan['id'].'">'.$fizikselImkan['name'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </li>
                                    <li>
                                        <select onchange="set_select2_multiple_icerik_servisler('servisler-select2')" data-select-search="true" class="servisler-select2" id="servisler-select2" name="servisler[]"  multiple="multiple">
                                            <?php
                                            $db->where("type", 2);
                                            $servisImkanlar = $db->get("facility");
                                            foreach ($servisImkanlar as $servisImkan) {
                                                echo in_array($servisImkan['id'], $_SESSION['servisler']) ? '<option value="'.$servisImkan['id'].'" selected>'.$servisImkan['name'].'</option>'
                                                    : '<option value="'.$servisImkan['id'].'">'.$servisImkan['name'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </li>
                                    <li>
                                        <select onchange="set_select2_multiple_icerik_aktiviteler('aktiviteler-select2')" data-select-search="true" class="aktiviteler-select2" id="aktiviteler-select2" name="aktiviteler[]"  multiple="multiple">
                                            <?php
                                            $db->where("type", 3);
                                            $aktiviteImkanlar = $db->get("facility");
                                            foreach ($aktiviteImkanlar as $aktiviteImkan) {
                                                echo in_array($aktiviteImkan['id'], $_SESSION['aktiviteler']) ? '<option value="'.$aktiviteImkan['id'].'" selected>'.$aktiviteImkan['name'].'</option>'
                                                    : '<option value="'.$aktiviteImkan['id'].'">'.$aktiviteImkan['name'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </li>
                                    <li>
                                        <select onchange="set_select2_multiple_icerik_diller('yabanci-diller-select2')" data-select-search="true" class="yabanci-diller-select2" id="yabanci-diller-select2" name="yabaciDiller[]"  multiple="multiple">
                                            <?php
                                            $db->where("type", 4);
                                            $dilImkanlar = $db->get("facility");
                                            foreach ($dilImkanlar as $dilImkan) {
                                                echo in_array($dilImkan['id'], $_SESSION['yabaciDiller']) ? '<option value="'.$dilImkan['id'].'" selected>'.$dilImkan['name'].'</option>'
                                                    : '<option value="'.$dilImkan['id'].'">'.$dilImkan['name'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="dir-alp-l3 dir-alp-l-com hidden-mobile">
                            <input type="hidden" name="searchTerm" value="<?php echo $searchTerm; ?>">
                            <i class="waves-effect waves-light tourz-sear-btn waves-input-wrapper" style="width: 48%;float: left;text-align: center;background: linear-gradient(to bottom, #20344c, #20344c); height: 30px;line-height: 27px;margin-left: 2%; font-weight: normal;"><input id="search-btn" type="submit" value="Filtrele" class="waves-button-input"></i>
                            <i class="waves-effect waves-light tourz-sear-btn waves-input-wrapper" style="width: 48%;float: left;text-align: center;background: linear-gradient(to bottom, #20344c, #20344c); height: 30px;line-height: 27px;margin-left: 2%; font-weight: normal;"><input id="search-btn" type="submit" onclick="reset_talep_form()" value="Temizle" class="waves-button-input"></i>
                        </div>
                    </form>
                    <!-- FİLTRELER DESKTOP SON -->
                    <!-- FİLTRELER MOBİL -->
                    <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#mobilFiltreler" class="hidden-desktop xxs-pt" style="text-align: center;"><br>
                        <div class="dir-alp-l3 dir-alp-l-com">
                            <h4><i class="fa fa-list"></i> Filtrele</h4>
                        </div>
                    </a>
                    <!-- FİLTRELER MOBİL SON -->
                </div>
                <div class="col-md-9 dir-alp-con-right">
                    <div class="dir-alp-con-right-1">
                        <div class="row">
                            <?php
                            if (count($getSortedSchoolId) > 0) {
                                // bulunan okul sayısını yazdırıyor
                                echo '<p class="xxs-pt">Arama kriterinize uygun <b>'.count($getSortedSchoolId).'</b> okul bulundu.</p>';
                            } else {
                                echo '<p class="xxs-pt">Arama kriterinize uygun bir okul bulunamadı.</p>';
                            }

                            try {
                                $pageLimit = 10;
                                if ($pageNumber) {
                                    $startPoint = (($pageNumber-1)*$pageLimit);
                                }
                                $schoolsByPage = array_slice($getSortedSchoolId, $startPoint, $pageLimit);
                                $featuresResult = Array("Yok", "Var");
                                foreach ($schoolsByPage as $schoolByPage) {
                                    // sayfada yer alan school id ler ile tüm veriyi alıyor.
                                    $db->where("id", $schoolByPage['id']);
                                    $school = $db->getOne("school");
                                    $schoolParams = Array($school['id']);
                                    $schoolImage = $db->rawQuery("SELECT href FROM gallery WHERE parent = (SELECT gallery_id FROM school_gallery WHERE school_id = ?) ORDER BY creation_time ASC LIMIT 1", $schoolParams);
                                    $image = $schoolImage[0]['href'];
                                    if (strpos($image , '.jpg') !== false) {
                                        $image = str_replace("../", "", $image);
                                    } else {
                                        $image = "images/ro-blank.jpg";
                                    }
                                    $languages = "";
                                    $schoolLanguages = $db->rawQuery("SELECT name FROM facility WHERE id IN (SELECT facility_id FROM `school_facility` WHERE school_id = ?) AND type = 4 LIMIT 3", $schoolParams);
                                    $languageCount = 0;
                                    foreach ($schoolLanguages as $schoolLanguage) {
                                        $languageCount++;
                                        if ($languageCount == count($schoolLanguages)) {
                                            $languages .= $schoolLanguage['name'];
                                            continue;
                                        }
                                        $languages .= $schoolLanguage['name'].", ";
                                    }
                                    if ($languages == "") {
                                        $languages = "Yok";
                                    }
                                    $db->where("school_id", $school['id']);
                                    $db->where("state", 1);
                                    $commentCount = $db->getValue("comment", "count(*)");
                                    $schoolPoint = $school['points'];
                                    $schoolPointCount = 1;
                                    $db->where("school_id",$school['id']);
                                    $allPointsForSchool = $db->get('school_points');
                                    if ($db->count > 0) {
                                        foreach ($allPointsForSchool as $singlePointForSchool) {
                                            $schoolPoint += $singlePointForSchool['point'];
                                            $schoolPointCount++;
                                        }
                                    }
                                    $schoolPoint = $schoolPoint/$schoolPointCount;
                                    if ($schoolPoint >= 4.5) {
                                        $schoolPointBgColor = "rate-4-5-bg-color";
                                    } else if ($schoolPoint >= 4.0) {
                                        $schoolPointBgColor = "rate-4-bg-color";
                                    } else {
                                        $schoolPointBgColor = "rate-0-3-bg-color";
                                    }
                                    echo '<a href="'.WEBURL.'okul/'.$school['link'].'" target="_blank">
											<div class="xxs-pt">
												<div class="home-list-pop">
													<div class="col-md-3">
														<img src="'.$image.'" alt="'.$school['name'].' - Rehber Okul" />
													</div>
													<div class="col-md-9 home-list-pop-desc">
														<a href="'.WEBURL.'okul/'.$school['link'].'"  target="_blank"><h3 class="index-school-name">'.$school['name'].'</h3></a>';
                                    $db->where("sehir_key", $school['sehir_key']);
                                    $city = mb_convert_case(mb_strtolower($db->getOne("city")['name']), MB_CASE_TITLE, "UTF-8");

                                    $db->where("ilce_key", $school['ilce_key']);
                                    $town = mb_convert_case(mb_strtolower($db->getOne("town")['name']), MB_CASE_TITLE, "UTF-8");

                                    echo '<h4>'.$town.'/'.$city.'</h4>';

                                    echo '<span class="home-list-pop-rat '.$schoolPointBgColor.'">'.number_format($schoolPoint, 1, '.', ',').'</span>';
                                    echo '<ul class="home-popular-school-ops">
												<li><i class="fa fa-check"></i> Psikolojik Danışman: '.$featuresResult[$school['counselor']].'</li>
												<li><i class="fa fa-check"></i> Yaş Aralığı: '.$school['age_interval'].'</li>
												<li><i class="fa fa-check"></i> Dil Olanakları: '.$languages.'</li>
												<li><i class="fa fa-check"></i> Servis: '.$featuresResult[$school['transportation']].'</li>
											</ul>
														<div class="hom-list-share">
															<ul>
																<li class="float-right bg-color-red"><a href="'.WEBURL.'okul/'.$school['link'].'" class="color-white"  target="_blank"><i class="fa fa-hand-o-right color-white" aria-hidden="true"></i> Seç</a> </li>
																<li class="float-right"><i class="fa fa-eye" aria-hidden="true"></i> '.$school['click_count'].'</li>
																<li class="float-right"><i class="fa fa-comment" aria-hidden="true"></i> '.$commentCount.'</li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</a>';
                                }
                            } catch (Exception $e) {

                            }
                            ?>
                        </div>
                        <div class="row">
                            <ul class="pagination list-pagenat">
                                <?php
                                if (count($getSortedSchoolId) > 0) {
                                    $totalPage =  ceil(count($getSortedSchoolId)/$pageLimit);
                                    if ($totalPage != 1) {
                                        if ($pageNumber != 1) {
                                            echo '<li class="waves-effect"><a class="page-link" href="'.WEBURL.$getRegion.'/'.($pageNumber-1).'"><i class="fa fa-angle-left"></i></a></li>';
                                        }
                                        if ($pageNumber == 1 || $pageNumber == 2 || $pageNumber == 3) {
                                            for ($i=1; $i <= 7; $i++) {
                                                if ($i <= $totalPage) {
                                                    echo '<li class="waves-effect';
                                                    if ($pageNumber == $i) {
                                                        echo ' active';
                                                    }
                                                    echo '"><a class="page-link" href="'.WEBURL.$getRegion.'/'.$i.'">'.$i.'</a></li>';
                                                }
                                            }
                                        } else if ($pageNumber == $totalPage || $pageNumber == $totalPage-1 || $pageNumber == $totalPage-2) {
                                            for ($i=$totalPage-6; $i <= $totalPage; $i++) {
                                                if ($i <= $totalPage && $i!=0) {
                                                    echo '<li class="waves-effect';
                                                    if ($pageNumber == $i) {
                                                        echo ' active';
                                                    }
                                                    echo '"><a class="page-link" href="'.WEBURL.$getRegion.'/'.$i.'">'.$i.'</a></li>';
                                                }
                                            }
                                        } else {
                                            for ($i=($pageNumber-3); $i <= ($pageNumber+3); $i++) {
                                                if ($i > 0 && $i <= $totalPage) {
                                                    if ($i <= $totalPage) {
                                                        echo '<li class="waves-effect';
                                                        if ($pageNumber == $i) {
                                                            echo ' active';
                                                        }
                                                        echo '"><a class="page-link" href="'.WEBURL.$getRegion.'/'.$i.'">'.$i.'</a></li>';
                                                    }
                                                }
                                            }
                                        }
                                        if ($pageNumber != $totalPage) {
                                            echo '<li class="waves-effect"><a class="page-link" href="'.WEBURL.$getRegion.'/'.($pageNumber+1).'"><i class="fa fa-angle-right"></i></a></li>';
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
if (isset($_SESSION['user_data']) && $_SESSION['is_logged_in']) {
    $db->where('id', $_SESSION['user_data']['user_id']);
    $loggedInUser = $db->getOne('user');
}
?>

<section id="ucretsiz-danismanlik-formu" class="com-padd quic-book-ser-full">
    <div class="quic-book-ser xs-pt">
        <div class="quic-book-ser-inn">
            <div class="quic-book-ser-left">
                <div class="land-com-form">
                    <p class="sizi-arayalım">Sizi Arayalım</p>
                    <form id="call-us-form">
                        <ul>
                            <li>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input type="text" name="full_name" value="<?php echo $_SESSION['user_data']['full_name'] ;?>" pattern="[a-zA-ZçÇöÖüÜşŞİığĞ\s]*" title="İsminizi Girmediniz!" required>
                                        <label>İsim Soyisim</label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input value="<?php echo $loggedInUser ? $loggedInUser['phone'] : '' ;?>" type="text" name="phone" pattern="^[0-9]{10,10}$" title="Sadece rakam kullanabilirsiniz! 10 haneli olmalıdır!" required>
                                        <label>Telefon</label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input value="<?php echo $loggedInUser ? $loggedInUser['email'] : '' ;?>" type="email" name="email" title="Hatalı Email!" required>
                                        <label>E-Posta</label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="input-field col s12 school-type-select">
                                        <select name="school_type" required title="Okul Türü Seçmediniz!">
                                            <option value="">Okul Türü</option>
                                            <option  value="1">Anaokulu veya Kreş</option>
                                            <option  value="2">İlkokul</option>
                                            <option  value="3">Ortaokul</option>
                                            <option  value="4">Lise</option>
                                        </select>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <textarea id="ta-call-us-note" name="note" required title="Not Girmediniz!" rows="4" cols="50" style="height: 70px;" placeholder="Notunuz"></textarea>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <button type="button" class="waves-effect waves-light btn-large full-btn" onclick="send_call_us();">Talep Oluştur</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
            <div class="quic-book-ser-right">
                <div class="hom-cre-acc-left">
                    <h5>Eğitim danışmanlarımız sizi arasın</h5>
                    <p>Sizin için en uygun okulu belirlemeye zaman ayıramıyorsanız, ücretiz olarak eğitim danışmanlarımızla iletişime geçebilir ve destek alabilirsiniz.</p>
                    <ul>
                        <li> <img src="images/ikonlar/talep-formu/adim-1.png" alt="">
                            <div>
                                <h5 class="xxs-pt">Formu doldurun</h5>
                                <p></p>
                            </div>
                        </li>
                        <li> <img src="images/ikonlar/talep-formu/adim-2.png" alt="">
                            <div>
                                <h5 class="xxs-pt">Eğitim danışmanlarımız sizi arasın</h5>
                                <p></p>
                            </div>
                        </li>
                        <li> <img src="images/ikonlar/talep-formu/adim-3.png" alt="">
                            <div>
                                <h5 class="xxs-pt">En uygun eğitim kurumunu bulun</h5>
                                <p></p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade dir-pop-com in" id="mobilFiltreler" role="dialog">
    <div class="modal-dialog">

        <div class="modal-body">
            <div class="dir-alp-con-left">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <form id="frm-talep-filtre-mobile" action="<?php echo WEBURL; ?>arama-sonucu" method="get">
                    <div class="dir-alp-l3 dir-alp-l-com">
                        <h4>Puan</h4>
                        <div class="dir-alp-l-com1 dir-alp-p3">
                            <ul>
                                <li>
                                    <input <?php echo $_SESSION['puan_45_5'] ? 'checked' : ''; ?> name="puan_45_5" value="1" type="checkbox" class="filled-in" id="lr101" />
                                    <label for="lr101">Çok İyi (4.5 ve üzeri)</label>
                                </li>
                                <li>
                                    <input <?php echo $_SESSION['puan_4_45'] ? 'checked' : ''; ?> name="puan_4_45" value="1" type="checkbox" class="filled-in" id="lr102" />
                                    <label for="lr102">İyi (4.0 ve üzeri)</label>
                                </li>
                                <li>
                                    <input <?php echo $_SESSION['puan_3_4'] ? 'checked' : ''; ?> name="puan_3_4" value="1" type="checkbox" class="filled-in" id="lr103" />
                                    <label for="lr103">Ortalama (3.0 ve üzeri)</label>
                                </li>
                                <li>
                                    <input <?php echo $_SESSION['puan_Diger'] ? 'checked' : ''; ?> name="puan_Diger" value="1" type="checkbox" class="filled-in" id="lr104" />
                                    <label for="lr104">Diğer</label>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="dir-alp-l3 dir-alp-l-com">
                        <h4>Bölge</h4>
                        <div class="dir-alp-l-com1 dir-alp-p3">
                            <ul>
                                <li>
                                    <select id="select-iller-mobile" onchange="set_multiple_towns_mobile('select-iller-mobile')" data-select-search="true" class="il-select2" name="iller[]"  multiple="multiple">
                                        <?php foreach ($allCities as $city) :?>
                                            <option value="<?php echo $city['sehir_key']; ?>" <?php foreach($_SESSION['cities'] as $sehir_key) { echo $city['sehir_key'] == $sehir_key ? 'selected' : '';}?>><?php echo ucwords_tr($city['name']); ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </li>
                                <li>
                                    <select id="select-ilceler-mobile" onchange="set_select2_multiple_icerik_ilce_mobile('ilce-select2')" data-select-search="true" class="ilce-select2" name="ilceler[]"  multiple="multiple">
                                        <?php foreach ($allTowns as $town) :?>
                                            <option value="<?php echo $town['ilce_key']; ?>" <?php foreach($_SESSION['towns'] as $ilce_key) { echo $town['ilce_key'] == $ilce_key ? 'selected' : '';}?>><?php echo ucwords_tr($town['name']); ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="dir-alp-l3 dir-alp-l-com">
                        <h4>Özellikler</h4>
                        <div class="dir-alp-l-com1 dir-alp-p3">
                            <ul>
                                <li>
                                    <input <?php echo $_SESSION['okulServisi'] ? 'checked' : ''; ?> name="okulServisi" value="1" type="checkbox" class="filled-in" id="lr105" />
                                    <label for="lr105">Okul Servisi</label>
                                </li>
                                <li>
                                    <input <?php echo $_SESSION['psikolojikDanisman'] ? 'checked' : ''; ?> name="psikolojikDanisman" value="1" type="checkbox" class="filled-in" id="lr106" />
                                    <label for="lr106">Psikolojik Danışman</label>
                                </li>
                                <li>
                                    <select onchange="set_select2_multiple_icerik_fiziksel_mobile('fiziksel-imkanlar-select2')" data-select-search="true" class="fiziksel-imkanlar-select2" id="fiziksel-imkanlar-select2-mobile" name="fizikselImkanlar[]"  multiple="multiple">
                                        <?php
                                        $db->where("type", 1);
                                        $fizikselImkanlar = $db->get("facility");
                                        foreach ($fizikselImkanlar as $fizikselImkan) {
                                            echo in_array($fizikselImkan['id'], $_SESSION['fizikselImkanlar']) ? '<option value="'.$fizikselImkan['id'].'" selected>'.$fizikselImkan['name'].'</option>'
                                                : '<option value="'.$fizikselImkan['id'].'">'.$fizikselImkan['name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </li>
                                <li>
                                    <select onchange="set_select2_multiple_icerik_servisler_mobile('servisler-select2')" data-select-search="true" class="servisler-select2" id="servisler-select2-mobile" name="servisler[]"  multiple="multiple">
                                        <?php
                                        $db->where("type", 2);
                                        $servisImkanlar = $db->get("facility");
                                        foreach ($servisImkanlar as $servisImkan) {
                                            echo in_array($servisImkan['id'], $_SESSION['servisler']) ? '<option value="'.$servisImkan['id'].'" selected>'.$servisImkan['name'].'</option>'
                                                : '<option value="'.$servisImkan['id'].'">'.$servisImkan['name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </li>
                                <li>
                                    <select onchange="set_select2_multiple_icerik_aktiviteler_mobile('aktiviteler-select2')" data-select-search="true" class="aktiviteler-select2" id="aktiviteler-select2-mobile" name="aktiviteler[]"  multiple="multiple">
                                        <?php
                                        $db->where("type", 3);
                                        $aktiviteImkanlar = $db->get("facility");
                                        foreach ($aktiviteImkanlar as $aktiviteImkan) {
                                            echo in_array($aktiviteImkan['id'], $_SESSION['aktiviteler']) ? '<option value="'.$aktiviteImkan['id'].'" selected>'.$aktiviteImkan['name'].'</option>'
                                                : '<option value="'.$aktiviteImkan['id'].'">'.$aktiviteImkan['name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </li>
                                <li>
                                    <select onchange="set_select2_multiple_icerik_diller_mobile('yabanci-diller-select2')" data-select-search="true" class="yabanci-diller-select2" id="yabanci-diller-select2-mobile" name="yabaciDiller[]"  multiple="multiple">
                                        <?php
                                        $db->where("type", 4);
                                        $dilImkanlar = $db->get("facility");
                                        foreach ($dilImkanlar as $dilImkan) {
                                            echo in_array($dilImkan['id'], $_SESSION['yabaciDiller']) ? '<option value="'.$dilImkan['id'].'" selected>'.$dilImkan['name'].'</option>'
                                                : '<option value="'.$dilImkan['id'].'">'.$dilImkan['name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="dir-alp-l3 dir-alp-l-com sm-pb">
                        <i class="waves-effect waves-light tourz-sear-btn waves-input-wrapper" style="width: 48%;float: left;text-align: center;background: linear-gradient(to bottom, #20344c, #20344c); height: 30px;line-height: 27px;margin-left: 2%; font-weight: normal;"><input id="search-btn" type="submit" value="Filtrele" class="waves-button-input"></i>
                        <input type="hidden" name="searchTerm" value="<?php echo $searchTerm; ?>">
                        <i class="waves-effect waves-light tourz-sear-btn waves-input-wrapper" style="width: 48%;float: left;text-align: center;background: linear-gradient(to bottom, #20344c, #20344c); height: 30px;line-height: 27px;margin-left: 2%; font-weight: normal;"><input id="search-btn" type="submit" onclick="reset_talep_form_mobile()" value="Temizle" class="waves-button-input"></i>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<?php
$db->where("sss_place", $getRegion);
$faqs = $db->get("sss");
if ($db->count > 0) {
    echo '<section class="xs-py">
		<div class="container dir-hom-pre-tit">
			<div class="row">
				<div class="xs-py">
					<h2 class="xs-pb">'.$pageTitle.' Hakkında Sıkça Sorulan Sorular</h2>';
    foreach ($faqs as $faq) {
        echo '<button class="sss-accordion">'.$faq['question'].' <i class="fa fa-2x fa-angle-down float-right"></i></button>
					<div class="sssPanel">
					  	<p class="xxs-py">'.$faq['answer'].'</p>
					</div>';
    }
    echo '</div></div></div></section>';

    echo '<script type="application/ld+json">';
    echo '{
		      "@context": "https://schema.org",
		      "@type": "FAQPage",
		      "mainEntity": [';
    $faqsCount = count($faqs);
    foreach ($faqs as $faq) {
        echo '{
			        "@type": "Question",
			        "name": "'.$faq['question'].'",
			        "acceptedAnswer": {
			          "@type": "Answer",
			          "text": "'.$faq['answer'].'"
			        }
			      }';
        if ($faqsCount > 1) {
            echo ',';
        }
        $faqsCount--;
    }
    echo ']
		    }';
    echo '</script>';

}
?>

<section id="landing-content" class="xs-py com-padd">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ml-auto mr-auto">
                <h4 class="text-center"><?php echo $searchTerm; ?></h4><br>
                <p>
                    <?php echo htmlspecialchars_decode($landingContent);?>
                </p>
            </div>
        </div>
    </div>
</section>


<?php
require_once('php/Components/Footer.php');
?>

<script src="js/bootstrap.js" type="text/javascript"></script>
<script src="js/materialize.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/select2.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/rehberokul.js"></script>
<script type="text/javascript">
    $(document).ready( function () {
        $('.school-type-select .select-wrapper .caret').remove();
        $('.school-type-select .select-wrapper .select-dropdown').remove();
        $('.mdb-select').materialSelect();
    });
    $(document).ready(function() {
        var uldiv = $('#select-iller').parent().next('span.select2').find('ul');
        var count = uldiv.find('li.select2-selection__choice').length;
        if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
            uldiv.html("<li>"+count+" Öğe Seçildi.</li>");
        }

    });

    $(document).ready(function() {
        var uldiv = $('#select-iller-mobile').parent().next('span.select2').find('ul');
        var count = uldiv.find('li.select2-selection__choice').length;
        if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
            uldiv.html("<li>"+count+" Öğe Seçildi.</li>");
        }

    });

    $(document).ready(function() {
        var uldiv = $('#select-ilceler').parent().next('span.select2').find('ul');
        var count = uldiv.find('li.select2-selection__choice').length;
        if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
            uldiv.html("<li>"+count+" Öğe Seçildi.</li>");
        }

    });

    $(document).ready(function() {
        var uldiv = $('#select-ilceler-mobile').parent().next('span.select2').find('ul');
        var count = uldiv.find('li.select2-selection__choice').length;
        if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
            uldiv.html("<li>"+count+" Öğe Seçildi.</li>");
        }

    });

    $(document).ready(function() {
        var uldiv = $('#fiziksel-imkanlar-select2').parent().next('span.select2').find('ul');
        var count = uldiv.find('li.select2-selection__choice').length;
        if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
            uldiv.html("<li>"+count+" Öğe Seçildi.</li>");
        }

    });

    $(document).ready(function() {
        var uldiv = $('#fiziksel-imkanlar-select2-mobile').parent().next('span.select2').find('ul');
        var count = uldiv.find('li.select2-selection__choice').length;
        if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
            uldiv.html("<li>"+count+" Öğe Seçildi.</li>");
        }

    });

    $(document).ready(function() {
        var uldiv = $('#servisler-select2').parent().next('span.select2').find('ul');
        var count = uldiv.find('li.select2-selection__choice').length;
        if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
            uldiv.html("<li>"+count+" Öğe Seçildi.</li>");
        }

    });

    $(document).ready(function() {
        var uldiv = $('#servisler-select2-mobile').parent().next('span.select2').find('ul');
        var count = uldiv.find('li.select2-selection__choice').length;
        if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
            uldiv.html("<li>"+count+" Öğe Seçildi.</li>");
        }

    });

    $(document).ready(function() {
        var uldiv = $('#aktiviteler-select2').parent().next('span.select2').find('ul');
        var count = uldiv.find('li.select2-selection__choice').length;
        if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
            uldiv.html("<li>"+count+" Öğe Seçildi.</li>");
        }

    });

    $(document).ready(function() {
        var uldiv = $('#aktiviteler-select2-mobile').parent().next('span.select2').find('ul');
        var count = uldiv.find('li.select2-selection__choice').length;
        if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
            uldiv.html("<li>"+count+" Öğe Seçildi.</li>");
        }

    });

    $(document).ready(function() {
        var uldiv = $('#yabanci-diller-select2').parent().next('span.select2').find('ul');
        var count = uldiv.find('li.select2-selection__choice').length;
        if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
            uldiv.html("<li>"+count+" Öğe Seçildi.</li>");
        }

    });

    $(document).ready(function() {
        var uldiv = $('#yabanci-diller-select2-mobile').parent().next('span.select2').find('ul');
        var count = uldiv.find('li.select2-selection__choice').length;
        if(count > 2) { // 2'den fazla seçim varsa 3 tane seçildi gibi gözükecek, 2 seçim ve az varsa seçilenler gözükecek
            uldiv.html("<li>"+count+" Öğe Seçildi.</li>");
        }

    });
</script>
</body>
</html>
