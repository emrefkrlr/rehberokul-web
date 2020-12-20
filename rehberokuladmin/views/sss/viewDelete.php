<?php $sm = new SssModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
            <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/delete/'.$viewModel['link']; ?>" method="post">
                <div class="form-group">
                    <label class="col-md-3 control-label">
                        SSS Yeri
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <select onchange="set_visible_sss_place()" data-plugin-selectTwo class="form-control populate" disabled data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="sss_place" name="sss_place">
                            <option value="">Seçiniz</option>
                            <option <?php echo $viewModel['sss_place'] == 'anaokulu-kres' ? 'selected' : ''?> value="anaokulu-kres">Anaokulu ve Kreş</option>
                            <option <?php echo $viewModel['sss_place'] == 'ilk-okul' ? 'selected' : ''?> value="ilk-okul">İlkokul</option>
                            <option <?php echo $viewModel['sss_place'] == 'orta-okul' ? 'selected' : ''?> value="orta-okul">Ortaokul</option>
                            <option <?php echo $viewModel['sss_place'] == 'lise' ? 'selected' : ''?> value="lise">Lise</option>
                            <option <?php echo $viewModel['sss_place'] == 'okul-detay' ? 'selected' : ''?> value="okul-detay">Okul Detay</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" for="question">
                        Soru
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" disabled class="form-control" id="question" name="question" value="<?php echo $viewModel['question']; ?>"/>
                    </div>
                </div>

                <div class="form-group" id="sss-connection-div" <?php echo $viewModel['sss_place'] == 'okul-detay' ? '' : 'style="display: none;"'?>>
                    <label class="col-md-3 control-label">
                        SSS Bağlantısı
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <select style="width: 100%" data-plugin-selectTwo class="form-control populate" disabled data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="sss_connection" name="sss_connection">
                            <option value="">Seçiniz</option>
                            <option <?php echo $viewModel['sss_connection'] == 'bagimsiz' ? 'selected' : ''?> value="bagimsiz">Özelliklerden Bağımsız</option>
                            <option <?php echo $viewModel['sss_connection'] == 'servis' ? 'selected' : ''?> value="servis">Servis İmkanı Var</option>
                            <option <?php echo $viewModel['sss_connection'] == 'danisman' ? 'selected' : ''?> value="danisman">Danışman İmkanı Var</option>
                            <option <?php echo $viewModel['sss_connection'] == 'yas-araligi' ? 'selected' : ''?> value="yas-araligi">Yaş Aralığı</option>
                            <option <?php echo $viewModel['sss_connection'] == 'okul-saatleri' ? 'selected' : ''?> value="okul-saatleri">Okul Saatleri</option>
                            <?php foreach($sm::$facility_types as $f_type): ?>
                                <option value="<?php echo URLHelper::seflinkGenerator($f_type['name']); ?>" <?php echo $viewModel['sss_connection'] == URLHelper::seflinkGenerator($f_type['name']) ? 'selected' : ''?>><?php echo $f_type['name'];?></option>
                            <?php endforeach; ?>
                            <?php foreach($sm::$facilities as $facility): ?>
                                <option value="<?php echo $facility['id']; ?>" <?php echo $viewModel['sss_connection'] == $facility['id'] ? 'selected' : ''?>><?php echo $facility['name'];?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group" id="sss-answer-type-div" <?php echo $viewModel['sss_place'] == 'okul-detay' ? '' : 'style="display: none;"'?>>
                    <label class="col-md-3 control-label">
                        SSS Cevap Türü
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <select onchange="set_answer_type()" style="width: 100%" data-plugin-selectTwo class="form-control populate" disabled data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="sss_answer_type" name="sss_answer_type">
                            <option value="">Seçiniz</option>
                            <option <?php echo $viewModel['sss_answer_type'] == 'manuel' ? 'selected' : ''?> value="manuel">Kendim Yazacağım</option>
                            <option <?php echo $viewModel['sss_answer_type'] == 'otomatik' ? 'selected' : ''?> value="otomatik">Otomatik Oluştursun</option>
                        </select>
                    </div>
                </div>


                <div class="form-group" id="sss-style-div" <?php echo $viewModel['sss_answer_type'] == 'otomatik' ? '' : 'style="display: none;"'?>>
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
                    <label class="col-md-3 control-label" for="answer">
                        Cevap
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <textarea type="text" class="form-control" id="answer" name="answer" disabled value="" rows="4" cols="5"><?php echo $viewModel['answer'];?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" for="state">
                        Onay Durumu
                        <span class="required" aria-required="true">*</span>
                    </label>
                    <div class="col-md-6">
                        <select disabled data-plugin-selectTwo class="form-control populate"  data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="state" name="state">
                            <option <?php echo $viewModel['state'] == 1 ? 'selected' : '';?> value="1">Aktif</option>
                            <option <?php echo $viewModel['state'] == 0 ? 'selected' : '';?> value="2">Pasif</option>
                        </select>
                    </div>
                </div>
                
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />

                    <div class="form-group">
                            <div class="center">
                                <input type="submit" name="submit" class="btn btn-danger" value="Sil"/>
                                <a href="<?php echo strtolower(get_class($this));?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>