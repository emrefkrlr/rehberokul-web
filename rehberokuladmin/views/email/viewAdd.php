
<section class="panel panel-primary">
    <header class="panel-heading">
        <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
        <form class="form-horizontal form-bordered" id="email-form" action="<?php echo strtolower(get_class($this)).'/add/'; ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label class="col-md-3 control-label" for="mail_subject">
                    Mail Başlığı
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" required title="Mail Başlığı Girmediniz!" class="form-control" id="mail_subject" name="mail_subject" value=""/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="summernote-email">
                    Mail İçeriği
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <div class="summernote"  id="summernote-email" data-plugin-summernote data-plugin-options='{ "height": 300, "codemirror": { "theme": "ambiance" } }'></div>
                    <input type="hidden" name="content" value="" id="hidden-field" />
                </div>
            </div>


            <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>" />


            <div class="form-group">
                <div class="center">
                    <button type="submit" name="submit" class="btn btn-primary">Kaydet</button>
                    <a href="<?php echo strtolower(get_class($this));?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                </div>
            </div>


        </form>

    </div>
</section>

