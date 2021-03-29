<?php
require_once('php/Core.php');
if (SUBFOLDER){
    $robotsStatus = "noindex, nofollow";
}else{
    $robotsStatus = "index, follow";
}
$pageTitle = "Özel Okul Bursluluk Sınav Tarihleri - Rehber Okul";
$pageDescription = "Türkiye genelinde özel okulların 2021 bursluluk sınav tarihlerini hemen incele. Sınav detayları, kabul kriterleri ve daha fazla bilgi için detaylara göz at.";
$pageUrl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$getScholarshipIDS = $db->query('SELECT id FROM scholarship ORDER BY scholarship.priority DESC');
$totalRow = count($getScholarshipIDS);

if (isset($_GET['sayfa'])) {
    $pageNumber = $_GET['sayfa'];
} else {
    $pageNumber = 1;
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
    <?php require_once('php/Components/Scripts.php'); ?>
</head>
<body>
<?php require_once('php/Components/Header-Part-1.php'); ?>
<div class="container dir-ho-t-sp">
    <div class="row">
        <div class="dir-hr1">
            <div class="dir-ho-t-tit">
                <h1>Özel Okul Bursluluk Sınavı</h1>
                <p>Özel okul ve kolejler için açıklanan sınav tarihleri burda</p>
            </div>
            <form action="search" method="post" autocomplete="off">
                <div class="col-md-9">
                    <input name="searchTerm" type="text" id="select-search" class="autocomplete" placeholder="Daha fazlası okul için yazın"  autocomplete="off" title="Lütfen arama kriterinizi yazın" required>
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
				<div class="xxs-pb">
					<h2 class="xxs-pb">Özel Okul Bursluluk Sınavı Tarihi 2021</h2>
					<p class="under-h-title-info">
                        Yüzlerce özel okul ve kolejin 2021 bursluluk sınav tarihlerini ve diğer detaylarını sizler için
                        bir araya getirdik. Özel okullar düzenledikleri bursluluk sınavı neticesinde başarılı olan öğrenciler için
                        <b>%100 e varan</b> bursluluk vermektedir. Okullara ait sınav takvimi ve detaylar için <b> Hemen Başvur </b> butonuna tıkla
                        Birçok özel okulun bursluluk sınavına hızlıca başvuru yapabileceksiniz. Listemiz
                        bursluluk sınav tarihlerini güncelledikçe sitemiz de yer alacaktır. Takipte kalın.
                    </p>
				</div>

                <div class="col-md-8 col-md-offset-2">
                    <div class="free-consultancy">
                        <div class="consultancy-icon">
                            <img src="images/opportunity.svg" alt="">
                        </div>
                        <div class="consultancy-title">
                            Ataşehir' deki popüler özel okulları görmek ister misin?
                            <p>Sana en uygun özel okulları görüntülemek için hemen tıkla! </p>
                        </div>
                        <div class="consultancy-action">
                            <a href="<?=WEBURL.'bolge/atasehir-ozel-okullar'?>">Okulları Gör</a>
                        </div>
                    </div>
                </div>


                <?php
                try {
                    $pageLimit = 12;
                    if ($pageNumber) {
                        $startPoint = (($pageNumber-1)*$pageLimit);
                    }
                    $scholarshipsByPage = array_slice($getScholarshipIDS, $startPoint, $pageLimit);
                    $limitH3 = 0;
                } catch (Exception $e){

                }
                ?>

                <?php foreach ($scholarshipsByPage as $scholarshipByPage):?>
                    <?php
                        $db->where("id", $scholarshipByPage['id']);
                        $scholarship = $db->getOne("scholarship");
                        $limitH3++;
                    ?>

				<div class="col-md-8 col-md-offset-2">
                    <a href="<?= WEBURL.'bursluluk-sinavi/'.$scholarship['scholarship_slug'] ?>" title="<?=$scholarship['scholarship_slug'].'-Rehber Okul'?>">
						<div>
							<div class="home-list-pop">
								<div class="col-md-3">
                                    <?php if ($scholarship['img'] != ''): ?>
                                        <img src="<?=WEBURL.'/'.$scholarship['img'] ?>" alt="<?=$scholarship['scholarship_slug'].'-Rehber Okul'?>" />
                                    <?php else:?>
                                        <img src="images/ro-blank.jpg" alt="<?=$scholarship['scholarship_slug'].'-Rehber Okul'?>" />
                                    <?php endif;?>
								</div>
								<div class="col-md-9 home-list-pop-desc">
                                    <a href="<?= WEBURL.'bursluluk-sinavi/'.$scholarship['scholarship_slug'] ?>">
                                        <h3 class="index-school-name"><?=$scholarship['title']?></h3>
                                    </a>
                                    <p><?=$scholarship['header']?></p>
									<div class="hom-list-share">
										<ul>
                                            <li class="float-right bg-color-red" style="width: auto">
                                                <a href="<?= WEBURL.'bursluluk-sinavi/'.$scholarship['scholarship_slug'] ?>" class="color-white" target="_blank">
                                                    <i class="fa fa-hand-o-right color-white" aria-hidden="true"></i> Hemen Başvur
                                                </a>
                                            </li>
                                            <?php if ($scholarship['school_id'] != 0):?>
                                                <?php
                                                    $db->where('id', $scholarship['school_id']);
                                                    $school_link = $db->get('school', null, 'link');
                                                ?>

                                                <a href="<?=WEBURL.'okul/'.$school_link[0]['link']?>">
                                                    Okulun profilini ziyaret et
                                                </a>
                                            <?php endif; ?>

                                        </ul>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>

                <?php endforeach; ?>


			</div>
		</div>
	</section>


<div class="row">
    <ul class="pagination list-pagenat">
        <?php
        if (($totalRow) > 0) {
            $totalPage = ceil(($totalRow) / $pageLimit);
            if ($totalPage != 1) {
                if ($pageNumber != 1) {
                    echo '<li class="waves-effect"><a class="page-link" href="'.WEBURL.'bursluluk-sinavi/sayfa/'.($pageNumber-1).'"><i class="fa fa-angle-left"></i></a></li>';
                }
                if ($pageNumber == 1 || $pageNumber == 2 || $pageNumber == 3) {
                    for ($i=1; $i <= 7; $i++) {
                        if ($i <= $totalPage) {
                            echo '<li class="waves-effect';
                            if ($pageNumber == $i) {
                                echo ' active';
                            }
                            echo '"><a class="page-link" href="'.WEBURL.'bursluluk-sinavi/sayfa/'.$i.'">'.$i.'</a></li>';
                        }
                    }
                } else if ($pageNumber == $totalPage || $pageNumber == $totalPage-1 || $pageNumber == $totalPage-2) {
                    for ($i=$totalPage-6; $i <= $totalPage; $i++) {
                        if ($i <= $totalPage && $i!=0) {
                            echo '<li class="waves-effect';
                            if ($pageNumber == $i) {
                                echo ' active';
                            }
                            echo '"><a class="page-link" href="'.WEBURL.'bursluluk-sinavi/sayfa/'.$i.'">'.$i.'</a></li>';
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
                                echo '"><a class="page-link" href="'.WEBURL.'bursluluk-sinavi/sayfa/'.$i.'">'.$i.'</a></li>';
                            }
                        }
                    }
                }
                if ($pageNumber != $totalPage) {
                    echo '<li class="waves-effect"><a class="page-link" href="'.WEBURL.'bursluluk-sinavi/sayfa/'.($pageNumber+1).'"><i class="fa fa-angle-right"></i></a></li>';
                }
            }
        }
        ?>
    </ul>
</div>



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
$db->where("sss_place", 'bursluluk-sinavi');
$faqs = $db->get("sss");
if ($db->count > 0) {
    echo '<section class="xs-py">
		<div class="container dir-hom-pre-tit">
			<div class="row">
				<div class="xs-py">
					<h2 class="xs-pb">Özel Okul Bursluluk Sınavları Hakkında Sıkça Sorulan Sorular</h2>';
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





<?php
require_once('php/Components/Footer.php');
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