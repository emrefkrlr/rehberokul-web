<?php $gm = new GalleryModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
        <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/add'; ?>" method="post" enctype="multipart/form-data">
                    
                    <div class="form-group">
                            <label class="col-md-3 control-label">
                                Ne Ekleyeceksiniz
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select data-plugin-selectTwo title="Ne Eklemek İstediğinizi Seçmediniz!" class="form-control populate"  onchange="visible_check_folder()" name='isdir' id="isdir" required>
                                    <option value="">Seçiniz</option>
                                    <option value="0">Galeri Ekleyeceğim</option>
                                    <option value="1">Galeriye Fotoğraf Ekleyeceğim</option>
                                </select>
                            </div>
                    </div>
            
                    <div class="form-group" id="folder" style="display: none;">
                            <label class="col-md-3 control-label folder" for="folder_name">
                                Galeri Adı
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                    <input type="text" class="form-control folder" id="folder_name" name="folder_name" value="" required pattern="[a-zA-Z0-9çÇöÖüÜşŞİığĞ._-\s]*" title='Galeri Adı İçin Büyük harf, küçük harf, rakam veya işaret(._-) kullanabilirsiniz!'/>
                            </div>
                    </div>
            
                    <div class="form-group" id="select_folder_div" style="display: none;">
                            <label class="col-md-3 control-label">
                                Galeri Seç
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select data-plugin-selectTwo class="form-control populate" style="width: 415px;"  name='select_folder' id="select_folder" required>
                                    <option value="">Seçiniz</option>
                                    <?php foreach(GalleryModel::$folders as $folder_item): ?>
                                    <option value="<?php echo $folder_item['id']; ?>">
                                        <?php echo $folder_item['name'];?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                    </div>
            
                    <div class="form-group" id="upload_div" style="display: none;">
                            <label class="col-md-3 control-label not_folder">
                                Fotoğraf
                                <span class="required" aria-required="true">*</span>
                            </label>
                            <div class="col-md-9 not_folder">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="input-append">
                                                    <div class="uneditable-input">
                                                            <i class="fa fa-file fileupload-exists"></i>
                                                            <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-default btn-file">
                                                            <span class="fileupload-exists">Değiştir</span>
                                                            <span class="fileupload-new">Dosya Seç</span>
                                                            <input type="file" multiple name="file-haber[]" onchange="updateList()" id="upload" accept="image/jpg, image/jpeg, image/png" title="Fotoğraf Seçilmedi!"/>
                                                    </span>
                                                    <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Kaldır</a>
                                            </div>
                                            <div>
                                                <label id="filename"></label>
                                            </div>
                                    </div>
                            </div>
                    </div>
            
                    <div class="form-group" id="photo_name_div" style="display: none;">
                            <label class="col-md-3 control-label not_folder" for="photo_name">
                                Fotoğraf Adı
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6 not_folder">
                                    <input type="text" class="form-control" id="photo_name" name="photo_name" value="" pattern="[a-zA-Z0-9çÇöÖüÜşŞİığĞ._-\s]*" title='Fotoğraf Adı İçin Büyük harf, küçük harf, rakam veya işaret(._-) kullanabilirsiniz!'/>
                            </div>
                    </div>
            
            
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />
                

                    <div class="form-group">
                            <div class="center">
                                <button type="submit" name="submit" class="btn btn-primary">Kaydet</button>
                                    <a href="<?php echo strtolower(get_class($this));?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>