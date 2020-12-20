<?php $dm = new DemandModel();?>
<section class="panel">
    <header class="panel-heading">

        <h2 class="panel-title"><?php echo Controller::$title?></h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-tabletools-demand-spesific">
            <thead>
            <tr>
                <th>Sıra</th>
                <th>İsim - Email</th>
                <th>Telefon</th>
                <th>Okul</th>
                <th>Durum</th>
                <th class="center">İşlemler</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($viewModel as $demands) :?>
                <tr>
                    <td class="td-middle"></td>
                    <td class="td-middle"><?php echo $demands['user_id'] != 0 ? $dm->getUser($demands['user_id'])['first_name'].' '.$dm->getUser($demands['user_id'])['last_name'].'<br>'.$dm->getUser($demands['user_id'])['email'] : $demands['full_name'].'<br>'.$demands['email']; ?></td>
                    <td class="td-middle"><?php echo $demands['user_id'] != 0 ? $dm->getUser($demands['user_id'])['phone'] : $demands['phone']; ?></td>
                    <td class="td-middle"><?php echo $dm->getSchool($demands['school_id']); ?></td>
                    <td class="td-middle"><?php echo $demands['is_active'] == 1 ? $demands['state'] == 0 ? 'Onay Bekliyor' : ($demands['state'] == 1 ? 'Onaylandı' : 'Karşılandı') : 'Pasif'; ?></td>
                    <td class="center">
                        <a href="<?php echo strtolower(get_class($this));?>/viewEditSpesific/<?php echo $demands['link'];?>" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" <?php echo $dm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 || $demands['state'] == 2 || $demands['is_active'] == 0? "style='display: none;'" : "";?>><i class="fa fa-edit"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/viewAddDemand/<?php echo $demands['link'];?>" title="Genel Talep Yap"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" <?php echo $dm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 || $demands['state'] == 2 || $demands['is_active'] == 0? "style='display: none;'" : "";?>><i class="fa fa-edit"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/detailSpesific/<?php echo $demands['link'];?>" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning" <?php echo $dm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-search"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/viewDeleteSpesific/<?php echo $demands['link'];?>" title="Pasife Çek"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" <?php echo $dm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting'] == 0 || $demands['is_active'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-trash"></i></button></a>
                    </td>
                </tr>
            <?php endforeach;?>

            </tbody>
        </table>
    </div>
</section>
