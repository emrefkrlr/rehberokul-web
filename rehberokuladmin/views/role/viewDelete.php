<?php $rm = new RoleModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
            <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/delete/'.$viewModel['link']; ?>" method="post">
                     <div class="form-group">
                            <label class="col-md-3 control-label" for="first_name">
                                Adı
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="first_name" name="role_name" value="<?php echo $rm->getRoleName($viewModel['role_id']);?>" disabled/>
                            </div>
                    </div>
            
                    <div class="form-group">
                            <label class="col-md-3 control-label">
                                Menü
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select data-plugin-selectTwo class="form-control populate" name='menu' id="menu" disabled>
                                            <?php foreach(RoleModel::$menuItems as $menuItem): ?>
                                                <option value="<?php echo $menuItem['id']; ?>" <?php echo $viewModel['menu_id'] == $menuItem['id'] ? 'selected' : ''; ?>><?php echo $menuItem['menu_name'];?></option>
                                            <?php endforeach; ?>
                                    </select>
                            </div>
                    </div>
            
                    <div class="form-group">
                            <label class="col-md-3 control-label" for="inputSuccess">
                                Yetkiler
                                <span class="required">*</span>
                            </label>
                            
                                <div class="col-md-9">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name='auth[]' disabled="true" value="reading" <?php echo $viewModel['reading'] == 1 ? 'checked' : ''; ?>/>Okuma
                                            </label>
                                            <label>
                                                <input type="checkbox" name='auth[]' disabled="true" value="adding" <?php echo $viewModel['adding'] == 1 ? 'checked' : ''; ?>/>Yazma
                                            </label>
                                            <label>
                                                <input type="checkbox" name='auth[]' disabled="true" value="editing" <?php echo $viewModel['editing'] == 1 ? 'checked' : ''; ?>/>Güncelleme
                                            </label>
                                            <label>
                                                <input type="checkbox" name='auth[]' disabled="true" value="deleting" <?php echo $viewModel['deleting'] == 1 ? 'checked' : ''; ?>/>Silme
                                            </label>
                                            <label>
                                                <input type="checkbox" name='auth[]' disabled="true" class="check_news" value="check_news" <?php echo $viewModel['check_news'] == 1 ? 'checked' : ''; ?>/><span class="check_news">Habere Onay Verme</span>
                                            </label>
                                        </div>
                                </div>
                            
                    </div>
                
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />

                    <div class="form-group">
                            <div class="center">
                                <input type="submit" name="submit" class="btn btn-danger" value="Sil"/>
                                <a href="<?php echo strtolower(get_class($this));?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>