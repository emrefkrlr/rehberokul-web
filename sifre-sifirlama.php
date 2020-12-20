<?php
    require_once('php/Core.php');
    $pageTitle = "Şifre Yenileme";
    $pageDescription = "Rehber Okul web sitesinin açılaması burada yer alacak. Rehber Okul web sitesinin açılaması burada yer alacak. ";
    $pageKeywords = "rehber okul";
    $pageSocialImagePath = "images/rehberokul/rehber-okul.jpg";
    $twitterUsername = "rehberokul";
    $pageUrl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (SUBFOLDER){
    $robotsStatus = "noindex, nofollow";
}else{
    $robotsStatus = "index, follow";
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
	<link href="css/custom.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <script src="js/login.js"></script>
<?php require_once('php/Components/Scripts.php'); ?></head>
<body>
	<?php require_once('php/Components/Header-Part-1.php'); ?>
		<div class="container">
			<div class="row">
				<div class="dir-hr1">
					<div class="dir-ho-t-tit xxs-py">
						<h1>Şifre Sıfırlama</h1>
					</div>
				</div>
			</div>
		</div>
	<?php require_once('php/Components/Header-Part-2.php'); ?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="log-in-pop">
                    <div class="log-in-pop-left">
                        <p class="h1">Merhaba... <span class="ng-binding"></span></p>
                        <p>Şifreni kolayca sıfırlayabilirsin.</p>
                    </div>
                    <div class="log-in-pop-right" style="padding: 20px;">
                        <h4>Şifreni Yenile</h4>
                        <form class="s12 ng-pristine ng-valid">
                            <div>
                                <div class="input-field s12">
                                    <input type="password" class="validate">
                                    <label>Yeni Şifre</label>
                                </div>
                            </div>
                            <div>
                                <div class="input-field s12">
                                    <input type="password" class="validate">
                                    <label>Yeni Şifre Doğrula</label>
                                </div>
                            </div>
                            <div>
                                <div class="input-field s4 xxs-pt">
                                    <i class="waves-effect waves-light log-in-btn waves-input-wrapper" style="">
                                        <input type="submit" value="Şifremi Sıfırla" class="waves-button-input">
                                    </i>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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