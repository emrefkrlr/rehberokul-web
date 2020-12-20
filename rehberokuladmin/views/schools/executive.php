<?php $rm = new SchoolsModel();?>
<section class="panel">
    <header class="panel-heading">

        <h2 class="panel-title"><?php echo Controller::$title?></h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-tabletools-kindergarten-ks">
            <thead>
            <tr>
                <th>Sıra</th>
                <th>İsim</th>
                <th>Telefon</th>
                <th>İletişim E-Posta</th>
                <th>Durum</th>
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
                    <td class="td-middle"> <?php echo $schools['token'] != '' ? 'E-Posta Doğrulanmamış' : ($schools['state'] == 1 ? 'Onay Bekliyor' : ($schools['state'] == 2 ? ($schools['admin_approved'] == 1 ? 'Aktif' : 'Admin İncelemesi Bekliyor') : 'Pasif' )); ?></td>
                    <td class="td-middle"> <?php echo $schools['package'] == '' ? 'Yok': $schools['package'];?></td>
                    <td class="td-middle"> <?php echo $rm->getCityName($schools['sehir_key']).' / '.$rm->getTownName($schools['ilce_key']) ?></td>
                    <td class="center">
                        <a href="<?php echo strtolower(get_class($this));?>/viewEditExecutive/<?php echo $schools['link'];?>" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" <?php echo $rm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 || $schools['admin_approved'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-edit"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/detailExecutive/<?php echo $schools['link'];?>" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning" <?php echo $rm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-search"></i></button></a>
                    </td>
                </tr>
            <?php endforeach;?>


            </tbody>
        </table>
    </div>
</section>
