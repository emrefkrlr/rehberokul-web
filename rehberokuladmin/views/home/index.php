<?php $hm = new HomeModel(); ?>
<!-- ADMINS -->
<?php echo $_SESSION['user_data']['role'] == 'Yönetici' ? '
<section class="panel">
    <div class="col-md-6 col-lg-12 col-xl-6">
        <div class="row">
            <div class="col-md-12 col-lg-6 col-xl-6">
                <section class="panel panel-featured-left panel-featured-primary">
                    <div class="panel-body" style="height: 180px;">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-primary">
                                    <i class="fa fa-graduation-cap"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">Onay Bekleyen Kurumlar</h4>
                                    <div class="info">
                                        <strong class="amount">'.$hm->getSchoolsNotApproved().'</strong>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <a class="text-muted text-uppercase" href="'.ROOT_URL.school.'/'.kindergarten.'">Anaokulları</a>
                                </div>
                                <div class="summary-footer">
                                    <a class="text-muted text-uppercase" href="'.ROOT_URL.school.'/'.middle.'">İlk ve Ortaokullar</a>
                                </div>
                                <div class="summary-footer">
                                    <a class="text-muted text-uppercase" href="'.ROOT_URL.school.'/'.high.'">Liseler</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-6">
                <section class="panel panel-featured-left panel-featured-secondary">
                    <div class="panel-body" style="height: 180px;">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-secondary">
                                    <i class="fa fa-reply"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">Onay Bekleyen Talepler</h4>
                                    <div class="info">
                                        <strong class="amount">'.$hm->getDemandsNotApproved().'</strong>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <a class="text-muted text-uppercase" href="'.ROOT_URL.demand.'">Genel Talepler</a>
                                </div>
                                <div class="summary-footer">
                                    <a class="text-muted text-uppercase" href="'.ROOT_URL.demand.'/'.spesific.'">Kuruma Özel Talepler</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-6">
                <section class="panel panel-featured-left panel-featured-tertiary">
                    <div class="panel-body" style="height: 180px;">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-tertiary">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">Süresi Bitecek Paketler</h4>
                                    <div class="info">
                                        <strong class="amount">0</strong>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <a class="text-muted text-uppercase" href="payment">Ödemeler</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-6">
                <section class="panel panel-featured-left panel-featured-quartenary">
                    <div class="panel-body" style="height: 180px;">
                        <div class="widget-summary">
                            <div class="widget-summary-col widget-summary-col-icon">
                                <div class="summary-icon bg-quartenary">
                                    <i class="fa fa-credit-card"></i>
                                </div>
                            </div>
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title">Bugün Satın Alınan Paketler</h4>
                                    <div class="info">
                                        <strong class="amount">'.$hm->getTodaysPurchase().'</strong>
                                    </div>
                                </div>
                                <div class="summary-footer">
                                    <a class="text-muted text-uppercase" href="payment">Ödemeler</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>' : '' ?>


<!--OWNERS-->
<?php
        if($_SESSION['user_data']['role'] == 'Kurum Sahibi') {
            echo  '<section class="panel">';
            foreach($hm->getOwnerSchools() as $school) {
                echo '<div class="row">
						<div class="col-md-12">
							<div class="toggle" data-plugin-toggle>
								<section class="toggle active">
									<label>'.$hm->getSchoolName($school['school_id']).' Hakkındaki İstatistikler</label>
									<div class="toggle-content">
										<div class="row" style="background: white; width: 100%; margin-left: 1px; padding-bottom: 15px;">
                                            <div class="col-md-3 center">
                                                <div class="row">
                                                    <i class="h4 fa fa-eye col-md-12" style="margin-top: 5px;"></i>
                                                    <p class="h5 text-weight-bold mb-none col-md-12">Görüntülenme Sayısı</p>
                                                </div>
                                                <div class="h4 text-weight-bold mb-none mt-lg">'.$hm->getSchoolClickCount($school['school_id']).'</div>
                                            </div>
                                            <div class="col-md-3 center">
                                                <div class="row">
                                                    <i class="h4 fa fa-reply col-md-12" style="margin-top: 5px;"></i>
                                                    <p class="h5 text-weight-bold mb-none col-md-12">Talep Sayısı</p>
                                                </div>
                                                <div class="h4 text-weight-bold mb-none mt-lg">'.$hm->getSchoolDemandCount($school['school_id']).'</div>
                                            </div>
                                            <div class="col-md-3 center">
                                                <div class="row">
                                                    <i class="h4 fa fa-comment col-md-12" style="margin-top: 5px;"></i>
                                                    <p class="h5 text-weight-bold mb-none col-md-12">Yorum Sayısı</p>
                                                </div>
                                                <div class="h4 text-weight-bold mb-none mt-lg">'.$hm->getSchoolCommentCount($school['school_id']).'</div>
                                            </div>
                                            <div class="col-md-3 center">
                                                <div class="row">
                                                    <i class="h4 fa fa-thumbs-up col-md-12" style="margin-top: 5px; color: green;"></i>
                                                    <p class="h5 text-weight-bold mb-none col-md-12" style="color: green;">Değerlendirme Puanı</p>
                                                </div>
                                                <div class="h4 text-weight-bold mb-none mt-lg" style="color: green;">'.$hm->getSchoolPoints($school['school_id']).'</div>
                                            </div>
                                        </div>
									</div>
								</section>
							</div>
						</div>
					</div>';
            }
            echo '</section>';
        } else {
            echo  '<section class="panel">';
            foreach($hm->getExecutiveSchools() as $school) {
                echo '<div class="row">
						<div class="col-md-12">
							<div class="toggle" data-plugin-toggle>
								<section class="toggle active">
									<label>'.$hm->getSchoolName($school['school_id']).' Hakkındaki İstatistikler</label>
									<div class="toggle-content">
										<div class="row" style="background: white; width: 100%; margin-left: 1px; padding-bottom: 15px;">
                                            <div class="col-md-3 center">
                                                <div class="row">
                                                    <i class="h4 fa fa-eye col-md-12" style="margin-top: 5px;"></i>
                                                    <p class="h5 text-weight-bold mb-none col-md-12">Görüntülenme Sayısı</p>
                                                </div>
                                                <div class="h4 text-weight-bold mb-none mt-lg">'.$hm->getSchoolClickCount($school['school_id']).'</div>
                                            </div>
                                            <div class="col-md-3 center">
                                                <div class="row">
                                                    <i class="h4 fa fa-reply col-md-12" style="margin-top: 5px;"></i>
                                                    <p class="h5 text-weight-bold mb-none col-md-12">Talep Sayısı</p>
                                                </div>
                                                <div class="h4 text-weight-bold mb-none mt-lg">'.$hm->getSchoolDemandCount($school['school_id']).'</div>
                                            </div>
                                            <div class="col-md-3 center">
                                                <div class="row">
                                                    <i class="h4 fa fa-comment col-md-12" style="margin-top: 5px;"></i>
                                                    <p class="h5 text-weight-bold mb-none col-md-12">Yorum Sayısı</p>
                                                </div>
                                                <div class="h4 text-weight-bold mb-none mt-lg">'.$hm->getSchoolCommentCount($school['school_id']).'</div>
                                            </div>
                                            <div class="col-md-3 center">
                                                <div class="row">
                                                    <i class="h4 fa fa-thumbs-up col-md-12" style="margin-top: 5px; color: green;"></i>
                                                    <p class="h5 text-weight-bold mb-none col-md-12" style="color: green;">Değerlendirme Puanı</p>
                                                </div>
                                                <div class="h4 text-weight-bold mb-none mt-lg" style="color: green;">'.$hm->getSchoolPoints($school['school_id']).'</div>
                                            </div>
                                        </div>
									</div>
								</section>
							</div>
						</div>
					</div>';
            }
            echo '</section>';
        } ?>
