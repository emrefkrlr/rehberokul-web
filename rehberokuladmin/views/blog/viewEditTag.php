
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
        <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/editTag/'.$viewModel['link']; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-md-3 control-label" for="tag_name">
                    Kategori Adı
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="tag_name" name="tag_name" pattern="[a-zA-Z0-9çÇöÖüÜşŞİığĞ-_\s]*" title='Kategori Adı İçin Sadece büyük,küçük harf, rakam, tire ve alt tire kullanabilirsiniz!' value="<?php echo $viewModel['name'];?>" required data-plugin-maxlength maxlength="250"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="description">
                    Kategori Açıklaması
                    <span class="required">*</span>
                </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="description" name="description" pattern="[a-zA-Z0-9çÇöÖüÜşŞİığĞ-_\s]*" title='Kategori Açıklaması İçin Sadece büyük,küçük harf, rakam, tire ve alt tire kullanabilirsiniz!' value="<?php echo $viewModel['description'];?>" required/>
                </div>
            </div>


            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />

                    <div class="form-group">
                            <div class="center">
                                <button type="submit" name="submit" class="btn btn-primary">Güncelle</button>
                                    <a href="<?php echo strtolower(get_class($this)).'/tag';?>"><button type="button" class="btn btn-default">Kapat</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>