
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
            <form class="form-horizontal form-bordered" method="post">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="mail_subject">
                        Mail Başlığı
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" disabled class="form-control" id="mail_subject" name="mail_subject" value="<?php echo $viewModel['title'] ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" for="summernote-email">
                        Mail İçeriği
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9 disable-summernote">
                        <div class="summernote"  id="summernote-email-edit" data-plugin-summernote data-plugin-options='{ "height": 300, "codemirror": { "theme": "ambiance" } }'><?php echo htmlspecialchars_decode($viewModel['content']); ?></div>
                        <input type="hidden" name="content" value="<?php echo $viewModel['content']; ?>" id="hidden-field" />
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