<?php
    require_once('php/Core.php');
    $pageTitle = "Özel okul arayanlar | Rehber Okul";
    $pageDescription = "Özel okul arayan ailelere ulaş ve hemen iletişime geç. Yeni öğrencilerin seni bekliyor.";
    $pageKeywords = "rehber okul";
    $pageSocialImagePath = "images/rehberokul/rehber-okul.jpg";
    $twitterUsername = "rehberokul";
    $pageUrl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $robotsStatus = "index, follow";
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
    <link rel="stylesheet" href="wizard/fonts/material-design-iconic-font/css/material-design-iconic-font.css">
	<link rel="stylesheet" href="wizard/css/style.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css"/>
	<link href="css/custom.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
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
    if (isset($_SESSION['user_data']) && $_SESSION['is_logged_in']) {
        $db->where('id', $_SESSION['user_data']['user_id']);
        $loggedInUser = $db->getOne('user');
    }
    if(isset($_GET['iller'])) {
        $_SESSION['sehirler'] = $_GET['iller'];
    } else {
        $_SESSION['sehirler'] = array();
    }
    if(isset($_GET['ilceler'])) {
        $_SESSION['ilceler'] = $_GET['ilceler'];
    } else {
        $_SESSION['ilceler'] = array();
    }
    if(isset($_GET['anaokulu']) && $_GET['anaokulu'] == 1) {
        $_SESSION['anaokulu'] = true;
    } else {
        $_SESSION['anaokulu'] = false;
    } if(isset($_GET['ilkokul']) && $_GET['ilkokul'] == 2) {
        $_SESSION['ilkokul'] = true;
    } else {
        $_SESSION['ilkokul'] = false;
    } if(isset($_GET['ortaokul']) && $_GET['ortaokul'] == 3) {
        $_SESSION['ortaokul'] = true;
    } else {
        $_SESSION['ortaokul'] = false;
    } if(isset($_GET['lise']) && $_GET['lise'] == 4) {
        $_SESSION['lise'] = true;
    } else {
        $_SESSION['lise'] = false;
    }
    ?>
    <?php
        $db->orderBy("name","asc");
        $allCities = $db->rawQuery('select * from city where sehir_key IN (select sehir_key from school group by sehir_key) order by name ASC');

        if(isset($_GET['iller'])) {
            $selected_cities = implode(",", $_SESSION['sehirler']);
            $allTowns = $db->rawQuery('select * from town where ilce_sehirkey IN ('.$selected_cities.') order by name ASC');
        }
        ?>
		<div class="container">
			<div class="row">
				<div class="lpe-com-main" style="width: 95%;">
					<div class="lpe-com lpe-left">
						<h1>Size en uygun<br>
						Okulu birlikte arayalım</h1>
					</div>
					<div class="lpe-com lpe-right">
						<div class="wrapper" style="width: 100%;">
				            <form id="talepler-form" action="" style="width: 100%;">
				            	<div id="wizard" style="text-align: left;">
				            		<!-- SECTION 1 -->
					                <h4></h4>
									<p style="text-align: left;">Karar vermekte zorlanıyor musunuz? Siz talebinizi oluşturun okullar iletişime geçsin.</p>
					                <section>
					                    <div class="form-row">
					                    	<label for="select-okul-tipi">
					                    		Okul Tipi *
					                    	</label>
					                    	<div class="form-holder school-type-select">
					                    		<select required id="select-okul-tipi" name="okul_tipi" onchange="okul_tipi_changed(this)" title="Okul Tipi Seçmediniz!" class="form-control">
                                                    <option value="">Seçiniz</option>
													<option value="1">Anaokulu veya Kreş</option>
													<option value="2">İlkokul</option>
													<option value="3">Ortaokul</option>
													<option value="4">Lise</option>
												</select>
												<i class="zmdi zmdi-caret-down"></i>
					                    	</div>
					                    </div>	
					                    <div class="form-row">
					                    	<label for="select-fiyat-araligi">
					                    		Fiyat Aralığı (aylık)*
					                    	</label>
					                    	<div class="form-holder school-type-select">
					                    		<select required id="select-fiyat-araligi" name="fiyat_araligi" onchange="click_closest_label(this)" title="Fiyat Aralığı Seçmediniz!" class="form-control">
													<option value="">Seçiniz</option>
                                                    <option value="500-1500">500 TL - 1500 TL</option>
													<option value="1500-3000">1500 TL - 3000 TL</option>
													<option value="3000-5000">3000 TL - 5000 TL</option>
													<option value="5000-10000">5000 TL - 10000 TL</option>
													<option value="10000-20000">10000 TL - 20000 TL</option>
												</select>
												<i class="zmdi zmdi-caret-down"></i>
					                    	</div>
					                    </div>
					                    <div class="form-row form-group">
					                    	<div class="form-holder school-type-select">
					                    		<label for="select-city-talep">
						                    		İl *
						                    	</label>
						                    	<select required id="select-city-talep" name="sehir_key" onchange="set_towns(this)" title="İl Seçmediniz!" class="form-control">
													<option value="">Seçiniz</option>
                                                    <?php foreach ($allCities as $city) :?>
                                                        <option value="<?php echo $city['sehir_key']; ?>"><?php echo $city['name']; ?></option>
                                                    <?php endforeach;?>
												</select>
                                                <i class="zmdi zmdi-caret-down" style="top: 40px;"></i>
					                    	</div>
					                    	<div class="form-holder school-type-select">
					                    		<label for="select-town-talep">
						                    		İlçe *
						                    	</label>
						                    	<select required id="select-town-talep" name="ilce_key" onchange="set_subtowns(this)" title="İlçe Seçmediniz!" class="form-control">
													<option value="">Seçiniz</option>
												</select>
												<i class="zmdi zmdi-caret-down" style="top: 40px;"></i>
					                    	</div>
					                    </div>
					                    <div class="form-row">
					                    	<label for="select-subtown-talep">
					                    		Mahalle *
					                    	</label>
					                    	<div class="form-holder school-type-select">
                                                <select required id="select-subtown-talep" name="mahalle_key" onchange="click_closest_label(this)" title="Mahalle Seçmediniz!" class="form-control">
                                                    <option value="">Seçiniz</option>
                                                </select>
												<i class="zmdi zmdi-caret-down"></i>
					                    	</div>
					                    </div>
					                </section>
					                
									<!-- SECTION 2 -->
					                <h4></h4>
					                <section>
					                	<div class="form-row form-group div-anaokulu">
					                    	<div class="form-holder school-type-select">
					                    		<label for="select-age-talep">
						                    		Yaş *
						                    	</label>
						                    	<select required id="select-age-talep" name="age" title="Yaş Seçmediniz!" onchange="click_closest_label(this)" class="form-control">
                                                    <option value="">Seçiniz</option>
												</select>
												<i class="zmdi zmdi-caret-down" style="top: 40px;"></i>
					                    	</div>
					                    	<div class="form-holder div-sinif school-type-select">
					                    		<label for="select-class-talep">
						                    		Sınıf Seçiniz *
						                    	</label>
						                    	<select id="select-class-talep" name="class_talep" title="Sınıf Seçmediniz!" onchange="click_closest_label(this)" class="form-control">
                                                    <option value="">Seçiniz</option>
												</select>
												<i class="zmdi zmdi-caret-down" style="top: 40px;"></i>
					                    	</div>
					                    </div>
					                    <div class="form-row">
					                    	<label for="select-quota-talep">
					                    		Kota
					                    	</label>
					                    	<p>Talebiniz ile iletişime geçebilecek okul sayısını seçebilirsiniz.</p>
					                    	<div class="form-holder school-type-select">
					                    		<select required id="select-quota-talep" name="quota" title="Kota Seçmediniz!" onchange="click_closest_label(this)" class="form-control">
													<option value="">Seçiniz</option>
                                                    <option value="Sınır Yok">Kota Yok</option>
													<option value="5">1 ile 5</option>
													<option value="10">5 ile 10</option>
													<option value="15">10 ile 15</option>
                                                    <option value="20">15 ile 20</option>
												</select>
												<i class="zmdi zmdi-caret-down"></i>
					                    	</div>
					                    </div>
					                    <div class="form-row" style="margin-bottom: 18px">
					                    	<label for="ta-note">
					                    		Senin için enuygun okulu ararken bizlere iletmek istediğiniz bir notunuz var mı?
					                    	</label>
					                    	<textarea required id="ta-note" name="note" title="Not Girmediniz!"  class="form-control" style="height: 100px"></textarea>
					                    </div>
					                </section>

					                <!-- SECTION 3 -->
					                <h4></h4>
					                <section>
					                    <div class="form-row form-group">
					                    	<div class="form-holder">
					                    		<label for="i-first-name">
					                    		Ad *
						                    	</label>
					                    		<input required id="i-first-name" <?php echo $loggedInUser ? "value='".$loggedInUser['first_name']."'" : ""; ?> name="first_name" pattern="[a-zA-ZçÇöÖüÜşŞİığĞ\s]*" title='Ad İçin Sadece büyük ve küçük harf kullanabilirsiniz!' type="text" class="form-control">
					                    	</div>
					                    	<div class="form-holder school-type-select">
					                    		<label for="i-last-name">
					                    		Soyad *
						                    	</label>
					                    		<input required id="i-last-name" name="last_name" <?php echo $loggedInUser ? "value='".$loggedInUser['last_name']."'" : ""; ?> pattern="[a-zA-ZçÇöÖüÜşŞİığĞ\s]*" title='Soyad İçin Sadece büyük ve küçük harf kullanabilirsiniz!' type="text" class="form-control">
					                    	</div>
					                    </div>
					                     <div class="form-row">
					                    	<div class="form-holder school-type-select">
					                    		<label for="i-email">
					                    		E-Posta *
						                    	</label>
					                    		<input required id="i-email" name="email" <?php echo $loggedInUser ? "value='".$loggedInUser['email']."'" : ""; ?> type="email" title="Hatalı Email!" class="form-control">
					                    	</div>
					                    	<div class="form-holder school-type-select">
					                    		<label for="i-phone">
					                    		Telefon *
						                    	</label>
					                    		<input required id="i-phone" name="phone" <?php echo $loggedInUser ? "value='".$loggedInUser['phone']."'" : ""; ?> pattern="^[0-9]{10,10}$" title="Sadece rakam kullanabilirsiniz! 10 haneli olmalıdır!" type="text" class="form-control">
					                    	</div>
					                    </div>
					                </section>
				            	</div>
				            </form>
                            <a id="filtered"></a>
						</div>

					</div>
				</div>
			</div>

		</div>

	<?php require_once('php/Components/Header-Part-2.php'); ?>
	<section class="dir-alp-1 dir-pa-sp-top">
		<div class="container">
            <div class="row">
				<div class="dir-alp-con dir-alp-con-1">
					<div class="col-md-3 dir-alp-con-left">
                        <form id="frm-talep-filtre" action="<?php echo $_SERVER['PHP_SELF']; ?>#filtered" method="get">
                            <input type="hidden" name="status" value="1">
                            <div class="dir-alp-l3 dir-alp-l-com hidden-mobile">

                                <h4>Okul Türü</h4>
                                <div class="dir-alp-l-com1 dir-alp-p3">

                                        <ul>
                                            <li>
                                                <input <?php echo $_SESSION['anaokulu'] ? 'checked' : ''; ?> name="anaokulu" type="checkbox" value="1" class="filled-in" id="scf1" />
                                                <label for="scf1">Anaokulu veya Kreş</label>
                                            </li>
                                            <li>
                                                <input <?php echo $_SESSION['ilkokul'] ? 'checked' : ''; ?> name="ilkokul" type="checkbox" value="2" class="filled-in" id="scf2" />
                                                <label for="scf2">İlkokul</label>
                                            </li>
                                            <li>
                                                <input <?php echo $_SESSION['ortaokul'] ? 'checked' : ''; ?> name="ortaokul" type="checkbox" value="3" class="filled-in" id="scf3" />
                                                <label for="scf3">Ortaokul</label>
                                            </li>
                                            <li>
                                                <input <?php echo $_SESSION['lise']? 'checked' : ''; ?> name="lise" type="checkbox" value="4" class="filled-in" id="scf4" />
                                                <label for="scf4">Lise</label>
                                            </li>
                                        </ul>
                                    </div>
                            </div>
                            <!--==========End Sub Category Filter============-->
                            <!--==========Sub Category Filter============-->
                            <div class="dir-alp-l3 dir-alp-l-com hidden-mobile">
                                <h4>Bölge</h4>
                                <div class="dir-alp-l-com1 dir-alp-p3">
                                        <ul>
                                            <li>
                                                <select id="select-iller" onchange="set_multiple_towns('il-select2')" data-select-search="true" class="il-select2" name="iller[]"  multiple="multiple">
                                                    <?php foreach ($allCities as $city) :?>
                                                        <option value="<?php echo $city['sehir_key']; ?>" <?php foreach($_SESSION['sehirler'] as $sehir_key) { echo $city['sehir_key'] == $sehir_key ? 'selected' : '';}?>><?php echo ucwords_tr($city['name']); ?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </li>
                                            <li>
                                                <select id="select-ilceler" onchange="set_select2_multiple_icerik_ilce('ilce-select2')" data-select-search="true" class="ilce-select2" name="ilceler[]"  multiple="multiple">
                                                    <?php foreach ($allTowns as $town) :?>
                                                        <option value="<?php echo $town['ilce_key']; ?>" <?php foreach($_SESSION['ilceler'] as $ilce_key) { echo $town['ilce_key'] == $ilce_key ? 'selected' : '';}?>><?php echo ucwords_tr($town['name']); ?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                            <div class="dir-alp-l3 dir-alp-l-com hidden-mobile">
                                <i class="waves-effect waves-light tourz-sear-btn waves-input-wrapper" style="width: 48%;float: left;text-align: center;background: linear-gradient(to bottom, #20344c, #20344c); height: 30px;line-height: 27px;margin-left: 2%; font-weight: normal;"><input id="search-btn-1" type="submit" name="submit_filtre_desktop" value="Filtrele" class="waves-button-input" style="color:#fff;"></i>
                                <i class="waves-effect waves-light tourz-sear-btn waves-input-wrapper" style="width: 48%;float: left;text-align: center;background: linear-gradient(to bottom, #20344c, #20344c); height: 30px;line-height: 27px;margin-left: 2%; font-weight: normal;"><input id="search-btn-2" type="submit" onclick="reset_talep_form()" value="Temizle" name="clear_filter" class="waves-button-input" style="color:#fff;"></i>
                                <a id="filtered-mobile"></a>
                            </div>

                            </form>

						<a href="#" data-dismiss="modal" data-toggle="modal" data-target="#mobilFiltreler" class="hidden-desktop xxs-pt" style="text-align: center;"><br>

                            <div class="dir-alp-l3 dir-alp-l-com">
								<h4><i class="fa fa-list"></i> Filtrele</h4>
							</div>
						</a>

					</div>
					<div class="col-md-9 dir-alp-con-right">
						<div class="dir-alp-con-right-1">
							<div class="row">


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
<?php

function proper_strrpos($haystack,$needle){
    while($ret = strrpos($haystack,$needle))
    {
        if(strncmp(substr($haystack,$ret,strlen($needle)),
                $needle,strlen($needle)) == 0 )
            return $ret;
        $haystack = substr($haystack,0,$ret -1 );
    }
    return $ret;
}

//$db->where('uptodate_pos', 0, ">");
$db->orderBy("create_date","desc");
$db->where('state', 0, '!=');
$db->where('school_id', 0);
$allDemands = $db->get('demand');
if(isset($_GET['submit_filtre_desktop'])) {
    $query = "SELECT * FROM demand WHERE state = 1 AND school_id = 0 ";

    if(isset($_GET['anaokulu']) || isset($_GET['ilkokul']) || isset($_GET['ortaokul']) || isset($_GET['lise'])) {
        $query .= " AND ( ";
    } if(isset($_GET['anaokulu']) && $_GET['anaokulu'] == 1) {
        $query .= " school_type = 1 OR ";
        $_SESSION['anaokulu'] = true;
    } if(isset($_GET['ilkokul']) && $_GET['ilkokul'] == 2) {
        $query .= " school_type = 2 OR ";
        $_SESSION['ilkokul'] = true;
    } if(isset($_GET['ortaokul']) && $_GET['ortaokul'] == 3) {
        $query .= " school_type = 3 OR";
        $_SESSION['ortaokul'] = true;
    } if(isset($_GET['lise']) && $_GET['lise'] == 4) {
        $query .= " school_type = 4 OR ";
        $_SESSION['lise'] = true;
    }
    $lastOrPosition = proper_strrpos($query, 'OR');  // Son OR' a kadar olanı al
    if($lastOrPosition > 0) {

        $query = substr($query, 0, $lastOrPosition).' ) ';
    }


    if(isset($_GET['iller']) && !isset($_GET['ilceler'])) { // Sadece Şehirler Seçildiyse
        $query .= " AND ( ";
        $selected_sehir_keys = $_GET['iller'];
        $_SESSION['sehirler'] = array();
        $_SESSION['sehirler'] = $selected_sehir_keys;
        unset($_SESSION['ilceler']);
        foreach($selected_sehir_keys as $sehir_key) {
            $query .= ' sehir_key = '.$sehir_key.' OR ';
        }
        $lastOrPosition = proper_strrpos($query, 'OR'); // Son OR' a kadar olanı al
        if($lastOrPosition > 0) {
            $query = substr($query, 0, $lastOrPosition).' ) ';
        }
    }

    if(isset($_GET['iller']) && isset($_GET['ilceler'])) { // İlçe ve İller Seçildiyse
        $query .= " AND ( ";
        $selected_ilce_keys = $_GET['ilceler'];
        $_SESSION['sehirler'] = array();
        $_SESSION['ilceler'] = array();
        $_SESSION['sehirler'] = $_GET['iller'];
        $_SESSION['ilceler'] = $selected_ilce_keys;
        foreach($selected_ilce_keys as $ilcekey) {
            $query .=  ' ilce_key = '.$ilcekey.' OR ';
        }
        $lastOrPosition = proper_strrpos($query, 'OR');
        if($lastOrPosition > 0) {
            $query = substr($query, 0, $lastOrPosition).' ) ';
        }
    }


    $query .= " ORDER BY create_date DESC";

    $allDemands = $db->rawQuery($query);

}

function isPremium($demandSchoolTypeId) {
    //Eğer user'ın demand type'a göre premium üyeliği var ise
    global $db;
    $db->orderBy('id', 'DESC'); // En son ödemeye bak
    $db->where('user_id', $_SESSION['user_data']['user_id']); // Giriş Yapmış Kullanıcının
    $db->where('school_type', $demandSchoolTypeId); // School typa'a ait ödeme var ise
    $db->where('state', 2); // Onaylanmış Ödemelerde
    $premiumUserPaymentForSchoolType = $db->getOne('payment');
    // Eğer hala geçerliyse üyeliği
    if($premiumUserPaymentForSchoolType && strtotime($premiumUserPaymentForSchoolType['end_date']) >= time()) {
        return 1;
    }
    return 0;
}

function hasEnoughQuota($demand) {
    global $db;
    $db->where('demand_id', $demand['id']);
    $demandInterests = $db->get('demands_interested'); // Kaç Kere Taleple İlgilenilmiş
    if(($demand['quota'] != 'Sınır Yok' && $db->count < +$demand['quota']) || $demand['quota'] == 'Sınır Yok') {
        return 1;
    }
    return 0;

}

function interestedBefore($demand) {
    global $db;
    if (isset($_SESSION['user_data']) && $_SESSION['is_logged_in']) { // Eğer kullanıcı daha önce taleple ilgilendiyse gösterme
        $db->where('user_id', $_SESSION['user_data']['user_id']);
        $db->where('demand_id', $demand['id']);
        $previouslyInterestedDemand = $db->getOne('demands_interested');
        if($previouslyInterestedDemand) {
           return 1;
        }
        else {
            return 0;
        }
    }
    return 0;
}

$demandCounter = 0;
if ($db->count > 0) {
    foreach ($allDemands as $demand) {
        $demandUserPhone = $demand['phone'];

        if($demand['user_id'] != 0) {
            $db->where("id",$demand['user_id']);
            $demandUser = $db->getOne('user');
            $demandNameSurname = $demandUser['first_name']." ".mb_substr($demandUser['last_name'],0,1,"utf-8").".";
            $demandNameSurname = ucwords_tr($demandNameSurname);
            $demandUserPhone = $demandUser['phone'];
        } else {
            $demandNameSurname = $demand['full_name'];
            $demandNameSurname = explode(' ', $demandNameSurname);
            $demandNameSurname = $demandNameSurname['0']." ".mb_substr($demandNameSurname['1'],0,1,"utf-8").".";;
            $demandNameSurname = ucwords_tr($demandNameSurname);
        }

    	$demandId = $demand['id'];

    	$db->where("sehir_key", $demand['sehir_key']);
		$demandCity = ucwords_tr($db->getOne("city")['name']);
		$db->where("ilce_key", $demand['ilce_key']);
		$demandTown = ucwords_tr($db->getOne("town")['name']);
		$db->where("mahalle_key", $demand['mahalle_key']);
		$demandSubTown = ucwords_tr($db->getOne("subtown")['name']);

    	$demandAddress = $demandCity." / ".$demandTown." / ".$demandSubTown;

    	$demandSchoolTypeId = $demand['school_type'];
    	$demandSchoolTypeName = $demandSchoolTypeId == 1 ? "Anaokulu & Kreş" : ($demandSchoolTypeId == 2 ? "İlkokul" : ($demandSchoolTypeId == 3 ? "Ortaokul" : "Lise"));
    	$demandSchoolClass = $demand['class'] != "" ? " / ".$demand['class'].'. Sınıf' : "";

    	$datetime1 = new DateTime('now');
		$datetime2 = new DateTime($demand['create_date']);
		$interval = $datetime1->diff($datetime2);
		$elapsed = $interval->format('%a');
		$demandDate = "";
		$isNewDemand = true;

		if (intval($elapsed/30) >= 1) {
			$demandDate .= intval($elapsed/30)." ay ";
			$elapsed -= intval($elapsed/30)*30;
            $isNewDemand = false;
		}
		if (intval($elapsed/7) == 1 || intval($elapsed/7) == 2 || intval($elapsed/7) == 3 || intval($elapsed/7) == 4) {
			$demandDate .= intval($elapsed/7)." hafta ";
			$elapsed -= intval($elapsed/7)*7;
            $isNewDemand = false;
		}
		if ($elapsed < 7 && $elapsed != 0) {
			$demandDate .= $elapsed." gün ";
            $isNewDemand = false;
		}
		$demandDate .= $isNewDemand ? 'Bugün': " önce";
    	$demandContent = $demand['note'];
    	$demandPrice = $demand['price_interval'];
    	$demandURL = WEBURL."rehberokuladmin/demands/detailInterested/".$demand['link'];

        echo $demandCounter == 0 && isset($_GET['submit_filtre_desktop']) ? '<div class="row" style="padding-left: 22px;padding-top: 10px; padding-bottom: 5px;">
                                <em>Arama Sonucunuza Uygun '.count($allDemands).' Talep Bulundu.</em>
                            </div>' : '';
        echo $demandCounter == 0 && !isset($_GET['submit_filtre_desktop']) ? '<div class="row" style="padding-left: 22px;padding-top: 10px; padding-bottom: 5px;">
                                <em>'.count($allDemands).' Talep Arasından Size Uygun Olanlarla İlgilenin.</em>
                            </div>' : '';
    	echo '<div class="home-list-pop list-spac list-spac-1" style="border-radius: 10px;">
			<div class="col-md-8 home-list-pop-desc inn-list-pop-desc">
				<h3>'.$demandNameSurname.'</h3>
				<p><i class="fa fa-map-marker" style="font-size: 20px; margin-left: 3px;"></i> '.$demandAddress.'</p>
				<p><i class="fa fa-graduation-cap"></i> '.$demandSchoolTypeName.$demandSchoolClass.'</p>
			</div>
			<div class="col-md-4 home-list-pop-desc inn-list-pop-desc">
				<p style="text-align: right;"><i class="fa fa-calendar" style="font-size: 20px; margin-left: 3px;"></i> '.$demandDate.'</p>
			</div>
			<div class="col-md-12" style="background-color: #000000; height: 2px;margin-top: 10px;margin-bottom: 10px;"></div>
			<div class="col-md-12 home-list-pop-desc inn-list-pop-desc">
				<p>'.$demandContent.'</p>
			</div>
			<div class="col-md-12 home-list-pop-desc inn-list-pop-desc">
			    <input type="hidden" value="'.$demandURL.'" id="demand_url">
				<p style="text-align: right;">Fiyat Aralığı (aylık): '.$demandPrice.'</p>
				<p style="float: right;" class="xxs-pt">';
		if (isset($_SESSION['user_data']) && $_SESSION['is_logged_in']) {
			if ($_SESSION['user_data']['role'] == "Kurum Sahibi") {
			    echo isPremium($demandSchoolTypeId) == 1 ? '<label class="float-right text-info veliye-iletildi-'.$demandCounter.' hide">Veliye Talebiyle İlgilendiğiniz Bilgisi İletilmiştir!</label>' : '<label class="float-right text-danger premium-degilsiniz-'.$demandCounter.' hide">'.$demandSchoolTypeName.' İçin Premium Üyeliğiniz Bulunmamaktadır!</label>';
                echo $demand['state'] == 2 ? '<label class="float-right text-success talep-karsilandi-'.$demandCounter.'">Talep Karşılandı!</label>' : '';
                echo interestedBefore($demand) == 1 ? '<label class="float-right text-info">Talep İle İlgileniyorsunuz!</label>' : '';
                echo hasEnoughQuota($demand) == 0 ? '<label class="float-right text-warning kota-doldu-'.$demandCounter.'">Talep Belirlenen Kotaya Ulaştı!</label>' : '';
			    echo hasEnoughQuota($demand) == 1 && $demand['state'] != 2 && interestedBefore($demand) == 0 ? '<button id="taleple-ilgilen-'.$demandCounter.'" onclick="taleple_ilgilen('.$demand['id'].','.$demand['user_id'].','.$demandCounter.','.isPremium($demandSchoolTypeId).','.hasEnoughQuota($demand).')" style="font-size: 14px;font-weight: 400;border-radius: 4px;max-width: 200px;cursor:pointer;" class="waves-effect waves-light btn-large full-btn list-red-btn float-right">Taleple İlgilen</button>'
                    : (interestedBefore($demand) == 0 ? '<button disabled style="font-size: 14px;font-weight: 400;border-radius: 4px;max-width: 200px;cursor:pointer;" class="waves-effect waves-light btn-large full-btn list-red-btn float-right">Taleple İlgilen</button>'
                        : '<a href="'.$demandURL.'" style="font-size: 14px;font-weight: 400;border-radius: 4px;max-width: 200px;cursor:pointer;" class="waves-effect waves-light btn-large full-btn list-red-btn float-right">Talebe Git</a>');
                echo '</p>';
                echo isPremium($demandSchoolTypeId) && interestedBefore($demand) == 0 ?
                    '<p style="float: right;" class="xxs-pt col-md-12 veliye-iletildi-'.$demandCounter.' hide"><label class="float-right"><i class="waves-effect waves-light fa fa-phone"><span style="margin-left:5px;"><strong>'.$demandUserPhone.'</strong><span></span></i></label></p>'
                    : ( interestedBefore($demand) == 1 ? '<p style="float: right;" class="xxs-pt col-md-12"><label class="float-right"><i class="waves-effect waves-light fa fa-phone"><span style="margin-left:5px;"><strong>'.$demandUserPhone.'</strong><span></span></i></label></p>' :'');
			}
		} else {
			echo '<a href="#" data-dismiss="modal" data-toggle="modal" data-target="#giris-yap" style="font-size: 14px;font-weight: 400;border-radius: 4px;max-width: 200px;cursor:pointer;" class="waves-effect waves-light btn-large full-btn list-red-btn">Taleple İlgilen</a>';
            echo	'</p>';
		}
		echo'
			</div>
		</div>';
        $demandCounter++;
    }
} else {
    echo count($allDemands) == 0 ? '<div class="row" style="padding-left: 22px;padding-top: 10px; padding-bottom: 5px;">
                                <em>Talep Bulunmamaktadır.</em>
                            </div>' : '';
}

?>
								
								
							</div>
						</div>
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
                        <form id="frm-talep-filtre-mobile" action="<?php echo $_SERVER['PHP_SELF']; ?>#filtered-mobile" method="get">
                            <div class="dir-alp-l3 dir-alp-l-com">
                                <h4>Okul Türü</h4>
                                <div class="dir-alp-l-com1 dir-alp-p3">

                                    <ul>
                                        <li>
                                            <input <?php echo $_SESSION['anaokulu'] ? 'checked' : ''; ?> name="anaokulu" type="checkbox" value="1" class="filled-in" id="scf11" />
                                            <label for="scf11">Anaokulu veya Kreş</label>
                                        </li>
                                        <li>
                                            <input <?php echo $_SESSION['ilkokul'] ? 'checked' : ''; ?> name="ilkokul" type="checkbox" value="2" class="filled-in" id="scf22" />
                                            <label for="scf22">İlkokul</label>
                                        </li>
                                        <li>
                                            <input <?php echo $_SESSION['ortaokul'] ? 'checked' : ''; ?> name="ortaokul" type="checkbox" value="3" class="filled-in" id="scf33" />
                                            <label for="scf33">Ortaokul</label>
                                        </li>
                                        <li>
                                            <input <?php echo $_SESSION['lise'] ? 'checked' : ''; ?> name="lise" type="checkbox" value="4" class="filled-in" id="scf44" />
                                            <label for="scf44">Lise</label>
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
                                                    <option value="<?php echo $city['sehir_key']; ?>" <?php foreach($_SESSION['sehirler'] as $sehir_key) { echo $city['sehir_key'] == $sehir_key ? 'selected' : '';}?>><?php echo ucwords_tr($city['name']); ?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </li>
                                        <li>
                                            <select id="select-ilceler-mobile" onchange="set_select2_multiple_icerik_ilce_mobile('ilce-select2')" data-select-search="true" class="ilce-select2" name="ilceler[]"  multiple="multiple">
                                                <?php foreach ($allTowns as $town) :?>
                                                    <option value="<?php echo $town['ilce_key']; ?>" <?php foreach($_SESSION['ilceler'] as $ilce_key) { echo $town['ilce_key'] == $ilce_key ? 'selected' : '';}?>><?php echo ucwords_tr($town['name']); ?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dir-alp-l3 dir-alp-l-com sm-pb">
                                <i class="waves-effect waves-light tourz-sear-btn waves-input-wrapper" style="width: 48%;float: left;text-align: center;background: linear-gradient(to bottom, #20344c, #20344c); height: 30px;line-height: 27px;margin-left: 2%; font-weight: normal;"><input id="search-btn-3" type="submit" name="submit_filtre_desktop" value="Filtrele" class="waves-button-input" style="color:#fff;"></i>
                                <i class="waves-effect waves-light tourz-sear-btn waves-input-wrapper" style="width: 48%;float: left;text-align: center;background: linear-gradient(to bottom, #20344c, #20344c); height: 30px;line-height: 27px;margin-left: 2%; font-weight: normal;"><input id="search-btn-4" type="submit" onclick="reset_talep_form_mobile()" value="Temizle" name="clear_filter" class="waves-button-input" style="color:#fff;"></i>
                            </div>
                        </form>
					</div>
				</div>
            </div>
        </div>
    </div>
	<?php require_once('php/Components/Footer.php'); ?>
	<script src="js/bootstrap.js" type="text/javascript"></script>
    <script src="js/materialize.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/select2.min.js"></script>
    <script src="js/jquery-validation/jquery.validate.js"></script>
    <script src="js/jquery-validation/additional-methods.js"></script>
	<script src="js/custom.js"></script>
	<script src="js/rehberokul.js"></script>
	<script src="wizard/js/jquery.steps.js"></script>
	<script src="wizard/js/main.js"></script>
	<script type="text/javascript">
	$(document).ready( function () {
	  	$('.school-type-select .select-wrapper .caret').remove();
		$('.school-type-select .select-wrapper .select-dropdown').remove();

		$('.initialized').parent().removeClass("form-control");
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

</script>

</body>

</html>