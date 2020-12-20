<?php $pm = new BlogModel();?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
            <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/delete/'.$viewModel['link']; ?>" method="post">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="title">
                        Başlık
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="title" name="title"  disabled value="<?php echo $viewModel['title']; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" for="description">
                        Seo Açıklama
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="description" name="description" disabled value="<?php echo $viewModel['description']; ?>"  data-plugin-maxlength maxlength="140"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">
                        Mevcut Fotoğraf
                        <span class="required" aria-required="true">*</span>
                    </label>
                    <div class="col-md-9">
                        <img class="thmb" id="asd" src="<?php echo $viewModel['photo'];?>" >
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-3 control-label" for="summernote">
                        İçerik
                        <span class="required" aria-required="true">*</span>
                    </label>
                    <div class="col-md-9 disable-summernote">
                        <div class="summernote"  id="summernote" data-plugin-summernote data-plugin-options='{ "height": 300, "codemirror": { "theme": "ambiance" } }'>
                            <?php echo htmlspecialchars_decode($viewModel['content']); ?>
                        </div>
                        <input type="hidden" name="content" value="<?php echo $viewModel['content']; ?>" id="hidden-field" />
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-3 control-label">
                        Yayınlanma Tarihi
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <div class="input-group">
                        <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                        </span>
                            <input type="text" value="<?php $date = new DateTime($viewModel['publish_date']); echo $date->format('Y-m-d'); ?>" name="publish_date" id="publish_date" disabled data-plugin-datepicker data-plugin-options='{ "startDate": "+0d", "language":"tr", "format":"yyyy-mm-dd" }' class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">
                        Kategori
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6">
                        <select disabled data-plugin-selectTwo class="form-control populate" multiple="multiple"  data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="tagss" name="tagss[]">
                            <?php foreach(BlogModel::$tags as $tag): ?>
                                <option value="<?php echo $tag['id']; ?>" <?php  foreach($pm::$blog_tags as $btag) { echo $tag['id'] == $btag['tag_id']  ? 'selected' : '';}?>>
                                    <?php echo $tag['name'];?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />

                    <div class="form-group">
                            <div class="center">
                                <input type="submit" name="submit" class="btn btn-danger" value="Sil"/>
                                <a href="<?php echo strtolower(get_class($this)).'/post';?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>