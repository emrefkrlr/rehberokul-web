<?php $um = new UserModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
        <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/add/'; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                            <label class="col-md-3 control-label" for="first_name">
                                Adı
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                    <input type="text" class="form-control" id="first_name" name="first_name" pattern="[a-zA-ZçÇöÖüÜşŞİığĞ\s]*" title='Ad İçin Sadece büyük ve küçük harf kullanabilirsiniz!' value="" required/>
                            </div>
                    </div>
                
                    <div class="form-group">
                            <label class="col-md-3 control-label" for="last_name">
                                Soyadı
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-6">
                                    <input type="text" class="form-control" id="last_name" name="last_name" pattern="[a-zA-ZçÇöÖüÜşŞİığĞ\s]*" title='Soyad İçin Sadece büyük ve küçük harf kullanabilirsiniz!' value="" required/>
                            </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="last_name">
                            Telefon
                            <span class="required" aria-required="true">*</span>
                        </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="phone" name="phone" pattern="^[0-9]{10,10}$" title="Sadece rakam kullanabilirsiniz! 10 haneli olmalıdır!" value="" required/>
                        </div>
                    </div>
                
                    <div class="form-group">
                            <label class="col-md-3 control-label" for="user_name">
                                Email
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="email" class="form-control"  id="email" name="email" value="" pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$" required title="Hatalı Email!"/>
                            </div>
                    </div>
   
                
                    <div class="form-group">
                            <label class="col-md-3 control-label" for="password">
                                Parola
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" id="password" name="password" value="" required pattern="^$|^(?=.*[a-zA-Z])(?=.*[!+@?._-])(?=.*\d)[!+@?a-zA-Z.-_\d]{8,15}$" title="Parola En az 1 noktalama(!+@?._-), harf, rakam olmak üzere minimum 8 maksimum 15 karakter olmalı!"/>
                            </div>
                    </div>
                
                    <div class="form-group">
                            <label class="col-md-3 control-label" for="password_verification">
                                Parola Onayla
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" id="password_verification" name="password_verification" value="" required pattern="^$|^(?=.*[a-zA-Z])(?=.*[!+@?._-])(?=.*\d)[!+@?a-zA-Z.-_\d]{8,15}$" title="Parola Onayı En az 1 noktalama(!+@?._-), harf, rakam olmak üzere minimum 8 maksimum 15 karakter olmalı!"/>
                            </div>
                    </div>
                
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="is_active">
                            Aktiflik Durumu
                            <span class="required" aria-required="true">*</span>
                        </label>
                        <div class="col-md-6">               
                                <div class="radio">
                                        <label class="col-md-3">
                                                <input type="radio" name="is_active" id="active" value="1" required/>
                                                Aktif
                                        </label>
                                        <label class="col-md-3">
                                                <input type="radio" name="is_active" id="passive" value="0" required/>
                                                Pasif
                                        </label>
                                </div>
                        </div>
                    </div>
            
                    <div class="form-group">
                            <label class="col-md-3 control-label">
                                Kullanıcı Tipi
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-6">
                                    <select onchange="visible_schools()" data-plugin-selectTwo class="form-control populate" id="roles_select" name='role'>
                                            <?php foreach($viewModel as $roles): ?>
                                                <option value="<?php echo $roles['role_id']; ?>"><?php echo $roles['role_name'];?></option>
                                            <?php endforeach; ?>
                                    </select>
                            </div>
                    </div>

                    <div class="form-group" id="schools_select_div" style="display: none;">
                <label class="col-md-3 control-label">
                    Yetkilendirilecek Okul
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select style="width: 415px;" title="Yetkilendirilecek Okulu Seçmediniz!" data-plugin-selectTwo class="form-control populate" id="schools_select" name='school'>
                        <option value="">Seçiniz</option>
                        <?php foreach($um::$schools as $school): ?>
                            <option value="<?php echo $school['id']; ?>"><?php echo $school['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
            

                    <div class="form-group">
                            <div class="center">
                                <button type="submit" name="submit" class="btn btn-primary">Kaydet</button>
                                    <a href="<?php echo strtolower(get_class($this)).'/all_users';?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>