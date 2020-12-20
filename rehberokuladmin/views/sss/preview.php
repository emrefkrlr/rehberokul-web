<?php $sm = new SssModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
            <form class="form-horizontal form-bordered" method="post">

                <div class="form-group">
                    <label class="col-md-3 control-label" for="question">
                        Soru
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" disabled class="form-control" id="question" name="question" value="<?php echo $viewModel['question']; ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">
                        Okul Seçiniz
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <select style="width: 100%" onchange="preview_answer('<?php echo $viewModel['link'];?>','<?php echo $viewModel['sss_connection'];?>')" data-plugin-selectTwo class="form-control populate" required title="Lütfen Okul Seçiniz!" data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="school" name="school">
                            <option value="">Seçiniz</option>
                            <?php foreach($sm::$schools as $school): ?>
                                <option value="<?php echo $school['id']; ?>"><?php echo $school['name'];?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">
                        SSS Cevap Tarzı
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <select style="width: 100%" data-plugin-selectTwo class="form-control populate" disabled data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="sss_style" name="sss_style">
                            <option value="">Seçiniz</option>
                            <option <?php echo $viewModel['sss_style'] == 'yazi' ? 'selected' : ''?> value="yazi">Düz Yazı</option>
                            <option <?php echo $viewModel['sss_style'] == 'liste' ? 'selected' : ''?> value="liste">Liste</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" for="summernote-answer">
                        Cevap
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <div class="summernote"  id="summernote-answer" data-plugin-summernote data-plugin-options='{ "height": 300, "codemirror": { "theme": "ambiance" } }'>

                        </div>
                        <input type="hidden" name="content" value="" id="hidden-field" />
                    </div>
                </div>


                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />

                    <div class="form-group">
                            <div class="center">
                                <a href="<?php echo strtolower(get_class($this));?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>