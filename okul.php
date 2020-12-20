<?php
    require_once('php/Core.php');
    $robotsStatus = "index, follow";
    function turkcetarih_formati($format, $datetime = 'now'){
	    $z = date("$format", strtotime($datetime));
	    $gun_dizi = array(
	        'Monday'    => 'Pazartesi',
	        'Tuesday'   => 'Salı',
	        'Wednesday' => 'Çarşamba',
	        'Thursday'  => 'Perşembe',
	        'Friday'    => 'Cuma',
	        'Saturday'  => 'Cumartesi',
	        'Sunday'    => 'Pazar',
	        'January'   => 'Ocak',
	        'February'  => 'Şubat',
	        'March'     => 'Mart',
	        'April'     => 'Nisan',
	        'May'       => 'Mayıs',
	        'June'      => 'Haziran',
	        'July'      => 'Temmuz',
	        'August'    => 'Ağustos',
	        'September' => 'Eylül',
	        'October'   => 'Ekim',
	        'November'  => 'Kasım',
	        'December'  => 'Aralık',
	        'Mon'       => 'Pts',
	        'Tue'       => 'Sal',
	        'Wed'       => 'Çar',
	        'Thu'       => 'Per',
	        'Fri'       => 'Cum',
	        'Sat'       => 'Cts',
	        'Sun'       => 'Paz',
	        'Jan'       => 'Oca',
	        'Feb'       => 'Şub',
	        'Mar'       => 'Mar',
	        'Apr'       => 'Nis',
	        'Jun'       => 'Haz',
	        'Jul'       => 'Tem',
	        'Aug'       => 'Ağu',
	        'Sep'       => 'Eyl',
	        'Oct'       => 'Eki',
	        'Nov'       => 'Kas',
	        'Dec'       => 'Ara',
	    );
	    foreach($gun_dizi as $en => $tr){
	        $z = str_replace($en, $tr, $z);
	    }
	    if(strpos($z, 'Mayıs') !== false && strpos($format, 'F') === false) $z = str_replace('Mayıs', 'May', $z);
	    return $z;
	}
    if (isset($_GET['okulSeflink'])) {
        $okulSeflink = $_GET['okulSeflink'];
        $db->where("link", $okulSeflink);
        $singleSchool = $db->getOne("school");
        if ($singleSchool) {
        	$schoolId = $singleSchool['id'];
        	$schoolState = $singleSchool['state'];
        	$schoolType = $singleSchool['type'];
        	$schoolName = $singleSchool['name'];
        	$pageTitle = $schoolName;
        	$schoolAddress = $singleSchool['address'];
        	$db->where("sehir_key", $singleSchool['sehir_key']);
			$schoolCity = mb_convert_case(mb_strtolower($db->getOne("city")['name']), MB_CASE_TITLE, "UTF-8");
			$db->where("ilce_key", $singleSchool['ilce_key']);
			$schoolTown = mb_convert_case(mb_strtolower($db->getOne("town")['name']), MB_CASE_TITLE, "UTF-8");
        	$schoolDescription = htmlspecialchars_decode($singleSchool['description']);
        	$schoolDiscount = $singleSchool['discount'];
        	$schoolPrice = $singleSchool['price'];
        	$schoolPoint = $singleSchool['points'];
        	$schoolPointCount = 1;
        	$schoolTypeCreationLinkForOwner = $schoolType == 1 ? "viewEditKindergarten" : ($schoolType == 2 ? "viewEditMiddle" : ($schoolType == 3 ? "viewEditMiddle" : "viewEditHigh"));
		    $schoolTypeCreationLinkForOwner .= "/".$okulSeflink;
		    $schoolTypeCreationLinkForOwner = WEBURL.'rehberokuladmin/schools/'.$schoolTypeCreationLinkForOwner;
        	$db->where("school_id",$schoolId);
			$allPointsForSchool = $db->get('school_points');
			if ($db->count > 0) {
			    foreach ($allPointsForSchool as $singlePointForSchool) {
			    	$schoolPoint += $singlePointForSchool['point'];
			    	$schoolPointCount++;
			    }
			}
			$schoolPoint = $schoolPoint/$schoolPointCount;

			$clickUpdateData = Array (
				'click_count' => $db->inc(1)
			);
			$db->where('id', $schoolId);
			$db->update('school', $clickUpdateData);
        } else {
            header("Location: ".WEBURL);
        }
    } else {
        header("Location: ".WEBURL);
    }
    $pageKeywords = "rehber okul";
    $pageSocialImagePath = "images/rehberokul/rehber-okul.jpg";
    $twitterUsername = "rehberokul";
    $pageUrl = WEBURL."okul/".$okulSeflink;

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
	<link rel="stylesheet" type="text/css" href="slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="js/login.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/autcomplete-custom.js"></script>
<?php require_once('php/Components/Scripts.php'); ?></head>
<body>
	<?php require_once('php/Components/Header-Part-1.php'); ?>
	<?php require_once('php/Components/Header-Part-2.php'); ?>
	<section class="pg-list-1" style="margin-top: 0px;">
		<div class="container">
			<div class="row">
				<div class="pg-list-1-left"><h3><?php echo $schoolName; ?></h3>
					<?php
						if ($schoolDiscount) {
							echo '<p style="color: #16c642;font-weight: 600;"><i class="fa fa-star"></i> &nbsp;Rehber Okula Özel İndirim</p>';
						}

						if ($schoolPoint >= 4.5) {
							$schoolPointBgColor = "rate-4-5-bg-color";
						} else if ($schoolPoint >= 4.0) {
							$schoolPointBgColor = "rate-4-bg-color";
						} else {
							$schoolPointBgColor = "rate-0-3-bg-color";
						}
					?>
					
					<div class="list-rat-ch"><span class="<?php echo $schoolPointBgColor; ?>"><?php echo number_format($schoolPoint, 1, '.', ','); ?></span></div>
					<h4><?php echo $schoolCity; ?>, <?php echo $schoolTown; ?></h4>
					<p><b>Adres:</b> <?php echo $schoolAddress; ?></p>
					<div class="list-number pag-p1-phone">
						<ul>
							<li><i class="fa fa-phone" aria-hidden="true"></i> 0507 865 44 23</li>
						</ul>
					</div>
				</div>
				<div class="pg-list-1-right">
					<div class="list-enqu-btn pg-list-1-right-p1">
						<?php
							if ($schoolPrice != "") {
								echo '<p class="color-white float-right" style="font-weight: 600;width: 100%;text-align: right;">Aylık '.$schoolPrice.' ₺</p>';
							}
						?>
						
						<a href="<?php echo $pageUrl; ?>#ucretsiz-danismanlik-formu" style="font-size: 14px !important;color: #fff !important;border: 1px solid #44526c !important;font-weight: 400 !important;border-radius: 4px !important;padding: 10px 10px !important;margin-left: 7px !important;max-width: 200px !important;cursor:pointer !important;height: 55px !important;line-height: 35px !important;" class="waves-effect waves-light tourz-sear-btn waves-input-wrapper float-right"><i class="fa fa-bookmark"></i> &nbsp;Talep Oluştur</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="list-pg-bg md-pt-mobile">
		<div class="container">
			<div class="row">
				<div class="com-padd">
					<div class="list-pg-lt list-page-com-p">
						<!--LISTING DETAILS: LEFT PART 1-->
						<div class="pglist-p1 pglist-bg pglist-p-com okul-hakkinda" id="ld-abour">
							<div class="pglist-p-com-ti">
								<h3>Okul Hakkında</h3></div>
							<div class="list-pg-inn-sp">
								<div class="share-btn">
									<ul>
										<li><a href="https://www.facebook.com/sharer.php?u=<?php echo $pageUrl; ?>" target="_blank"><i class="fa fa-facebook fb1"></i> Facebook'da Paylaş</a> </li>
										<li><a href="https://twitter.com/share?url=<?php echo $pageUrl; ?>&text=<?php echo $pageTitle; ?>" target="_blank"><i class="fa fa-twitter tw1"></i> Twitter'da Paylaş</a> </li>
										<li><a href="https://api.whatsapp.com/send?text=<?php echo $pageTitle; ?> <?php echo $pageUrl; ?>" target="_blank"><i class="fa fa-whatsapp wa1"></i> WhatsApp İle Paylaş</a> </li>
									</ul>
								</div>
								<?php echo $schoolDescription; ?>
							</div>
						</div>
						<!--END LISTING DETAILS: LEFT PART 1-->
						<!--LISTING DETAILS: LEFT PART 3-->
                        <?php
                            $schoolParams = Array($schoolId);
                            $schoolImages = $db->rawQuery("SELECT href FROM gallery WHERE parent = (SELECT gallery_id FROM school_gallery WHERE school_id = ?) ORDER BY creation_time ASC", $schoolParams);
                        ?>

						<div class="pglist-p3 pglist-bg pglist-p-com fotograf-galerisi <?php echo count($schoolImages) <= 0 ? 'hide': '';?>" id="ld-gal">
							<div class="pglist-p-com-ti">
								<h3><span>Fotoğraf</span> Galerisi</h3></div>
							<div class="list-pg-inn-sp">
								<div id="myCarousel" class="carousel slide" data-ride="carousel">
									<!-- Indicators -->
									<ol class="carousel-indicators">
										<?php
											$schoolImageCount = 0;
											foreach ($schoolImages as $schoolImage) {
        										if (strpos($schoolImage['href'] , '.jpg') !== false) {
	        										echo '<li data-target="#myCarousel" data-slide-to="'.$schoolImageCount.'"';
	        										if ($schoolImageCount == 0) {
	        											echo ' class="active"';
	        										}
	        										echo '></li>';
	        										$schoolImageCount++;
	        									}
        									}
										?>
									</ol>
									<!-- Wrapper for slides -->
									<div class="carousel-inner">
										<?php
											$schoolImageCount = 0;
											foreach ($schoolImages as $schoolImage) {
												if (strpos($schoolImage['href'] , '.jpg') !== false) {
									        		$image = str_replace("../", "", $schoolImage['href']);
									        		echo '<div class="item';
									        		if ($schoolImageCount == 0) {
		        										echo ' active';
		        									}
									        		echo '"><img src="'.$image.'" alt=""> </div>';
												}
												$schoolImageCount++;
	        								}
										?>
									</div>
									<!-- Left and right controls -->
									<a class="left carousel-control" href="#myCarousel" data-slide="prev"> <i class="fa fa-angle-left list-slider-nav" aria-hidden="true"></i> </a>
									<a class="right carousel-control" href="#myCarousel" data-slide="next"> <i class="fa fa-angle-right list-slider-nav list-slider-nav-rp" aria-hidden="true"></i> </a>
								</div>
							</div>
						</div>
						<!--END LISTING DETAILS: LEFT PART 3-->

						<div class="pglist-p3 pglist-bg pglist-p-com tum-imkanlar" id="ld-roo">
							<div class="pglist-p-com-ti">
								<h3><span>Tüm</span> İmkanlar</h3> 
							</div>
							<div class="list-pg-inn-sp">
								<?php
									$schoolFacilities = $db->get('facility_type');
									foreach ($schoolFacilities as $schoolFacility) {
										echo '<div class="home-list-pop list-spac list-spac-1 list-room-mar-o"><div class="col-md-12 home-list-pop-desc inn-list-pop-desc list-room-deta">
										<h3>'.$schoolFacility['name'].'</h3>
										<div class="list-room-type list-rom-ami">
											<ul>';
										$facilityParams = Array($schoolId, $schoolFacility['id']);
										$facilityDetails = $db->rawQuery("SELECT name FROM facility WHERE id IN (SELECT facility_id FROM `school_facility` WHERE school_id = ?) AND type = ?", $facilityParams);
										foreach ($facilityDetails as $singleFacility) {
											echo '<li>'.$singleFacility['name'].'</li>';
										}
										echo '</ul></div></div></div>';
									}
								?>
							</div>
						</div>


					
						<?php if (isset($_SESSION['user_data']) && $_SESSION['is_logged_in']): ?>
                            <?php
                                $db->where('school_id', $schoolId);
                                $db->where('user_id', $_SESSION['user_data']['user_id']);
                                $userPoint = $db->getOne('school_points');
                            ?>
						<div class="pglist-p3 pglist-bg pglist-p-com" id="ld-rew">
							<div class="pglist-p-com-ti">
								<h3><span>Görüş</span> Bildir</h3> </div>
							<div class="list-pg-inn-sp">
								<div class="list-pg-write-rev">
									<form id="comment-form" class="col-md-12">
										<p>Bu okulla ilgili görüşlerini bu form aracılığı ile yazabilirsin</p>
										<div class="row">
											<div class="col s12">
												<fieldset class="rating">
													<input <?php echo $userPoint['point'] == 5 ? 'checked' : ''; ?> type="radio" id="star5" name="rating" value="5" />
													<label class="full" for="star5" title="Çok İyi - 5 yıldız"></label>
													<input <?php echo $userPoint['point'] == 4 ? 'checked' : ''; ?> type="radio" id="star4" name="rating" value="4" />
													<label class="full" for="star4" title="İyi - 4 yıldız"></label>
													<input <?php echo $userPoint['point'] == 3 ? 'checked' : ''; ?> type="radio" id="star3" name="rating" value="3" />
													<label class="full" for="star3" title="Ortalama - 3 yıldız"></label>
													<input <?php echo $userPoint['point'] == 2 ? 'checked' : ''; ?> type="radio" id="star2" name="rating" value="2" />
													<label class="full" for="star2" title="Kötü"></label>
													<input <?php echo $userPoint['point'] == 1 ? 'checked' : ''; ?> type="radio" id="star1" name="rating" value="1" />
													<label class="full" for="star1" title="Kötü"></label>
												</fieldset>
											</div>
										</div>
										<div class="row">
											<div class="input-field col s12">
												<textarea id="re_msg" name="comment" class="materialize-textarea"></textarea>
												<label for="re_msg">Görüşün</label>
											</div>
										</div>
										<div class="row">
                                            <input type="hidden" name="comment_url" value="<?php echo $pageUrl;?>">
                                            <input type="hidden" name="school" value="<?php echo $schoolId;?>">
                                            <div class="input-field col s12"> <button type="button" class="waves-effect waves-light btn-large full-btn" onclick="comment_school()">Gönder</button> </div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<?php endif ?>

						<div class="pglist-p3 pglist-bg pglist-p-com" id="ld-rer">
							<div class="pglist-p-com-ti">
								<h3><span>Üye</span> Yorumları</h3> </div>
							<div class="list-pg-inn-sp">
								<div class="lp-ur-all">
									<div class="lp-ur-all-left">
										<div class="lp-ur-all-left-1">
											<div class="lp-ur-all-left-11">Çok İyi (4.5 +)</div>
											<div class="lp-ur-all-left-12">
												<div class="lp-ur-all-left-13 rate-4-5-bg-color"></div>
											</div>
										</div>
										<div class="lp-ur-all-left-1">
											<div class="lp-ur-all-left-11">İyi (4.0 +)</div>
											<div class="lp-ur-all-left-12">
												<div class="lp-ur-all-left-13 lp-ur-all-left-Good rate-4-bg-color"></div>
											</div>
										</div>
										<div class="lp-ur-all-left-1">
											<div class="lp-ur-all-left-11">Ortalama (3.0 +)</div>
											<div class="lp-ur-all-left-12">
												<div class="lp-ur-all-left-13 lp-ur-all-left-satis rate-0-3-bg-color"></div>
											</div>
										</div>
									</div>
									<div class="lp-ur-all-right">
										<h5>Okul Puanı</h5>
										<p>
											<span class="<?php echo $schoolPointBgColor; ?>">
												<?php echo number_format($schoolPoint, 1, '.', ','); ?> <i class="fa fa-star" aria-hidden="true"></i>
											</span>
											<?php echo $schoolPointCount; ?> değerlendirmeye göre
										</p>
									</div>
								</div>
								<div class="lp-ur-all-rat">
									<h5>Yorumlar</h5>
									<ul>
<?php
	$db->where("school_id",$schoolId);
    $db->where("state",1); // Onaylı
	$allCommentsForSchool = $db->get('comment');
	if ($db->count > 0) {
	    foreach ($allCommentsForSchool as $singleCommentForSchool) {
	    	$commentatorId = $singleCommentForSchool['commentator'];
	    	$db->where("id",$commentatorId);
			$commentatorUser = $db->getOne('user');
	    	$userNameSurname = $commentatorUser['first_name']." ".mb_substr($commentatorUser['last_name'],0,1,"utf-8").".";
	    	$db->where("school_id",$schoolId);
	    	$db->where("user_id",$commentatorId);
			$commentPoint = $db->getOne('school_points')['point'];
			if ($commentPoint >= 4.5) {
				$commentPointBgColor = "rate-4-5-bg-color";
			} else if ($commentPoint >= 4.0) {
				$commentPointBgColor = "rate-4-bg-color";
			} else {
				$commentPointBgColor = "rate-0-3-bg-color";
			}
			$db->where('comment_id', $singleCommentForSchool['id']);
			$db->where('liked', 1);
			$commentLikes = $db->get('comment_likes');
            $db->where('comment_id', $singleCommentForSchool['id']);
            $db->where('liked', 2);
            $commentDislikes = $db->get('comment_likes');
	    	echo '<li>
					<div class="lr-user-wr-con">
						<h6>'.$userNameSurname.' <span class="'.$commentPointBgColor.'">'.$commentPoint.' <i class="fa fa-star" aria-hidden="true"></i></span></h6> <span class="lr-revi-date">'.turkcetarih_formati('j F Y',$singleCommentForSchool['publish_date']).'</span>
						<p>'.$singleCommentForSchool['comment'].'</p>
					</div>
					<div class="lr-user-wr-con">
                        <button class="like" type="button" onclick="like_dislike(2, '.$singleCommentForSchool['id'].')">
                            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                        </button>
                        <span id="dislikes_'.$singleCommentForSchool['id'].'">'.count($commentDislikes).'</span>
                        <button class="dislike" type="button" onclick="like_dislike(1, '.$singleCommentForSchool['id'].')">
                            <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
                        </button>
                        <span id="likes_'.$singleCommentForSchool['id'].'">'.count($commentLikes).'</span>
                    </div>
				</li>';
	    }
	} else {
	    echo '<p>Bu Okula Henüz Yorum Yapılmamış!</p>';
    }
?>
									</ul>
								</div>
							</div>
						</div>
						<!--END LISTING DETAILS: LEFT PART 5-->
					</div>
					<div class="list-pg-rt">
					
						<!--LISTING DETAILS: LEFT PART 8-->
						<div class="pglist-p3 pglist-bg pglist-p-com egitim-danismani">
							<div class="pg-list-user-pro"> <img src="images/users/call-center.png" alt="" width="70"> </div>
							<div class="list-pg-inn-sp">
								<div class="list-pg-upro">
									<h5>Eğitim Danışmanı</h5>
									<p>Size enuygun okulu birlikte arayalım</p>
									<p class="full-btn list-pg-btn egitim-danisman-no">0507 865 44 23</p>
								</div>
							</div>
						</div>
						<?php
							$db->where("school_id",$schoolId);
							$allAnnouncementsForSchool = $db->get('announcement_school');
							if ($db->count > 0) {
								$announcementCount = 0;
								echo '<div class="pglist-p3 pglist-bg pglist-p-com duyuru-ve-etkinlikler">
							<div class="pglist-p-com-ti pglist-p-com-ti-right">
								<h3><span>Duyurular & Etkinlikler</span></h3>
							</div>
							<div id="newsAndAnnSlider" class="card-slider">';
							    foreach ($allAnnouncementsForSchool as $singleAnnouncementForSchool) {
							    	$announcementCount++;
							    	$db->where("id",$singleAnnouncementForSchool['announcement_id']);
                                    $db->where("state", 1);
							    	$singleAnnouncement = $db->getOne('announcement');
							    	$announcementTitle = $singleAnnouncement['title'];
							    	$announcementDescription = mb_substr($singleAnnouncement['content'],0,90,"utf-8")."...";
							    	echo '<div class="card-wrapper">
							    	<div class="card">
							             <a href="#">
							                <div class="dir-hli-5">
							                  <div class="dir-hli-1">
							                    <div class="dir-hli-3"><img height="230" src="images/news-slider/'.$announcementCount.'.jpg" alt=""> </div>
							                    <div class="dir-hli-4"> </div> <img height="230" src="images/news-slider/'.$announcementCount.'.jpg" alt=""> </div>
							                  <div class="dir-hli-2">
							                    <h4 class="index-school-name">'.$announcementTitle.'</h4>
							                    <p class="xxs-pt index-school-comment">'.$announcementDescription.'</p>
							                </div>
							                </div>
							              </a>
							        </div>
							  	</div>';
							  	if ($announcementCount == 3) {
							  		$announcementCount = 0;
							  	}
							    }
							    echo '</div></div>';
							}
						?>
						<div class="pglist-p3 pglist-bg pglist-p-com okulun-ozellikleri">
							<div class="pglist-p-com-ti pglist-p-com-ti-right">
								<h3><span>Okulun</span> Özellikleri</h3> 
							</div>
							<div class="list-pg-inn-sp">
								<div class="list-pg-oth-info">
									<ul>
									<?php
										$featuresResult = Array("Yok", "Var");
										$languages = "";
										$schoolLanguages = $db->rawQuery("SELECT name FROM facility WHERE id IN (SELECT facility_id FROM `school_facility` WHERE school_id = ?) AND type = 4", $schoolParams);
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

										echo '<li>Psikolojik Danışman: <span>'.$featuresResult[$singleSchool['counselor']].'</span></li>';
										if ($singleSchool['age_interval'] != "") {
											echo '<li>Yaş Aralığı: <span>'.$singleSchool['age_interval'].'</span></li>';
										}
										echo '<li>Sınıf Mevcudu: <span>'.$singleSchool['class_quota'].'</span></li>';
                                        $margin_multiplier = intval(count($languages) / 4);
                                        $margin_multiplier = count($languages) % 4 > 0 ? $margin_multiplier + 1 : $margin_multiplier;
										echo '<li class="language-height-'.$margin_multiplier.'">Dil Olanakları: <span style="width: 100%; text-align: left;">'.$languages.'</span></li>';
										echo '<li>Servis: <span >'.$featuresResult[$singleSchool['transportation']].'</span></li>';

					                    $db->where("school_id", $schoolId);
					                    $transportationPoints = $db->get('transportation_point');
					                    if ($db->count > 0) {
					                        $margin_multiplier = intval($db->count / 3);
					                        $margin_multiplier = $db->count % 3 > 0 ? $margin_multiplier + 1 : $margin_multiplier;
					                    	echo '<li class="transportation-margin-'.$margin_multiplier.'">Servis Bölgeleri: <span style="width: 100%; text-align: left;">';
					                    	$transportationPointCount = 0;
					                        foreach ($transportationPoints as $transportationPoint) {
					                        	$db->where("ilce_key", $transportationPoint['ilce_key']);
												$transportationPointTown = mb_convert_case(mb_strtolower($db->getOne("town")['name']), MB_CASE_TITLE, "UTF-8");
												$transportationPointCount++;
												if ($transportationPointCount == count($transportationPoints)) {
													echo $transportationPointTown;
													continue;
												}
												echo $transportationPointTown.", ";
					                        }
					                        echo '</span></li>';
					                    }
									?>
									</ul>
								</div>
							</div>
						</div>
					</div>
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
						<form id="school-spesific-demand-form">
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
                                        <div class="input-field col s12 school-type-select disabled">
                                            <select style="pointer-events: none !important;" name="school_type" required title="Okul Türü Seçmediniz!">
                                                <option value="">Okul Türü</option>
                                                <option <?php echo $schoolType == 1 ? 'selected' : '' ?> value="1">Anaokulu veya Kreş</option>
                                                <option <?php echo $schoolType == 2 ? 'selected' : '' ?> value="2">İlkokul</option>
                                                <option <?php echo $schoolType == 3 ? 'selected' : '' ?> value="3">Ortaokul</option>
                                                <option <?php echo $schoolType == 4 ? 'selected' : '' ?> value="4">Lise</option>
                                            </select>
                                        </div>
                                    </div>
								</li>
								<li>
									<div class="row">
										<div class="input-field col s12">
											<textarea id="ta-w3mission" name="note" required title="Not Girmediniz!" rows="4" cols="50" style="height: 70px;" placeholder="Notunuz"></textarea>
										</div>
									</div>
								</li>
								<li>
									<div class="row">
										<div class="input-field col s12">
                                            <button type="button" class="waves-effect waves-light btn-large full-btn" onclick="okula_ozel_talep_gonder()">Talep Oluştur</button>
										</div>
									</div>
								</li>
                                <input type="hidden" name="school_link" value="<?php echo $okulSeflink;?>">
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
    <?php
    $db->where("school_link", $okulSeflink);
    $schoolFaqs = $db->get("weekly_sss");
    if ($db->count > 0) {
        echo '<section class="xs-py">
        <div class="container dir-hom-pre-tit">
            <div class="row">
                <div class="xs-py">
                    <h2 class="xs-pb">'.$schoolName.' Hakkında Sıkça Sorulan Sorular</h2>';
        foreach ($schoolFaqs as $faq) {
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
	    $faqsCount = count($schoolFaqs);
	    foreach ($schoolFaqs as $faq) {
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
		$db->where("school_id", $schoolId);
		$ownedSchoolControl = $db->getValue("school_owner", "count(*)");
		if ($ownedSchoolControl <= 0) {
		    if (isset($_SESSION['user_data']) && $_SESSION['is_logged_in'] && $_SESSION['user_data']['role'] == "Kurum Sahibi") {
		    	echo '<div id="ownerArea" class="con-com">
			<h4 class="con-tit-top-o">Merhaba</h4>
			<p>Kurum sahibi misiniz?</p>
		    <div class="input-field col s12" style="max-width:80px;float:left;margin-top: -4px;">';
		    	echo '<a href="'.$schoolTypeCreationLinkForOwner.'" target="_blank">
						<i class="waves-effect waves-light btn-large full-btn list-red-btn waves-input-wrapper" style="">
							<input type="submit" value="Evet" class="waves-button-input" style="width:80px;margin-left:-20px;font-size:10pt;height:20px;margin-top:-20px;line-height: 24px;">
						</i>
					</a>';
					echo '</div>
			<div class="input-field col s12" style="max-width:80px;float:left;margin-left:10px;margin-top: -4px;">
				<i class="waves-effect waves-light btn-large full-btn list-green-btn waves-input-wrapper" style="" onclick="closeOwnerBox();">
					<input type="submit" value="Hayır" class="waves-button-input" style="width: 80px;font-size:10pt;margin-left:-20px;line-height: 24px;" onclick="closeOwnerBox();">
				</i>
			</div>
		</div>';
		    } else if (isset($_SESSION['user_data']) && $_SESSION['is_logged_in'] && $_SESSION['user_data']['role'] != "Kurum Sahibi") {

		    } else {
		    	echo '<div id="ownerArea" class="con-com">
			<h4 class="con-tit-top-o">Merhaba</h4>
			<p>Kurum sahibi misiniz?</p>
		    <div class="input-field col s12" style="max-width:80px;float:left;margin-top: -4px;">';
		    	echo '<a href="#" data-dismiss="modal" data-toggle="modal" data-target="#owner-kayit-ol">
						<i class="waves-effect waves-light btn-large full-btn list-red-btn waves-input-wrapper" style="">
							<input type="submit" value="Evet" class="waves-button-input" style="width:80px;margin-left:-20px;font-size:10pt;height:20px;margin-top:-20px;line-height: 24px;">
						</i>
					</a>';
					echo '</div>
			<div class="input-field col s12" style="max-width:80px;float:left;margin-left:10px;margin-top: -4px;">
				<i class="waves-effect waves-light btn-large full-btn list-green-btn waves-input-wrapper" style="" onclick="closeOwnerBox();">
					<input type="submit" value="Hayır" class="waves-button-input" style="width:80px; font-size:10pt;margin-left:-20px;line-height: 24px;" onclick="closeOwnerBox();">
				</i>
			</div>
		</div>';
		    }
		    	
			
		}
	?>
	<?php require_once('php/Components/Footer.php'); ?>
	<?php if ($ownedSchoolControl <= 0): ?>
	<section>
	    <div class="modal fade dir-pop-com in" id="owner-kayit-ol" role="dialog">
	        <div class="modal-dialog" style="width: 100%;">
	           
	            <div class="modal-body">
	                <div class="log-in-pop">
	                    <div class="log-in-pop-left">
	                        <p class="h1">Merhaba... <span class="ng-binding"></span></p>
	                        <p>Rehber Okul ailesine hoş geldin.</p>
	                    </div>
	                    <div class="log-in-pop-right">
	                        <a href="#" class="pop-close" data-dismiss="modal"><img width="20" src="images/cancel.png" alt="">
	                        </a>
	                        <h4>Kayıt Ol</h4>
                            <form id="register-form-owner" class="s12">
                                <div>
                                    <div class="r-form input-field s12">
                                        <input id="first_name" name="first_name" type="text" class="validate" required pattern="[a-zA-ZçÇöÖüÜşŞİığĞ\s]*" title="Ad Girmediniz!">
                                        <label for="first_name">Ad*</label>
                                    </div>
                                </div>
                                <div>
                                    <div class="r-form input-field s12">
                                        <input name="last_name" type="text" class="validate" required pattern="[a-zA-ZçÇöÖüÜşŞİığĞ\s]*" title="Soyad Girmediniz!">
                                        <label>Soyad*</label>
                                    </div>
                                </div>
                                <div>
                                    <div class="r-form input-field s12">
                                        <input name="email" type="email" class="validate" required title="Hatalı Email!">
                                        <label>E-Posta*</label>
                                    </div>
                                </div>
                                <div>
                                    <div class="r-form input-field s12">
                                        <input name="phone" autocomplete="off" type="text" class="validate" required pattern="^[0-9]{10,10}$" title="Sadece rakam kullanabilirsiniz! 10 haneli olmalıdır!">
                                        <label>Telefon*</label>
                                    </div>
                                </div>
                                <div>
                                    <div class="r-form input-field s12">
                                        <input name="password" type="password" required class="validate" pattern="^$|^(?=.*[a-zA-Z])(?=.*[!+@?._-])(?=.*\d)[!+@?a-zA-Z.-_\d]{8,15}$" title="Parola En az 1 noktalama(!+@?._-), harf, rakam olmak üzere minimum 8 maksimum 15 karakter olmalı!">
                                        <label>Şifre*</label>
                                    </div>
                                </div>
                                <div>
                                    <div class="r-form input-field s12">
                                        <input name="password_verification" required type="password" class="validate" pattern="^$|^(?=.*[a-zA-Z])(?=.*[!+@?._-])(?=.*\d)[!+@?a-zA-Z.-_\d]{8,15}$" title="Parola En az 1 noktalama(!+@?._-), harf, rakam olmak üzere minimum 8 maksimum 15 karakter olmalı!">
                                        <label>Şifre Doğrula*</label>
                                    </div>
                                </div>
                                <div>
                                    <div class="r-form input-field s12">
                                        <input name="kvkk_control" value="1" required title="KVKK Kutucuğunu İşaretleyiniz!" type="checkbox" class="filled-in" id="cbx_owner">
                                        <label for="cbx_owner">
                                            * Kayıt olarak <a style="font-size: 10pt; font-weight: bold;" href="<?php echo WEBURL; ?>kisisel-verilerin-islenmesine-dair-bilgilendirme-kullanimi" target="_blank">Kişisel Verilerin İşlenmesine Dair Bilgilendirme Kullanımı</a> metnini kabul etmiş sayılırsınız. <br><br>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <div class="input-field s4 xxs-pt">
                                        <input name="user_role" type="hidden" value="2">
                                        <input id="submit_handle_owner" type="submit" style="display: none">
                                        <button type="button" onclick="register(2)" class="waves-effect waves-light btn-large full-btn">Kayıt Ol</button>

                                    </div>
                                </div>
                                <div>
                                    <div class="input-field s12">Zaten üye misin? | <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#giris-yap">Giriş Yap</a></div>
                                </div>
                            </form>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
        <script src="js/jquery-validation/jquery.validate.js"></script>
        <script src="js/jquery-validation/additional-methods.js"></script>
	</section>
	<section>
	    <div class="modal fade dir-pop-com in" id="owner-giris-yap" role="dialog">
	        <div class="modal-dialog" style="width: 100%;">

	            <div class="modal-body">
	                <div class="log-in-pop">
	                    <div class="log-in-pop-left">
	                        <p class="h1">Merhaba... <span class="ng-binding"></span></p>
	                        <p>Seni aramızda görmek bizi sevindiriyor.</p>
	                    </div>
	                    <div class="log-in-pop-right">
	                        <a href="#" class="pop-close" data-dismiss="modal"><img width="20" src="images/cancel.png" alt="">
	                        </a>
	                        <h4>Giriş Yap</h4>
	                        <p id="kurum-message-box"></p>
	                        <form id="kurum-login-form" class="s12 ng-pristine ng-valid">
	                            <div>
	                                <div class="input-field s12">
	                                    <input name="email" type="email" data-ng-model="name1" class="validate ng-pristine ng-untouched ng-valid ng-empty">
	                                    <label>E-Posta</label>
	                                </div>
	                            </div>
	                            <div>
	                                <div class="input-field s12">
	                                    <input name="password" type="password" class="validate">
	                                    <label>Şifre</label>
	                                </div>
	                            </div>
	                            <div>
	                                <div class="input-field s4">
	                                    <input id="loginBtn" name="submit" type="button" value="Giriş Yap" class="waves-button-input" onclick="interfaceKurumLogin();" style="background-color: #f4364f;color: #ffffff;">
	                                </div>
	                            </div>
	                            <div>
	                            	<input type="hidden" name="ownerLoginArea" value="Kurum">
	                                <input name="redirectUrl" value="<?php echo $schoolTypeCreationLinkForOwner; ?>" type="hidden">
	                                <div class="input-field s12"> <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#sifremi-unuttum">Şifremi Unuttum</a></div>
	                            </div>
	                        </form>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</section>
	<?php endif ?>

	<script src="js/bootstrap.js" type="text/javascript"></script>
	<script src="js/materialize.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/select2.min.js"></script>
	<script src="js/custom.js"></script>
    <script>
        $(document).ready(function() {
            $('.okul-turu-select').select2();
        });
    </script>
	<script src="js/rehberokul.js"></script>
	<script type="text/javascript" src="slick/slick.min.js"></script>
	<script type="text/javascript">
	function closeOwnerBox() {
		$('#ownerArea').remove();
	}

	$(document).ready( function () {
	  	$('.school-type-select .select-wrapper .caret').remove();
		$('.school-type-select .select-wrapper .select-dropdown').remove();
	});
	
	$('.card-slider').slick({
		autoplay: true,
		dots: false,
		infinite: true,
		speed: 1500,
		slidesToShow: 1,
		slidesToScroll: 1,
		responsive: [
		  {
		    breakpoint: 1024,
		    settings: {
		      slidesToShow: 1,
		      slidesToScroll: 1,
		      infinite: true,
		      dots: false
		    }
		  },
		  {
		    breakpoint: 600,
		    settings: {
		      slidesToShow: 1,
		      slidesToScroll: 1
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

    <script>
//        Tablet veya mobilse
        // window.mobileAndTabletCheck = function() {
        //     let check = false;
        //     (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
        //     return check;
        // };
// Sadece Mobilse
        window.mobileCheck = function() {
            let check = false;
            (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))
                check = true;})(navigator.userAgent||navigator.vendor||window.opera);
            return check; // true ise mobil değilse değil
        };

        if(mobileCheck()) {
            if($('.okul-hakkinda') && $('.egitim-danismani')) {
                $('.okul-hakkinda').prepend($('.egitim-danismani'));
                $('.egitim-danisman-no').css('color', 'white');
                $('.egitim-danisman-no').css('line-height', '45px');
                if($('.fotograf-galerisi')) {
                    $('.fotograf-galerisi').insertAfter($('.egitim-danismani'));
                    if($('.okulun-ozellikleri')) {
                        $('.okulun-ozellikleri').insertAfter($('.fotograf-galerisi'));
                    }
                }
            }
            if($('.duyuru-ve-etkinlikler') && $('.tum-imkanlar')) {
                $('.duyuru-ve-etkinlikler').insertAfter($('.tum-imkanlar'));
            }


        }
    </script>
</body>
</html>