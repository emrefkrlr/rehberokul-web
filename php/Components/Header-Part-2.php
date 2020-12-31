</section>
<section id="myID" class="bottomMenu hom-top-menu">
    <div class="container top-search-main">
        <div class="row">
            <div class="ts-menu">
                <div class="ts-menu-1">
                    <a href="<?php echo WEBURL; ?>"><img src="images/rehberokul/rehber-okul-ikon.png" alt=""> </a>
                </div>
                <div class="ts-menu-2"><a href="#" class="t-bb">Menü <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                    <div class="cat-menu cat-menu-1">
                        <div class="dz-menu">
                            <div class="dz-menu-inn">
                                <h4>Okullar</h4>
                                <ul>
                                    <li><a href="<?php echo WEBURL; ?>okul-tipi/anaokulu-kres">Anaokulu & Kreş</a></li>
                                    <li><a href="<?php echo WEBURL; ?>okul-tipi/ilk-okul">İlk Okul</a></li>
                                    <li><a href="<?php echo WEBURL; ?>okul-tipi/orta-okul">Orta Okul</a></li>
                                    <li><a href="<?php echo WEBURL; ?>okul-tipi/lise">Lise</a></li>
                                    <li><a href="<?php echo WEBURL; ?>talepler">Talepler</a></li>
                                </ul>
                            </div>
                            <div class="dz-menu-inn">
                                <h4>Rehber Okul</h4>
                                <ul>
                                    <li><a href="<?php echo WEBURL; ?>talepler">Talepler</a></li>
                                    <li><a href="<?php echo WEBURL; ?>bursluluk-sinavi">Bursluluk Sınavları</a></li>
                                    <li><a href="<?php echo WEBURL; ?>rehber-blog">Rehber Blog</a></li>
                                    <li><a href="<?php echo WEBURL; ?>iletisim">İletişim</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="dir-home-nav-bot">
                            <ul>
                                <li><a href="#ucretsiz-danismanlik-formu" class="waves-effect waves-light btn-large"><i class="fa fa-bookmark"></i> Danışmanlık Al</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="ts-menu-3">
                    <div class="">
                        <form class="tourz-search-form tourz-top-search-form" action="<?php echo WEBURL; ?>search" method="post" autocomplete="off">
                            <div class="input-field" style="width: 80% !important;">
                                <input name="searchTerm" type="text" id="top-select-search" class="autocomplete" autocomplete="off" title="Lütfen arama kriterinizi yazın" required>
                                <label for="top-select-search" class="search-hotel-type">Arama Yap (Şehir veya okul adı yazın)</label>
                            </div>
                            <div class="input-field" style="width: 10% !important;">
                                <input type="submit" value="" class="waves-effect waves-light tourz-top-sear-btn tiny-search"> </div>
                        </form>
                    </div>
                </div>
                <div class="ts-menu-4">
                    <div class="v3-top-ri">
                        <ul>
                            <?php
                            if (isset($_SESSION['user_data']) && $_SESSION['is_logged_in']) {
                                    $userProfileLink = 'https://www.rehberokul.com/rehberokuladmin/user/viewEdit/'.$_SESSION['user_data']['link'];
                                    $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                    $cikislink = WEBURL."cikis-yap/".$actual_link;
                                    echo '<li><a href="'.$userProfileLink.'" target="_blank"><i class="fa fa-user"></i> '.$_SESSION['user_data']['full_name'].'</a></li>
                                        <li><a href="'.$cikislink.'"><i class="fa fa-sign-in"></i> Çıkış Yap</a></li>';
                                } else {
                                    echo '<li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#kayit-ol" class="v3-menu-sign"><i class="fa fa-user"></i> Kayıt Ol</a> </li>
                                    <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#giris-yap" class="v3-add-bus"><i class="fa fa-sign-in"></i> Giriş Yap</a> </li>';
                                } 
                            ?>
                            
                        </ul>
                    </div>
                </div>
                <div class="ts-menu-5"><span><i class="fa fa-bars" aria-hidden="true"></i></span> </div>
                <div class="mob-right-nav" data-wow-duration="0.5s">
                    <div class="mob-right-nav-close"><i class="fa fa-times" aria-hidden="true"></i> </div>
                    <ul class="mob-menu-icon">
                        <?php
                         if (isset($_SESSION['user_data']) && $_SESSION['is_logged_in']) {
                                 $userProfileLink = 'https://www.rehberokul.com/rehberokuladmin/user/viewEdit/'.$_SESSION['user_data']['link'];
                                 $panelLink = WEBURL."rehberokuladmin/";
                                 echo '<li><a href="'.$userProfileLink.'" target="_blank"><i class="fa fa-user"></i> '.$_SESSION['user_data']['full_name'].'</a></li>
                                    <li><a href="'.$userProfileLink.'" target="_blank"><i class="fa fa-columns"></i> Panelime Git</a></li>
                                    <li><a href="'.$cikislink.'"><i class="fa fa-sign-in"></i> Çıkış Yap</a></li>';
                             } else {
                                 echo '<li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#kayit-ol" class="v3-menu-sign"><i class="fa fa-user"></i> Kayıt Ol</a> </li>
                                 <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#giris-yap" class="v3-add-bus"><i class="fa fa-sign-in"></i> Giriş Yap</a> </li>';
                             } 
                         ?>
                    </ul>
                    <h5>Okullar</h5>
                    <ul>
                        <li><a href="<?php echo WEBURL; ?>okul-tipi/anaokulu-kres">Anaokulu & Kreş</a></li>
                        <li><a href="<?php echo WEBURL; ?>okul-tipi/ilk-okul">İlk Okul</a></li>
                        <li><a href="<?php echo WEBURL; ?>okul-tipi/orta-okul">Orta Okul</a></li>
                        <li><a href="<?php echo WEBURL; ?>okul-tipi/lise">Lise</a></li>
                    </ul>
                    <h5>Rehber Okul</h5>
                    <ul>
                        <li><a href="<?php echo WEBURL; ?>talepler">Talepler</a></li>
                        <li><a href="<?php echo WEBURL; ?>bursluluk-sinavi">Bursluluk Sınavları</a></li>
                        <li><a href="<?php echo WEBURL; ?>rehber-blog">Rehber Blog</a></li>
                        <li><a href="<?php echo WEBURL; ?>iletisim">İletişim</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>