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
        <form class="form-horizontal form-bordered" action="<?php echo strtolower(get_class($this)).'/delete/'.$viewModel['link']; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-md-3 control-label" for="full_name">
                    İsim
                    <span class="required">*</span>
                </label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $viewModel['user_id'] != 0 ? $dm->getUser($viewModel['user_id'])['first_name'].' '.$dm->getUser($viewModel['user_id'])['last_name'] : $viewModel['full_name']; ?>" disabled/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="email">
                    Email
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <input type="mail" class="form-control" id="email" name="email" disabled value="<?php echo $viewModel['user_id'] != 0 ? $dm->getUser($viewModel['user_id'])['email'] : $viewModel['email']; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="phone">
                    Telefon
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="phone" name="phone" disabled value="<?php echo $viewModel['user_id'] != 0 ? $dm->getUser($viewModel['user_id'])['phone'] : $viewModel['phone']; ?>"/>
                </div>
            </div>

            <div class="form-group" id="schools_select_div">
                <label class="col-md-3 control-label">
                    Okul
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <select multiple disabled style="width: 415px;" data-plugin-selectTwo class="form-control populate" name='school[]'>
                        <option value="">Seçiniz</option>
                        <?php foreach($dm::$schools as $school): ?>
                            <option value="<?php echo $school['id']; ?>" <?php echo $school['id'] == $viewModel['school_id'] ? 'selected' : ''; ?>><?php echo $school['name'];?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="note">
                    Not
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <textarea class="form-control" disabled id="note" name="note" value="" rows="4" cols="5"><?php echo $viewModel['note']; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-3 control-label" for="create_date">
                    Yayınlanma Tarihi
                    <span class="required" aria-required="true">*</span>
                </label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="create_date" name="create_date" disabled value="<?php echo $viewModel['create_date']; ?>"/>
                </div>
            </div>

            <div class="form-group <?php echo $_SESSION['user_data']['role'] != 'Yönetici' ? 'hide' : '';?>">
                <label class="col-md-3 control-label" for="state">
                    Onay Durumu
                    <span class="required" aria-required="true"></span>
                </label>
                <div class="col-md-6">
                    <select data-plugin-selectTwo disabled class="form-control populate" data-plugin-search  data-plugin-options='{ "maxHeight": 200 }' id="state" name="state">
                        <option value="">Seçiniz</option>
                        <option <?php echo $viewModel['state'] == 1 ? 'selected' : ''; ?> value="1">Onaylandı Olarak Belirle</option>
                        <option <?php echo $viewModel['state'] == 2 ? 'selected' : ''; ?> value="2">Karşılandı Olarak Belirle</option>
                    </select>
                </div>
            </div>

            
                    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>" />

                    <div class="form-group">
                            <div class="center">
                                <button type="submit" name="submit" class="btn btn-danger">Pasife Çek</button>
                                    <a href="<?php echo strtolower(get_class($this)).'/spesific';?>"><button type="button" class="btn btn-default">Geri Dön</button></a>
                            </div>
                    </div>
                
                
            </form>
        
    </div>
</section>