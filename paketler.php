<?php
    require_once('php/Core.php');
    $pageTitle = "Paketler";
    $pageDescription = "Rehber Okul web sitesinin açılaması burada yer alacak. Rehber Okul web sitesinin açılaması burada yer alacak. ";
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
	<link href="css/custom.css" rel="stylesheet">
	<script src="js/login.js"></script>
<?php require_once('php/Components/Scripts.php'); ?></head>
<body>
	<?php require_once('php/Components/Header-Part-1.php'); ?>
	<?php require_once('php/Components/Header-Part-2.php'); ?>
	<section class="dir-pa-sp-top dir-pa-sp-top-bg v4-pri-bg" style="margin-top: 0px;">
		<div class="rows">
			<div class="container">
				<div class="v4-price-list com-padd">
					<div class="col-md-3">
						<div class="v4-pril-inn">
							<div class="v4-pril-inn-top">
								<h2>Anaokulu</h2>
								<p class="v4-pril-price"><span class="v4-pril-curr">₺</span> <b>2500</b> <span class="v4-pril-mon">/ 1 Yıl</span></p>
							</div>
							<div class="v4-pril-inn-bot">
								<ul>
									<li><i class="fa fa-check"></i> Bölgenizle ilgili aramalar ilk sıralarda görünün</li>
									<li><i class="fa fa-check"></i> Okul adediniz kadar kurum sorumlusu ekleyin</li>
									<li><i class="fa fa-check"></i> Kurumunuza gelen talepleri görüntüleyin</li>
									<li><i class="fa fa-check"></i> Bölgenizle ilgili talepleri görüntüleyin</li>	
								</ul>
								<a class="waves-effect waves-light btn-large full-btn" href="db-listing-add.html">Sepete Ekle</a>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="v4-pril-inn">
							<div class="v4-pril-inn-top">
								<h2>İlk Okul</h2>
								<p class="v4-pril-price"><span class="v4-pril-curr">₺</span> <b>4500</b> <span class="v4-pril-mon">/ 1 Yıl</span></p>
							</div>
							<div class="v4-pril-inn-bot">
								<ul>
									<li><i class="fa fa-check"></i> Bölgenizle ilgili aramalar ilk sıralarda görünün</li>
									<li><i class="fa fa-check"></i> Okul adediniz kadar kurum sorumlusu ekleyin</li>
									<li><i class="fa fa-check"></i> Kurumunuza gelen talepleri görüntüleyin</li>
									<li><i class="fa fa-check"></i> Bölgenizle ilgili talepleri görüntüleyin</li>	
								</ul>
								<a class="waves-effect waves-light btn-large full-btn" href="db-listing-add.html">Sepete Ekle</a>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="v4-pril-inn">
							<div class="v4-pril-inn-top">
								<h2>Orta Okul</h2>
								<p class="v4-pril-price"><span class="v4-pril-curr">₺</span> <b>4500</b> <span class="v4-pril-mon">/ 1 Yıl</span></p>
							</div>
							<div class="v4-pril-inn-bot">
								<ul>
									<li><i class="fa fa-check"></i> Bölgenizle ilgili aramalar ilk sıralarda görünün</li>
									<li><i class="fa fa-check"></i> Okul adediniz kadar kurum sorumlusu ekleyin</li>
									<li><i class="fa fa-check"></i> Kurumunuza gelen talepleri görüntüleyin</li>
									<li><i class="fa fa-check"></i> Bölgenizle ilgili talepleri görüntüleyin</li>	
								</ul>
								<a class="waves-effect waves-light btn-large full-btn" href="db-listing-add.html">Sepete Ekle</a>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="v4-pril-inn">
							<div class="v4-pril-inn-top">
								<h2>Lise</h2>
								<p class="v4-pril-price"><span class="v4-pril-curr">₺</span> <b>4500</b> <span class="v4-pril-mon">/ 1 Yıl</span></p>
							</div>
							<div class="v4-pril-inn-bot">
								<ul>
									<li><i class="fa fa-check"></i> Bölgenizle ilgili aramalar ilk sıralarda görünün</li>
									<li><i class="fa fa-check"></i> Okul adediniz kadar kurum sorumlusu ekleyin</li>
									<li><i class="fa fa-check"></i> Kurumunuza gelen talepleri görüntüleyin</li>
									<li><i class="fa fa-check"></i> Bölgenizle ilgili talepleri görüntüleyin</li>	
								</ul>
								<a class="waves-effect waves-light btn-large full-btn" href="db-listing-add.html">Sepete Ekle</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php require_once('php/Components/Footer.php'); ?>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.js" type="text/javascript"></script>
	<script src="js/materialize.min.js" type="text/javascript"></script>
	<script src="js/custom.js"></script>
	<script src="js/rehberokul.js"></script>
</body>
</html>