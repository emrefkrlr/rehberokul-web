<?php $sm = new SssModel(); ?>
<section class="panel">
    <header class="panel-heading">

        <h2 class="panel-title"><?php echo Controller::$title?></h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-tabletools-sss">
            <thead>
            <tr>
                <th>Sıra</th>
                <th>Soru</th>
                <th>SSS Yeri</th>
                <th>Yayınlanma Tarihi</th>
                <th>Durum</th>
                <th class="center">İşlemler</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($viewModel as $ssss) :?>
                <tr>
                    <td class="td-middle"></td>
                    <td class="td-middle"><?php echo $ssss['question']; ?></td>
                    <td class="td-middle"><?php echo $ssss['sss_place'] == 'anaokulu-kres' ? 'Anaokulu & Kreş' : ($ssss['sss_place'] == 'ilk-okul' ? 'İlkokul' : ($ssss['sss_place'] == 'orta-okul' ? 'Ortaokul' : ($ssss['sss_place'] == 'lise' ? 'Lise' : ($ssss['sss_place'] == 'Okul Detay' ? 'Okul Detay': $ssss['sss_place'])))); ?></td>
                    <td class="td-middle"><?php $date = new DateTime($ssss['publish_date']); echo $date->format('Y-m-d'); ?></td>
                    <td class="td-middle"><?php echo $ssss['state'] == 1 ? 'Aktif' : 'Pasif'; ?></td>
                    <td class="center">
                        <a href="<?php echo strtolower(get_class($this));?>/preview/<?php echo $ssss['link'];?>" title="Önizleme"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-primary" <?php echo $sm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 || $ssss['sss_connection'] == 'bagimsiz' || $ssss['sss_answer_type'] == 'manuel' || $ssss['sss_place'] != 'okul-detay'  ? "style='display: none;'" : "";?>><i class="fa fa-info-circle"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/viewEdit/<?php echo $ssss['link'];?>" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" <?php echo $sm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-edit"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/detail/<?php echo $ssss['link'];?>" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning" <?php echo $sm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-search"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/viewDelete/<?php echo $ssss['link'];?>" title="Sil"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" <?php echo $sm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-trash"></i></button></a>
                    </td>
                </tr>
            <?php endforeach;?>

            </tbody>
        </table>
        <div class="center" <?php echo $sm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding'] == 0 ? "style='display: none;'" : "";?>>
            <a href="<?php echo strtolower(get_class($this)).'/viewAdd/';?>"><button type="button" class="btn btn-primary">Yeni Soru Ekle</button></a>
        </div>
    </div>
</section>
