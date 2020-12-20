<?php $gm = new GalleryModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
            <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/discard/'.$viewModel['link']; ?>" method="post">
                   <div class="form-group">
                            <label class="col-md-3 control-label">
                                Klasör Mü
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select data-plugin-selectTwo class="form-control populate" name='isdir' id="isdir" disabled>
                                    <option value="">Seçiniz</option>
                                    <option <?php echo $viewModel['isdir'] == 0 ? 'selected' : '';?> value="0">Hayır Fotoğraf</option>
                                    <option <?php echo $viewModel['isdir'] == 1 ? 'selected' : '';?> value="1">Evet Klasör</option>
                                </select>
                            </div>
                    </div>
            
                    <div class="form-group folder" <?php echo $viewModel['isdir'] == 0 ? 'style="display: none;"' : ''; ?>>
                            <label class="col-md-3 control-label folder" for="folder_name">
                                Klasör Adı
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control folder" id="folder_name" name="folder_name" value="<?php echo $viewModel['name'];?>" disabled/>
                            </div>
                    </div>
            
                    <div class="form-group">
                            <label class="col-md-3 control-label">
                                Konum
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select data-plugin-selectTwo class="form-control populate"  name='select_folder' disabled id="select_folder">
                                    <option value="0">Yeni Klasör</option>
                                    <?php foreach(GalleryModel::$folders as $folder_item): ?>
                                    <option value="<?php echo $folder_item['id']; ?>" <?php echo $viewModel['parent_id'] == $folder_item['id'] ? 'selected' : '';?>><?php echo $gm->getDirectoryName($folder_item['parent_id'])['name'].' / '.$folder_item['name'];?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                    </div>
            
                    <div class="form-group not_folder" <?php echo $viewModel['isdir'] == 1 ? 'style="display: none;"' : ''; ?>>
                            <label class="col-md-3 control-label not_folder">
                                Fotoğraf
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-9">
                                <img class="thmb" id="asd" src="<?php echo $viewModel['href'];?>" >
                            </div>
                    </div>
            
                    <div class="form-group not_folder" <?php echo $viewModel['isdir'] == 1 ? 'style="display: none;"' : ''; ?>>
                            <label class="col-md-3 control-label not_folder" for="photo_name">
                                Fotoğraf Adı
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 not_folder">
                                    <input disabled type="text" class="form-control" id="photo_name" name="photo_name" value="<?php echo $viewModel['name']; ?>"/>
                            </div>
                    </div>
                
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />

                    <div class="form-group">
                            <div class="center">
                                <input type="submit" name="submit" class="btn btn-danger" value="Galeriden Çıkar"/>
                                <a href="<?php echo strtolower(get_class($this));?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>