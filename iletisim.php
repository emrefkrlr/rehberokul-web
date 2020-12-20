<?php
    require_once('php/Core.php');
    $pageTitle = "İletişim | Rehber Okul";
    $pageDescription = "Rehber Okul adres, telefon, e-posta ve iletişim bilgileri";
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
		<div class="container xxs-py">
			<div class="row">
				<div class="dir-hr1">
					<div class="dir-ho-t-tit">
						<p class="h1">İletişim</p>
					</div>
				</div>
			</div>
		</div>
	<?php require_once('php/Components/Header-Part-2.php'); ?>
	<section>
		<div class="con-page">
			<div class="con-page-ri">
				<div class="con-com">
					<h4 class="con-tit-top-o">Bizi nerede bulacağını biliyorsun</h4>
					<p><i class="fa fa-map-marker"></i> <b>Adres:</b> Çifte Havuzlar Mahallesi Eski Londra Asfaltı Cad. Kuluçka Mrk. A1 Blok No: 151/1C İç Kapı No: 1B20 YTÜ Teknoloji Geliştirme Bölgesi Davutpaşa Yerleşkesi Esenler/İstanbul</p>
					<p><i class="fa fa-envelope"></i> <b>E-Posta:</b> <a href="mailto:bilgi@rehberokul.com" class="text-decor">bilgi@rehberokul.com</a></p>
                    <p><i class="fa fa-phone"></i> <b>Telefon:</b> <a href="tel:+905078654423" class="text-decor">+90 507 865 44 23</a></p>
                    <h4>Takipte Kal!</h4>
					<p>Sosyal medya hesaplarımızı takip ederek duyuru ve etkinliklerden ilk sizin haberiniz olsun.</p>
					<div class="share-btn">
						<ul>
							<li><a href="https://www.facebook.com/rehberokull/" target="_blank"><i class="fa fa-facebook fb1"></i> Facebook</a> </li>
							<li><a href="https://www.twitter.com/rehberokul/" target="_blank"><i class="fa fa-twitter tw1"></i> Twitter</a> </li>
							<li><a href="https://www.instagram.com/rehberokul/" target="_blank" style="background-image: url('images/bg/instagram-button-bg.jpg'); background-size: 100%;"><i class="fa fa-instagram"></i> Instagram</a> </li>
						</ul>
					</div>
				</div>
				<div class="con-com con-pag-map con-com-mar-bot-o">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1505.1178214707686!2d28.88814295832806!3d41.020100294824886!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14cabae6abebd867%3A0xcaee7bc81385afcd!2zWcSxbGTEsXogVGVrbm9wYXJrIC0gWVTDnCBEYXZ1dHBhxZ9hIEthbXDDvHPDvA!5e0!3m2!1str!2sin!4v1586096215227!5m2!1str!2sin" allowfullscreen="" height="500"></iframe>
				</div>
			</div>
		</div>
	</section>
	<?php require_once('php/Components/Footer.php'); ?>
	<script src="js/bootstrap.js" type="text/javascript"></script>
	<script src="js/materialize.min.js" type="text/javascript"></script>
	<script src="js/custom.js"></script>
	<script src="js/rehberokul.js"></script>
</body>
</html>