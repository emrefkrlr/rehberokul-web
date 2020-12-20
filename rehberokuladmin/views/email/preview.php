<?php $em = new EmailModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
            <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/sendTest/'; ?>" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label class="col-md-3 control-label" for="test_email">
                        E-Posta Adresi
                        <span class="required" aria-required="true">*</span>
                    </label>
                    <div class="col-md-6">
                        <input type="mail" class="form-control" id="test_email" name="test_email" pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$" required title="Hatalı Email!" value=""/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" for="mail_subject">
                        Mail Başlığı
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="mail_subject" name="mail_subject" value="<?php echo $viewModel['title'] ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" for="summernote-email">
                        Mail İçeriği
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <div class="summernote"  id="summernote-email-edit" data-plugin-summernote data-plugin-options='{ "height": 300, "codemirror": { "theme": "ambiance" } }'><?php echo htmlspecialchars_decode($viewModel['content']); ?></div>
                        <input type="hidden" name="content" value="<?php echo $viewModel['content']; ?>" id="hidden-field" />
                    </div>
                </div>


                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />

                    <div class="form-group">
                            <div class="center">
                                <button type="submit" name="submit" class="btn btn-primary">Gönder</button>
                                <a href="<?php echo strtolower(get_class($this));?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>