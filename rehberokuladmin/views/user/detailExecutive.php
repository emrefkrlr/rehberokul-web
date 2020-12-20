<?php $um = new UserModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
            <form class="form-horizontal form-bordered" method="post">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="first_name">Adı</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $viewModel['first_name'];?>" disabled/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" for="last_name">Soyadı</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $viewModel['last_name'];?>" disabled/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" for="last_name">Telefon</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $viewModel['phone'];?>" disabled/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" for="user_name">Email</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $viewModel['email'];?>" disabled/>
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
                    <label class="col-md-3 control-label" for="is_active">Aktiflik Durumu</label>
                    <div class="col-md-6">
                        <div class="radio">
                            <label class="col-md-3">
                                <input type="radio" name="is_active" id="active" value="1" <?php echo $viewModel['is_active']==true ? 'checked' : '';?> disabled/>
                                Aktif
                            </label>
                            <label class="col-md-3">
                                <input type="radio" name="is_active" id="passive" value="0" <?php echo $viewModel['is_active']==false ? 'checked' : '';?> disabled/>
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
                        <select style="width: 100%;" disabled data-plugin-selectTwo class="form-control populate" id="schools_select" name='school'>
                            <option value="">Seçiniz</option>
                            <?php foreach($um::$owner_schools as $school): ?>
                                <option value="<?php echo $school['id']; ?>" <?php echo $school['id'] == $um::$owner_schools['school_id'] ? 'selected' : ''; ?>><?php echo $school['name'];?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                    <div class="form-group">
                            <div class="center">
                                <a href="<?php echo strtolower(get_class($this)).'/executive';?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>