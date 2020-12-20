<?php $cm = new CMSModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
        <form class="form-horizontal form-bordered" enctype="multipart/form-data">
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
                    <input type="text" disabled class="form-control"  value="<?php echo $viewModel['top_header']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="content">
                    Üst İçerik
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <textarea type="text" class="form-control" disabled rows="4" cols="5"><?php echo $viewModel['top_content']; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="title">
                    Popüler Başlık
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" disabled class="form-control" value="<?php echo $viewModel['popular_header']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="content">
                    Üst İçerik
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <textarea type="text" class="form-control" disabled rows="4" cols="5"><?php echo $viewModel['popular_content']; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="title">
                    Alt Başlık
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" disabled class="form-control" value="<?php echo $viewModel['bottom_header']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="content">
                    Alt İçerik
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <textarea type="text" class="form-control" disabled rows="4" cols="5"><?php echo $viewModel['bottom_content']; ?></textarea>
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
                                    <a href="<?php echo strtolower(get_class($this)).'/schooltype';?>"><button type="button" class="btn btn-default">Kapat</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>