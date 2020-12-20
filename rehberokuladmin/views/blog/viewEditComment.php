<?php $bm = new BlogModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
        <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/editComment/'.$viewModel['link']; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-md-3 control-label" for="question">
                    Gönderen
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" disabled class="form-control" value="<?php echo $bm->getCommentator($viewModel['commentator'])['first_name'].'-'.$bm->getCommentator($viewModel['commentator'])['last_name'];?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="question">
                    Email
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" disabled class="form-control" value="<?php echo $bm->getCommentator($viewModel['commentator'])['email'];?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="question">
                    Yazı Başlığı
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" disabled class="form-control" value="<?php echo $bm->getBlogName($viewModel['blog_id']);?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="question">
                    Oluşturulma Tarihi
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" disabled class="form-control" value="<?php echo $viewModel['publish_date'];?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="comment">
                    Yorum
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <textarea type="text" class="form-control" id="comment" name="comment" title='Yorum Girmediniz!' required rows="4" cols="5"><?php echo $viewModel['comment'];?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="state">
                    Onay Durumu
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select required title="Yorumun Onay Durumunu Belirlemediniz!" data-plugin-selectTwo class="form-control populate"  data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="state" name="state">
                        <option <?php echo $viewModel['state'] == 1 ? 'selected' : '';?> value="1">Aktif</option>
                        <option <?php echo $viewModel['state'] == 0 ? 'selected' : '';?> value="0">Pasif</option>
                    </select>
                </div>
            </div>


            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />

                    <div class="form-group">
                            <div class="center">
                                <button type="submit" name="submit" class="btn btn-primary">Güncelle</button>
                                    <a href="<?php echo strtolower(get_class($this)).'/comment';?>"><button type="button" class="btn btn-default">Kapat</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>