<?php $rm = new SchoolModel();?>
<section class="panel">
    <header class="panel-heading">

        <h2 class="panel-title"><?php echo Controller::$title?></h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-tabletools-kindergarten">
            <thead>
            <tr>
                <th>Sıra</th>
                <th>İsim</th>
                <th>Telefon</th>
                <th>İletişim E-Posta</th>
                <th>Durum</th>
                <th>Prio</th>
                <th>Paket</th>
                <th>İl / İlçe</th>
                <th class="center">İşlemler</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($viewModel as $schools) :?>
                <tr>
                    <td class="td-middle"></td>
                    <td class="td-middle"><?php echo $schools['name']; ?></td>
                    <td class="td-middle"> <?php echo $schools['phone']; ?></td>
                    <td class="td-middle"> <?php echo $schools['contact_email']; ?></td>
                    <td class="td-middle"> <?php echo $schools['state'] == 1 ? 'Onay Bekliyor / '.($schools['token'] == '' ? 'Doğrulanmış' : 'Henüz Doğrulanmamış') : ($schools['state'] == 2 ? 'Aktif'.($schools['admin_approved'] == 1 ? '' : (($schools['token'] == '' ? ' / Admin İncelemesi Bekliyor' : ' / Henüz Doğrulanmamış'))) : 'Pasif' ); ?></td>
                    <td class="td-middle"> <?php echo $schools['priority']; ?></td>
                    <td class="td-middle"> <?php echo $schools['package'] == '' ? 'Yok': $schools['package'];?></td>
                    <td class="td-middle"> <?php echo $rm->getCityName($schools['sehir_key']).' / '.$rm->getTownName($schools['ilce_key']) ?></td>
                    <td class="center">
                        <a href="<?php echo strtolower(get_class($this));?>/viewEditMiddle/<?php echo $schools['link'];?>" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" <?php echo $rm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-edit"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/detailMiddle/<?php echo $schools['link'];?>" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning" <?php echo $rm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-search"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/viewDeleteMiddle/<?php echo $schools['link'];?>" title="Sil"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" <?php echo $rm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-trash"></i></button></a>
                    </td>
                </tr>
            <?php endforeach;?>


            </tbody>
        </table>
        <div class="center" <?php echo $rm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding'] == 0 ? "style='display: none;'" : "";?>>
            <a href="<?php echo strtolower(get_class($this)).'/viewAddMiddle/';?>"><button type="button" class="btn btn-primary">Yeni İlk veya Ortaokul Ekle</button></a>
        </div>
    </div>
</section>
