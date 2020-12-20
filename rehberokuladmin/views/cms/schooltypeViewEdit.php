<?php $cm = new CMSModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
        <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/schooltypeEdit/'.$viewModel['slug']; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-md-3 control-label" for="title">
                    Okul Tipi
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" disabled class="form-control" id="school_type" value="<?php echo str_replace('-', ' ', $viewModel['slug']); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="title">
                    Üst Başlık
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" required class="form-control" id="top_header" name="top_header" title='Üst Başlık Girmediniz!' value="<?php echo $viewModel['top_header']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="content">
                    Üst İçerik
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <textarea type="text" class="form-control" id="top_content" name="top_content" title='Üst İçerik Girmediniz!' value="" required rows="4" cols="5"><?php echo $viewModel['top_content']; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="title">
                    Popüler Başlık
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" required class="form-control" id="popular_header" name="popular_header" title='Popüler Başlık Girmediniz!' value="<?php echo $viewModel['popular_header']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="content">
                    Üst İçerik
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <textarea type="text" class="form-control" id="popular_content" name="popular_content" title='Popüler İçerik Girmediniz!' value="" required rows="4" cols="5"><?php echo $viewModel['popular_content']; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="title">
                    Alt Başlık
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" required class="form-control" id="bottom_header" name="bottom_header" title='Alt Başlık Girmediniz!' value="<?php echo $viewModel['bottom_header']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="content">
                    Alt İçerik
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <textarea type="text" class="form-control" id="bottom_content" name="bottom_content" title='Alt İçerik Girmediniz!' value="" required rows="4" cols="5"><?php echo $viewModel['bottom_content']; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">
                    Kapak Fotoğrafı
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-9">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="input-append">
                            <div class="uneditable-input">
                                <i class="fa fa-file fileupload-exists"></i>
                                <span class="fileupload-preview"></span>
                            </div>
                            <span class="btn btn-default btn-file">
                                                            <span class="fileupload-exists">Değiştir</span>
                                                            <span class="fileupload-new">Dosya Seç</span>
                                                            <input type="file" name="file-icerik" id="upload-single" accept="image/jpg, image/jpeg, image/png"/>
                                                    </span>
                            <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Kaldır</a>
                        </div>
                        <div>
                            <label id="filename-single"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">
                    Mevcut Kapak Fotoğrafı
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-9">
                    <img class="thmb" id="asd" src="<?php echo $viewModel['photo'];?>" >
                </div>
            </div>


            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />

                    <div class="form-group">
                            <div class="center">
                                <button type="submit" name="submit" class="btn btn-primary">Güncelle</button>
                                    <a href="<?php echo strtolower(get_class($this)).'/schooltype';?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>