<?php $dm = new DemandsModel();?>
<section class="panel">
    <header class="panel-heading">

        <h2 class="panel-title"><?php echo Controller::$title?></h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-tabletools-demands">
            <thead>
            <tr>
                <th>Sıra</th>
                <th>Okul Türü</th>
                <th>Sınıf</th>
                <th>İl / İlçe</th>
                <th>Fiyat Aralığı</th>
                <th>Tarih</th>
                <th>Not</th>
                <th class="center">İşlemler</th>
            </tr>
            </thead>
            <tbody>

                <?php foreach ($viewModel as $demands) :?>
                    <tr>
                        <td class="td-middle"></td>
                        <td class="td-middle"><?php echo $dm->getSchoolType($demands['school_type']); ?></td>
                        <td class="td-middle"><?php echo $demands['school_type'] == 1 ? 'Yok' : $demands['class'].'. Sınıf'; ?></td>
                        <td class="td-middle"><?php echo $dm->getCity($demands['sehir_key']).' / '.$dm->getTown($demands['ilce_key']); ?></td>
                        <td class="td-middle"><?php echo $demands['price_interval']; ?></td>
                        <td class="td-middle"><?php $date = new DateTime($demands['end_date']); echo $date->format('Y-m-d'); ?></td></td>
                        <td class="td-middle" style="width: 20%;"><?php echo $demands['note']; ?></td>
                        <td class="td-middle center">
                            <a href="<?php echo strtolower(get_class($this));?>/interest/<?php echo $demands['link'];?>" title="Taleple İlgilen"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-success" <?php echo $dm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-check"></i></button></a>
                            <a href="<?php echo strtolower(get_class($this));?>/detail/<?php echo $demands['link'];?>" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning" <?php echo $dm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-search"></i></button></a>
                        </td>
                    </tr>
                <?php endforeach;?>

            </tbody>
        </table>
    </div>
</section>
