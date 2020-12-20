<?php $dm = new DemandModel();
function str_replace_first($from, $to, $content)
{
    $from = '/'.preg_quote($from, '/').'/';

    return preg_replace($from, $to, $content, 1);
}?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
        <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/addDemand/'.$viewModel['link']; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-md-3 control-label" for="full_name">
                    İsim
                    <span class="required">*</span>
                </label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $dm->getUser($viewModel['user_id'])['first_name'].' '.$dm->getUser($viewModel['user_id'])['last_name']; ?>" disabled/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="email">
                    Email
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <input type="mail" class="form-control" id="email" name="email" disabled value="<?php echo $dm->getUser($viewModel['user_id'])['email']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="phone">
                    Telefon
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="phone" name="phone" disabled value="<?php echo $dm->getUser($viewModel['user_id'])['phone']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="city">
                    Şehir
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select required title="Şehir Seçmediniz!" onchange="set_towns()" data-plugin-selectTwo class="form-control populate" name='city' id="city">
                        <option value="">Seçiniz</option>
                        <?php foreach($dm::$cities as $cits): ?>
                            <option <?php echo $viewModel['sehir_key'] == $cits['sehir_key'] ? 'selected' : '' ?> value="<?php echo $cits['sehir_key']; ?>"><?php echo $cits['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="town">
                    İlçe
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select onchange="set_subtowns()" data-plugin-selectTwo required title="İlçe Seçmediniz!" class="form-control populate" name='town' id="town">
                        <option value="">Seçiniz</option>
                        <?php foreach($dm::$towns as $town): ?>
                            <option <?php echo $viewModel['ilce_key'] == $town['ilce_key'] ? 'selected' : '' ?> value="<?php echo $town['ilce_key']; ?>"><?php echo $town['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="subtown">
                    Mahalle
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select data-plugin-selectTwo required title="Mahalle Seçmediniz!" class="form-control populate" name='subtown' id="subtown">
                        <option value="">Seçiniz</option>
                        <?php foreach($dm::$subtowns as $subtown): ?>
                            <option <?php echo $viewModel['mahalle_key'] == $subtown['mahalle_key'] ? 'selected' : '' ?> value="<?php echo $subtown['mahalle_key']; ?>"><?php echo $subtown['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="price">
                    Fiyat Aralığı
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select data-plugin-selectTwo required title="Fiyat Aralığı Seçmediniz!" class="form-control populate" name='price' id="price">
                        <option value="">Seçiniz</option>
                        <option value="500 TL - 1500 TL">500 TL - 1500 TL</option>
                        <option value="1500 TL - 3000 TL">1500 TL - 3000 TL</option>
                        <option value="3000 TL - 5000 TL">3000 TL - 5000 TL</option>
                        <option value="5000 TL - 10000 TL">5000 TL - 10000 TL</option>
                        <option value="10000 TL - 20000 TL">10000 TL - 20000 TL</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="age">
                    Yaş
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="age" name="age" value="" pattern="[0-9]*"  title='Yaş İçin Sadece Rakam Kullanılabilir!' required/>
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-3 control-label" for="school_type">
                    Okul Türü
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select data-plugin-selectTwo onchange="set_classes()" required title="Okul Türünü Seçmediniz!" class="form-control populate" name='school_type' id="school_type">
                        <option value="">Seçiniz</option>
                        <option value="1">Anaokulu veya Kreş</option>
                        <option value="2">İlkokul</option>
                        <option value="3">Ortaokul</option>
                        <option value="4">Lise</option>
                    </select>
                </div>
            </div>


            <div class="form-group" id="classroom_div_ilkokul" style="display: none;">
                <label class="col-md-3 control-label" for="classroom_ilkokul">
                    Sınıf
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select style="width: 415px;" data-plugin-selectTwo title="Sınıf Seçmediniz!" class="form-control populate" name='classroom_ilkokul' id="classroom_ilkokul">
                        <option value="">Seçiniz</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
            </div>

            <div class="form-group" id="classroom_div_ortaokul" style="display: none;">
                <label class="col-md-3 control-label" for="classroom_ortaokul">
                    Sınıf
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select style="width: 415px;" data-plugin-selectTwo title="Sınıf Seçmediniz!" class="form-control populate" name='classroom_ortaokul' id="classroom_ortaokul">
                        <option value="">Seçiniz</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                </div>
            </div>

            <div class="form-group" id="classroom_div_lise" style="display: none;">
                <label class="col-md-3 control-label" for="classroom_lise">
                    Sınıf
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select style="width: 415px;" data-plugin-selectTwo title="Sınıf Seçmediniz!" class="form-control populate" name='classroom_lise' id="classroom_lise">
                        <option value="">Seçiniz</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="quota">
                    Kota
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select data-plugin-selectTwo required title="Kota Seçmediniz!" class="form-control populate" name='quota' id="quota">
                        <option value="">Seçiniz</option>
                        <option value="Sınır Yok">Sınır Yok</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="note">
                    Not
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <textarea class="form-control" id="note" name="note" required title="Not Girmediniz!" value="" rows="4" cols="5"><?php echo $viewModel['note']; ?></textarea>
                </div>
            </div>

            <div class="form-group <?php echo $_SESSION['user_data']['role'] != 'Yönetici' ? 'hide' : '';?>">
                <label class="col-md-3 control-label" for="state">
                    Onay Durumu
                    <span class="required" aria-required="true"></span>
                </label>
                <div class="col-md-6">
                    <select data-plugin-selectTwo class="form-control populate" data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="state" name="state">
                        <option value="">Seçiniz</option>
                        <option <?php echo $viewModel['state'] == 1 ? 'selected' : ''; ?> value="1">Onaylandı Olarak Belirle</option>
                        <option <?php echo $viewModel['state'] == 2 ? 'selected' : ''; ?> value="2">Karşılandı Olarak Belirle</option>
                    </select>
                </div>
            </div>

            
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />

                    <div class="form-group">
                            <div class="center">
                                <button type="submit" name="submit" class="btn btn-primary">Kaydet</button>
                                    <a href="<?php echo strtolower(get_class($this)).'/spesific';?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>