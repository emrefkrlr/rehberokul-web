<?php $nm = new NotificationModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
        <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
        <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/add/'; ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label class="col-md-3 control-label" for="title">
                    Başlık
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" required class="form-control" id="title" name="title" title='Başlık Girmediniz!' value=""/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="answer">
                    Bildiri
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <textarea type="text" class="form-control" id="content" name="content" title='Bildiri Girmediniz!' value="" required rows="4" cols="5"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="send_type">
                    Gönderim Türü
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select required title="Gönderim Türünü Seçmediniz!" onchange="visible_notification()" data-plugin-selectTwo class="form-control populate"  data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="send_type" name="send_type">
                        <option value="">Seçiniz</option>
                        <option value="1">Toplu Gönderim</option>
                        <option value="2">Özel Gönderim</option>
                    </select>
                </div>
            </div>

            <div class="form-group" id="send_to_multi_div" style="display: none;">
                <label class="col-md-3 control-label" for="send_to">
                    Kimlere Gönderilecek
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select title="Kime Gönderileceğini Seçmediniz!" style="width: 415px;" data-plugin-selectTwo class="form-control populate"  data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="send_to_multi" name="send_to_multi">
                        <option value="">Seçiniz</option>
                        <option value="1">Velilere</option>
                        <option value="2">Kurum Sahiplerine</option>
                    </select>
                </div>
            </div>

            <div class="form-group" id="send_to_single_div" style="display: none;">
                <label class="col-md-3 control-label" for="send_to">
                    Kimlere Gönderilecek
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select title="Kime Gönderileceğini Seçmediniz!" multiple style="width: 415px;" data-plugin-selectTwo class="form-control populate"  data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="send_to_single" name="send_to[]">
                        <option value="">Seçiniz</option>
                        <?php foreach($nm::$users as $user): ?>
                            <option value="<?php echo $user['id']; ?>"><?php echo $user['first_name'].' '.$user['last_name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>


            <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']; ?>" />


            <div class="form-group">
                <div class="center">
                    <button type="submit" name="submit" class="btn btn-primary">Gönder</button>
                    <a href="<?php echo strtolower(get_class($this));?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                </div>
            </div>


        </form>

    </div>
</section>

