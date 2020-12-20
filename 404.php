<?php
    require_once('php/Core.php');
    $pageTitle = "Sayfa Bulunamadı";
    $pageDescription = "R";
    $pageKeywords = "rehber okul";
    $pageSocialImagePath = "images/rehberokul/rehber-okul.jpg";
    $twitterUsername = "rehberokul";
    $pageUrl = WEBURL."";
    $robotsStatus = "noindex, nofollow";
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
	<link rel="stylesheet" type="text/css" href="slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
	<script src="js/login.js"></script>
<?php require_once('php/Components/Scripts.php'); ?></head>
<body>
	<?php require_once('php/Components/Header-Part-1.php'); ?>
		<div class="container dir-ho-t-sp">
			<div class="row">
				<div class="dir-hr1">
					<div class="dir-ho-t-tit">
						<h1>Aradığınız Sayfa Bulunamadı <br>404</h1>
					</div>
					<a href="<?php echo WEBURL; ?>" style="color: #fff;font-weight: 400;border-radius: 25px;padding: 6px 10px;background: #ffffff1c;border: 1px solid #e3e3e3;">Ana Sayfa'ya Git</a>
				</div>
			</div>
		</div>
	<?php require_once('php/Components/Header-Part-2.php'); ?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
			</div>
		</div>
	</div>
	<?php require_once('php/Components/Footer.php'); ?>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.js" type="text/javascript"></script>
	<script src="js/materialize.min.js" type="text/javascript"></script>
	<script src="js/custom.js"></script>
	<script src="js/rehberokul.js"></script>
</body>
</html>