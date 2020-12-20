<?php $gm = new GalleryModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
            <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/delete/'.$viewModel['link']; ?>" method="post">
                <div class="form-group" id="folder" <?php echo $viewModel['isdir'] == 1 ? '' : 'style="display: none;"';?> >
                    <label class="col-md-3 control-label folder" for="folder_name">
                        Galeri Adı
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <input disabled type="text" class="form-control folder" id="folder_name" name="folder_name" value="<?php echo $viewModel['name'];?>"  pattern="[a-zA-Z0-9çÇöÖüÜşŞİığĞ._-\s]*" title='Büyük harf, küçük harf, rakam veya işaret(._-) kullanabilirsiniz!'/>
                    </div>
                </div>

                <div class="form-group" id="select_folder_div" <?php echo $viewModel['isdir'] != 1 ? '' : 'style="display: none;"';?>>
                    <label class="col-md-3 control-label">
                        Galeri Seç
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <select disabled data-plugin-selectTwo class="form-control populate" style="width: 415px;"  name='select_folder' id="select_folder">
                            <option value="">Seçiniz</option>
                            <?php foreach(GalleryModel::$folders as $folder_item): ?>
                                <option value="<?php echo $folder_item['id']; ?>" <?php echo $viewModel['parent']==$folder_item['id'] ? 'selected' : '';?>>
                                    <?php echo $folder_item['name'];?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group not_folder" <?php echo $viewModel['isdir'] != 1 ? '' : 'style="display: none;"';?>>
                    <label class="col-md-3 control-label not_folder">
                        Mevcut Fotoğraf
                        <span class="required" aria-required="true">*</span>
                    </label>
                    <div class="col-md-9">
                        <img class="thmb" id="asd" src="<?php echo $viewModel['href'];?>" >
                    </div>
                </div>

                <div class="form-group" id="upload_div" <?php echo $viewModel['isdir'] != 1 ? '' : 'style="display: none;"';?>>
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
                                                            <input disabled type="file" name="file-haber" id="upload" accept="image/jpg, image/jpeg, image/png" title="Fotoğraf Seçilmedi!"/>
                                                    </span>
                                <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Kaldır</a>
                            </div>
                            <div>
                                <label id="filename"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="photo_name_div" <?php echo $viewModel['isdir'] != 1 ? '' : 'style="display: none;"';?>>
                    <label class="col-md-3 control-label not_folder" for="photo_name">
                        Fotoğraf Adı
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6 not_folder">
                        <input type="text" disabled class="form-control" id="photo_name" name="photo_name" value="<?php echo $viewModel['name'];?>" pattern="[a-zA-Z0-9çÇöÖüÜşŞİığĞ._-\s]*" title='Büyük harf, küçük harf, rakam veya işaret(._-) kullanabilirsiniz!'/>
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