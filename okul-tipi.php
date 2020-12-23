<?php
    require_once('php/Core.php');
    if (isset($_GET['okulTipiSeflink'])) {
        $okulTipiSeflink = $_GET['okulTipiSeflink'];
        if ($okulTipiSeflink == "anaokulu-kres") {
        	$pageTitle = "Anaokulu &amp; Kreşler Hakkında Her Şey Burada  - Rehber Okul";
        	$pageH = "Anaokulları & Kreşler";
        	$pageDesc = "Sana enuygun anaokulu & kreşi bulmak için arama yap";
        	$pageDescription = "Anaokullar ve kreş fiyatlarını, veli değerlendirmeleri ve yorumları okulların profil sayfasından ziyaret et. Türkiye &#39;de ki en iyi anaokullarını hemen incele.";
        	$pageHsmall = "anaokulları & kreşler";
        	$schoolType = 1;
        } else if ($okulTipiSeflink == "ilk-okul") {
        	$pageTitle = "Bölgende ki Özel İlkokulları Hemen İncele - Rehber Okul";
        	$pageH = "İlkokullar";
        	$pageDesc = "Sana enuygun ilkokulları bulmak için arama yap";
        	$pageDescription = "İstanbul, Ankara ve İzmir özel ilkokulları hemen ara. Okulun görsellerini, fiziksel imkanları, servis imkanı ve okul hakkında detaylı bilgileri hemen incele.";
        	$pageHsmall = "ilkokullar";
        	$schoolType = 2;
        } else if ($okulTipiSeflink == "orta-okul") {
        	$pageTitle = "Ortaokul Düzeyinde Eğitim Veren Özel Okullar - Rehber Okul";
        	$pageH = "Ortaokullar";
        	$pageDesc = "Sana enuygun ortaokulları bulmak için arama yap";
        	$pageDescription = "Çocuğunuz için eğitim olanaklarını detaylı inceleyebileceğiniz, diğer veli yorumlarını inceleyerek bölgendeki özel ortaokulları arasında bütçenize en uygun olanı seç.";
        	$pageHsmall = "ortaokullar";
        	$schoolType = 3;
        } else if ($okulTipiSeflink == "lise") {
        	$pageTitle = "En İyi Özel Liseler ve Fiyatları Burada - Rehber Okul";
        	$pageH = "Liseler";
        	$pageDesc = "Sana enuygun liseleri bulmak için arama yap";
        	$pageDescription = "Türkiye &#39;de ki en iyi özel liseleri, bursluluk sınavları ve fiyatlarını hemen incele. Bölgende bulunan en popüler liseler için hemen tıkla araştırmaya başla.";
        	$pageHsmall = "liseler";
        	$schoolType = 4;
        }

        $db->where("slug", $okulTipiSeflink);
		$schoolTypePage = $db->getOne("setting");
		$pageBgImage = str_replace("../", "", $schoolTypePage['photo']);

    }
    $pageKeywords = "rehber okul";
    $pageSocialImagePath = "images/rehberokul/rehber-okul.jpg";
    $twitterUsername = "rehberokul";
    $pageUrl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
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
						<h1>En İyi <?php echo $pageH; ?></h1>
						<p><?php echo $pageDesc; ?></p>
					</div>
					<form action="<?php echo WEBURL; ?>search" method="post" autocomplete="off">
						<div class="col-md-9">
							<input name="searchTerm" type="text" id="select-search" class="autocomplete" placeholder="Daha fazla <?php echo $pageHsmall; ?> için yazın"  autocomplete="off" title="Lütfen arama kriterinizi yazın" required>
						</div>
						<div class="col-md-3">
							<input id="search-btn" type="submit" value="Hemen Bul" class="waves-effect waves-light tourz-sear-btn" style="width:100%;"> </div>
					</form>
				</div>
			</div>
		</div>
	<?php require_once('php/Components/Header-Part-2.php'); ?>
	<section class="xs-py">
		<div class="container dir-hom-pre-tit">
			<div class="row">
				<div class="xs-pb">
					<h2 class="xxs-pb"><?php echo $schoolTypePage['top_header']; ?></h2>
					<p class="under-h-title-info"><?php echo $schoolTypePage['top_content']; ?></p>
				</div>
			</div>
			<div class="row">
				<div class="xxs-pb">
					<h2 class="xxs-pb"><?php echo $shr; ?> <?php echo $schoolTypePage['popular_header']; ?></h2>
					<p class="under-h-title-info"><?php echo $schoolTypePage['popular_content']; ?></p>
				</div>
				<div class="col-md-6">
<?php
	$schoolLimitCount = 0;
	$featuresResult = Array("Yok", "Var");
    $params = Array($schoolType, $cityCode); //type, sehir_key
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
										<li><i class="fa fa-check"></i> Psikolojik Danışman: '.$featuresResult[$school['counselor']].'</li>';
							if ($school['age_interval'] != "") {
								echo'<li><i class="fa fa-check"></i> Yaş Aralığı: '.$school['age_interval'].'</li>';
							}
							echo '<li><i class="fa fa-check"></i> Dil Olanakları: '.$languages.'</li>
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
                                                <option <?php echo $schoolType == 1 ? 'selected' : '';?> value="1">Anaokulu veya Kreş</option>
                                                <option <?php echo $schoolType == 2 ? 'selected' : '';?> value="2">İlkokul</option>
                                                <option <?php echo $schoolType == 3 ? 'selected' : '';?> value="3">Ortaokul</option>
                                                <option <?php echo $schoolType == 4 ? 'selected' : '';?> value="4">Lise</option>
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
                        <p class="h3">Eğitim danışmanlarımız sizi arasın</p>
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
    <?php
    	$db->where("sss_place", $okulTipiSeflink);
		$faqs = $db->get("sss");
		if ($db->count > 0) {
			echo '<section class="xs-py">
		<div class="container dir-hom-pre-tit">
			<div class="row">
				<div class="xs-py">
					<h2 class="xs-pb">'.$pageH.' Hakkında Sıkça Sorulan Sorular</h2>';
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
	
	<section class="xs-py">
		<div class="container dir-hom-pre-tit">
			<div class="row">
				<div class="xs-py">
					<h2 class="xxs-pb"><?php echo $schoolTypePage['bottom_header']; ?></h2>
					<p class="under-h-title-info"><?php echo $schoolTypePage['bottom_content']; ?></p>
				</div>
			</div>
		</div>
	</section>
	<?php
		require_once('php/Components/Footer.php');
		echo '<script>document.getElementById("background").style.backgroundImage = "url(\''.$pageBgImage.'\')";</script>';
	?>
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