<div class="ts-menu-5"><span><i class="fa fa-bars" aria-hidden="true"></i></span> </div>
<section id="background" class="dir1-home-head">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="dir-ho-tl">
                    <ul>
                        <li>
                            <a href="<?php echo WEBURL; ?>"><img src="images/rehberokul/rehber-okul-logo.png" alt="" height="60"> </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8 col-sm-8">
                <div class="dir-ho-tr">
                    <ul>
                        <li><a href="<?php echo WEBURL; ?>okul-tipi/anaokulu-kres">Anaokulu & Kreş</a></li>
                        <li><a href="<?php echo WEBURL; ?>okul-tipi/ilk-okul">İlk Okul</a></li>
                        <li><a href="<?php echo WEBURL; ?>okul-tipi/orta-okul">Orta Okul</a></li>
                        <li><a href="<?php echo WEBURL; ?>okul-tipi/lise">Lise</a></li>
                        <li><a href="<?php echo WEBURL; ?>talepler">Talepler</a></li>
                        <?php
                            if (isset($_SESSION['user_data']) && $_SESSION['is_logged_in']) {
                                $userProfileLink = 'https://www.rehberokul.com/rehberokuladmin/user/viewEdit/'.$_SESSION['user_data']['link'];
                                $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                $cikislink = WEBURL."cikis-yap/".$actual_link;
                                echo '<li class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown" style="padding: 1px 8px;height: auto;">
                                <i class="fa fa-user"></i> '.$_SESSION['user_data']['full_name'].' <i class="fa fa-caret-down"></i></button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1" style="margin-top: 2px;min-width: 100px;">
                                  <li role="presentation"><a role="menuitem" tabindex="-1" href="'.$userProfileLink.'" target="_blank" style="color:#33336e;width:100%;padding: 4px;"><i class="fa fa-columns"></i> Panelime Git</a></li>
                                  <li role="presentation"><a role="menuitem" tabindex="-1" href="'.$cikislink.'" style="color:#33336e;width:100%;padding: 4px;"><i class="fa fa-sign-in"></i> Çıkış Yap</a></li>   
                                </ul>
                                </li>
                                ';
                            } else {
                                echo '<li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#kayit-ol"><i class="fa fa-user"></i> Kayıt Ol</a></li>
                                    <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#giris-yap"><i class="fa fa-sign-in"></i> Giriş Yap</a></li>';
                            } 
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
