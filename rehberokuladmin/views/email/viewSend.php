
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
        <form class="form-horizontal form-bordered" id="email-form" action="<?php echo strtolower(get_class($this)).'/sendAll/'; ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label class="col-md-3 control-label" for="send_to_multi">
                    Kimlere Gönderilecek
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select required title="Kime Gönderileceğini Seçmediniz!" style="width: 100%;" data-plugin-selectTwo class="form-control populate"  data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="send_to_multi" name="send_to_multi">
                        <option value="">Seçiniz</option>
                        <option value="1">Velilere</option>
                        <option value="2">Kurum Sahiplerine</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="mail_subject">
                    Mail Başlığı
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" required title="Mail Başlığı Girmediniz!" class="form-control" id="mail_subject" name="mail_subject" value="<?php echo $viewModel['title'] ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="summernote-email">
                    Mail İçeriği
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <div class="summernote"  id="summernote-email" data-plugin-summernote data-plugin-options='{ "height": 300, "codemirror": { "theme": "ambiance" } }'><?php echo htmlspecialchars_decode($viewModel['content']); ?></div>
                    <input type="hidden" name="content" value="<?php echo $viewModel['content']; ?>" id="hidden-field" />
                </div>
            </div>


            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />

                    <div class="form-group">
                            <div class="center">
                                <button type="submit" name="submit" class="btn btn-primary">Gönder</button>
                                    <a href="<?php echo strtolower(get_class($this));?>"><button type="button" class="btn btn-default">Kapat</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>