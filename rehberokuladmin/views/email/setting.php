<?php $em = new EmailModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.' Formu';?></h2>
    </header>
    <div class="panel-body">
        <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/setSetting/'.$viewModel['name']; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-md-3 control-label" for="email_address">
                    E-Posta Adresi
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <input type="mail" class="form-control" id="email_address" name="email_address" pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$" required title="Hatalı Email!" value="<?php echo $viewModel['email_address']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="email_password">
                    Parola
                </label>
                <div class="col-md-6">
                    <input type="password" class="form-control" id="email_password" name="email_password" value="<?php echo openssl_decrypt($viewModel['email_password'], "AES-128-ECB", $em::$SECRETKEY); ?>" title="Parola Boş Bırakılamaz!"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="password_verification">
                    Parola Onayla
                </label>
                <div class="col-md-6">
                    <input type="password" class="form-control" id="password_verification" name="password_verification" value="<?php echo openssl_decrypt($viewModel['email_password'], "AES-128-ECB", $em::$SECRETKEY); ?>" title="Parola Onayı Boş Bırakılamaz!"/>
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