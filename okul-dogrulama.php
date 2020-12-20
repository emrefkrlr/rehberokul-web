<?php
    require_once('php/Core.php');
    $pageTitle = "Okul E-Posta Doğrulama";
    $pageDescription = "";
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
	<link rel="stylesheet" type="text/css" href="slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
	<script src="js/login.js"></script>
<?php require_once('php/Components/Scripts.php'); ?></head>
<body>
	<?php require_once('php/Components/Header-Part-1.php'); ?>
		<div class="container xxs-py">
			<div class="row">
				<div class="dir-hr1">
					<div class="dir-ho-t-tit">
						<h1>Okul E-Posta Doğrulama</h1>
					</div>
				</div>
			</div>
		</div>
	<?php require_once('php/Components/Header-Part-2.php'); ?>
	<section class="container">
	    <div class="row">
	    	<?php
	    		if (isset($_GET['schoolLink']) && isset($_GET['schoolToken'])) {
        			$schoolLink = $_GET['schoolLink'];
        			$schoolToken = $_GET['schoolToken'];
        			$db->where ("link", $userLink);
        			$schoolInformations = $db->getOne("school");
        			if ($schoolInformations) {
        				if ($schoolInformations['state'] != 1) {
        					echo '<p class="xs-pt" style="color: red; font-size: 16pt;text-align: center;">E-Posta hesabınız daha önce doğrulanmıştır.</p>';
        				} else {
        					if ($schoolToken == $schoolInformations['token']) {
        						$updateData = Array (
									'token' => ''
								);
								$db->where ("link", $schoolLink);
								if ($db->update ('school', $updateData)) {
									echo '<p class="xs-pt" style="color: green; font-size: 16pt;text-align: center;">Hesabınız başarıyla doğrulanmıştır.</p>';
								} else {
									echo '<p class="xs-pt" style="color: red; font-size: 16pt;text-align: center;">Lütfen daha sonra tekrar deneyiniz.</p>';
								}
        					}
        				}
        			}
        		}
	    	?>
	    	<div class="log-in-pop">
	            <div class="log-in-pop-left">
	                <p class="h1">Merhaba... <span class="ng-binding"></span></p>
	                <p>Seni aramızda görmek bizi sevindiriyor.</p>
	            </div>
	            <div class="log-in-pop-right">
	                <h4>Tebrikler...</h4>
                    <a href="<?php echo WEBURL; ?>rehberokuladmin/" class="white-text waves-effect waves-light tourz-sear-btn waves-input-wrapper full-btn"><i class="fa fa-bookmark"></i> &nbsp;Panele Git</a>
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