<?php $um = new UserModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
        <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/editExecutive/'.$viewModel['link']; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                            <label class="col-md-3 control-label" for="first_name">
                                Adı
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-6">
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $viewModel['first_name'];?>" required pattern="[a-zA-ZçÇöÖüÜşŞİığĞ\s]*" title='Ad İçin Sadece büyük ve küçük harf kullanabilirsiniz!'/>
                            </div>
                    </div>
                
                    <div class="form-group">
                            <label class="col-md-3 control-label" for="last_name">
                                Soyadı
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-6">
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $viewModel['last_name'];?>" required pattern="[a-zA-ZçÇöÖüÜşŞİığĞ\s]*" title='Soyad İçin Sadece büyük ve küçük harf kullanabilirsiniz!'/>
                            </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="last_name">
                            Telefon
                            <span class="required" aria-required="true">*</span>
                        </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $viewModel['phone'];?>" required pattern="^[0-9]{10,10}$" title="Sadece rakam kullanabilirsiniz! 10 haneli olmalıdır!"/>
                        </div>
                    </div>
                
                    <div class="form-group">
                            <label class="col-md-3 control-label" for="user_name">
                                Email
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="email" name="email" value="<?php echo $viewModel['email'];?>" pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$" required title="Hatalı Email!"/>
                            </div>
                    </div>

                    <div class="form-group <?php echo $viewModel['role_id'] != 2  ? 'hide' : '';?>">
                        <label class="col-md-3 control-label" for="kurumlar">
                            Kurum Sayısı
                            <span class="required" aria-required="true">*</span>
                        </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="kurumlar" name="kurumlar" value="<?php echo $um->getNumberOfSchools($viewModel['id']); ?>" disabled/>
                        </div>
                    </div>
   
                
                    <div class="form-group">
                            <label class="col-md-3 control-label" for="password">
                                Parola
                            </label>
                            <div class="col-md-6">
                                    <input type="password" class="form-control" id="password" name="password" value="" pattern="^$|^(?=.*[a-zA-Z])(?=.*[!+@?._-])(?=.*\d)[!+@?a-zA-Z.-_\d]{8,15}$" title="Parola İçin En az 1 noktalama(!+@?._-), harf, rakam olmak üzere minimum 8 maksimum 15 karakter olmalı!"/>
                            </div>
                    </div>
                
                    <div class="form-group">
                            <label class="col-md-3 control-label" for="password_verification">
                                Parola Onayla
                            </label>
                            <div class="col-md-6">
                                    <input type="password" class="form-control" id="password_verification" name="password_verification" value="" pattern="^$|^(?=.*[a-zA-Z])(?=.*[!+@?._-])(?=.*\d)[!+@?a-zA-Z.-_\d]{8,15}$" title="Parola Onayı İçin En az 1 noktalama(!+@?._-), harf, rakam olmak üzere minimum 8 maksimum 15 karakter olmalı!"/>
                            </div>
                    </div>



            
                    <div class="form-group <?php echo $viewModel['link'] == $_SESSION['user_data']['link'] ? 'hide' : '';?>">
                        <label class="col-md-3 control-label" for="is_active">
                            Aktiflik Durumu
                            <span class="required" aria-required="true">*</span>
                        </label>
                        <div class="col-md-6">               
                                <div class="radio">
                                        <label class="col-md-3">
                                                <input type="radio" name="is_active" id="active" value="1" <?php echo $viewModel['is_active']==true ? 'checked' : '';?> required/>
                                                Aktif
                                        </label>
                                        <label class="col-md-3">
                                                <input type="radio" name="is_active" id="passive" value="0" <?php echo $viewModel['is_active']==false ? 'checked' : '';?> required/>
                                                Pasif
                                        </label>
                                </div>
                        </div>
                    </div>

                    <div class="form-group" id="schools_select_div">
                        <label class="col-md-3 control-label">
                            Yetkilendirilecek Okul
                            <span class="required" aria-required="true">*</span>
                        </label>
                        <div class="col-md-6">
                            <select style="width: 100%;" title="Yetkilendirilecek Okulu Seçmediniz!" data-plugin-selectTwo class="form-control populate" id="schools_select" name='school'>
                                <option value="">Seçiniz</option>
                                <?php foreach($um::$owner_schools as $school): ?>
                                    <option value="<?php echo $school['id']; ?>" <?php echo $school['id'] == $um::$school_executive['school_id'] ? 'selected' : ''; ?>><?php echo $school['name'];?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                
            
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />

                    <div class="form-group">
                            <div class="center">
                                <button type="submit" name="submit" class="btn btn-primary">Güncelle</button>
                                    <a href="<?php echo strtolower(get_class($this)).'/executive';?>"><button type="button" class="btn btn-default">Kapat</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>