<?php $sm = new ScholarshipModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
        <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">

        <div class="form-group">
            <h2 class="panel-title center" style="color: #0a0a0a">Sadece Okul ya da Kolej Seç</h2>
        </div>

        <form id="frmPost" class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/scholarshipPost/'; ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label class="col-md-3 control-label" for="city">
                    Okul Seç
                    <span class="required" aria-required="true">*</span>
                </label>

                <div class="col-md-6">
                    <select title="Okul Seçmediniz!"  data-plugin-selectTwo class="form-control populate" name='school_id' id="school_id">
                        <option value="">Seçiniz</option>
                        <option value="0">Boş geç</option>
                        <?php foreach($viewModel['schools'] as $school): ?>
                            <option value="<?php echo $school['id']; ?>"><?php echo $school['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="city">
                    Kolej Seç
                    <span class="required" aria-required="true">*</span>
                </label>

                <div class="col-md-6">
                    <select title="Okul Seçmediniz!"  data-plugin-selectTwo class="form-control populate" name='college_id' id="college_id">
                        <option value="">Seçiniz</option>
                        <option value="0">Boş geç</option>
                        <?php foreach($viewModel['collages'] as $collage): ?>
                            <option value="<?php echo $collage['id']; ?>"><?php echo $collage['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

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
                <label class="col-md-3 control-label" for="title">
                    Sayfa Description
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="page_description" name="page_description"  title='Description Girmediniz!' value="" required />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="title">
                    Yıl Gir
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="year" name="year"  title='Başlık Girmediniz!' value="" required />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="header">
                    Kısa Açıklama
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="header" name="header" title='Açıklama Girmediniz! 140 Karakter Maksimum!' value="" required data-plugin-maxlength maxlength="250"/>
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
                                                            <input type="file" name="file-icerik" id="upload-single"  title="Fotoğraf Seçmediniz!" accept="image/jpg, image/jpeg, image/png"/>
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
                <label class="col-md-3 control-label" for="content">
                    Öncelik
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="number" id="priority" name="priority" min="0" max="999" value="">
                </div>
            </div>

            <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>" />


            <div class="form-group">
                <div class="center">
                    <button type="submit" name="submit" class="btn btn-primary">Kaydet</button>
                    <a href="<?php echo strtolower(get_class($this)).'/scholarship';?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                </div>
            </div>


        </form>

    </div>
</section>

