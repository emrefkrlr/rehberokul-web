<?php $sm = new SssModel(); ?>

<section class="panel panel-primary">
    <header class="panel-heading">
        <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
        <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/add/'; ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label class="col-md-3 control-label">
                    SSS Yeri
                    <span class="required">*</span>
                </label>
                <div class="col-md-6">
                    <select onchange="set_visible_sss_place()" data-plugin-selectTwo class="form-control populate" required title="SSS Yeri Seçiniz!" data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="sss_place" name="sss_place">
                        <option value="">Seçiniz</option>
                        <option value="anaokulu-kres">Anaokulu ve Kreş</option>
                        <option value="ilk-okul">İlkokul</option>
                        <option value="orta-okul">Ortaokul</option>
                        <option value="lise">Lise</option>
                        <option value="okul-detay">Okul Detay</option>
                        <?php foreach ($viewModel as $landings): ?>
                            <option value="<?= $landings['page_url'] ?>"><?= $landings['page_name'] ?></option>
                        <?php endforeach;?>

                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="question">
                    Soru
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" required class="form-control" id="question" name="question" title='Soru Girmediniz!' value=""/>
                </div>
            </div>

            <div class="form-group" id="sss-connection-div" style="display: none;">
                <label class="col-md-3 control-label">
                    SSS Bağlantısı
                    <span class="required">*</span>
                </label>
                <div class="col-md-6">
                    <select style="width: 100%" data-plugin-selectTwo class="form-control populate" title="SSS Bağlantısı Seçiniz!" data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="sss_connection" name="sss_connection">
                        <option value="">Seçiniz</option>
                        <option value="bagimsiz">Özelliklerden Bağımsız</option>
                        <option value="servis">Servis İmkanı Var</option>
                        <option value="danisman">Danışman İmkanı Var</option>
                        <option value="yas-araligi">Yaş Aralığı</option>
                        <option value="okul-saatleri">Okul Saatleri</option>
                        <?php foreach($sm::$facility_types as $f_type): ?>
                            <option value="<?php echo URLHelper::seflinkGenerator($f_type['name']); ?>"><?php echo $f_type['name'];?></option>
                        <?php endforeach; ?>
                        <?php foreach($sm::$facilities as $facility): ?>
                            <option value="<?php echo $facility['id']; ?>"><?php echo $facility['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group" id="sss-answer-type-div" style="display: none;">
                <label class="col-md-3 control-label">
                    SSS Cevap Türü
                    <span class="required">*</span>
                </label>
                <div class="col-md-6">
                    <select onchange="set_answer_type()" style="width: 100%" data-plugin-selectTwo class="form-control populate" title="SSS Cevap Türü Seçiniz!" data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="sss_answer_type" name="sss_answer_type">
                        <option value="">Seçiniz</option>
                        <option value="manuel">Kendim Yazacağım</option>
                        <option value="otomatik">Otomatik Oluştursun</option>
                    </select>
                </div>
            </div>


            <div class="form-group" id="sss-style-div" style="display: none;">
                <label class="col-md-3 control-label">
                    SSS Cevap Tarzı
                    <span class="required">*</span>
                </label>
                <div class="col-md-6">
                    <select style="width: 100%" data-plugin-selectTwo class="form-control populate" title="SSS Tarzı Seçiniz!" data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="sss_style" name="sss_style">
                        <option value="">Seçiniz</option>
                        <option value="yazi">Düz Yazı</option>
                        <option value="liste">Liste</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="answer">
                    Cevap
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <textarea type="text" class="form-control" id="answer" name="answer" title='Cevap Girmediniz!' value="" required rows="4" cols="5"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="state">
                    Onay Durumu
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select data-plugin-selectTwo class="form-control populate"  data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="state" name="state">
                        <option value="1">Aktif</option>
                        <option value="0">Pasif</option>
                    </select>
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

