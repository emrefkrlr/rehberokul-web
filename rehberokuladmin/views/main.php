<!doctype html>
<html class="fixed header-dark" lang="tr">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8" />
                <title>
                    <?php
                        if(isset($_SESSION['is_logged_in'])) {
                            echo Controller::$title.' | '.APP_TITLE;
                        }
                    ?>
                </title>
                <base href="<?php echo ROOT_URL;?>" />
                <meta name="robots" content="noindex, nofollow" />

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">


		<!-- Vendor CSS -->

		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />

		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />



		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/jquery-ui/jquery-ui.css" />
		<link rel="stylesheet" href="assets/vendor/jquery-ui/jquery-ui.theme.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />

		<link rel="stylesheet" href="assets/vendor/morris.js/morris.css" />
        <link rel="stylesheet" href="assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />

                 <!-- Datatables css -->
                <link rel="stylesheet" href="assets/vendor/select2/css/select2.css" />
		<link rel="stylesheet" href="assets/vendor/select2-bootstrap-theme/select2-bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

                <!-- Summernote css -->
                <link rel="stylesheet" href="assets/vendor/summernote/summernote.css" />

                <!-- File upload css -->
                <link rel="stylesheet" href="assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />

		<!-- Theme CSS -->
                <link rel="stylesheet" href="assets/stylesheets/jstree.min.css" />
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

                <link rel="stylesheet" href="assets/stylesheets/custom.css">
        <link rel="stylesheet" href="assets/stylesheets/shop-cart.css">
		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>






	</head>
	<body>
		<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="<?php echo ROOT_URL;?>" class="logo">
						<img src="../images/logo/rehberokul-admin-logo-beyaz.png" height="54" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>

				<!-- start: search & user box -->
				<div class="header-right">


					<div id="userbox" class="userbox" style="margin-top:6px;">
                                            <a data-toggle="dropdown" style="cursor: pointer;">

							<div class="profile-info">
								<span class="name"><?php echo $_SESSION['user_data']['full_name'];?></span>
								<span class="role"><?php echo $_SESSION['user_data']['role'];?></span>
							</div>

							<i class="fa custom-caret"></i>
						</a>

						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="user/viewEdit/<?php echo $_SESSION['user_data']['link'];?>"><i class="fa fa-user"></i> Profilim</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="home/logout"><i class="fa fa-power-off"></i> Çıkış</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">

					<div class="sidebar-header">
						<div class="sidebar-title">
							Menü
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>

					<?php require('sidebar.php'); ?>

				</aside>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<header class="page-header">
						<h2><?php echo Controller::$title ? Controller::$title : 'Anasayfa'; ?></h2>
					</header>
					<!-- start: page -->
					<?php
                                            Message::display();
                                            require($view);
                                        ?>
					<!-- end: page -->
				</section>
			</div>

		</section>

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/locales/bootstrap-datepicker.tr.min.js"></script>
                <script src="assets/vendor/magnific-popup/jquery.magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery-placeholder.js"></script>

		<!-- Specific Page Vendor -->
		<script src="assets/vendor/jquery-ui/jquery-ui.js"></script>
		<script src="assets/vendor/jqueryui-touch-punch/jqueryui-touch-punch.js"></script>
		<script src="assets/vendor/jquery-appear/jquery-appear.js"></script>
		<script src="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
		<script src="assets/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js"></script>
		<script src="assets/vendor/flot/jquery.flot.js"></script>
		<script src="assets/vendor/flot.tooltip/flot.tooltip.js"></script>
		<script src="assets/vendor/flot/jquery.flot.pie.js"></script>
		<script src="assets/vendor/flot/jquery.flot.categories.js"></script>
		<script src="assets/vendor/flot/jquery.flot.resize.js"></script>
		<script src="assets/vendor/jquery-sparkline/jquery-sparkline.js"></script>
		<script src="assets/vendor/raphael/raphael.js"></script>

		<script src="assets/vendor/morris.js/morris.js"></script>
		<script src="assets/vendor/gauge/gauge.js"></script>
		<script src="assets/vendor/snap.svg/snap.svg.js"></script>
		<script src="assets/vendor/liquid-meter/liquid.meter.js"></script>
		<script src="assets/vendor/jqvmap/jquery.vmap.js"></script>
		<script src="assets/vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
		<script src="assets/vendor/jqvmap/maps/jquery.vmap.world.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script>

        <script src="assets/vendor/bootstrap-timepicker/bootstrap-timepicker.js"></script>


                <!-- Datatables js -->
		<script src="assets/vendor/select2/js/select2.js"></script>
		<script src="assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>

        <!-- Summernote js -->
        <script src="assets/javascripts/summernoteimageupload.js"></script>
        <script src="assets/vendor/summernote/summernote.js"></script>


        <!-- File upload js -->
        <script src="assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>

		<!-- Theme Base, Components and Settings -->
        <script src="assets/javascripts/jstree.min.js"></script>
		<script src="assets/javascripts/theme.js"></script>

		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
        <script src="assets/javascripts/summernotepost.js"></script>
        <script src="assets/javascripts/fileupload.js"></script>
        <script src="assets/javascripts/textarea.js"></script>


		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>

		<!-- Examples -->

		<script src="assets/javascripts/tables/examples.datatables.tabletools.js"></script>



	</body>
</html>

