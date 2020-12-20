<?php $pm = new BlogModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
        <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
        <form id="frmPost" class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/add/'; ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label class="col-md-3 control-label" for="title">
                    Başlık
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="title" name="title"  title='Başlık Girmediniz!' value="" required />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="description">
                    Seo Açıklama
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="description" name="description" title='Açıklama Girmediniz! 140 Karakter Maksimum!' value="" required data-plugin-maxlength maxlength="250"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">
                    Fotoğraf
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
                                                            <input type="file" name="file-icerik" id="upload-single" required title="Fotoğraf Seçmediniz!" accept="image/jpg, image/jpeg, image/png"/>
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
                <label class="col-md-3 control-label" for="summernote">
                    İçerik
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-9">
                    <div class="summernote"  id="summernote-post" data-plugin-summernote data-plugin-options='{ "height": 300, "codemirror": { "theme": "ambiance" } }'></div>
                    <input type="hidden" name="content" id="hidden-field" />
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-3 control-label">
                    Yayınlanma Tarihi
                    <span class="required">*</span>
                </label>
                <div class="col-md-6">
                    <div class="input-group">
                                            <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                            </span>
                        <input type="text" name="publish_date" id="publish_date" required title="Yayınlanma Tarihi Girmediniz!" data-plugin-datepicker data-plugin-options='{ "startDate": "+0d", "language":"tr", "format":"yyyy-mm-dd" }' class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label">
                    Kategori
                    <span class="required">*</span>
                </label>
                <div class="col-md-6">
                    <select data-plugin-selectTwo class="form-control populate" multiple="multiple" required title="Etiket Seçiniz!" data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="tagss" name="tagss[]">
                        <?php foreach(BlogModel::$tags as $tag): ?>
                            <option value="<?php echo $tag['id']; ?>"><?php echo $tag['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>





            <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>" />


            <div class="form-group">
                <div class="center">
                    <button type="submit" name="submit" class="btn btn-primary">Kaydet</button>
                    <a href="<?php echo strtolower(get_class($this)).'/post';?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                </div>
            </div>


        </form>

    </div>
</section>

