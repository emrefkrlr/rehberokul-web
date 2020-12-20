<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
            <form class="form-horizontal form-bordered" method="post">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="tag_name">
                        Kategori Adı
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="tag_name" name="tag_name" value="<?php echo $viewModel['name'];?>" disabled data-plugin-maxlength maxlength="250"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label" for="description">
                        Kategori Açıklaması
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="description" name="description" value="<?php echo $viewModel['description'];?>" disabled/>
                    </div>
                </div>


                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />

                    <div class="form-group">
                            <div class="center">
                                <a href="<?php echo strtolower(get_class($this)).'/tag';?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>