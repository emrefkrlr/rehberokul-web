<?php $pm = new PaymentModel(); ?>
<section class="panel panel-primary">
    <header class="panel-heading">
            <h2 class="panel-title"><?php echo Controller::$title.'me Formu';?></h2>
    </header>
    <div class="panel-body">
            <form class="form-horizontal form-bordered" method="post" action="<?php echo strtolower(get_class($this)).'/approve/'.$viewModel['reference_no'].'-'.$viewModel['school_id']; ?>">

                <div class="form-group">
                    <label class="col-md-3 control-label">
                        Referans No
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" disabled class="form-control" value="<?php echo $viewModel['reference_no'];?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">
                        Kullanıcı
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" disabled class="form-control" value="<?php echo $pm->getUser($viewModel['user_id'])['first_name'].' '.$pm->getUser($viewModel['user_id'])['last_name'];?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">
                        Email
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" disabled class="form-control" value="<?php echo $pm->getUser($viewModel['user_id'])['email'];?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">
                        Telefon
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" disabled class="form-control" value="<?php echo $pm->getUser($viewModel['user_id'])['phone'];?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">
                        İşlem Tarihi
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" disabled class="form-control" value="<?php echo $viewModel['payment_time'];?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">
                        Paket
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" disabled class="form-control" value="<?php echo $viewModel['package'];?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">
                        Fiyat
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-9">
                        <input type="text" disabled class="form-control" value="<?php echo number_format($viewModel['amount'], 2, ',', '.');?> TL"/>
                    </div>
                </div>


                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />

                    <div class="form-group">
                            <div class="center">
                                <button type="submit" name="submit" class="btn btn-primary">Onayla</button>
                                <a href="<?php echo strtolower(get_class($this));?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>