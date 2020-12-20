<?php $cm = new CMSModel(); ?>
<section class="panel">
    <header class="panel-heading">

        <h2 class="panel-title"><?php echo Controller::$title?></h2>
    </header>
    <div class="panel-body">
        <table class="table table-bordered table-striped mb-none" id="datatable-tabletools-demand-spesific">
            <thead>
            <tr>
                <th>Sıra</th>
                <th>Okul Tipi</th>
                <th>Üst Başlık</th>
                <th>Popüler Başlık</th>
                <th>Alt Başlık</th>
                <th class="center">İşlemler</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($viewModel as $schoolTypes) :?>
                <tr>
                    <td class="td-middle"></td>
                    <td class="td-middle"><?php echo str_replace('-', ' ', $schoolTypes['slug']); ?></td>
                    <td class="td-middle"><?php echo $schoolTypes['top_header']; ?></td>
                    <td class="td-middle"><?php echo $schoolTypes['popular_header']; ?></td>
                    <td class="td-middle"><?php echo $schoolTypes['bottom_header'];?></td>
                    <td class="center">
                        <a href="<?php echo strtolower(get_class($this));?>/schooltypeViewEdit/<?php echo $schoolTypes['slug'];?>" title="Düzenle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" <?php echo $cm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-edit"></i></button></a>
                        <a href="<?php echo strtolower(get_class($this));?>/schooltypeDetail/<?php echo $schoolTypes['slug'];?>" title="Görüntüle"><button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-warning" <?php echo $cm->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading'] == 0 ? "style='display: none;'" : "";?>><i class="fa fa-search"></i></button></a>
                    </td>
                </tr>
            <?php endforeach;?>

            </tbody>
        </table>

    </div>
</section>
