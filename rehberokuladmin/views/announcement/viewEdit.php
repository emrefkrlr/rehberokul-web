<?php $am = new AnnouncementModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
        <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/edit/'.$viewModel['link']; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-md-3 control-label" for="school">
                    Okul
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select required title="Okul Seçmediniz!" multiple data-plugin-selectTwo class="form-control populate" id="school" name='school[]'>
                        <option value="">Seçiniz</option>
                        <?php foreach($am::$ownerSchools as $school): ?>
                            <option value="<?php echo $school['id']; ?>" <?php  foreach($am::$announcementSchools as $announcementSchool) { echo $school['id'] == $announcementSchool['school_id']  ? 'selected' : '';}?>><?php echo $school['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="title">
                    Başlık
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" required class="form-control" id="title" name="title" title='Başlık Girmediniz!' value="<?php echo $viewModel['title']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="content">
                    İçerik
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <textarea type="text" class="form-control" id="content" name="content" title='İçerik Girmediniz!' value="" required rows="4" cols="5"><?php echo $viewModel['content']; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="end_date">
                    Bitiş Tarihi
                    <span class="required">*</span>
                </label>
                <div class="col-md-6">
                    <div class="input-group">
                                            <span class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                            </span>
                        <input type="text" name="end_date" value="<?php $date = new DateTime($viewModel['end_date']); echo $date->format('Y-m-d'); ?>" id="end_date" required title="Bitiş Tarihi Girmediniz!" data-plugin-datepicker data-plugin-options='{ "startDate": "+0d", "language":"tr", "format":"yyyy-mm-dd" }' class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="state">
                    Onay Durumu
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select data-plugin-selectTwo class="form-control populate"  data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="state" name="state">
                        <option <?php echo $viewModel['state'] == 1 ? 'selected' : ''; ?> value="1">Aktif</option>
                        <option <?php echo $viewModel['state'] == 0 ? 'selected' : ''; ?> value="0">Pasif</option>
                    </select>
                </div>
            </div>


            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />

                    <div class="form-group">
                            <div class="center">
                                <button type="submit" name="submit" class="btn btn-primary">Güncelle</button>
                                    <a href="<?php echo strtolower(get_class($this));?>"><button type="button" class="btn btn-default">Kapat</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>