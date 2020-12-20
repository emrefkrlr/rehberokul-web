<?php $ld = new LandingsModel() ?>
<section class="panel panel-primary">
    <header class="panel-heading">
        <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
        <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/landingEdit/'.$viewModel['id']; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-md-3 control-label" for="title">
                    Bölge İsmi
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" disabled class="form-control" id="page_name" value="<?php echo $viewModel['page_name']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="title">
                    Bölge Linki
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" disabled class="form-control" id="page_url" value="<?php echo $viewModel['page_url']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="title">
                    Sayfa Title
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" required class="form-control" id="page_title" name="page_title" title='Üst Başlık Girmediniz!' value="<?php echo $viewModel['page_title']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="title">
                    Sayfa Description
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" required class="form-control" id="page_description" name="page_description" title='Üst Başlık Girmediniz!' value="<?php echo $viewModel['page_description']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="content">
                    Header İçerik
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <textarea type="text" class="form-control" id="header_content" name="header_content" title='Üst İçerik Girmediniz!' value="" required rows="4" cols="5"><?php echo $viewModel['header_content']; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="content">
                    Landing İçerik
                    <span class="required">*</span>
                </label>

                <div class="col-md-9">
                    <div class="summernote"  id="summernote-post" data-plugin-summernote data-plugin-options='{ "height": 300, "codemirror": { "theme": "ambiance" } }'>
                        <?php echo htmlspecialchars_decode($viewModel['landing_content']); ?>
                    </div>
                    <input type="hidden" name="landing_content" value="<?php echo $viewModel['landing_content']; ?>" id="hidden-field" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="title">
                    Sorgu
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" required class="form-control" id="query" name="query" title='Alt Başlık Girmediniz!' value="<?php echo $viewModel['query']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="content">
                    Öncelik
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="number" id="priority" name="priority" min="0" max="999" value="<?php echo $viewModel['priority'] ?>">
                </div>
            </div>


            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />

            <div class="form-group">
                <div class="center">
                    <button type="submit" name="submit" class="btn btn-primary">Güncelle</button>
                    <a href="<?php echo strtolower(get_class($this)).'/landings';?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                </div>
            </div>


        </form>

    </div>
</section>