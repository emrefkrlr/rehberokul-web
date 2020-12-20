<?php
    require_once('php/Core.php');

    # PAGE CONFIG
    $pageTitle = "Rehber Okul | Anaokuları, Kreşler, Kolejler, Okul Bilgileri ve Yorumları";
    $pageDescription = "Rehber Okul ile kriterlerinize en uygun Özel okulları, anaokullarını, kreşleri ve kolejler hakkında detaylı bilgileri sana özel indirim fırsatlarıyla zaman kaybetmeden bul.";
    $pageKeywords = "rehber okul";
    $pageSocialImagePath = "images/rehberokul/rehber-okul.jpg";
    $twitterUsername = "rehberokul";
    $pageUrl = WEBURL."";
if (SUBFOLDER){
    $robotsStatus = "noindex, nofollow";
}else{
    $robotsStatus = "index, follow";
}



    function GetIP(){
	    if(getenv("HTTP_CLIENT_IP")) {
	        $ip = getenv("HTTP_CLIENT_IP");
	    } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
	        $ip = getenv("HTTP_X_FORWARDED_FOR");
	        if (strstr($ip, ',')) {
	            $tmp = explode (',', $ip);
	            $ip = trim($tmp[0]);
	        }
	    } else {
	    $ip = getenv("REMOTE_ADDR");
	    }
	    return $ip;
	}
	$ipkontrol = GetIP();
	$veri = file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=d08672270e61b91e4753c0221ea2284c537967771767a1bec765659885664846&ip=$ipkontrol");
	$dizi = $veri;
	$deger = explode(";",$dizi); 
	$shr = $deger[6]; // Bu kısımda sadece şehiri seçtirdik. diğer arraylarla da diğer bilgileri çekebilirsiniz.
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

	$cities = $db->get("city");
	$cityOk = false;
    foreach ($cities as $city) {
        if (ucwords_tr($shr) == ucwords_tr($city["name"])) {
            $cityCode = $city["sehir_key"];
            $db->where("sehir_key",$city['sehir_key']);
            $citySchools = $db->get('school');
            if($db->count < 8) {
                $cityCode = 34;
                $shr = 'İstanbul';
            }
            $cityOk = true;
            break;
        }
    }

    if(!$cityOk) {
        $cityCode = 34;
        $shr = 'İstanbul';
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
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css"/>
	<link href="css/custom.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
	<script src="js/login.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/autcomplete-custom.js"></script>
<?php require_once('php/Components/Scripts.php'); ?></head>
<body>
	<?php require_once('php/Components/Header-Part-1.php'); ?>
		<div class="container dir-ho-t-sp">
			<div class="row">
				<div class="dir-hr1">
					<div class="dir-ho-t-tit">
						<h1>Size en uygun eğitim kurumunu zaman kaybetmeden bulun</h1>
					</div>
					<form action="<?php echo WEBURL; ?>search" method="post" autocomplete="off">
						<div class="col-md-9">
							<input name="searchTerm" type="text" id="select-search" class="autocomplete" placeholder="Arama Yap (Şehir veya okul adı yazın)" autocomplete="off" title="Lütfen arama kriterinizi yazın" required>
						</div>
						<div class="col-md-3">
							<input id="search-btn" type="submit" value="Hemen Bul" class="waves-effect waves-light tourz-sear-btn">
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php require_once('php/Components/Header-Part-2.php'); ?>
	<section class="proj mar-bot-red-m30 xs-pt">
		<div class="container">
			<div class="row">
				<div class="col-md-3 index-school-stats">
					<div class="hom-pro" onclick="go_school_type_page(1, '<?php echo WEBURL; ?>')"> <img width="100" src="images/ikonlar/okul-tipleri/anaokulu-kres.png" alt="" />
						<h4 class="xs-pb xxs-mx-mobile xxs-pt-mobile">
						<?php
							$db->where("type", 1);
							echo $db->getValue ("school", "count(*)");
						?>
						Anaokulu & Kreş</h4>
						<a href="<?php echo WEBURL; ?>okul-tipi/anaokulu-kres" class="hidden-mobile">İncele</a>
					</div>
				</div>
				<div class="col-md-3 index-school-stats">
					<div class="hom-pro" onclick="go_school_type_page(2, '<?php echo WEBURL; ?>')"> <img width="100" src="images/ikonlar/okul-tipleri/ilkokul.png" alt="" />
						<h4 class="xs-pb xxs-mx-mobile xxs-pt-mobile">
						<?php
							$db->where("type", 2);
							echo $db->getValue ("school", "count(*)");
						?>
						İlk Okul</h4>
						<a href="<?php echo WEBURL; ?>okul-tipi/ilk-okul" class="hidden-mobile">İncele</a>
					</div>
				</div>
				<div class="col-md-3 index-school-stats">
					<div class="hom-pro" onclick="go_school_type_page(3, '<?php echo WEBURL; ?>')"> <img width="100" src="images/ikonlar/okul-tipleri/ortaokul.png" alt="" />
						<h4 class="xs-pb xxs-mx-mobile xxs-pt-mobile"> 
						<?php
							$db->where("type", 3);
							echo $db->getValue ("school", "count(*)");
						?>
						Orta Okul</h4>
						<a href="<?php echo WEBURL; ?>okul-tipi/orta-okul" class="hidden-mobile">İncele</a>
					</div>
				</div>
				<div class="col-md-3 index-school-stats">
					<div class="hom-pro" onclick="go_school_type_page(4, '<?php echo WEBURL; ?>')"> <img width="100" src="images/ikonlar/okul-tipleri/lise.png" alt="" />
						<h4 class="xs-pb xxs-mx-mobile xxs-pt-mobile">
						<?php
							$db->where("type", 4);
							echo $db->getValue ("school", "count(*)");
						?>
						Lise</h4>
						<a href="<?php echo WEBURL; ?>okul-tipi/lise" class="hidden-mobile">İncele</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="com-padd com-padd-redu-bot">
		<div class="container dir-hom-pre-tit">
			<div class="row">
				<div class="com-title">
					<h2><?php echo $shr; ?> İlindeki Popüler Anaokulları</h2>
					<p class="under-h-title-info"><?php echo $shr; ?> İlindeki en popüler anaokulları hemen incele</p>
				</div>
				<div class="col-md-6">

                    <?php
                    $schoolLimitCount = 0;
                    $featuresResult = Array("Yok", "Var");
                    $params = Array(1, $cityCode); //type, sehir_key
                    $homePagePopularSchoolsOfCity = $db->rawQuery("SELECT * FROM school WHERE type = ? AND sehir_key = ? ORDER BY priority DESC LIMIT 8", $params);
                    if ($db->count > 0) {
                        foreach ($homePagePopularSchoolsOfCity as $school) {
                            $schoolLimitCount++;
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
                            $hLimit = 2;
                            $saylimit = 0;
                            if ($db->count > 0) {
                                foreach ($allPointsForSchool as $singlePointForSchool) {
                                    $schoolPoint += $singlePointForSchool['point'];
                                    $schoolPointCount++;
                                    $saylimit++;


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

                            echo '<a href="'.WEBURL.'okul/'.$school['link'].'" title="'.$school['name'].'">
						<div>
							<div class="home-list-pop">
								<div class="col-md-3">
									<img src="'.$image.'" alt="'.$school['name'].' - Rehber Okul" />
								</div>
								<div class="col-md-9 home-list-pop-desc">
									<a href="'.WEBURL.'okul/'.$school['link'].'"><h3 class="index-school-name">'.$school['name'].'</h3></a>';
                            $db->where("sehir_key", $school['sehir_key']);
                            $city = mb_convert_case(mb_strtolower($db->getOne("city")['name']), MB_CASE_TITLE, "UTF-8");

                            $db->where("ilce_key", $school['ilce_key']);
                            $town = mb_convert_case(mb_strtolower($db->getOne("town")['name']), MB_CASE_TITLE, "UTF-8");

                            echo '<h4>'.$town.'/'.$city.'</h4>';

                            echo '<span class="home-list-pop-rat '.$schoolPointBgColor.'">'.number_format($schoolPoint, 1, '.', ',').'</span>';
                            if ($school['discount']) {
                                echo '<p class="ro-special-price"><i class="fa fa-star"></i> Rehber Okula Özel İndirim</p>';
                            }
                            echo '<ul class="home-popular-school-ops">
										<li><i class="fa fa-check"></i> Psikolojik Danışman: '.$featuresResult[$school['counselor']].'</li>
										<li><i class="fa fa-check"></i> Yaş Aralığı: '.$school['age_interval'].'</li>
										<li><i class="fa fa-check"></i> Dil Olanakları: '.$languages.'</li>
										<li><i class="fa fa-check"></i> Servis: '.$featuresResult[$school['transportation']].'</li>
									</ul>
									<div class="hom-list-share">
										<ul>
											<li class="float-right"><i class="fa fa-eye" aria-hidden="true"></i> '.$school['click_count'].'</li>
											<li class="float-right"><i class="fa fa-comment" aria-hidden="true"></i> '.$commentCount.'</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</a>';
                            if ($schoolLimitCount == 4) {
                                echo '</div><div class="col-md-6">';
                            }
                        }
                    }
                    ?>




				</div>
			</div>
		</div>
	</section>
    <?php
        try
        {
            $lastCommentedSchoolIds = $db->rawQuery("SELECT DISTINCT(school_id) FROM comment WHERE state = 1 AND school_id != 0 ORDER BY publish_date DESC LIMIT 12");
        }catch(Exception $e) {

        }
	?>
	<section class="com-padd com-padd-redu-bot1 pad-bot-red-40 <?php echo count($lastCommentedSchoolIds) > 0 ? '' : 'hide'; ?>">
		<div class="container">
			<div class="row">
				<div class="com-title">
					<h2>Son yorum alan okullarımızdan bazıları</h2>
					<p class="under-h-title-info">Değerli velilerimizden değerlendirmeleri hemen incele</p>
				</div>
				<div class="card-slider">
<?php
try {
	$commentedSchoolIds = [];
	foreach ($lastCommentedSchoolIds as $lastCommentedSchoolId) {
		array_push($commentedSchoolIds, $lastCommentedSchoolId['school_id']);
	}
    $db->where('id', $commentedSchoolIds, 'IN');
    $homePageMostCommentedSchools = $db->get('school');
    if ($db->count > 0) {
        foreach ($homePageMostCommentedSchools as $school) {
        	$schoolImage = $db->rawQuery("SELECT href FROM gallery WHERE parent = (SELECT gallery_id FROM school_gallery WHERE school_id = ?) ORDER BY creation_time ASC LIMIT 1", $schoolParams);
        	$image = $schoolImage[0]['href'];
        	if (strpos($image , '.jpg') !== false) {
        		$image = str_replace("../", "", $image);
			} else {
				$image = "images/ro-blank.jpg";
			}
			$db->where("school_id", $school['id']);
			$db->where("state", 1);
			$commentCount = $db->getValue("comment", "count(*)");
        	echo '<div class="card-wrapper">
			        	<div class="card">
				             <a href="'.WEBURL.'okul/'.$school['link'].'" title="'.$school['name'].'">
				                <div class="dir-hli-5">
				                  <div class="dir-hli-1">
				                    <div class="dir-hli-3"><img src="'.$image.'" alt="'.$school['name'].' - Rehber Okul" /></div>
				                    <div class="dir-hli-4"> </div><img src="'.$image.'" alt="'.$school['name'].' - Rehber Okul" /></div>
				                  <div class="dir-hli-2">
				                    <h4 class="index-school-name">'.$school['name'].'</h4>
				                    <p class="xxs-pt index-school-comment"></p>
				                    <p style="text-align: right; font-size: 10pt;" class="xxs-pt"><i class="fa fa-comment"></i> '.$commentCount.'</p> 
				                </div>
				                </div>
				              </a>
			            </div>
			      	</div>';
        }
    }
} catch (Exception $e) {}	
?>
			    </div>
			</div>
		</div>
	</section>
	<section class="com-padd com-padd-redu-top">
		<div class="container">
			<div class="row">
				<div class="com-title">
					<h2>Çocuk ve Eğitime Dair Her Şey</h2>
					<p class="under-h-title-info">Eğitim ve birey sağlığı alanında faydalanabileceğiniz yazılarımız</p>
				</div>
				<div class="col-md-6">
<?php
$homePostCount = 0;
$db->orderBy("publish_date","desc");
$homepagePosts = $db->get('blog', 5);
if ($db->count > 0) {
    foreach ($homepagePosts as $homepagePost) {
    	$homePostCount++;
        echo '<a href="'.WEBURL.'rehber-blog/'.$homepagePost['link'].'">
						<div class="list-mig-like-com">
							<div class="list-mig-lc-img"> <img src="'.str_replace("../", "", $homepagePost['photo']).'" alt="" /> </div>
							<div class="list-mig-lc-con list-mig-lc-con2">
								<h5>'.$homepagePost['title'].'</h5>
								
							</div>
						</div>
					</a>';
        if ($homePostCount < 5) {
            echo '</div><div class="col-md-3">';
       	}
    }
}
?>
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
		<div class="quic-book-ser">
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
                                                <option value="1">Anaokulu veya Kreş</option>
                                                <option value="2">İlkokul</option>
                                                <option value="3">Ortaokul</option>
                                                <option value="4">Lise</option>
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
						<p class="under-h-title-info">Sizin için en uygun okulu belirlemeye zaman ayıramıyorsanız, ücretiz olarak eğitim danışmanlarımızla iletişime geçebilir ve destek alabilirsiniz.</p>
						<ul>
							<li> <img src="images/ikonlar/talep-formu/adim-1.png" alt="" width="35">
								<div>
									<h5 class="xxs-pt under-h-title-info">Formu doldurun</h5>
									<p></p>
								</div>
							</li>
							<li> <img src="images/ikonlar/talep-formu/adim-2.png" alt="" width="35">
								<div>
									<h5 class="xxs-pt under-h-title-info">Eğitim danışmanlarımız sizi arasın</h5>
									<p></p>
								</div>
							</li>
							<li> <img src="images/ikonlar/talep-formu/adim-3.png" alt="" width="35">
								<div>
									<h5 class="xxs-pt under-h-title-info">En uygun eğitim kurumunu bulun</h5>
									<p></p>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php require_once('php/Components/Footer.php'); ?>

	<script src="js/bootstrap.js" type="text/javascript"></script>
	<script src="js/materialize.min.js" type="text/javascript"></script>
	<script src="js/custom.js"></script>
	<script src="js/rehberokul.js"></script>
	<script type="text/javascript" src="slick/slick.min.js"></script>
	<script type="text/javascript">
	$(document).ready( function () {
	  	$('.school-type-select .select-wrapper .caret').remove();
		$('.school-type-select .select-wrapper .select-dropdown').remove();
	});
	$('.card-slider').slick({
		autoplay: true,
		dots: false,
		infinite: true,
		speed: 1500,
		slidesToShow: 4,
		slidesToScroll: 4,
		responsive: [
		  {
		    breakpoint: 1024,
		    settings: {
		      slidesToShow: 3,
		      slidesToScroll: 3,
		      infinite: true,
		      dots: false
		    }
		  },
		  {
		    breakpoint: 600,
		    settings: {
		      slidesToShow: 2,
		      slidesToScroll: 2
		    }
		  },
		  {
		    breakpoint: 480,
		    settings: {
		      slidesToShow: 1,
		      slidesToScroll: 1
		    }
		  }
		]
	});
	</script>
</body>
</html>