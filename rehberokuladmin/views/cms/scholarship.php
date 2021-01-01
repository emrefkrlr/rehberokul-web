<?php $ld = new ScholarshipModel() ?>

<section class="panel">
    <header class="panel-heading">

        <h2 class="panel-title"><?php echo Controller::$title?></h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-tabletools-demand-spesific">
            <thead>
            <tr>
                <th>Sıra</th>
                <th>Başlık</th>
                <th>Açıklama</th>
                <th>İçerik</th>
                <th>Sayfa URL</th>
                <th>Güncelleme Tarihi</th>
                <th>Oluşturulma Tarihi</th>
                <th>Öncelik Sırası</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($viewModel as $scholarship) :?>
                <tr>
                    <td class="td-middle"><?php echo $scholarship['id']; ?></td>
                    <td class="td-middle"><?php echo $scholarship['title']; ?></td>
                    <td class="td-middle"><?php echo $scholarship['header']; ?></td>
                    <td class="td-middle"><?php echo $scholarship['content'];?></td>
                    <td class="td-middle"><?php echo $scholarship['scholarship_slug'];?></td>
                    <td class="td-middle"><?php echo $scholarship['updated_date'];?></td>
                    <td class="td-middle"><?php echo $scholarship['created_date'];?></td>
                    <td class="td-middle"><?php echo $scholarship['priority'];?></td>

                    <td class="td-middle center">
                        <a href="<?php echo strtolower(get_class($this));?>/landingViewEdit/<?php echo $scholarship['id'];?>" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" <?php echo $ld->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-edit"></i></button></a>

                    </td>
                </tr>
            <?php endforeach;?>

            </tbody>
        </table>

        <div class="center" <?php echo $ld->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding'] == 0 ? "style='display: none;'" : "";?>>
            <a href="<?php echo strtolower(get_class($this)).'/scholarshipAdd/';?>"><button type="button" class="btn btn-primary">Yeni Bursluluk Ekle</button></a>
        </div>

    </div>
</section>
