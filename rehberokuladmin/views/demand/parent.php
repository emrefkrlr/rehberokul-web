<?php $dm = new DemandModel();?>
<section class="panel">
    <header class="panel-heading">

        <h2 class="panel-title"><?php echo Controller::$title?></h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-tabletools-demand">
            <thead>
            <tr>
                <th>Sıra</th>
                <th>İsim - Email</th>
                <th>Telefon</th>
                <th>İl / İlçe</th>
                <th>Fiyat Aralığı</th>
                <th>Tıklayan Okullar</th>
                <th>Durum</th>
                <th class="center">İşlemler</th>
            </tr>
            </thead>
            <tbody>

                <?php foreach ($viewModel as $demands) :?>
                    <tr>
                        <td class="td-middle"></td>
                        <td class="td-middle">
                            <?php
                                if($dm->getRoleId($demands['user_id']) != 1) { // Yönetici değilse
                                    echo  $dm->getUser($demands['user_id'])['first_name'].' '.$dm->getUser($demands['user_id'])['last_name'].'<br>'.
                                        $dm->getUser($demands['user_id'])['email'];
                                } else {
                                    echo $demands['full_name'].'<br>'.$demands['email'];
                                }
                                ?>

                                </td>
                        <td class="td-middle"><?php echo $dm->getRoleId($demands['user_id']) != 1 ? $dm->getUser($demands['user_id'])['phone']: $demands['phone']; ?></td>
                        <td class="td-middle"><?php echo $dm->getCity($demands['sehir_key']).' / '.$dm->getTown($demands['ilce_key']); ?></td>
                        <td class="td-middle"><?php echo $demands['price_interval'] ? $demands['price_interval'] : 'Bilinmiyor'; ?></td>
                        <td class="td-middle"><?php echo $dm->getInterestedSchools($demands['id']) ? $dm->getInterestedSchools($demands['id']) : 'Henüz Yok'; ?></td>
                        <td class="td-middle"><?php echo $demands['is_active'] == 1 ? $demands['state'] == 0 ? 'Onay Bekliyor' : ($demands['state'] == 1 ? 'Onaylandı' : 'Karşılandı') : 'Pasif'; ?></td>
                        <td class="td-middle center">
                            <a href="<?php echo strtolower(get_class($this));?>/doneParentDemand/<?php echo $demands['link'];?>" title="Karşıla"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-primary" <?php echo $dm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 || $demands['state'] != 1 || $demands['state'] == 2  || $demands['is_active'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-thumbs-up"></i></button></a>
                            <a href="<?php echo strtolower(get_class($this));?>/viewEditParentDemand/<?php echo $demands['link'];?>" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" <?php echo $dm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 || $demands['state'] != 0 || $demands['is_active'] == 0 || $demands['school_id'] != 0 ? "style='display: none;'" : "";?>><i class="fa fa-edit"></i></button></a>
                            <a href="<?php echo strtolower(get_class($this));?><?php echo $demands['school_id'] == 0 ? '/detailParentDemand/' :'/detailParentDemandSpesific/';?><?php echo $demands['link'];?>" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning" <?php echo $dm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-search"></i></button></a>
                            <a href="<?php echo strtolower(get_class($this));?><?php echo $demands['school_id'] == 0 ? '/viewDeleteParentDemand/' :'/viewDeleteParentDemandSpesific/';?><?php echo $demands['link'];?>" title="Pasife Çek"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" <?php echo $dm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting'] == 0 || $demands['is_active'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-trash"></i></button></a>
                        </td>
                    </tr>
                <?php endforeach;?>

            </tbody>
        </table>
        <div class="center" <?php echo $dm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding'] == 0 ? "style='display: none;'" : "";?>>
            <a href="<?php echo strtolower(get_class($this)).'/viewAddParentDemand/';?>"><button type="button" class="btn btn-primary">Yeni Talep Ekle</button></a>
        </div>
    </div>
</section>
