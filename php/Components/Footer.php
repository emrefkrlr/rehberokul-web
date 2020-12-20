<footer id="colophon" class="site-footer clearfix">
    <div id="quaternary" class="sidebar-container " role="complementary">
        <div class="sidebar-inner">
            <div class="widget-area clearfix">
                <div id="azh_widget-2" class="widget widget_azh_widget">
                    <div data-section="section">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-3 col-md-3 foot-logo">
                                    <img src="images/rehberokul/rehber-okul-logo.png" alt="logo" class="xs-pt">
                                </div>
                                <div class="col-sm-9 col-md-9">
                                    <p class="hasimg">Rehber Okul, enuygun eğitim kurumunu bulmak için doğru yerdesin.</p>
                                    <p class="hasimg">Binlerce kurum arasında sana enuygun okulu bulmak için sadece bir kaç dakikanı ayır. Doğru kararı vermek için okulun resimlerini, yorum ve değerlendirme puanını incele.</p>
                                    <p class="hasimg">Alanında uzman eğitimci kadromuzla size yardım etmekten mutluluk duyarız. Bizlere yada talepler ekranında kriterlerinizi belirtin. Okullar sizi arasın.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-section="section" class="foot-sec2">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4>Bize Ulaşın</h4>
                                    
                                    <p><b>E-Posta:</b> <a href="mailto:bilgi@rehberokul.com">bilgi@rehberokul.com</a></p>
                                    <p><b>Telefon:</b> <a href="tel:+905078654423">+90 507 865 44 23</a></p>
                                    <p><b>Adres:</b> Çifte Havuzlar Mahallesi Eski Londra Asfaltı Cad. Kuluçka Mrk. A1 Blok No: 151/1C İç Kapı No: 1B20 YTÜ Teknoloji Geliştirme Bölgesi <br>Davutpaşa Yerleşkesi Esenler/İstanbul</p>
                                </div>
                                <div class="col-sm-6 foot-social">
                                    <h4>Bizi Sosyal Medya'da Takip Edin</h4>
                                    <p>Eğitim kurumları ile ilgili güncel gelişmelerden haberdar olun!</p>
                                    <ul>
                                        <li><a href="https://www.facebook.com/rehberokull/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a> </li>
                                        <li><a href="https://www.instagram.com/rehberokul/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a> </li>
                                        <li><a href="https://www.twitter.com/rehberokul/" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a> </li>
                                    </ul>
                                </div>
                                <div class="col-sm-12 right-align">
                                    <a href="https://www.algorit.com.tr" target="_blank" title="Algorit Bilişim ve Danışmanlık"><img width="100" height="28" src="https://www.algorit.com.tr/web/algorit-bilisim-danismanlik.png" alt="Yazılım Hizmetleri | ALGORİT Bilişim &amp; Danışmanlık"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<section class="copy">
    <div class="container">
        <p>Copyrights © 2020 Rehber Okul. Tüm Hakları Saklıdır</p>
    </div>
</section>
<section>
    <div class="modal fade dir-pop-com in" id="giris-yap" role="dialog">
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
                        <p id="message-box"></p>
                        <form id="login-form" class="s12 ng-pristine ng-valid">
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
                                    <input id="loginBtn" name="submit" type="button" value="Giriş Yap" class="waves-button-input" onclick="interfaceLogin();" style="background-color: #f4364f;color: #ffffff;">
                                </div>
                            </div>
                            <div class="row">
                                <input name="redirectUrl" value="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" type="hidden">
                                <div class="input-field col-md-6"> <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#sifremi-unuttum">Şifremi Unuttum</a></div>
                                <div class="input-field col-md-6"> <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#kayit-ol">Üye Değil Misin ?</a></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="modal fade dir-pop-com in" id="sifremi-unuttum" role="dialog">
        <div class="modal-dialog" style="width: 100%;">
            <div class="modal-body">
                <div class="log-in-pop">
                    <div class="log-in-pop-left">
                        <p class="h1">Merhaba... <span class="ng-binding"></span></p>
                        <p>E-posta adresini yazarak şifreni gelen mail ile hemen yenileyebilirsin..</p>
                    </div>
                    <div class="log-in-pop-right">
                        <a href="#" class="pop-close" data-dismiss="modal"><img width="20" src="images/cancel.png" alt="">
                        </a>
                        <h4>Şifremi Unuttum</h4>
                        <form id="forgotPassword" class="s12 ng-pristine ng-valid">
                            <div>
                                <div class="input-field s12">
                                    <input name="emailAddress" type="text" data-ng-model="name1" class="validate ng-pristine ng-untouched ng-valid ng-empty">
                                    <label>E-Posta</label>
                                </div>
                            </div>
                            <div>
                                <div class="input-field s4">
                                    <i class="waves-effect waves-light log-in-btn waves-input-wrapper" style="">
                                        <input name="submit" type="button" value="Şifremi Sıfırla" class="waves-button-input" onclick="forgotPassword();" style="background-color: #f4364f;color: #ffffff;">
                                    </i>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <div class="modal fade dir-pop-com in" id="kayit-ol" role="dialog">
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
                        <form id="register-form" class="s12 ng-pristine ng-valid" method="post">
                            <div>
                                <div class="r-form input-field s12">
                                    <input name="first_name" type="text" class="validate" required pattern="[a-zA-ZçÇöÖüÜşŞİığĞ\s]*" title="Ad Girmediniz!">
                                    <label>Ad*</label>
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
                                    <input name="phone" type="text" class="validate" required pattern="^[0-9]{10,10}$" title="Sadece rakam kullanabilirsiniz! 10 haneli olmalıdır!">
                                    <label>Telefon*</label>
                                </div>
                            </div>
                            <div>
                                <div class="r-form input-field s12">
                                    <select name="user_role" required title="Kullanıcı Tipi Seçmediniz!">
                                        <option value="">Kullanıcı Tipi Seçiniz*</option>
                                        <option value="2">Kurum Sahibi</option>
                                        <option value="3">Veli</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div class="r-form input-field s12">
                                    <input name="password" value="" type="password" required class="validate" pattern="^$|^(?=.*[a-zA-Z])(?=.*[!+@?._-])(?=.*\d)[!+@?a-zA-Z.-_\d]{8,15}$" title="Parola En az 1 noktalama(!+@?._-), harf, rakam olmak üzere minimum 8 maksimum 15 karakter olmalı!">
                                    <label>Şifre*</label>
                                </div>
                            </div>
                            <div>
                                <div class="r-form input-field s12">
                                    <input name="password_verification" value="" required type="password" class="validate" pattern="^$|^(?=.*[a-zA-Z])(?=.*[!+@?._-])(?=.*\d)[!+@?a-zA-Z.-_\d]{8,15}$" title="Parola En az 1 noktalama(!+@?._-), harf, rakam olmak üzere minimum 8 maksimum 15 karakter olmalı!">
                                    <label>Şifre Doğrula*</label>
                                </div>
                            </div>
                            <div>
                                <div class="r-form input-field s12">
                                    <input name="kvkk_control" value="1" title="KVKK Kutucuğunu İşaretleyiniz!" required type="checkbox" class="filled-in" id="cbx">
                                    <label for="cbx">
                                        * Kayıt olarak <a style="font-size: 10pt; font-weight: bold;" href="<?php echo WEBURL; ?>kisisel-verilerin-islenmesine-dair-bilgilendirme-kullanimi" target="_blank">Kişisel Verilerin İşlenmesine Dair Bilgilendirme Kullanımı</a> metnini kabul etmiş sayılırsınız. <br><br>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <div class="input-field s4 xxs-pt">
                                        <input id="submit_handle" type="submit" style="display: none">
                                        <button type="button" onclick="register(1)" class="waves-effect waves-light btn-large full-btn">Kayıt Ol</button>

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
<button onclick="upToPageTop()" id="upToTopButton" title="Yukarı Çık"><i class="fa fa-arrow-up"></i></button>