<?php $sm = new SchoolsModel();?>
<section class="panel panel-primary">
    <header class="panel-heading">
        <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
        <form class="form-horizontal form-bordered"  method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-md-3 control-label" for="service">
                    Okul Türü
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select data-plugin-selectTwo class="form-control populate"  disabled data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="school_type" name="school_type">
                        <option value="">Seçiniz</option>
                        <option <?php echo $viewModel['type'] == 2 ? 'selected' : ''; ?> value="2">İlkokul</option>
                        <option <?php echo $viewModel['type'] == 3 ? 'selected' : ''; ?> value="3">Ortaokul</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="school_name">
                    Okul Adı
                    <span class="required">*</span>
                </label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="school_name" name="school_name" value="<?php echo $viewModel['name']; ?>" disabled/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="school_email">
                    Okula Ait E-Posta
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <input type="mail" class="form-control" id="school_email" name="school_email" disabled value="<?php echo $viewModel['school_email']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="phone">
                    Telefon
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $viewModel['phone']; ?>" disabled/>
                </div>
            </div>

            <div class="form-group <?php echo $_SESSION['user_data']['role'] != 'Yönetici' ? 'hide' : '';?>">
                <label class="col-md-3 control-label" for="priority">
                    Priority
                    <span class="required" aria-required="true"></span>
                </label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="priority" name="priority" disabled value="<?php echo $viewModel['priority']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="contact_email">
                    İletişim E-Posta
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <input type="email" class="form-control"  id="contact_email" name="contact_email" value="<?php echo $viewModel['contact_email']; ?>" disabled/>
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-3 control-label" for="city">
                    Bulunduğu Şehir
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select disabled onchange="set_towns()" data-plugin-selectTwo class="form-control populate" name='city' id="city">
                        <option value="">Seçiniz</option>
                        <?php foreach($sm::$cities as $cits): ?>
                            <option <?php echo $viewModel['sehir_key'] == $cits['sehir_key'] ? 'selected' : '' ?> value="<?php echo $cits['sehir_key']; ?>"><?php echo $cits['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="town">
                    Bulunduğu İlçe
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select onchange="set_subtowns()" data-plugin-selectTwo disabled class="form-control populate" name='town' id="town">
                        <option value="">Seçiniz</option>
                        <?php foreach($sm::$towns as $town): ?>
                            <option <?php echo $viewModel['ilce_key'] == $town['ilce_key'] ? 'selected' : '' ?> value="<?php echo $town['ilce_key']; ?>"><?php echo $town['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="subtown">
                    Bulunduğu Mahalle
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select data-plugin-selectTwo disabled class="form-control populate" name='subtown' id="subtown">
                        <option value="">Seçiniz</option>
                        <?php foreach($sm::$subtowns as $subtown): ?>
                            <option <?php echo $viewModel['mahalle_key'] == $subtown['mahalle_key'] ? 'selected' : '' ?> value="<?php echo $subtown['mahalle_key']; ?>"><?php echo $subtown['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="address">
                    Açık Adres
                    <span class="required">*</span>
                </label>
                <div class="col-md-6">
                    <input type="text"  class="form-control" id="address" name="address" value="<?php echo $viewModel['address']; ?>" disabled/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="tax_no">
                    Vergi Numarası
                    <span class="required" aria-required="true"></span>
                </label>
                <div class="col-md-6">
                    <input type="text" disabled class="form-control" id="tax_no" name="tax_no" value="<?php echo $viewModel['tax_no']; ?>" pattern="[0-9]{10,11}$" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="quota">
                    Sınıf Mevcutu
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="quota" name="quota" value="<?php echo $viewModel['class_quota']; ?>" disabled/>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">Okul Saatleri
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">

                    <div class="input-group input-group-icon">
                            <span class="input-group-addon">
                                <span class="icon">Pzt Başlangıç</span>
                            </span>
                        <input style="margin-left: 110px; width: 100px;" value="<?php echo $sm::$school_hours['monday_start'];?>" disabled name="monday_start" id="monday_start"  type="text" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false }'>

                        <span class="input-group-addon">
                                <span class="icon">Pzt Bitiş</span>
                            </span>
                        <input style="margin-left: 80px; width: 100px;" value="<?php echo $sm::$school_hours['monday_end'];?>" disabled name="monday_end" id="monday_end" type="text" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false }'>
                    </div>
                    <div class="input-group input-group-icon">
                                <span class="input-group-addon">
                                    <span class="icon">Sal Başlangıç</span>
                                </span>
                        <input style="margin-left: 110px; width: 100px;" value="<?php echo $sm::$school_hours['tuesday_start'];?>" disabled name="tuesday_start" id="tuesday_start" type="text" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false }'>

                        <span class="input-group-addon">
                                    <span class="icon">Sal Bitiş</span>
                                </span>
                        <input style="margin-left: 80px; width: 100px;" value="<?php echo $sm::$school_hours['tuesday_end'];?>" disabled name="tuesday_end" id="tuesday_end" type="text" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false }'>
                    </div>
                    <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon">Çrş Başlangıç</span>
                                    </span>
                        <input style="margin-left: 110px; width: 100px;" value="<?php echo $sm::$school_hours['wednesday_start'];?>" disabled name="wednesday_start" id="wednesday_start" type="text" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false }'>

                        <span class="input-group-addon">
                                        <span class="icon">Çrş Bitiş</span>
                                    </span>
                        <input style="margin-left: 80px; width: 100px;" value="<?php echo $sm::$school_hours['wednesday_end'];?>" disabled name="wednesday_end" id="wednesday_end" type="text" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false }'>
                    </div>
                    <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon">Prş Başlangıç</span>
                                    </span>
                        <input style="margin-left: 110px; width: 100px;" value="<?php echo $sm::$school_hours['thursday_start'];?>" disabled name="thursday_start" id="thursday_start" type="text" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false }'>

                        <span class="input-group-addon">
                                        <span class="icon">Prş Bitiş</span>
                                    </span>
                        <input style="margin-left: 80px; width: 100px;" value="<?php echo $sm::$school_hours['thursday_end'];?>" disabled name="thursday_end" id="thursday_end"  type="text" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false }'>
                    </div>
                    <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon">Cum Başlangıç</span>
                                    </span>
                        <input style="margin-left: 110px; width: 100px;" value="<?php echo $sm::$school_hours['friday_start'];?>" disabled name="friday_start" id="friday_start" type="text" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false }'>

                        <span class="input-group-addon">
                                        <span class="icon">Cum Bitiş</span>
                                    </span>
                        <input  style="margin-left: 80px; width: 100px;" value="<?php echo $sm::$school_hours['friday_end'];?>" disabled name="friday_end" id="friday_end" type="text" data-plugin-timepicker class="form-control" data-plugin-options='{ "showMeridian": false }'>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="counselor">
                    Psikolojik Danışman
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select data-plugin-selectTwo class="form-control populate"  disabled data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="counselor" name="counselor">
                        <option value="">Seçiniz</option>
                        <option value="1" <?php echo $viewModel['counselor'] == 1 ? 'selected' : ''; ?>>Var</option>
                        <option value="0" <?php echo $viewModel['counselor'] == 0 ? 'selected' : ''; ?>>Yok</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="service">
                    Servis
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select data-plugin-selectTwo class="form-control populate"  disabled data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="service" name="service">
                        <option value="">Seçiniz</option>
                        <option value="1" <?php echo $viewModel['transportation'] == 1 ? 'selected' : ''; ?>>Var</option>
                        <option value="0" <?php echo $viewModel['transportation'] == 0 ? 'selected' : ''; ?>>Yok</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="facs">
                    İmkanlar
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select disabled data-plugin-selectTwo class="form-control populate" multiple="multiple" data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="facs" name="facs[]">

                        <?php foreach($sm::$facility_types as $types): ?>
                            <optgroup label="<?php echo $types['name'] ?>">
                                <?php foreach($sm::$facilities as $facs): ?>
                                    <?php if($facs['type']==$types['id']): ?>
                                        <option value="<?php echo $facs['id']; ?>" <?php  foreach($sm::$school_facilities as $sfacility) { echo $facs['id'] == $sfacility['facility_id']  ? 'selected' : '';}?> >
                                            <?php echo $facs['name'];?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endforeach; ?>

                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="summernote-kinder">
                    Okul Hakkında Detay
                    <span class="required" aria-required="true"></span>
                </label>
                <div class="col-md-6 disable-summernote">
                    <div class="summernote"  id="summernote-kinder" data-plugin-summernote data-plugin-options='{ "height": 300, "codemirror": { "theme": "ambiance" } }'>
                        <?php echo htmlspecialchars_decode($viewModel['description']); ?>
                    </div>
                    <input type="hidden" name="content" id="hidden-field" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="servc">
                    Servis Bölgeleri
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select disabled data-plugin-selectTwo class="form-control populate" multiple="multiple" data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="servc" name="servc[]">
                        <?php foreach($sm::$towns as $town): ?>
                            <option value="<?php echo $town['ilce_key']; ?>" <?php  foreach($sm::$transportation_points as $tpoints) { echo $town['ilce_key'] == $tpoints['ilce_key']  ? 'selected' : '';}?>><?php echo $town['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="price">
                    Ortalama Ücret(Aylık)
                </label>
                <div class="col-md-6">
                    <input disabled type="text" class="form-control" id="price" name="price" pattern="[0-9]*"  title='Sadece Rakam Kullanılabilir!' value="<?php echo $viewModel['price']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="discount">
                    Rehberokul Üyelerine İndirim
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select data-plugin-selectTwo class="form-control populate" disabled data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="discount" name="discount">
                        <option value="">Seçiniz</option>
                        <option value="1" <?php echo $viewModel['discount']=='1' ? 'selected' : '';?>>Yapacağım</option>
                        <option value="2" <?php echo $viewModel['discount']=='2' ? 'selected' : '';?>>Yapmayacağım</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="city">
                    Fotoğraf Galerisi
                </label>
                <div class="col-md-6">
                    <select disabled data-plugin-selectTwo class="form-control populate" name='gallery' id="gallery">
                        <option value="">Seçiniz</option>
                        <?php foreach($sm::$galleries as $gals): ?>
                            <option value="<?php echo $gals['id']; ?>" <?php echo $sm::$school_galleries['gallery_id'] == $gals['id'] ? 'selected' : ''; ?>><?php echo $gals['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group <?php echo $_SESSION['user_data']['role'] != 'Yönetici' ? 'hide' : '';?>">
                <label class="col-md-3 control-label" for="executive">
                    Kurum Sahibi
                    <span class="required" aria-required="true"><?php echo $_SESSION['user_data']['role'] == 'Yönetici' ? '*' : '';?></span>
                </label>
                <div class="col-md-6">
                    <select disabled data-plugin-selectTwo class="form-control populate" name='owner' id="owner">
                        <option value="">Seçiniz</option>
                        <?php foreach($sm::$users as $u): ?>
                            <option value="<?php echo $u['id']; ?>"  <?php echo $sm::$school_owner['user_id'] == $u['id'] ? 'selected' : ''; ?>><?php echo $u['first_name'].' '.$u['last_name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="facebook">
                    Facebook
                </label>
                <div class="col-md-6">
                    <input disabled type="text" class="form-control" id="facebook" name="facebook" value="<?php echo $viewModel['facebook']; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="twitter">
                    Twitter
                </label>
                <div class="col-md-6">
                    <input disabled type="text" class="form-control" id="twitter" name="twitter" value="<?php echo $viewModel['twitter']; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="instagram">
                    İnstagram
                </label>
                <div class="col-md-6">
                    <input disabled type="text" class="form-control" id="instagram" name="instagram" value="<?php echo $viewModel['instagram']; ?>" />
                </div>
            </div>

            <div class="form-group <?php echo $_SESSION['user_data']['role'] != 'Yönetici' ? 'hide' : '';?>">
                <label class="col-md-3 control-label" for="approve">
                    Onay Durumu
                    <span class="required" aria-required="true"></span>
                </label>
                <div class="col-md-6">
                    <select disabled data-plugin-selectTwo class="form-control populate" data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="approve" name="approve">
                        <option value="">Seçiniz</option>
                        <option <?php echo $viewModel['state'] == 2 ? 'selected' : ''; ?> value="2">Onaylandı</option>
                        <option <?php echo $viewModel['state'] == 3 ? 'selected' : ''; ?> value="3">Pasife Çekildi</option>
                    </select>
                </div>
            </div>

            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />


            <div class="form-group">
                <div class="center">
                    <a href="<?php echo strtolower(get_class($this)).'/middle';?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                </div>
            </div>


        </form>

    </div>
</section>